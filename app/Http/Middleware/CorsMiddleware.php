<?php

namespace App\Http\Middleware;

use Closure;
use Fruitcake\Cors\CorsService;
use Illuminate\Http\Request;

class CorsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $config = app('config')->get('cors', []);
        $paths = $config['paths'] ?? [];
        $matchesPath = false;

        foreach ($paths as $path) {
            if ($request->is(trim($path, '/'))) {
                $matchesPath = true;
                break;
            }
        }

        if (!$matchesPath) {
            return $next($request);
        }

        $cors = new CorsService([
            'supportsCredentials' => $config['supports_credentials'] ?? false,
            'allowedOrigins' => $config['allowed_origins'] ?? [],
            'allowedOriginsPatterns' => $config['allowed_origins_patterns'] ?? [],
            'allowedHeaders' => $config['allowed_headers'] ?? [],
            'allowedMethods' => $config['allowed_methods'] ?? [],
            'exposedHeaders' => $config['exposed_headers'] ?? [],
            'maxAge' => $config['max_age'] ?? 0,
        ]);

        if (!$cors->isCorsRequest($request) || !$cors->isOriginAllowed($request)) {
            return $next($request);
        }

        if ($cors->isPreflightRequest($request)) {
            $response = $cors->handlePreflightRequest($request);
            $cors->varyHeader($response, 'Access-Control-Request-Method');

            return $response;
        }

        return $cors->addActualRequestHeaders($next($request), $request);
    }
}
