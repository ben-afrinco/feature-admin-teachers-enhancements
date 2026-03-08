import json
import logging
import requests
import os
import uuid
import urllib.parse
from django.http import StreamingHttpResponse, JsonResponse
from django.shortcuts import render, redirect
from django.conf import settings
from django.db import transaction
from testing.models import Test, Question, Option, DentAnswer, Result, Evaluation
from .models import ChatSession
import google.generativeai as genai

logger = logging.getLogger(__name__)

def ollama_explain(request):
    if request.method != 'POST':
        return JsonResponse({'error': 'Method not allowed'}, status=405)

    try:
        data = json.loads(request.body)
        question = data.get('question')
        correct_answer = data.get('correct_answer')
        student_answer = data.get('student_answer')
    except json.JSONDecodeError:
        return JsonResponse({'error': 'Invalid JSON'}, status=400)

    prompt = f"""You are a helpful English teacher. A student answered a question incorrectly on an English test.

Question: {question}
Student's answer: {student_answer}
Correct answer: {correct_answer}

Explain briefly (3-4 sentences max) why the student's answer is wrong and why the correct answer is right. Be encouraging and clear. Use simple English."""

    def event_stream():
        ollama_url = os.getenv('OLLAMA_URL', 'http://localhost:11434') + '/api/generate'
        payload = {
            'model': os.getenv('OLLAMA_MODEL', 'tinyllama:1.1b'),
            'prompt': prompt,
            'stream': True,
            'options': {
                'temperature': 0.7,
                'num_predict': 256,
            },
        }

        try:
            response = requests.post(ollama_url, json=payload, stream=True, timeout=60)
            for line in response.iter_lines():
                if line:
                    chunk = json.loads(line.decode('utf-8'))
                    if 'response' in chunk:
                        yield f"data: {json.dumps({'token': chunk['response']})}\n\n"
                    if chunk.get('done'):
                        yield "data: [DONE]\n\n"
        except Exception as e:
            logger.error(f'Ollama streaming error: {str(e)}')
            yield f"data: {json.dumps({'token': 'AI explanation is temporarily unavailable.'})}\n\n"
            yield "data: [DONE]\n\n"

    return StreamingHttpResponse(event_stream(), content_type='text/event-stream')

def generate_tests_groq():
    api_key = os.getenv('GROQ_API_KEY')
    if not api_key:
        logger.warning('Groq API key is missing.')
        return False

    prompt = """You are an expert English language test creator for beginners. Generate a brand new, unique, and engaging reading, writing, and speaking test.
Return ONLY a valid JSON object matching the exact structure below.

{
  "reading": {
    "passage": "A completely new original story of about 100-150 words.",
    "questions": [
      {
        "text": "A multiple choice question about the passage",
        "options": ["Correct Answer", "Wrong Option 1", "Wrong Option 2", "Wrong Option 3"],
        "correct_index": 0
      }
    ]
  },
  "writing": {
    "topic": "A completely new, interesting writing topic for beginners."
  },
  "speaking": {
    "passage": "A completely new short passage (20-30 words) for the student to read aloud."
  }
}"""

    try:
        response = requests.post(
            'https://api.groq.com/openai/v1/chat/completions',
            headers={'Authorization': f'Bearer {api_key}', 'Content-Type': 'application/json'},
            json={
                'model': 'llama-3.1-8b-instant',
                'messages': [
                    {'role': 'system', 'content': 'You only reply with valid, raw JSON.'},
                    {'role': 'user', 'content': prompt}
                ],
                'temperature': 0.8,
                'response_format': {'type': 'json_object'}
            },
            timeout=30
        )

        if response.status_code == 200:
            content = response.json()['choices'][0]['message']['content']
            data = json.loads(content)

            with transaction.atomic():
                # Reading
                reading_test = Test.objects.create(
                    test_name='Dynamic Reading',
                    level='Beginner',
                    skill='reading_dynamic',
                    content=data['reading']['passage']
                )
                for q in data['reading']['questions']:
                    new_q = Question.objects.create(
                        test=reading_test,
                        question_text=q['text'],
                        question_type='mcq'
                    )
                    for idx, opt_text in enumerate(q['options']):
                        Option.objects.create(
                            question=new_q,
                            optione_text=opt_text,
                            is_correct=(idx == q['correct_index'])
                        )

                # Writing
                writing_test = Test.objects.create(
                    test_name='Dynamic Writing',
                    level='Beginner',
                    skill='writing_dynamic',
                    content=data['writing']['topic']
                )

                # Speaking
                speaking_test = Test.objects.create(
                    test_name='Dynamic Speaking',
                    level='Beginner',
                    skill='speaking_dynamic',
                    content=data['speaking']['passage']
                )

                return {
                    'reading': reading_test.test_id,
                    'writing': writing_test.test_id,
                    'speaking': speaking_test.test_id
                }
    except Exception as e:
        logger.error(f"Groq generation failed: {str(e)}")
        return False

