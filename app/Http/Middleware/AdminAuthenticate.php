<?php

// Declare the namespace for the middleware class, indicating that this class is located 
// in the 'App\Http\Middleware' directory.
namespace App\Http\Middleware;

// Import the necessary classes from the Laravel framework.
// 'Authenticate' is the base middleware class for handling authentication.
// 'Request' is used to handle incoming HTTP requests.
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class AdminAuthenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * This method checks if the incoming request expects a JSON response. If not, 
     * it redirects the user to the admin login page.
     *
     * @param Request $request - The incoming request object.
     * @return string|null - The path to redirect to, or null if JSON is expected.
     */
    protected function redirectTo(Request $request): ?string
    {
        // If the request expects a JSON response, return null (no redirection).
        // Otherwise, redirect to the 'admin.login' route.
        return $request->expectsJson() ? null : route('admin.login');
    }

    /**
     * Handle the authentication process for admin users.
     *
     * This method checks if the admin user is authenticated using the 'admin' guard.
     * If authenticated, it sets the guard for the current session. If not authenticated,
     * it triggers the unauthenticated response.
     *
     * @param Request $request - The incoming request object.
     * @param array $guards - An array of guards, which can be used to authenticate different user types.
     */
    protected function authenticate($request, array $guards)
    {
        // Check if the admin guard is authenticated.
        if ($this->auth->guard('admin')->check()) {
            // If authenticated, set the guard to 'admin' for the current session.
            return $this->auth->shouldUse('admin');
        }

        // If the admin is not authenticated, call the 'unauthenticated' method,
        // which will handle the response when the user is not logged in.
        $this->unauthenticated($request, ['admin']);
    }
}
