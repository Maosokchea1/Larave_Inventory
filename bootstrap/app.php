<?php

use App\Http\Middleware\SetLocale;
use App\Http\Middleware\AdminMiddleware; // បញ្ចូល Class របស់ AdminMiddleware
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // បន្ថែម global ឬ web middleware ដូចដើម
        $middleware->web(append: [
            SetLocale::class,
        ]);

        // ចុះឈ្មោះ Alias Middleware សម្រាប់ប្រើប្រាស់ជាមួយ Route (ឧទាហរណ៍: ->middleware('admin'))
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            // 'permission' => \App\Http\Middleware\CheckPermission::class, // បើមាន Middleware ផ្សេងទៀតអាចដាក់ទីនេះបន្ថែម
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();