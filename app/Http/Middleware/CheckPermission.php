<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ?string $permissionKey = null): Response
    {
        // ១. ពិនិត្យមើលថាតើបាន Login ចូលហើយឬยัง
        if (!auth()->check()) {
            abort(403, 'សូមចូលប្រព័ន្ធជាមុន។');
        }

        $user = auth()->user();

        // ២. បើគណនីនោះជា Admin (ឆែកទាំងអក្សរតូចធំ) គឺអនុញ្ញាតឱ្យចូលគ្រប់ទីកន្លែងតែម្តង
        if (strtolower($user->role) === 'admin') {
            return $next($request);
        }

        // ៣. បើមិនមែនជា Admin ទេ ហើយមានផ្ញើ $permissionKey មកជាមួយ ត្រូវពិនិត្យសិទ្ធិរបស់គាត់
        if ($permissionKey && method_exists($user, 'hasPermission') && !$user->hasPermission($permissionKey)) {
            abort(403, 'អ្នកមិនមានសិទ្ធិអនុវត្តសកម្មភាពនេះទេ!');
        }

        return $next($request);
    }
}