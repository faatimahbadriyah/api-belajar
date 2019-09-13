<?php
class MatakuliahController extends Phalcon\Mvc\Controller
{
  /**
    *
    * @SWG\Get(
    *   path="/matkul",
    *   tags={"Matakuliah"},
    *   summary="Get Data Matkul",
    *   produces={"application/json"},
    *   @SWG\Response(
    *     response=200,
    *     description="success",
    *    @SWG\Schema(ref="#/definitions/ResponseApiWorks")
    *   )
    * )
    */
    public function getData(){
        $q = $this->modelsManager->createQuery('SELECT * FROM Matakuliah'); 
        $datas = $q->execute();
        
        $this->responseApi->status=0;
        $this->responseApi->message="Success";
        $this->responseApi->data=!empty($datas)? $datas :[];
    }

    /**
     *
     * @SWG\Post(
     *   path="/matkul",
     *   tags={"Matakuliah"},
     *   summary="Add Matakuliah",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="data",
     *     required=true,
     *     description="Activity Data",
     *     @SWG\Schema(ref="#/definitions/AddDataMk")
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="success",
     *    @SWG\Schema(ref="#/definitions/ResponseApiWorks")
     *   )
     * )
     */

    public function addData(){
      $params = $this->common->parseParameters();        

      $matkul= new Matakuliah;        
      $matkul->namamk = $params->namamk;

      $save = $matkul->save(); 

      $message = "Success";
      if(!$save){
          $message = "Failed";
      }

      $this->responseApi->status=0;
      $this->responseApi->message=$message;
    }

    /**
     *
     * @SWG\Put(
     *   path="/matkul",
     *   tags={"Matakuliah"},
     *   summary="Edit Data Matkul",
     *   produces={"application/json"},
     *     @SWG\Parameter(
     *     in="body",
     *     name="data",
     *     required=true,
     *     description="Activity Data",
     *     @SWG\Schema(ref="#/definitions/EditDataMk")
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="success",
     *    @SWG\Schema(ref="#/definitions/ResponseApiWorks")
     *   )
     * )
     */

    public function editData(){
      $params = $this->common->parseParameters();

      $matkul = Matakuliah::findFirst($params->idmk);
      $matkul->namamk = $params->namamk;
      
      $message = "Data Not Found";
      if($matkul){
          $save = $matkul->save();
          if(!$save){
              $message = "Failed";
          }
          $message = "Success";
      }

      $this->responseApi->status=0;
      $this->responseApi->message=$message;
    }

    /**
     *
     * @SWG\Delete(
     *   path="/matkul",
     *   tags={"Matakuliah"},
     *   summary="Delete Data Matakuliah",
     *   produces={"application/json"},
     *     @SWG\Parameter(
     *     in="body",
     *     name="data",
     *     required=true,
     *     description="Activity Data",
     *     @SWG\Schema(ref="#/definitions/DeleteDataMk")
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="success",
     *    @SWG\Schema(ref="#/definitions/ResponseApiWorks")
     *   )
     * )
     */

    public function deleteData(){
      $params = $this->common->parseParameters();
      
      $matkul = Matakuliah::findFirst($params->idmk);
      
      $message = "Data Not Found";
      if($matkul){
          $delete = $matkul->delete();         
          if(!$delete){
              $message = "Failed";
          }   
          $message = "Success";
      }

      $this->responseApi->status=0;
      $this->responseApi->message=$message;
    }

    /**
    *
    * @SWG\Get(
    *   path="/matkul/mk",
    *   tags={"Matakuliah"},
    *   summary="Get Data Matakuliah By ID",
    *   produces={"application/json"},
    *   @SWG\Parameter(
    *     in="query",
    *     type="number",
    *     name="idmk",
    *     required=true,
    *     description="ID Matakuliah",
    *   ),
    *   @SWG\Response(
    *     response=200,
    *     description="success",
    *    @SWG\Schema(ref="#/definitions/ResponseApiWorks")
    *   )
    * )
    */
    public function getOneData(){        
      $idmk=$this->request->getQuery("idmk");
      
      $matakuliah = Matakuliah::findFirst($idmk);
      
      $message = "Success";
      if(!$matakuliah){
          $message = "Failed";
      }
      
      $this->responseApi->status=0;
      $this->responseApi->message=$message;
      $this->responseApi->data=!empty($matakuliah)? $matakuliah :[];
  }
}
