<?php
class BelajarController extends Phalcon\Mvc\Controller
{
  /**
    *
    * @SWG\Get(
    *   path="/belajar",
    *   tags={"Mahasiswa"},
    *   summary="Get Data Mahasiswa",
    *   produces={"application/json"},
    *   @SWG\Response(
    *     response=200,
    *     description="success",
    *    @SWG\Schema(ref="#/definitions/ResponseApiWorks")
    *   )
    * )
    */
    public function getData(){
        $q = $this->modelsManager->createQuery('SELECT * FROM Mahasiswa'); 
        $datas = $q->execute();
        
        $this->responseApi->status=0;
        $this->responseApi->message="Success";
        $this->responseApi->data=!empty($datas)? $datas :[];
    }

    /**
     *
     * @SWG\Post(
     *   path="/belajar/add",
     *   tags={"Mahasiswa"},
     *   summary="Add Mahasiswa",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="data",
     *     required=true,
     *     description="Activity Data",
     *     @SWG\Schema(ref="#/definitions/AddData")
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

        $mahasiswa= new Mahasiswa;        
        $mahasiswa->namamhs = $params->namamhs;
        $mahasiswa->notlpmhs = $params->notlpmhs;
        $mahasiswa->tgllahirmhs = $params->tgllahirmhs;

        $save = $mahasiswa->save(); 

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
     *   path="/belajar/edit",
     *   tags={"Mahasiswa"},
     *   summary="Edit Data",
     *   produces={"application/json"},
     *     @SWG\Parameter(
     *     in="body",
     *     name="data",
     *     required=true,
     *     description="Activity Data",
     *     @SWG\Schema(ref="#/definitions/EditData")
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
  
        $mahasiswa = Mahasiswa::findFirst($params->idmhs);
        $mahasiswa->namamhs = $params->namamhs;
        $mahasiswa->notlpmhs = $params->notlpmhs;
        $mahasiswa->tgllahirmhs = $params->tgllahirmhs;
  
        $save = $mahasiswa->save(); 

        $message = "Success";
        if(!$save){
            $message = "Failed";
        }

        $this->responseApi->status=0;
        $this->responseApi->message=$message;
      }
}
