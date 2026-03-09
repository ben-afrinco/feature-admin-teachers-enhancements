from django.shortcuts import render, redirect, get_object_or_404
from django.db import transaction
from django.db.models import Count
from django.http import JsonResponse
from .models import Test, Question, Option, DentAnswer, Result, Evaluation
from accounts.models import Student
from ai_engine.views import evaluate_with_gemini, generate_tests_groq, generate_listening_openrouter
import logging

logger = logging.getLogger(__name__)

def get_student_id(request):
    if not request.user.is_authenticated: return None
    student = Student.objects.filter(user=request.user).first()
    return student.student_id if student else None

def test_instructions(request):
    return render(request, 'testing/instructions.html')

def start_ai(request):
    if not request.user.is_authenticated:
        return redirect('accounts:login')

    test_ids = generate_tests_groq()
    listening_id = generate_listening_openrouter()

    if test_ids or listening_id:
        request.session['dynamic_tests_ready'] = True
        final_ids = test_ids or {}
        if listening_id: final_ids['listening'] = listening_id
        request.session['dynamic_test_ids'] = final_ids
        return redirect('testing:reading_start')

    request.session['dynamic_tests_ready'] = False
    return redirect('testing:reading_start')

# Reading
def reading_start(request):
    return redirect('testing:reading_q1')

def reading_q1(request):
    test_id = request.session.get('dynamic_test_ids', {}).get('reading')
    if test_id:
        test = get_object_or_404(Test, test_id=test_id)
        questions = test.questions.prefetch_related('options').all()
        return render(request, 'testing/reading_q1.html', {'test': test, 'questions': questions})
    return render(request, 'testing/reading_q1.html')

def submit_reading(request, q):
    student_id = get_student_id(request)
    if not student_id: return redirect('accounts:login')

    if request.method == 'POST':
        test_id = request.session.get('dynamic_test_ids', {}).get('reading')
        if not test_id:
            test = Test.objects.filter(skill='reading').first()
            if not test: return redirect('testing:reading_done')
            test_id = test.test_id

        test = Test.objects.get(test_id=test_id)
        questions = test.questions.all()
        correct_count = 0

        with transaction.atomic():
            for question in questions:
                answer_key = f'q{question.question_id}'
                selected_option_id = request.POST.get(answer_key)
                if selected_option_id:
                    try:
                        option = Option.objects.get(option_id=selected_option_id)
                        DentAnswer.objects.update_or_create(
                            student_id=student_id,
                            question=question,
                            defaults={'option': option}
                        )
                        if option.is_correct:
                            correct_count += 1
                    except Option.DoesNotExist:
                        continue

            final_score = (correct_count / questions.count()) * 100 if questions.count() > 0 else 0
            Result.objects.update_or_create(
                user=request.user,
                test=test,
                defaults={'final_score': final_score}
            )

        return redirect('testing:reading_done')
    return redirect('testing:reading_done')

def reading_done(request):
    return render(request, 'testing/reading_done.html')

# Listening
def listening_start(request):
    test_id = request.session.get('dynamic_test_ids', {}).get('listening')
    if test_id:
        test = get_object_or_404(Test, test_id=test_id)
        questions = test.questions.prefetch_related('options').all()
        return render(request, 'testing/listening_q1.html', {'test': test, 'questions': questions})
    return render(request, 'testing/listening_q1.html')

def submit_listening(request, q):
    student_id = get_student_id(request)
    if not student_id: return redirect('accounts:login')

    if request.method == 'POST':
        test_id = request.session.get('dynamic_test_ids', {}).get('listening')
        if not test_id:
            test = Test.objects.filter(skill='listening').first()
            if not test: return redirect('testing:listening_done')
            test_id = test.test_id

        test = Test.objects.get(test_id=test_id)
        questions = test.questions.all()
        correct_count = 0

        with transaction.atomic():
            for question in questions:
                answer_key = f's{question.question_id}'
                selected_option_id = request.POST.get(answer_key)
                if selected_option_id:
                    try:
                        option = Option.objects.get(option_id=selected_option_id)
                        DentAnswer.objects.update_or_create(
                            student_id=student_id,
                            question=question,
                            defaults={'option': option}
                        )
                        if option.is_correct:
                            correct_count += 1
                    except Option.DoesNotExist:
                        continue

            final_score = (correct_count / questions.count()) * 100 if questions.count() > 0 else 0
            Result.objects.update_or_create(
                user=request.user,
                test=test,
                defaults={'final_score': final_score}
            )
        return redirect('testing:listening_done')
    return redirect('testing:listening_done')

