from django.shortcuts import redirect
from django.core.exceptions import PermissionDenied
from functools import wraps

def session_auth_required(roles=None):
    """
    Decorator for views that require session-based authentication.
    """
    def decorator(view_func):
        @wraps(view_func)
        def _wrapped_view(request, *args, **kwargs):
            if not request.user.is_authenticated:
                return redirect('accounts:info_account')

            role = getattr(request.user, 'role', None)
            if roles and role not in roles:
                raise PermissionDenied("ليس لديك صلاحية للوصول إلى هذه الصفحة.")

            return view_func(request, *args, **kwargs)
        return _wrapped_view
    return decorator
