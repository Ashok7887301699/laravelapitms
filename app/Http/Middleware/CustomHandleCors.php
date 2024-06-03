<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Middleware\HandleCors as BaseHandleCors;
use Illuminate\Support\Facades\Log;

class CustomHandleCors extends BaseHandleCors
{
    public function handle($request, Closure $next)
    {
        Log::debug('Executing CustomHandleCors middleware');
        return parent::handle($request, $next);
    }
}
