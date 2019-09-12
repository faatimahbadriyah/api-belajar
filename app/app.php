<?php
/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */

$routes=require(__DIR__  . DIRECTORY_SEPARATOR .'config/' . 'routes.php');

$microCollections=[];
foreach($routes as $key=>$row):
  $microCollections[$key]=new Phalcon\Mvc\Micro\Collection();
  $microCollections[$key]->setHandler($row["controller"], true);
  foreach($row["data"] as $action):
    $microCollections[$key]->{$action["method"]}($action["path"],$action["action"]);
    //call_user_func_array([$microCollections[$key],$action["method"]],[$action["path"],$action["action"]]);
  endforeach;
  $app->mount($microCollections[$key]);
endforeach;


$app->setService("checkAuth", function () use ($app,$routes){
  $handler=$app->getActiveHandler();
  foreach($routes as $route):
    if($route["controller"]==$handler[0]->getDefinition()):
      foreach($route["data"] as $data):
        if($data["action"]==$handler[1]):
          return isset($data["checkAuth"])? $data["checkAuth"] : true;
          break;
        endif;
      endforeach;
    endif;
  endforeach;
  return true;
});

$app->setService("adminAuth", function () use ($app,$routes){
  $handler=$app->getActiveHandler();
  foreach($routes as $route):
    if($route["controller"]==$handler[0]->getDefinition()):
      foreach($route["data"] as $data):
        if($data["action"]==$handler[1]):
          return isset($data["adminAuth"])? $data["adminAuth"] : false;
          break;
        endif;
      endforeach;
    endif;
  endforeach;
  return true;
});

/**
 * Not found handler
 */
$app->notFound(function () use($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo $app['view']->render('404');
});
$app->before(function () use($app,$routes) {
  $app->logger->info("POST Request: " . json_encode($_POST));
  $app->logger->info("GET Request: " . json_encode($_GET));
  $app->logger->info("POST Body Request: " . file_get_contents("php://input"));
  $app->logger->info("FILE  Request: " . json_encode($_FILES));
  $app->logger->info($app->common->clientIp()."-Header: " . json_encode($app->common->getallheaders()));
  // Get Roles
  $scRoles=ScRole::find();
  $app->requestApi->data->roles=!empty($scRoles) ? $scRoles:[];
  if($app->checkAuth): // Need to verified
    $application=Applications::findFirstByAppId($app->requestApi->applicationId);
    
    if(!$application):
      throw new Exception(Definitions::message(Definitions::E_INVALID_APPLICATION),Definitions::E_INVALID_APPLICATION);
    endif;
    
  
    $app->requestApi->data->application=$application;
    $app->requestApi->data->input_str=file_get_contents("php://input");
    $app->requestApi->data->input=json_decode($app->requestApi->data->input_str);
    if(trim($app->requestApi->token)!=trim($application->token)):
      throw new Exception(Definitions::message(Definitions::E_INVALID_TOKEN),Definitions::E_INVALID_TOKEN);
    endif;
    if(strtotime($application->expired)<time()):
      //$application->delete(); // Delete token when expire
      throw new Exception(Definitions::message(Definitions::E_TOKEN_EXPIRED),Definitions::E_TOKEN_EXPIRED);
    endif;
    $app->requestApi->data->application=$application;
    $app->requestApi->data->input_str=file_get_contents("php://input");
    $app->requestApi->data->input=json_decode($app->requestApi->data->input_str);
    // update token
    $application->expired=date("Y-m-d H:i:s",(time()+$app->config->token->expire));
    $application->save();
  endif;
});

$app->after(function () use($app) {
  $handler=$app->getActiveHandler();
  if(!in_array($handler[1],["doc","swagger","swagger.json"])):
    $app->logger->info("Response: " . json_encode($app->responseApi));
    $app->response->setJsonContent($app->responseApi);
    $app->response->send($app->responseApi);
  endif;
});
$app->error(function ($exception) use($app) {
  $app->responseApi->status=$exception->getCode();
  if($app->responseApi->status==0):
    $app->responseApi->status=Definitions::E_DATABASE;
  endif;
  $app->responseApi->message=Definitions::message($app->responseApi->status);
  $app->responseApi->data=$exception->getMessage();
  $app->logger->error("Response: " . json_encode($app->responseApi));
  $app->logger->error("Response System: " . json_encode($exception->getMessage()));
  $app->response->setJsonContent($app->responseApi);
  $app->response->send($app->responseApi);
  exit;
});
