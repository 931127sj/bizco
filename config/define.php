<?php
/**
 * 지금 여기서 필요한것들을 정의해놓는 파일
 */

# Primary constant
define('DIR',    __DIR__.'/../');

define('VIEW',   DIR.'views/');
define('HELPER', DIR.'helpers/');

# Assets constant
define('ASSETS', '/assets/');
define('CSS',    ASSETS.'css/');
define('JS',     ASSETS.'js/');


# autoload
spl_autoload_register(function ($class) {
    $prefix = '';
    $base_dir = DIR;

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0)
        return;

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file))
        require $file;
});

$view = new stdClass();
$view->load = new \librarys\ViewLoader;