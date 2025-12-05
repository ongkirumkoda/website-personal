<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIRAGA - System Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 3px solid #007bff;
            padding-bottom: 10px;
        }
        .status {
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            font-weight: bold;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        .warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #007bff;
            color: white;
        }
        .link-test {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-left: 4px solid #007bff;
        }
        .link-test a {
            color: #007bff;
            text-decoration: none;
            display: block;
            padding: 5px 0;
        }
        .link-test a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 SIRAGA System Test</h1>
        
        <?php
        // PHP Version Check
        $phpVersion = phpversion();
        $phpOk = version_compare($phpVersion, '7.4.0', '>=');
        ?>
        
        <div class="status <?php echo $phpOk ? 'success' : 'error'; ?>">
            PHP Version: <?php echo $phpVersion; ?>
            <?php echo $phpOk ? '✅ OK' : '❌ Minimum PHP 7.4 required'; ?>
        </div>

        <h2>📊 System Information</h2>
        <table>
            <tr>
                <th>Component</th>
                <th>Status</th>
            </tr>
            <tr>
                <td>PHP Version</td>
                <td><?php echo $phpVersion; ?></td>
            </tr>
            <tr>
                <td>Server Software</td>
                <td><?php echo $_SERVER['SERVER_SOFTWARE']; ?></td>
            </tr>
            <tr>
                <td>Document Root</td>
                <td><?php echo $_SERVER['DOCUMENT_ROOT']; ?></td>
            </tr>
            <tr>
                <td>Script Path</td>
                <td><?php echo __FILE__; ?></td>
            </tr>
        </table>

        <h2>🔌 Apache Modules</h2>
        <?php
        if (function_exists('apache_get_modules')) {
            $modules = apache_get_modules();
            $modRewrite = in_array('mod_rewrite', $modules);
            ?>
            <div class="status <?php echo $modRewrite ? 'success' : 'error'; ?>">
                mod_rewrite: <?php echo $modRewrite ? '✅ Aktif' : '❌ Tidak Aktif'; ?>
            </div>
            <?php if (!$modRewrite): ?>
                <div class="status error">
                    ⚠️ mod_rewrite harus diaktifkan! Edit httpd.conf dan restart Apache.
                </div>
            <?php endif; ?>
        <?php } else { ?>
            <div class="status warning">
                ⚠️ Tidak bisa mengecek Apache modules (mungkin menggunakan PHP-FPM)
            </div>
        <?php } ?>

        <h2>📦 PHP Extensions</h2>
        <?php
        $requiredExtensions = [
            'pdo' => 'PDO (Database)',
            'pdo_mysql' => 'PDO MySQL Driver',
            'mbstring' => 'Multibyte String',
            'openssl' => 'OpenSSL',
            'curl' => 'cURL',
            'json' => 'JSON',
            'gd' => 'GD (Image Processing)',
            'zip' => 'ZIP Archive'
        ];
        
        echo '<table>';
        echo '<tr><th>Extension</th><th>Status</th></tr>';
        foreach ($requiredExtensions as $ext => $name) {
            $loaded = extension_loaded($ext);
            $status = $loaded ? '✅ Loaded' : '❌ Missing';
            $class = $loaded ? 'success' : 'error';
            echo "<tr><td>$name</td><td class='$class'>$status</td></tr>";
        }
        echo '</table>';
        ?>

        <h2>📁 File & Directory Check</h2>
        <?php
        $files = [
            '.htaccess' => 'Apache rewrite rules',
            '.env' => 'Environment configuration',
            'index.php' => 'Entry point',
            'vendor/autoload.php' => 'Composer autoloader',
            'app/core/Router.php' => 'Router class',
            'routes/web.php' => 'Route definitions'
        ];
        
        echo '<table>';
        echo '<tr><th>File/Directory</th><th>Status</th></tr>';
        foreach ($files as $file => $desc) {
            $exists = file_exists(__DIR__ . '/' . $file);
            $status = $exists ? '✅ Exists' : '❌ Missing';
            $class = $exists ? 'success' : 'error';
            echo "<tr><td>$file<br><small>$desc</small></td><td class='$class'>$status</td></tr>";
        }
        echo '</table>';
        ?>

        <h2>🔐 .env Configuration</h2>
        <?php
        if (file_exists(__DIR__ . '/.env')) {
            echo '<div class="status success">✅ .env file found</div>';
            
            // Parse .env
            $envFile = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $envVars = [];
            foreach ($envFile as $line) {
                if (strpos(trim($line), '#') === 0) continue;
                if (strpos($line, '=') === false) continue;
                list($key, $value) = explode('=', $line, 2);
                $envVars[trim($key)] = trim($value);
            }
            
            echo '<table>';
            echo '<tr><th>Variable</th><th>Value</th></tr>';
            $importantVars = ['APP_URL', 'BASE_PATH', 'DB_NAME', 'DB_USER', 'DB_HOST'];
            foreach ($importantVars as $var) {
                $value = isset($envVars[$var]) ? $envVars[$var] : '<span class="error">NOT SET</span>';
                echo "<tr><td>$var</td><td>$value</td></tr>";
            }
            echo '</table>';
        } else {
            echo '<div class="status error">❌ .env file not found</div>';
        }
        ?>

        <div class="link-test">
            <h2>🔗 Test Routes</h2>
            <p>Klik link dibawah untuk test routing:</p>
            <a href="<?php echo dirname($_SERVER['PHP_SELF']); ?>/" target="_blank">🏠 Homepage (<?php echo dirname($_SERVER['PHP_SELF']); ?>/)</a>
            <a href="<?php echo dirname($_SERVER['PHP_SELF']); ?>/auth/login" target="_blank">🔐 Login Page</a>
            <a href="<?php echo dirname($_SERVER['PHP_SELF']); ?>/auth/register" target="_blank">📝 Register Page</a>
            <a href="<?php echo dirname($_SERVER['PHP_SELF']); ?>/dashboard" target="_blank">📊 Dashboard</a>
        </div>

        <div class="status info" style="margin-top: 30px;">
            <strong>📝 Catatan:</strong>
            <ul style="margin: 10px 0;">
                <li>Jika mod_rewrite tidak aktif, edit <code>httpd.conf</code></li>
                <li>Pastikan <code>AllowOverride All</code> di konfigurasi Apache</li>
                <li>Sesuaikan <code>RewriteBase</code> di <code>.htaccess</code></li>
                <li>Sesuaikan <code>BASE_PATH</code> di <code>.env</code></li>
            </ul>
        </div>
    </div>
</body>
</html>
