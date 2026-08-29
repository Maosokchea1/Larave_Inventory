<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // ពិនិត្យមើលថាតើបាន Login ហើយ និងមាន role ជា admin ឬអត់
        if (Auth::check() && strtolower(Auth::user()->role) === 'admin') {
            return $next($request);
        }

        // បើមិនមែនជា Admin ទេ ឱ្យបញ្ជូនទៅកាន់ Dashboard ធម្មតាវិញ ព្រមទាំងផ្ញើសារជូនដំណឹង
        return redirect('/dashboard')->with('error', 'អ្នកមិនមានសិទ្ធិគ្រប់គ្រាន់ដើម្បីចូលទីនេះទេ។');
    }
}