<?php
/**
 * SIRAGA - Sistem Pencatatan Tumbuh Kembang Anak
 * Application Entry Point
 * 
 * @package SIRAGA
 * @version 1.0.0
 */

// Start session
session_start();

// Define root path
define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('STORAGE_PATH', ROOT_PATH . '/storage');
define('CONFIG_PATH', ROOT_PATH . '/config');

// Error reporting based on environment
$env = getenv('APP_ENV') ?: 'development';
if ($env === 'production') {
    error_reporting(0);
    ini_set('display_errors', 0);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Load environment variables
require_once ROOT_PATH . '/config/env.php';

// Load core files
require_once APP_PATH . '/core/Database.php';
require_once APP_PATH . '/core/Router.php';
require_once APP_PATH . '/core/Controller.php';
require_once APP_PATH . '/core/Model.php';
require_once APP_PATH . '/core/Middleware.php';
require_once APP_PATH . '/core/Logger.php';
require_once APP_PATH . '/helpers/functions.php';

// Autoload classes
spl_autoload_register(function ($class) {
    $paths = [
        APP_PATH . '/models/',
        APP_PATH . '/controllers/',
        APP_PATH . '/middleware/',
        APP_PATH . '/services/',
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Initialize router
$router = new Router();

// Load routes
require_once ROOT_PATH . '/routes/web.php';
require_once ROOT_PATH . '/routes/api.php';

// Handle request
try {
    $router->dispatch();
} catch (Exception $e) {
    // Log error
    Logger::error('Application Error: ' . $e->getMessage());
    
    // Show error page
    if ($env === 'production') {
        http_response_code(500);
        require_once ROOT_PATH . '/app/views/errors/500.php';
    } else {
        echo '<h1>Application Error</h1>';
        echo '<p>' . $e->getMessage() . '</p>';
        echo '<pre>' . $e->getTraceAsString() . '</pre>';
    }
}
