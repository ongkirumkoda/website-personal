<?php
/**
 * SIRAGA Router Class (Fixed Version)
 * Handles HTTP routing with middleware support
 * 
 * @package    SIRAGA
 * @subpackage Core
 * @version    1.0.1 (Fixed)
 */

namespace Siraga\Core;

class Router {
    
    /**
     * Registered routes
     * @var array
     */
    private $routes = [];
    
    /**
     * Global middlewares
     * @var array
     */
    private $globalMiddlewares = [];
    
    /**
     * Base path for routing
     * @var string
     */
    private $basePath = '';
    
    /**
     * Constructor
     */
    public function __construct() {
        // Get base path from environment
        $this->basePath = getenv('BASE_PATH') ?: '';
        $this->basePath = rtrim($this->basePath, '/');
    }
    
    /**
     * Add GET route
     */
    public function get($path, $handler, $middlewares = []) {
        $this->addRoute('GET', $path, $handler, $middlewares);
        return $this;
    }
    
    /**
     * Add POST route
     */
    public function post($path, $handler, $middlewares = []) {
        $this->addRoute('POST', $path, $handler, $middlewares);
        return $this;
    }
    
    /**
     * Add PUT route
     */
    public function put($path, $handler, $middlewares = []) {
        $this->addRoute('PUT', $path, $handler, $middlewares);
        return $this;
    }
    
    /**
     * Add DELETE route
     */
    public function delete($path, $handler, $middlewares = []) {
        $this->addRoute('DELETE', $path, $handler, $middlewares);
        return $this;
    }
    