def evaluate_with_gemini(text, skill):
    api_key = os.getenv('GEMINI_API_KEY')
    if not api_key:
        return {'score': 75, 'feedback': 'Mock feedback (API Key missing)'}

    genai.configure(api_key=api_key)
    model = genai.GenerativeModel('gemini-1.5-flash-latest')

    if skill == 'writing':
        prompt = f"""Evaluate this writing response. Reply ONLY with JSON: {{"score":N, "feedback":"..."}} \n\n Response: {text}"""
    else:
        prompt = f"""Evaluate this speaking transcription. Reply ONLY with JSON: {{"score":N, "feedback":"..."}} \n\n Transcription: {text}"""

    try:
        response = model.generate_content(prompt)
        content = response.text.strip('`json\n ')
        result = json.loads(content)
        return result
    except Exception as e:
        logger.error(f"Gemini evaluation failed: {str(e)}")
        return {'score': 50, 'feedback': 'AI evaluation error.'}

def chatbot_history(request):
    if not request.user.is_authenticated:
        return JsonResponse({'error': 'Unauthorized'}, status=401)

    history = ChatSession.objects.filter(user=request.user).order_by('created_at')
    data = [{'role': chat.role, 'content': chat.content} for chat in history]
    return JsonResponse(data, safe=False)

def chatbot_send(request):
    if request.method == 'POST':
        if not request.user.is_authenticated:
            return JsonResponse({'error': 'Unauthorized'}, status=401)

        message = request.POST.get('message')
        if not message:
            return JsonResponse({'error': 'Message required'}, status=400)

        with transaction.atomic():
            ChatSession.objects.create(user=request.user, role='user', content=message)

            # Use Gemini for real AI response
            eval_res = evaluate_with_gemini(message, 'writing')
            response_text = eval_res.get('feedback', 'I am your English tutor. How can I help today?')

            ChatSession.objects.create(user=request.user, role='model', content=response_text)

        return JsonResponse({'status': 'success', 'response': response_text})
    return JsonResponse({'error': 'Method not allowed'}, status=405)

def strengthening_plan(request):
    if not request.user.is_authenticated:
        return redirect('accounts:login')
    return render(request, 'core/strengthening.html')

def generate_listening_openrouter():
    api_key = os.getenv('OPENROUTER_API_KEY')
    if not api_key:
        logger.warning('OpenRouter API key is missing.')
        return False

    prompt = """Generate 3 listening tests for English beginners. Each should have a short script (50-80 words) and 5 MCQs. Return ONLY raw JSON array."""

    try:
        response = requests.post(
            'https://openrouter.ai/api/v1/chat/completions',
            headers={'Authorization': f'Bearer {api_key}', 'Content-Type': 'application/json'},
            json={
                'model': 'meta-llama/llama-3.3-70b-instruct:free',
                'messages': [{'role': 'user', 'content': prompt}]
            },
            timeout=60
        )
        if response.status_code == 200:
            content = response.json()['choices'][0]['message']['content']
            data = json.loads(content.strip('`json\n '))

            with transaction.atomic():
                first_test_id = None
                for test_data in data:
                    # 1. Generate TTS via Google Translate API
                    text = urllib.parse.quote(test_data['script'][:500])
                    audio_url = f"https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q={text}&tl=en-US"

                    audio_res = requests.get(audio_url, timeout=30)
                    audio_path = ""
                    if audio_res.status_code == 200:
                        file_name = f'dynamic_listening_{uuid.uuid4()}.mp3'
                        dir_path = os.path.join(settings.MEDIA_ROOT, 'audio')
                        os.makedirs(dir_path, exist_ok=True)
                        full_path = os.path.join(dir_path, file_name)
                        with open(full_path, 'wb') as f:
                            f.write(audio_res.content)
                        audio_path = f"{settings.MEDIA_URL}audio/{file_name}"

                    test = Test.objects.create(
                        test_name='Dynamic Listening',
                        level='Beginner',
                        skill='listening_dynamic',
                        content=audio_path or test_data['script']
                    )
                    if not first_test_id: first_test_id = test.test_id

                    for q in test_data['questions']:
                        new_q = Question.objects.create(test=test, question_text=q['text'], question_type='mcq')
                        for idx, opt_text in enumerate(q['options']):
                            Option.objects.create(question=new_q, optione_text=opt_text, is_correct=(idx == q['correct_index']))
                return first_test_id
    except Exception as e:
        logger.error(f"OpenRouter generation failed: {str(e)}")
        return False
