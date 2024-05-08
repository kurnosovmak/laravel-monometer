<?php declare(strict_types=1);

namespace LaravelMonometer\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;

class RouteMetric
{
    public function __construct(
        private readonly Router $router,
    ) {
    }

    /**
     * Handle an incoming request.
     *
     * @param Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //        if (!$this->statsHouse->enabled()) {
        //            return $next($request);
        //        }

        $startTime = (float) microtime(true);
        $result = $next($request);
        if ($this->router->current() !== null) {
            $error = $this->statsHouse->send('request', (float) microtime(true) - $startTime, [
                -1 => app()->isLocal() ? 'local' : 'product',
                $this->router->current()->uri(),
                $request->method(),
            ]);

            if ($error !== null) {
                logger()->error('Error send metrics', [
                    'message' => $error,
                ]);
            }
        }

        return $result;
    }
}
