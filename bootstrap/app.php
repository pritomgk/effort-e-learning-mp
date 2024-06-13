<?php

use App\Http\Middleware\CeoMiddleware;
use App\Http\Middleware\SeoMiddleware;
use Illuminate\Foundation\Application;
use App\Http\Middleware\LoginMiddleware;
use App\Http\Middleware\TeacherMiddleware;
use App\Http\Middleware\DirectorMiddleware;
use App\Http\Middleware\ExecutiveMiddleware;
use App\Http\Middleware\PresenterMiddleware;
use App\Http\Middleware\LoginAdminMiddleware;
use App\Http\Middleware\MemberUserMiddleware;
use App\Http\Middleware\HeadTeacherMiddleware;
use App\Http\Middleware\EmailVerifiedMiddleware;
use App\Http\Middleware\ChiefPresenterMiddleware;
use App\Http\Middleware\DirectorGeneralMiddleware;
use App\Http\Middleware\ExecutiveOfficerMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminPannelCommonMiddleware;
use App\Http\Middleware\DeveloperMiddleware;
use App\Http\Middleware\DGDirectorMiddleware;
use App\Http\Middleware\StatusMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'developer' => DeveloperMiddleware::class,
            'admin' => AdminPannelCommonMiddleware::class,
            'director_general' => DirectorGeneralMiddleware::class,
            'dg_director' => DGDirectorMiddleware::class,
            'director' => DirectorMiddleware::class,
            'ceo' => CeoMiddleware::class,
            'seo' => SeoMiddleware::class,
            'executive_officer' => ExecutiveOfficerMiddleware::class,
            'executive' => ExecutiveMiddleware::class,
            'chief_presenter' => ChiefPresenterMiddleware::class,
            'presenter' => PresenterMiddleware::class,
            'head_teacher' => HeadTeacherMiddleware::class,
            'teacher' => TeacherMiddleware::class,
            'member' => MemberUserMiddleware::class,
            'logged_in' => LoginMiddleware::class,
            'logged_in_admin' => LoginAdminMiddleware::class,
            'email_verified' => EmailVerifiedMiddleware::class,
            'status_check' => StatusMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

    
