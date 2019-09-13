<?php
/**
  * @SWG\Swagger(
   * basePath="/",
   * @SWG\Info(title="Belajar API", version="0.1",
   *    description="API for Belajar "
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
  * @SWG\Definition(definition="AddData",
  * @SWG\Property(property="namamhs", type="string", example="Edward Swan", description="Nama"),
  * @SWG\Property(property="notlpmhs", type="string", example="089789887889", description="No. Tlp"),
  * @SWG\Property(property="tgllahirmhs", type="date", example="2000-02-20", description="Tanggal Lahir"),
  * )  
  * @SWG\Definition(definition="EditData",
  * @SWG\Property(property="idmhs", type="int", example="1", description="ID Mahasiswa"),
  * @SWG\Property(property="namamhs", type="string", example="Edward Swan", description="Nama"),
  * @SWG\Property(property="notlpmhs", type="string", example="089789887889", description="No. Tlp"),
  * @SWG\Property(property="tgllahirmhs", type="date", example="2000-02-20", description="Tanggal Lahir"),
  * ) 
  * @SWG\Definition(definition="DeleteData",
  * @SWG\Property(property="idmhs", type="int", example="1", description="ID Mahasiswa"),
  * )
  * @SWG\Definition(definition="AddDataMk",
  * @SWG\Property(property="namamk", type="string", example="Bahasa Inggris", description="Nama Matakuliah"),
  * ) 
  * @SWG\Definition(definition="EditDataMk",
  * @SWG\Property(property="idmk", type="int", example="1", description="ID Matakuliah"),
  * @SWG\Property(property="namamk", type="string", example="Bahasa Inggris", description="Nama Matakuliah"),
  * )
  * @SWG\Definition(definition="DeleteDataMk",
  * @SWG\Property(property="idmk", type="int", example="1", description="ID Matakuliah"),
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
