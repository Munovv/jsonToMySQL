<?php

require 'app/tools/Debuging.php'; // Дебагинг

use app\Application;

spl_autoload_register(function($class) {
    $path = str_replace('\\', '/', $class.'.php');
    if (file_exists($path)) {
        require $path;
    }
});


$application = new Application('childrens');
$application->run();

// В файле categories.json отсутствует элемент с ID-13.

?>
