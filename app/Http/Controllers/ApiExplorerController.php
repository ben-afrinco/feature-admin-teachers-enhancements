<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Services\AdminPanelService;

/**
 * ApiExplorerController - Interactive API endpoint browser and tester.
 */
class ApiExplorerController extends Controller
{
    /**
     * Show API Explorer interface.
     */
    public function index()
    {
        $nav = AdminPanelService::getSidebarNav();

        // Collect all registered routes
        $routes = collect(Route::getRoutes())->map(function ($route) {
            return [
                'method'     => implode('|', $route->methods()),
                'uri'        => $route->uri(),
                'name'       => $route->getName(),
                'action'     => $route->getActionName(),
                'middleware'  => implode(', ', $route->middleware()),
            ];
        })->filter(function ($route) {
            // Exclude internal framework routes
            return !str_starts_with($route['uri'], '_') && !str_starts_with($route['uri'], 'sanctum');
        })->values();

        // Group routes by prefix
        $grouped = $routes->groupBy(function ($route) {
            $parts = explode('/', $route['uri']);
            return $parts[0] ?? 'root';
        });

        return view('admin-panel.api-explorer', compact('nav', 'routes', 'grouped'));
    }

    /**
     * Execute an API request (proxy).
     */
    public function execute(Request $request)
    {
        $method = strtoupper($request->input('method', 'GET'));
        $url = $request->input('url');
        $headers = $request->input('headers', []);
        $body = $request->input('body', '');

        // Build internal request
        $startTime = microtime(true);

        try {
            $internalRequest = Request::create($url, $method, [], [], [], [], $body);

            foreach ($headers as $key => $value) {
                $internalRequest->headers->set($key, $value);
            }

            // Copy session
            $internalRequest->setLaravelSession(session());

            $response = app()->handle($internalRequest);

            $duration = round((microtime(true) - $startTime) * 1000, 2);

            return response()->json([
                'status'   => $response->getStatusCode(),
                'headers'  => $response->headers->all(),
                'body'     => $response->getContent(),
                'duration' => $duration . 'ms',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 500,
                'body'    => json_encode(['error' => $e->getMessage()]),
                'duration' => round((microtime(true) - $startTime) * 1000, 2) . 'ms',
            ]);
        }
    }
}
