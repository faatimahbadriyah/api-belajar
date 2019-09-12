<?php
/**
 * @SWG\Definition()
 */
class RequestApi
{
  /**
 * Application ID (Default "")
 * @var integer
 * @SWG\Property()
 */
  public $applicationId="";
  /**
   * Token
   * @var string
   * @SWG\Property()
   */
  public $token="";
  /**
   * Additional data
   * @var object
   * @SWG\Property()
   */
  public $data;

  public function __construct()
  {
    $this->data=new stdClass();
  }
}