def listening_done(request):
    return render(request, 'testing/listening_done.html')

# Writing
def writing_start(request):
    test_id = request.session.get('dynamic_test_ids', {}).get('writing')
    if test_id:
        test = get_object_or_404(Test, test_id=test_id)
        return render(request, 'testing/writing_q1.html', {'test': test})
    return render(request, 'testing/writing_q1.html')

def submit_writing(request):
    student_id = get_student_id(request)
    if not student_id: return redirect('accounts:login')

    if request.method == 'POST':
        essay = request.POST.get('essay')
        test_id = request.session.get('dynamic_test_ids', {}).get('writing')
        if not test_id:
            test = Test.objects.filter(skill='writing').first()
            if not test: return redirect('testing:writing_done')
            test_id = test.test_id

        test = Test.objects.get(test_id=test_id)
        question, _ = Question.objects.get_or_create(test=test, defaults={'question_text': 'Writing Essay', 'question_type': 'essay'})

        if essay:
            evaluation = evaluate_with_gemini(essay, 'writing')
            with transaction.atomic():
                answer = DentAnswer.objects.update_or_create(student_id=student_id, question=question, defaults={'answer_text': essay})[0]
                Evaluation.objects.update_or_create(answer=answer, defaults={'ai_score': evaluation.get('score', 0), 'ai_feedback': evaluation.get('feedback', '')})
                Result.objects.update_or_create(user=request.user, test=test, defaults={'final_score': evaluation.get('score', 0)})
            return redirect('testing:writing_done')

    return redirect('testing:writing_done')

def writing_done(request):
    return render(request, 'testing/writing_done.html')

# Speaking
def speaking_start(request):
    test_id = request.session.get('dynamic_test_ids', {}).get('speaking')
    if test_id:
        test = get_object_or_404(Test, test_id=test_id)
        return render(request, 'testing/speaking_q1.html', {'test': test})
    return render(request, 'testing/speaking_q1.html')

def submit_speaking(request):
    student_id = get_student_id(request)
    if not student_id: return redirect('accounts:login')

    if request.method == 'POST':
        transcription = request.POST.get('transcription', '')
        accuracy = int(request.POST.get('accuracy', 0))
        test_id = request.session.get('dynamic_test_ids', {}).get('speaking')

        if not test_id:
            test = Test.objects.filter(skill='speaking').first()
            if not test: return redirect('testing:speaking_done')
            test_id = test.test_id

        test = Test.objects.get(test_id=test_id)
        question, _ = Question.objects.get_or_create(test=test, defaults={'question_text': 'Speaking Passage', 'question_type': 'speaking'})

        with transaction.atomic():
            answer = DentAnswer.objects.update_or_create(
                student_id=student_id,
                question=question,
                defaults={'answer_text': transcription}
            )[0]

            Evaluation.objects.update_or_create(
                answer=answer,
                defaults={'ai_score': accuracy, 'ai_feedback': f"Accuracy: {accuracy}%"}
            )

            Result.objects.update_or_create(
                user=request.user,
                test=test,
                defaults={'final_score': accuracy}
            )
        return redirect('testing:speaking_done')
    return redirect('testing:results')

def speaking_done(request):
    return render(request, 'testing/speaking_done.html')

# Results
def results(request):
    results = Result.objects.filter(user=request.user).select_related('test')
    return render(request, 'testing/results.html', {'results': results})
