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
     *   path="/belajar",
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
     *   path="/belajar",
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
        
        $message = "Data Not Found";
        if($mahasiswa){
            $save = $mahasiswa->save();
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
     *   path="/belajar",
     *   tags={"Mahasiswa"},
     *   summary="Delete Data",
     *   produces={"application/json"},
     *     @SWG\Parameter(
     *     in="body",
     *     name="data",
     *     required=true,
     *     description="Activity Data",
     *     @SWG\Schema(ref="#/definitions/DeleteData")
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
        
        $mahasiswa = Mahasiswa::findFirst($params->idmhs);
        
        $message = "Data Not Found";
        if($mahasiswa){
            $delete = $mahasiswa->delete();         
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
    *   path="/belajar/mahasiswa",
    *   tags={"Mahasiswa"},
    *   summary="Get Data Mahasiswa By ID",
    *   produces={"application/json"},
    *   @SWG\Parameter(
    *     in="query",
    *     type="number",
    *     name="idmhs",
    *     required=true,
    *     description="ID Mahasiswa",
    *   ),
    *   @SWG\Response(
    *     response=200,
    *     description="success",
    *    @SWG\Schema(ref="#/definitions/ResponseApiWorks")
    *   )
    * )
    */
    public function getOneData(){        
        $idmhs=$this->request->getQuery("idmhs");
        
        $mahasiswa = Mahasiswa::findFirst($idmhs);
        
        $message = "Success";
        if(!$mahasiswa){
            $message = "Failed";
        }
        
        $this->responseApi->status=0;
        $this->responseApi->message=$message;
        $this->responseApi->data=!empty($mahasiswa)? $mahasiswa :[];
    }
}
