<?php
/**
 * @SWG\Definition()
 */
class ResponseApi
{
  /**
 * Status Code (Default -1)
 * @var integer
 * @SWG\Property()
 */
  public $status=-1;
  /**
   * Message Status
   * @var string
   * @SWG\Property()
   */
  public $message="Unknown";
  /**
   * Data will pass to response
   * @var object
   * @SWG\Property(
   *  description="Type stdClass()"
   )
   */
  public $data;
  public function __construct()
  {
    $this->data=new stdClass();
  }
}
