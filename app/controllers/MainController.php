<?php
class MainController extends Phalcon\Mvc\Controller
{
  public function index()
  {
      print "School Connect Main API";
      /*if($this->common->sendsms(["+62817123"],"ada ngga nih?")):
        $this->responseApi->status=0;
        $this->responseApi->message="Success";
      endif;*/
  }

  public function data()
  {
    print "data\n";
  }

  public function doc()
  {
	if ($_SERVER['PHP_AUTH_USER']!="data" || $_SERVER['PHP_AUTH_PW']!='fatimah') {
		header('WWW-Authenticate: Basic realm="BSMitra Access"');
		header('HTTP/1.0 401 Unauthorized');
		echo 'Your are not authorized';
		exit;
	}
    echo $this->view->render("main/doc.phtml");
  }

  public function swagger()
  {
	if (!isset($_SERVER['PHP_AUTH_USER']) && !isset($_SERVER['PHP_AUTH_PW']) || ($_SERVER['PHP_AUTH_USER']!="data" && $_SERVER['PHP_AUTH_PW']!='kreativia')) {
		header('WWW-Authenticate: Basic realm="School Connect Access"');
		header('HTTP/1.0 401 Unauthorized');
		echo 'Your are not authorized';
		exit;
	}
	//if{
    require_once BASE_PATH . "/vendor/zircote/swagger-php/src/functions.php";
    $swagger = \Swagger\scan(APP_PATH);
    header('Content-Type: application/json');
    echo $swagger;
	//}
  }

}
