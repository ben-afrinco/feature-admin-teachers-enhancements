from django.shortcuts import render

def index(request):
    return render(request, 'core/index.html')

def how_it_works(request):
    return render(request, 'core/how_it_works.html')
