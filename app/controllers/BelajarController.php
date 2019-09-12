<?php
class BelajarController extends Phalcon\Mvc\Controller
{
  /**
    *
    * @SWG\Get(
    *   path="/belajar",
    *   tags={"9. Belajar"},
    *   summary="Get Data (Belajar)",
    *   produces={"application/json"},
    *     @SWG\Parameter(
    *     in="query",
    *     type="string",
    *     name="idclass",
    *     required=true,
    *     description="ID Kelas",
    *   ),   
    *    @SWG\Parameter(
    *    in="header",
    *    type="string",
    *    name="idschool",
    *    required=true,
    *    description="ID Sekolah",
    *   ),
    *   @SWG\Response(
    *     response=200,
    *     description="success",
    *    @SWG\Schema(ref="#/definitions/ResponseApiWorks")
    *   )
    * )
    */
    public function getData(){
        $idc=$this->request->getQuery("idclass");
        $ids=$this->request->getHeader("idschool");

        $qclass = $this->modelsManager->createQuery('SELECT * FROM SchStudent WHERE classid = :idc: AND schoolid = :ids:'); 
        $students_class = $qclass->execute(['ids' => $ids, 'idc' => $idc]);
        
        $this->responseApi->status=0;
        $this->responseApi->message="Success";
        $this->responseApi->data=!empty($students_class)? $students_class :[];
    }

    /**
     *
     * @SWG\Post(
     *   path="/belajar/add",
     *   tags={"9. Belajar"},
     *   summary="Post Data (Belajar)",
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
