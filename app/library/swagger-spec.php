<?php
/**
  * @SWG\Swagger(
   * basePath="/",
   * @SWG\Info(title="School Connect API", version="0.1",
   *    description="API for School Connect "
   * )
   *)
   */

/**
  *
  * @SWG\Definition(definition="ResponseApiTemplate", type="object",
  *   @SWG\Property(property="status", type="integer", example="0"),
  *   @SWG\Property(property="message", type="string", example="Success")
  * )
  *
  * @SWG\Definition(definition="ResponseApiData",
  *   @SWG\Property(property="data", type="object")
  * )
  *
  *
  * @SWG\Definition(
  *   definition="ResponseApiId",
  *   allOf={
  *    @SWG\Schema(ref="#/definitions/ResponseApiTemplate"),
  *    @SWG\Schema(required={"data"}, type="object",
  *       @SWG\Property(property="data",type="object",
  *         @SWG\Property(property="id", type="string", example="518cb7fe-c9bf-11e7-b626-5254005c6ff0")
  *       )
  *    )
  *   }
  * )

  * @SWG\Definition(definition="Work",
  *   @SWG\Property(property="id", type="string", example="1", description="Work Name"),
  *   @SWG\Property(property="name", type="string", example="Sys Admin", description="Work Name"),
  * )

  * @SWG\Definition(definition="WorksData",
  *   @SWG\Property(property="data", type="array",
  *       @SWG\Items(ref="#/definitions/Work")
  *  )
  * )
  * @SWG\Definition(definition="ResponseApiWorks",
  *   allOf={
  *    @SWG\Schema(ref="#/definitions/ResponseApiTemplate"),
  *    @SWG\Schema(ref="#/definitions/WorksData"),
  *   }
  * )  
  * @SWG\Definition(definition="Belajar",
  * @SWG\Property(property="idstudent", type="string", example="1", description="idstudent"),
  * @SWG\Property(property="idclass", type="string", example="3", description="idclass"),
  * ) 
  * @SWG\Definition(definition="ImagePng",
  * 	@SWG\Property(
  * 		property="image", type="binary",
  * 	),
  * )
    * @SWG\Definition(definition="VideoFile",
  * 	@SWG\Property(
  * 		property="video", type="binary",
  * 	),
  * )
 */
