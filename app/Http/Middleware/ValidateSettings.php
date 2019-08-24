<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateSettings
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $settingsName = $request->route()->parameter('settings');

        app()->singleton('itemconfig', function ($app) use ($settingsName) {
            $configFactory = app('admin_config_factory');

            return $configFactory->make($configFactory->getSettingsPrefix().$settingsName, true);
        });

        return $next($request);
    }
}
