from django.urls import path
from . import views

app_name = 'ai_engine'

urlpatterns = [
    path('api/ollama/explain/', views.ollama_explain, name='ollama_explain'),
    path('chatbot/history/', views.chatbot_history, name='chatbot_history'),
    path('chatbot/send/', views.chatbot_send, name='chatbot_send'),
]
