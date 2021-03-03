<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';

if (file_exists('../settings/global_settings.json')) {
    $json = file_get_contents('../settings/global_settings.json');
    if ($json !== false) {
        $globalSettings = @json_decode($json, true);
        if ($globalSettings) {
            $settings = array_replace_recursive($settings, $globalSettings);
        }
    }
} else if (file_exists('../global_settings.json')) {
    $json = file_get_contents(__DIR__ . '/../global_settings.json');
    if ($json !== false) {
        $globalSettings = @json_decode($json, true);
        if ($globalSettings) {
            $settings = array_replace_recursive($settings, $globalSettings);
        }
    }
}

$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();