    /**
     * Add route to routes array
     */
    private function addRoute($method, $path, $handler, $middlewares = []) {
        // Normalize path
        $path = '/' . trim($path, '/');
        if ($path === '/') {
            $path = '/';
        }
        
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler,
            'middlewares' => is_array($middlewares) ? $middlewares : [$middlewares]
        ];
    }
    
    /**
     * Add global middleware
     */
    public function middleware($middleware) {
        $this->globalMiddlewares[] = $middleware;
        return $this;
    }
    
    /**
     * Dispatch the request to matching route
     */
    public function dispatch() {
        // Get request method
        $method = $_SERVER['REQUEST_METHOD'];
        
        // Handle method override for PUT/DELETE
        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }
        
        // Get request URI
        $uri = $this->getRequestUri();
        
        // Debug mode
        if (getenv('APP_DEBUG') === 'true' && isset($_GET['debug'])) {
            $this->debugRoutes($method, $uri);
            return;
        }
        
        // Try to match route
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchPath($route['path'], $uri, $params)) {
                // Run global middlewares
                foreach ($this->globalMiddlewares as $middleware) {
                    $this->runMiddleware($middleware);
                }
                
                // Run route middlewares
                foreach ($route['middlewares'] as $middleware) {
                    $this->runMiddleware($middleware);
                }
                
                // Execute handler
                return $this->executeHandler($route['handler'], $params);
            }
        }
        
        // No route matched - 404
        $this->notFound($method, $uri);
    }
    
    /**
     * Get request URI
     */
    private function getRequestUri() {
        $uri = $_SERVER['REQUEST_URI'];
        
        // Remove query string
        $uri = strtok($uri, '?');
        
        // Remove base path
        if ($this->basePath && strpos($uri, $this->basePath) === 0) {
            $uri = substr($uri, strlen($this->basePath));
        }
        
        // Normalize
        $uri = '/' . trim($uri, '/');
        if ($uri === '/') {
            $uri = '/';
        }
        
        return $uri;
    }
    
    /**
     * Match route path with URI
     */
    private function matchPath($routePath, $uri, &$params = []) {
        $params = [];
        
        // Exact match
        if ($routePath === $uri) {
            return true;
        }
        
        // Dynamic parameter match
        $routePattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $routePath);
        $routePattern = '#^' . $routePattern . '$#';
        
        if (preg_match($routePattern, $uri, $matches)) {
            // Extract named parameters
            foreach ($matches as $key => $value) {
                if (!is_numeric($key)) {
                    $params[$key] = $value;
                }
            }
            return true;
        }
        
        return false;
    }
    
    /**
     * Run middleware
     */
    private function runMiddleware($middleware) {
        if (is_string($middleware)) {
            // Class name string
            $middlewareClass = $middleware;
            if (!class_exists($middlewareClass)) {
                $middlewareClass = "Siraga\\Middleware\\$middleware";
            }
            
            if (class_exists($middlewareClass)) {
                $middlewareInstance = new $middlewareClass();
                if (method_exists($middlewareInstance, 'handle')) {
                    $middlewareInstance->handle();
                }
            }
        } elseif (is_callable($middleware)) {
            // Closure
            call_user_func($middleware);
        }
    }
    
    /**
     * Execute route handler
     */
    private function executeHandler($handler, $params = []) {
        if (is_callable($handler)) {
            // Closure/function
            return call_user_func_array($handler, array_values($params));
            
        } elseif (is_string($handler)) {
            // Controller@method format
            if (strpos($handler, '@') !== false) {
                list($controller, $method) = explode('@', $handler, 2);
                
                // Try to load controller
                $controllerClass = $controller;
                if (!class_exists($controllerClass)) {
                    $controllerClass = "Siraga\\Controllers\\$controller";
                }
                
                if (class_exists($controllerClass)) {
                    $controllerInstance = new $controllerClass();
                    
                    if (method_exists($controllerInstance, $method)) {
                        return call_user_func_array(
                            [$controllerInstance, $method],
                            array_values($params)
                        );
                    } else {
                        $this->error("Method '$method' not found in controller '$controllerClass'");
                    }
                } else {
                    $this->error("Controller '$controllerClass' not found");
                }
            } else {
                $this->error("Invalid handler format: '$handler'");
            }
        } elseif (is_array($handler)) {
            // Array format [Controller::class, 'method']
            return call_user_func_array($handler, array_values($params));
        }
        
        $this->error("Invalid handler type");
    }
    
    /**
     * 404 Not Found response
     */
    private function notFound($method, $uri) {
        http_response_code(404);
        
        if (getenv('APP_DEBUG') === 'true') {
            echo '<!DOCTYPE html>';
            echo '<html><head><title>404 Not Found</title>';
            echo '<style>
                body { font-family: Arial, sans-serif; margin: 50px; background: #f5f5f5; }
                .container { background: white; padding: 30px; border-radius: 10px; max-width: 800px; margin: 0 auto; }
                h1 { color: #e74c3c; }
                .info { background: #ecf0f1; padding: 15px; border-radius: 5px; margin: 20px 0; }
                .routes { background: #ecf0f1; padding: 15px; border-radius: 5px; }
                .routes ul { list-style: none; padding: 0; }
                .routes li { padding: 5px 0; font-family: monospace; }
            </style>';
            echo '</head><body>';
            echo '<div class="container">';
            echo '<h1>404 - Route Not Found</h1>';
            echo '<div class="info">';
            echo '<p><strong>Method:</strong> ' . htmlspecialchars($method) . '</p>';
            echo '<p><strong>URI:</strong> ' . htmlspecialchars($uri) . '</p>';
            echo '<p><strong>Base Path:</strong> ' . htmlspecialchars($this->basePath) . '</p>';
            echo '</div>';
            echo '<div class="routes">';
            echo '<h3>Available Routes:</h3>';
            echo '<ul>';
            foreach ($this->routes as $route) {
                $handler = is_string($route['handler']) ? $route['handler'] : 'Closure';
                echo '<li><strong>' . $route['method'] . '</strong> ' . $route['path'] . ' → ' . $handler . '</li>';
            }
            echo '</ul>';
            echo '</div>';
            echo '<p><a href="' . ($this->basePath ?: '/') . '">← Back to Home</a></p>';
            echo '</div>';
            echo '</body></html>';
        } else {
            echo '<!DOCTYPE html>';
            echo '<html><head><title>404 Not Found</title></head>';
            echo '<body><h1>404 - Page Not Found</h1>';
            echo '<p>The requested page could not be found.</p>';
            echo '<p><a href="' . ($this->basePath ?: '/') . '">← Back to Home</a></p>';
            echo '</body></html>';
        }
        exit;
    }
    
    /**
     * Error response
     */
    private function error($message) {
        http_response_code(500);
        
        if (getenv('APP_DEBUG') === 'true') {
            echo '<h1>Router Error</h1>';
            echo '<p>' . htmlspecialchars($message) . '</p>';
        } else {
            echo '<h1>500 - Internal Server Error</h1>';
            echo '<p>Something went wrong.</p>';
        }
        exit;
    }
    
    /**
     * Debug routes (for development)
     */
    private function debugRoutes($currentMethod, $currentUri) {
        echo '<!DOCTYPE html>';
        echo '<html><head><title>Route Debugger</title>';
        echo '<style>
            body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
            .container { background: white; padding: 30px; border-radius: 10px; max-width: 1000px; margin: 0 auto; }
            h1 { color: #3498db; }
            table { width: 100%; border-collapse: collapse; margin: 20px 0; }
            th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
            th { background: #3498db; color: white; }
            .current { background: #ffffcc; }
            .method { font-weight: bold; padding: 5px 10px; border-radius: 3px; }
            .GET { background: #61affe; color: white; }
            .POST { background: #49cc90; color: white; }
            .PUT { background: #fca130; color: white; }
            .DELETE { background: #f93e3e; color: white; }
        </style>';
        echo '</head><body>';
        echo '<div class="container">';
        echo '<h1>🔍 Route Debugger</h1>';
        echo '<p><strong>Current Request:</strong> <span class="method ' . $currentMethod . '">' . $currentMethod . '</span> ' . htmlspecialchars($currentUri) . '</p>';
        echo '<p><strong>Base Path:</strong> ' . htmlspecialchars($this->basePath) . '</p>';
        echo '<h2>Registered Routes:</h2>';
        echo '<table>';
        echo '<tr><th>Method</th><th>Path</th><th>Handler</th><th>Middlewares</th></tr>';
        foreach ($this->routes as $route) {
            $handler = is_string($route['handler']) ? $route['handler'] : 'Closure';
            $middlewares = empty($route['middlewares']) ? '-' : implode(', ', $route['middlewares']);
            $isCurrent = ($route['method'] === $currentMethod && $route['path'] === $currentUri) ? 'current' : '';
            echo '<tr class="' . $isCurrent . '">';
            echo '<td><span class="method ' . $route['method'] . '">' . $route['method'] . '</span></td>';
            echo '<td>' . htmlspecialchars($route['path']) . '</td>';
            echo '<td>' . htmlspecialchars($handler) . '</td>';
            echo '<td>' . htmlspecialchars($middlewares) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '</div>';
        echo '</body></html>';
        exit;
    }
}
