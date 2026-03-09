from django.urls import path
from . import views

app_name = 'accounts'

urlpatterns = [
    path('account-selection/', views.account_selection, name='account_selection'),
    path('register/', views.info_account, name='info_account'),
    path('account/store/', views.account_store, name='account_store'),
    path('auth/login/', views.user_login, name='login'),
    path('logout/', views.logout, name='logout'),
]
