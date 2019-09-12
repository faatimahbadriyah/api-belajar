<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

if(file_exists(APP_PATH ."/app/config/environment.php")):
    $envConfig=require( APP_PATH  ."/app/config/environment.php");
    $environment=isset($envConfig->environment) ? $envConfig->environment: "development";
else:
    $environment="development";
endif;
defined('APP_ENV') ||
    define('APP_ENV', $environment);


$config=new \Phalcon\Config([
    'database' => [
        'adapter'    => 'Mysql',
        'host'       => 'localhost',
        'username'   => 'root',
        'password'   => '',
        'dbname'     => 'test',
  //      'charset'    => 'utf8',
    ],

    'application' => [
        "kerjaku_client_id"=>"id-kerjaku",
        "kerjaku_user_id"=>"id-kerjaku",
        'modelsDir'      => APP_PATH . '/models/',
        'modelStaticDir'      => APP_PATH . '/models/static/',
        'controllersDir'      => APP_PATH . '/controllers/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'libraryDir'       => APP_PATH . '/library/',
        'traitsDir'       => APP_PATH . '/traits/',
        'logsDir'       => BASE_PATH . '/logs/',
        'dataDir'       => BASE_PATH ."/data/",
        'baseUri'        => '/',
        "salesDistance"=>5,
        "limit_sales_pembiayaan"=>10 , // per day
    ],
    "file"=>[
        "base"=>BASE_PATH ."/data/",
        "activity_photo"=>"activity/photo/",
        "announcement_photo"=>"school/announcement/photo/",
        "user_photo"=>"user/photo/",
        "generalactivity_photo"=>"generalactivity/photo/",
        "generalactivity_video"=>"generalactivity/video/",
        "generalactivity_video_thumbnail"=>"generalactivity/video/thumbnail/",
        "activity_video"=>"activity/video/",
        "activity_video_thumbnail"=>"activity/video/thumbnail/",
    ],
]);

$configFile=dirname(__FILE__). DIRECTORY_SEPARATOR . 'env' . DIRECTORY_SEPARATOR . APP_ENV .'.php';
if(file_exists($configFile)):
    $configEnv=require('env' . DIRECTORY_SEPARATOR . APP_ENV .'.php');
    $config->merge($configEnv);
endif;
return $config;
