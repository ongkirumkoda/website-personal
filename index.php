<?php
/**
 * SIRAGA - Sistema Pencatatan Tumbuh Kembang Anak
 * Front Controller / Entry Point
 * 
 * @package    SIRAGA
 * @version    1.0.1 (Fixed)
 * @author     SIRAGA Dev Team
 */

// ==============================================
// Error Reporting (Development)
// ==============================================

error_reporting(E_ALL);
ini_set('display_errors', 1);

// ==============================================
// Define Paths
// ==============================================

define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . '/app');
define('CONFIG_PATH', ROOT_PATH . '/config');
define('STORAGE_PATH', ROOT_PATH . '/storage');
define('PUBLIC_PATH', ROOT_PATH . '/public');

// ==============================================
// Load Composer Autoloader
// ==============================================

if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    die('
    <h1>Error: Dependencies Not Installed</h1>
    <p>Please run: <code>composer install</code></p>
    <p>Or download composer from: <a href="https://getcomposer.org">getcomposer.org</a></p>
    ');
}

require_once __DIR__ . '/vendor/autoload.php';

// ==============================================
// Load Environment Variables
// ==============================================

if (!file_exists(__DIR__ . '/.env')) {
    die('
    <h1>Error: .env File Not Found</h1>
    <p>Please copy .env.example to .env and configure it</p>
    <p><code>cp .env.example .env</code></p>
    ');
}

// Simple .env loader
$envFile = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($envFile as $line) {
    if (strpos(trim($line), '#') === 0) continue;
    if (strpos($line, '=') === false) continue;
    
    list($key, $value) = explode('=', $line, 2);
    $key = trim($key);
    $value = trim($value);
    
    if (!array_key_exists($key, $_ENV)) {
        putenv("$key=$value");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

// ==============================================
// Set Timezone
// ==============================================

date_default_timezone_set(getenv('TIMEZONE') ?: 'Asia/Jakarta');

// ==============================================
// Session Start
// ==============================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ==============================================
// Load Helper Functions
// ==============================================

if (file_exists(APP_PATH . '/helpers/functions.php')) {
    require_once APP_PATH . '/helpers/functions.php';
}

// ==============================================
// Load Routes
// ==============================================

if (!file_exists(ROOT_PATH . '/routes/web.php')) {
    die('
    <h1>Error: Routes File Not Found</h1>
    <p>File <code>routes/web.php</code> is missing</p>
    ');
}

try {
    // Initialize Router
    $router = new \Siraga\Core\Router();
    
    // Load route definitions
    require_once ROOT_PATH . '/routes/web.php';
    
    // Dispatch the request
    $router->dispatch();
    
} catch (Exception $e) {
    // Error handling
    if (getenv('APP_DEBUG') === 'true') {
        echo '<h1>Application Error</h1>';
        echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
        echo '<p><strong>File:</strong> ' . $e->getFile() . '</p>';
        echo '<p><strong>Line:</strong> ' . $e->getLine() . '</p>';
        echo '<pre>' . $e->getTraceAsString() . '</pre>';
    } else {
        echo '<h1>500 - Internal Server Error</h1>';
        echo '<p>Something went wrong. Please contact the administrator.</p>';
    }
    
    // Log error
    error_log($e->getMessage());
}
