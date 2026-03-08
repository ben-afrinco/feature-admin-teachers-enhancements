from django.urls import path
from . import views

app_name = 'classroom'

urlpatterns = [
    path('teacher/', views.teacher_dashboard, name='teacher_dashboard'),
    path('developer/', views.developer_dashboard, name='developer_dashboard'),
    path('teacher/session/create/', views.create_online_session, name='create_session'),
    path('admin/user/delete/<int:user_id>/', views.delete_user, name='delete_user'),
    path('teacher/assignment/create/', views.create_assignment, name='create_assignment'),
    path('student/assignments/', views.student_assignments, name='student_assignments'),
    path('assignment/submit/<int:assignment_id>/', views.submit_assignment, name='submit_assignment'),
    path('submission/grade/<int:submission_id>/', views.grade_submission, name='grade_submission'),
]
