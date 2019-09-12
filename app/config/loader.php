<?php

/**
 * Registering an autoloader
 */
$loader = new \Phalcon\Loader();

include_once BASE_PATH ."/vendor/autoload.php";
$loader->registerDirs(
    [
        $config->application->modelsDir,
        $config->application->modelStaticDir,
        $config->application->controllersDir,
        $config->application->libraryDir,
        //$config->application->traitsDir,
    ]
)->register();



$loader->registerNamespaces(
    [
       "Swagger" => BASE_PATH . "/vendor/zircote/swagger-php/src/",
       "Symfony\\Component\\Finder" => BASE_PATH . "/vendor/symfony/finder",
       "Doctrine\\Common\\Annotations" => BASE_PATH . "/vendor/doctrine/annotations/lib/Doctrine/Common/Annotations",
       "Doctrine\\Common\\Lexer" => BASE_PATH . "/vendor/doctrine/lexer/lib/Doctrine/Common/Lexer",
       'Phalcon' => BASE_PATH . '/vendor/phalcon/incubator/Library/Phalcon/',
       "BSMitra"=>APP_PATH . "/library/BSMitra",
       "Bsm\\Models"=>APP_PATH ."/models",
       "FFMpeg"=>BASE_PATH ."/vendor/php-ffmpeg/php-ffmpeg/src/FFMpeg/",
    ]
);
