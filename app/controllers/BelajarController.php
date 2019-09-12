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
     *     @SWG\Schema(ref="#/definitions/Belajar")
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
        
        $idstudent = $params->idstudent;
        $idclass = $params->idclass;

        $data_std = SchStudent::findFirstByStudentid($idstudent);
        $data_std->classid = $idclass;
        $save_change = $data_std->save(); 

        $message = "Success";
        if(!$save_change){
            $message = "Failed";
        }

        $this->responseApi->status=0;
        $this->responseApi->message=$message;

    }
}
