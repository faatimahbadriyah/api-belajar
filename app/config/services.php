<?php

use Phalcon\Mvc\View\Simple as View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Logger\Multiple as MultipleStream;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\File as FileLogger;
/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});

/**
 * Sets the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setViewsDir($config->application->viewsDir);
    return $view;
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);
    return $url;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    /*$params = [
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset
    ];*/
    $params=$config->database->toArray();
    unset($params['adapter']);

    if ($config->database->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    $connection = new $class($params);

    return $connection;
});

/*$di->setShared("swagger",function($path=""){
  print "aaa";exit;
  require_once BASE_PATH . "/vendor/zircote/swagger-php/src/functions.php";
  print "sss";exit;
  return  \Swagger\scan($path);
});*/


$di->setShared("responseApi",function(){
  return new ResponseApi();
});

$di->setShared("requestApi",function() {
  $request=new RequestApi();
  $request->applicationId=$this->getRequest()->getHeader("app");
  $request->token=$this->getRequest()->getHeader("token");
  $request->limit=$this->getRequest()->getQuery("l","int",20);
  $request->offset=$this->getRequest()->getQuery("o","int",0);
  $request->sort=$this->getRequest()->getQuery("s");
  return $request;
});

$di->setShared("random",function(){
  return new Phalcon\Security\Random();
});

$di->setShared("common",function(){
  return new CommonLibrary();
});

$di->set("logger",function(){
    $config = $this->getConfig();
    $logger=new MultipleStream();
    $logger->push(new \Phalcon\Logger\Adapter\File($config->application->logsDir . date("Ymd") . ".log"));
    //$logger->push(new DatabaseLog(["db"=>$di->get('db')]));
    return $logger;
});

$di->set("cache", function(){
	$config = $this->getConfig();
	$frontCache = new Phalcon\Cache\Frontend\Data(
		[
			"lifetime" => 3600,
		]
	);

	// Create the component that will cache "Data" to a "Memcached" backend
	// Memcached connection settings
	$cache = new Phalcon\Cache\Backend\Libmemcached(
		$frontCache,
		[
			"servers" => [
				[
					"host"   => $config->cache->host,
					"port"   => $config->cache->port,
					"weight" => "1",
				]
			]
		]
	);

	return $cache;
});

$di->set(
    'modelsCache',
    function () {
        // Cache data for one day (default setting)
	$config = $this->getConfig();
        $frontCache = new Phalcon\Cache\Frontend\Data(
            [
                'lifetime' => 86400,
            ]
        );

	$cache = new Phalcon\Cache\Backend\Libmemcached(
		$frontCache,
		[
			"servers" => [
				[
					"host"   => $config->cache->host,
					"port"   => $config->cache->port,
					"weight" => "1",
				]
			]
		]
	);

        return $cache;
    }
);

$di->set('httpScheme',function(){
	    return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
});
$di->setShared('stomp', function () {
    $config = $this->getConfig();
    try {
		$stomp = new Stomp("tcp://{$config->stomp->host}:{$config->stomp->port}");
	} catch(StompException $e) {
		die ("Connection failed: ". $e->getMessage());
	}
	return $stomp;
});

$di->setShared('stompSend', function () {
    $config = $this->getConfig();
    try {
		$stomp = new Stomp("tcp://{$config->stomp->host}:{$config->stomp->port}");
	} catch(StompException $e) {
		die ("Connection failed: ". $e->getMessage());
	}
	return $stomp;
});

$di->setShared('fcm', function () {
    return new FcmLibrary();
});
