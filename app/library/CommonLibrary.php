<?php
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;

class CommonLibrary
{
  protected $di;
  public function __construct()
  {
    $this->di=Phalcon\Di::getDefault();
  }

  public function generateVerificationCode()
  {
    //$verificationCode=substr($this->di->getRandom()->number(100000),0,5);
    $verificationCode=substr(rand(123456,999999),0,5);
    return $verificationCode;
  }
  public function initializeCodeValid($code="")
  {
      $appInitialize=AppInitialize::findFirst([
        "conditions"=>"code=:code: and verified=1",
        "bind"=>[
          "code"=>$code,
        ]
      ]);
      return !$appInitialize? false:true;
  }

  /*public function sendSms($to=[], $text="")
  {

    //Split Operator
    $operator=[];
    foreach($to as $msisdn):
        $msisdnFormatted=$this->msisdnFormat($msisdn);
        $prefix=substr($msisdnFormatted,0,6);
        $operatorSelected=ucfirst(isset(Definitions::OPERATOR_PREFIX[$prefix])? Definitions::OPERATOR_PREFIX[$prefix]:"zenziva");
        $operator[$operatorSelected][]=["number"=>$msisdnFormatted,"message"=>$text];
    endforeach;
    // get available provider Curl or Stream
    $provider = Phalcon\Http\Client\Request::getProvider();

    $provider->setBaseUri('http://128.199.232.241/');

    $provider->header->set('Accept', 'application/json');


    $result=false;
    foreach($operator as $operatorKey=>$smsData):
      $functionName="sendSms" . $operatorKey;
      if(method_exists($this,$functionName)):
        if(call_user_func_array([$this,$functionName],[$smsData])):
          $result=true;
        endif;
      endif;
    endforeach;
    
    return $result;

  }*/
  function clientIp() {
			$ipaddress = '';
			if (isset($_SERVER['HTTP_CLIENT_IP']))
					$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
			else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
					$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
			else if(isset($_SERVER['HTTP_X_FORWARDED']))
					$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
			else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
					$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
			else if(isset($_SERVER['HTTP_FORWARDED']))
				 $ipaddress = $_SERVER['HTTP_FORWARDED'];
			else if(isset($_SERVER['REMOTE_ADDR']))
					$ipaddress = $_SERVER['REMOTE_ADDR'];
			else
					$ipaddress = 'UNKNOWN';
			return $ipaddress;
	}

  public function parseParameters()
  {
    $data=json_decode(file_get_contents("php://input"));
    return !$data ? new stdClass():$data;
  }

  public function sendEmail($recipient="",$cc="",$from="",$subject="",$message="")
  {
    $mailer = new \Phalcon\Mailer\Manager($this->di->getConfig()->mail->toArray());

    $message = $mailer->createMessage()
            ->to($recipient)
            ->subject($subject)
            ->content($message);

    // Set the Cc addresses of this message.
    if(!empty($cc)):
      $message->cc($cc);
    endif;

    // Set the Bcc addresses of this message.
//    $message->bcc('example_bcc@gmail.com');

    // Send message
    return $message->send();
  }
  public function sendEmails($recipients=[],$from="",$subject="",$message="")
  {
    foreach($recipients as $to=>$name):
      //$this->sendEmail("$name<$to>","",)
    endforeach;
  }

  public function generateLinkVerification($email="",$code="")
  {
    $verificationEmail=VerificationEmail::findFirstByEmail($email);
    if(!$verificationEmail):
      $verificationEmail=new VerificationEmail();
      $verificationEmail->email=$email;
      $verificationEmail->code=$code;
      if(!$verificationEmail->save()):
        $dbMessage=" DB Message:";
        foreach($verificationEmail->getMessages() as $message):
            $dbMessage.= " " . $message;
        endforeach;
        throw new Exception(Definitions::message(Definitions::E_VERIFICATION_EMAIL_FAILED) . $dbMessage,Definitions::E_VERIFICATION_EMAIL_FAILED);
      endif;
    else:
      $verificationEmail->verified=0;
      $verificationEmail->created_at=date("Y-m-d H:i:s");
      $verificationEmail->save();
    endif;
    return $verificationEmail->id;
  }

  public function maskPhoneNumber($number="",$maskLength=4)
  {
    $length=strlen($number);
    $result=str_pad(substr($number,0,$length-$maskLength) ,$length,'X');
    return $result;
  }
  public function maskEmail($email="",$maskLength=4)
  {
    $emailParts=explode("@",$email);
    $userLength=strlen($emailParts[0]);
    if($userLength<=4):
      $user=str_pad(substr($emailParts[0],0,2),4,'X');
    else:
      $user=str_pad(substr($emailParts[0],0,3),$userLength,'X');
    endif;
    $domainLength=strlen($emailParts[1]);
    $domain=str_pad(substr($emailParts[1],0,$domainLength-4),$domainLength,"X");
    return $user."@". $domain;
  }

  
  public function uploadFileForm($path="/",$field="photo",$fileDelete=true,$throwException=true)
  {
	  $field=$field==null? "photo":$field;
	  $dir=dirname($path);
	  if(!file_exists($dir)):
		mkdir($dir,0755,true);
	  endif;
	  $statusUpload=copy($_FILES[$field]["tmp_name"],$path);
    if($throwException && !$statusUpload):
		throw new Exception(Definitions::message(Definitions::E_FILE_UPLOAD_FAILED ),Definitions::E_FILE_UPLOAD_FAILED);
	  endif;
	  if($fileDelete):
		@unlink($_FILES[$field]["tmp_name"]);
	  endif;
	  return $statusUpload;
  }
  
  public function getFileName($path="/")
  {
	  return $this->di->get("config")->file->base . $path;
  }
  public function validFileName($file="")
  {
	  print "common: " . $file ."\n";
	  return preg_match('/[^A-Za-z?]/i',$file);
  }
  public function isUser()
  {
	  return isset($this->di->get("requestApi")->data->application->id_user);
  }
  public function userId()
  {
	  return trim(isset($this->di->get("requestApi")->data->application->uid) ? $this->di->get("requestApi")->data->application->uid:null);
  }
  public function roleId()
  {
	  return trim(isset($this->di->get("requestApi")->data->application->roleid) ? $this->di->get("requestApi")->data->application->roleid:null);
  }

  
  public function userDetail(){
    $where[] = 'ScUser.uid=:uid:';
    $bind['uid'] = $this->userId();

      $queryBuilder = $this->di->get("modelsManager")->createBuilder()
//      ->from('Applications')
      ->columns('ScUser.*,TbPerson.*,SchTeacher.*,SchParent.*')
      ->from('ScUser')
      ->leftjoin('TbPerson', 'TbPerson.persid = ScUser.persid')
      ->leftjoin('SchTeacher', 'TbPerson.persid = SchTeacher.persid')
      ->leftjoin('SchParent', 'TbPerson.persid = SchParent.persid')
      ->where(implode(" AND ", $where), $bind);
      $schoolid = $queryBuilder->getQuery()->execute();
      return !empty($schoolid[0]) ? $schoolid[0]:null;
  }

  public function schoolId()
  {
    $userDetail=$this->userDetail();
    if($userDetail):
      return $userDetail->tbPerson->schoolid;
    endif;
    return null;
  }
  public function personId()
  {
    $userDetail=$this->userDetail();
    if($userDetail):
      return $userDetail->tbPerson->persid;
    endif;
    return null;
  }
  public function teacherId()
  {
    $userDetail=$this->userDetail();
    if($userDetail):
      return $userDetail->schTeacher->teacherid;
    endif;
    return null;
  }
  public function teacherClassId()
  {
    $userDetail=$this->userDetail();
    if($userDetail):
      return $userDetail->schTeacher->classid;
    endif;
    return null;
  }
  public function parentId()
  {
    $userDetail=$this->userDetail();
    if($userDetail):
      return $userDetail->schParent->parentid;
    endif;
    return null;
  }
  public function numericOnly($number="")
  {
	  return preg_replace( '/[^0-9]/', '', $number );
  }
  
  public function resizeImagebyPercent($fileName="",$percent=50,$ext=null)
  {
	  $functionNames=[
		"jpg"=>"imagecreatefromjpeg",
		"jpeg"=>"imagecreatefromjpeg",
		"png"=>"imagecreatefrompng",
		"gif"=>"imagecreatefromgif",
		"bmp"=>"imagecreatefrombmp",
	  ];
	  $imageFunctionNames=[
		"jpg"=>"imagejpeg",
		"jpeg"=>"imagejpeg",
		"png"=>"imagepng",
		"gif"=>"imagegif",
		"bmp"=>"imagebmp",
	  ];
	  if($ext==null):
		$ext = pathinfo($fileName, PATHINFO_EXTENSION);
	  endif;
	  $percent/=100;
	  $mimeType=mime_content_type($fileName);
	  list($type,$ext)=explode("/",$mimeType);
	  if(isset($functionNames[$ext])):
		list($width, $height) = getimagesize($fileName);
		$newwidth = $width * $percent;
		$newheight = $height * $percent;
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		$image=$functionNames[$ext]($fileName);
		imagecopyresized($thumb, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		header("Content-Type: " .$mimeType);
		$imageFunctionNames[$ext]($thumb);
	  endif;
  }
  
  public function mimeType($ext="jpeg")
  {
		if(!isset(Definitions::MIME_TYPES[$ext])):
			$mimeType="image/png";
		else:
			$mimeType=Definitions::MIME_TYPES[$ext];
		endif;
		return $mimeType;
  }  
  public function msisdnFormat($msisdn="")
  {
      if(substr($msisdn,0,1)=="0"):
		    $msisdn="+62".ltrim($msisdn,'0');
      endif;
      return $msisdn;
  }
  
  public function displayTextPhoto($string="",$color="")
  {
	if(empty($color)):
		$transparent=false;
		$redInt=rand(100,255);
		$greenInt=rand(100,255);
		$blueInt=rand(100,255);
	else:
		$transparent=false;
		$red=substr($color,0,2);
		$green=substr($color,2,2);
		$blue=substr($color,4,2);
		$redInt=!empty($red) ? hexdec($red):0;
		$greenInt=!empty($green) ? hexdec($green):0;
		$blueInt=!empty($blue) ? hexdec($blue):0;
	endif;

	$width=100;
	$height=100;
	$img=imagecreatetruecolor($width,$height);

	if($transparent):
		imagealphablending($img,false);
		$col=imagecolorallocatealpha($img,$redInt,$greenInt,$blueInt,127);
		imagefilledrectangle($img,0,0,$width,$height,$col);
		imagealphablending($img,true);
	else:
		$col=imagecolorallocate($img,$redInt,$greenInt,$blueInt);
		imagefilledrectangle($img,0,0,$width,$height,$col);
	endif;

	$fontSize=30;
	$font=BASE_PATH ."/public/fonts/Lato-Bold.ttf";
	$type_space = imagettfbbox($fontSize, 0, $font, $string);
	$font_width = abs($type_space[2] - $type_space[0]) ;
	$font_height = abs($type_space[3] - $type_space[5]);
	$color = imagecolorallocate($img, 255, 255, 255);
	$fontX=($width-$font_width)/2+1;
	$fontY=(($height-$font_height)/2+1)+$font_height;
	imagettftext($img,$fontSize,0,$fontX,$fontY,$color,$font,$string); 
	header('Content-Type: image/png');
	imagealphablending($img,false);
	imagesavealpha($img,true);
	imagepng($img);	  
	exit;
	  	  
  }
  
  public function getInitialCompany($string="")
  {
  //  $string=preg_replace("/\./"," ",$string);
    $string=str_replace("."," ",$string);
	  $stringList=explode(" ",$string);
	if(isset($stringList[0])):
		$stringList[0]=preg_replace("/[^A-Za-z]/", '', $stringList[0]);
	endif;
	if(in_array(strtoupper($stringList[0]),["PT","CV"])):
	//if(strlen($stringList[0])<3):
		array_shift($stringList);
	endif;
	$stringDisplay="";
	$stringList=array_slice($stringList,0,2); // Get first 3 word
	foreach($stringList as $word):
		$stringDisplay .= strtoupper(substr($word,0,1));
	endforeach;
	return $stringDisplay;
  }


  protected function sendNotificationQueue($id="",$title="",$body="")
  {
    $fcm=new FcmLibrary();
    $fcm->generateDataSingle($id,$title,$body);

    $this->di->get("logger")->info("Send Push notification: ". json_encode($fcm->getParams()));
    return $this->di->get("stompSend")->send($this->di->get("config")->queue->fcm->send,json_encode($fcm->getParams()));
  }

  public function generateBarcode($data="",$width=-20,$height=-20)
  {
    $barcode = new \Com\Tecnick\Barcode\Barcode();

    // generate a barcode
    $bobj = $barcode->getBarcodeObj(
        'QRCODE,H,C39E+',                     // barcode type and additional comma-separated parameters
        $data,          // data string to encode
        $width,                             // bar width (use absolute or negative value as multiplication factor)
        $height,                             // bar height (use absolute or negative value as multiplication factor)
        'black',                        // foreground color
        array(-2, -2, -2, -2)           // padding (use absolute or negative values as multiplication factors)
        )->setBackgroundColor('white'); // background color
        $mimeType="image/png";
        header("Content-Type: $mimeType");    
        return $bobj->getPngData();
  }

  public function throwErrorDb($table=null)
  {
    $messageDb="";
    foreach($table->getMessages() as $message):
      $messageDb .= " " . $message;
    endforeach;
    $this->di->get("responseApi")->data=$messageDb;
    throw new Exception(Definitions::message(Definitions::E_DATABASE )."|" . $messageDb,Definitions::E_DATABASE);
  }

  public function getallheaders()
  {
    if (!function_exists('getallheaders')):
      $headers = [];
      foreach ($_SERVER as $name => $value) {
          if (substr($name, 0, 5) == 'HTTP_') {
              $headers[str_replace(' ', '-', strtolower(str_replace('_', ' ', substr($name, 5))))] = $value;
          }
      }
    else:
      $headers=getallheaders();
    endif;
    return $headers;
  }

  public function generateNasabahId()
  {
    $nasabah=\Bsm\Models\MNasabah::findFirst(["order"=>"idnasabah desc"]);
    $id=1;
    if($nasabah):
      $arrayNasabahId=explode("NSH",$nasabah->idnasabah);
      if(!empty($arrayNasabahId[1])):
        $idCurrent=intval($arrayNasabahId[1]);
        $id=$idCurrent+1;
      endif;
    endif;
    return "NSH".str_pad($id,16,"0",STR_PAD_LEFT);
  }
 
  public function pengajuanPembiayaan($params)
  {
    $mPendidikan=\Bsm\Models\MPendidikan::findFirstByNmpendidikan($params->pendidikan_terakhir);
    $mPekerjaan=\Bsm\Models\MPekerjaan::findFirstByNmpekerjaan($params->pekerjaan);
    $mJnsjaminan=\Bsm\Models\MJnsjaminan::findFirstByNmjnsjaminan($params->jenis_jaminan);
    $mTujuanpembiayaan=\Bsm\Models\MTujuanpembiayaan::findFirstByNmtujuanpembiayaan($params->tujuan_pembiayaan);
    $mStatuskawin=\Bsm\Models\MStskawin::findFirstByNmstskawin($params->status_menikah);
    $mJnsKelamin=\Bsm\Models\MJnskelamin::findFirstByNmjnskelamin($params->jenis_kelamin);

    $nasabah=new \Bsm\Models\TPengajuanPinjaman();
    $nasabah->idpengajuan=rand(1000000000,99999999999999);
    $nasabah->idnasabah=!empty($params->user_id)? $params->user_id:null;
    $nasabah->nmlengkap=$params->nama_lengkap;
    $nasabah->notelphome=$params->notelp ; 
    $nasabah->nohp=$params->nohp ;
    $nasabah->email=$params->email;
    $nasabah->umur=!empty($params->umur)?$params->umur:0;
    $nasabah->idjnspengajuan=1;
    $nasabah->idstskawin=!empty($mStatuskawin)?$mStatuskawin->idstskawin:null;
    $nasabah->idjnskelamin=!empty($mJnsKelamin) ? $mJnsKelamin->idjnskelamin:null;
    $nasabah->idpendidikan=!empty($mPendidikan)?$mPendidikan->idpendidikan:null;
    $nasabah->idpekerjaan=!empty($mPekerjaan)?$mPekerjaan->idpekerjaan:null;
    $nasabah->npwp=$params->npwp;
    $nasabah->noktp=$params->noktp;
    $nasabah->lamakerja=$params->lama_bekerja;
    $nasabah->nmperushbekerja=$params->perusahaan;
    $nasabah->jmlpengajuan=preg_replace("/[^0-9]+/i","",$params->jumlah_pengajuan);
    $nasabah->jkwaktu=$params->jangka_waktu;
    $nasabah->idjnsjaminan=!empty($mJnsjaminan)?$mJnsjaminan->idjnsjaminan:null;
    $nasabah->idtujuanpembiayaan=!empty($mTujuanpembiayaan)?$mTujuanpembiayaan->idtujuanpembiayaan:null;
    $nasabah->dokpelengkapjaminan=$params->dokumen_jaminan;
    $nasabah->lokasipengambilan=$params->lokasi;
    $nasabah->waktukunjungan=$params->waktu_kunjungan . " " .$params->jam_kunjungan;
    list($latitude,$longitude)=explode(",",$params->lokasi);
    try{
      $nasabah->lat1=(double)$latitude;
      $nasabah->lat=(double)$latitude;
      $nasabah->long1=(double)$longitude;
      $nasabah->long=(double)$longitude;
    } catch(Exception $e) {
      $nasabah->lat1=null;
      $nasabah->lat=0;
      $nasabah->long1=null;
      $nasabah->long=0;
      }

    $nasabah->alamatlokasi=$params->alamat;
    if(!empty($params->idsales)):
      $nasabah->idsales=$params->idsales;
    else:
      $sales=$this->getNearestSales($nasabah->lat,$nasabah->long,$this->di->get("config")->application->salesDistance);
      $salesArray=$sales->toArray();
      if(!empty($salesArray)):
        $nasabah->idsales=$salesArray[0]["idsales"];
      endif;
    endif;
    // Cek sudah berapa kali per hari Sales di assign
    //print_r($this->di->get("config")->application->toArray());exit;
    $limitAssign=$this->di->get("config")->application->limit_sales_pembiayaan;
    $pengajuanAssign=\Bsm\Models\TPengajuanPinjaman::findFirst([
      "columns"=>"count(1) as total",
      "conditions"=>"idsales=:idsales: AND tglpengajuan=:tglpengajuan:",
      "bind"=>[
        "idsales"=>$nasabah->idsales,
        "tglpengajuan"=>date("Y-m-d"),
      ]
    ]);
    if($pengajuanAssign):
      if($pengajuanAssign->total >$limitAssign):
        //Over limit Assign
        throw new Exception(Definitions::message(Definitions::E_LIMIT_SALES),Definitions::E_LIMIT_SALES);
      endif;
    endif;
    //$nasabah->waktu_kunjungan=$params->waktu_kunjungan; // Belum ada
    if(!$nasabah->save()):
      $this->throwErrorDb($nasabah);
    endif;
    return $nasabah;

  }
  public function pengajuanPembiayaanUpdate($params)
  {
    $nasabah=\Bsm\Models\TPengajuanPinjaman::findFirstByIdpengajuan($params->id);
    if(!$nasabah):
      throw new Exception(Definitions::message(Definitions::E_PEMBIAYAAN_NOT_EXISTS),Definitions::E_PEMBIAYAAN_NOT_EXISTS);
    endif;
    $mPendidikan=\Bsm\Models\MPendidikan::findFirstByNmpendidikan($params->pendidikan_terakhir);
    $mPekerjaan=\Bsm\Models\MPekerjaan::findFirstByNmpekerjaan($params->pekerjaan);
    $mJnsjaminan=\Bsm\Models\MJnsjaminan::findFirstByNmjnsjaminan($params->jenis_jaminan);
    $mTujuanpembiayaan=\Bsm\Models\MTujuanpembiayaan::findFirstByNmtujuanpembiayaan($params->tujuan_pembiayaan);
    $mStatuskawin=\Bsm\Models\MStskawin::findFirstByNmstskawin($params->status_menikah);
    $mJnsKelamin=\Bsm\Models\MJnskelamin::findFirstByNmjnskelamin($params->jenis_kelamin);

    //$nasabah=new \Bsm\Models\TPengajuanPinjaman();
//    $nasabah->idpengajuan=rand(1000000000,99999999999999);
    $nasabah->nmlengkap=$params->nama_lengkap;
    $nasabah->notelphome=$params->notelp ; 
    //$nasabah->notep=$params->notep ; // ngga ada di field
    $nasabah->nohp=$params->nohp ;
    $nasabah->email=$params->email;
    $nasabah->umur=!empty($params->umur)?$params->umur:0;
    $nasabah->idjnspengajuan=1;
    $nasabah->idnasabah=!empty($params->user_id)? $params->user_id:$nasabah->idnasabah;
    $nasabah->idstskawin=!empty($mStatuskawin)?$mStatuskawin->idstskawin:null;
    $nasabah->idjnskelamin=!empty($mJnsKelamin) ? $mJnsKelamin->idjnskelamin:null;
    $nasabah->idpendidikan=!empty($mPendidikan)?$mPendidikan->idpendidikan:null;
    $nasabah->idpekerjaan=!empty($mPekerjaan)?$mPekerjaan->idpekerjaan:null;
    $nasabah->npwp=$params->npwp;
    $nasabah->noktp=$params->noktp;
    $nasabah->lamakerja=$params->lama_bekerja;
    $nasabah->nmperushbekerja=$params->perusahaan;
    $nasabah->jmlpengajuan=preg_replace("/[^0-9]+/i","",$params->jumlah_pengajuan);
    $nasabah->jkwaktu=$params->jangka_waktu;
    $nasabah->idjnsjaminan=!empty($mJnsjaminan)?$mJnsjaminan->idjnsjaminan:null;
    $nasabah->idtujuanpembiayaan=!empty($mTujuanpembiayaan)?$mTujuanpembiayaan->idtujuanpembiayaan:null;
    $nasabah->dokpelengkapjaminan=$params->dokumen_jaminan;
    $nasabah->lokasipengambilan=$params->lokasi;
    $nasabah->catatan=$params->catatan;
    $nasabah->waktukunjungan=$params->waktu_kunjungan . " " .$params->jam_kunjungan;
    if(!empty($params->status)):
      $nasabah->status=$params->status;
    endif;
    list($latitude,$longitude)=explode(",",$params->lokasi);
    try{
      $nasabah->lat1=(double)$latitude;
      $nasabah->lat=(double)$latitude;
      $nasabah->long1=(double)$longitude;
      $nasabah->long=(double)$longitude;
    } catch(Exception $e) {
      $nasabah->lat1=null;
      $nasabah->lat=0;
      $nasabah->long1=null;
      $nasabah->long=0;
      }

    $nasabah->alamatlokasi=$params->alamat;
    if(!empty($params->idsales)):
      $nasabah->idsales=$params->idsales;
    endif;
    //$nasabah->waktu_kunjungan=$params->waktu_kunjungan; // Belum ada
    if(!$nasabah->save()):
      $this->throwErrorDb($nasabah);
    endif;
    if($nasabah->status==Definitions::STATUS_CONFIRM && !empty($params->idsales)):
      $mSales=\Bsm\Models\MSales::findFirstByIdsales($params->idsales);
      if($mSales):
        $content=<<<AIMI
        Pengajuan pembiayaan nasabah atas nama nasabah {$nasabah->nmlengkap} telah berhasil dikonfirmasi oleh  sales {$mSales->nmlengkap}
        
AIMI;
        // Get MBM Email
        $mMbm=\Bsm\Models\MMbm::findByIdcabang($mSales->idcabang);
        if($mMbm):
          foreach($mMbm as $mbm):
            if(!empty($mbm->email)):
              $this->sendEmail($mbm->email,"","","[BSMITRA] - Bukti Setor (Copy Cabang)",$content);
            endif;
          endforeach;
        endif;
      endif;
    endif;
    return $nasabah;
  }

  public function pengajuanPembiayaanUploadFile($params)
  {
     $type=$params->type;
    $id=$params->id;
    $listFields=[
      "ktp"=>"lampktp",
      "kk"=>"lampkk",
      "npwp"=>"lampnpwp",
      "docjaminan"=>"lampdokjaminan",
    ];
    if(empty($listFields[$type])):
      throw new Exception(Definitions::message(Definitions::E_FILE_UPLOAD_INVALID),Definitions::E_FILE_UPLOAD_INVALID);
    endif;

    $pengajuanPinjaman=\Bsm\Models\TPengajuanPinjaman::findFirstByIdpengajuan($id);
    if(!$pengajuanPinjaman):
      throw new Exception(Definitions::message(Definitions::E_DATA_NOT_EXISTS),Definitions::E_DATA_NOT_EXISTS);
    endif;
    if($_FILES["file"]["error"]!=0):
      throw new Exception(Definitions::message(Definitions::E_FILE_UPLOAD_FAILED),Definitions::E_FILE_UPLOAD_FAILED);
    endif;
    $filePath=$this->di->get("config")->file->base."/uploads/" .$type ."/".$id;
    $dirName=dirname($filePath);
    if(!file_exists($dirName)):
      mkdir($dirName,0755,true);
    endif;
    //$realFilePath=realpath($filePath);
    $realFilePath=$filePath;
    if(!move_uploaded_file($_FILES["file"]["tmp_name"],$filePath)):
      throw new Exception(Definitions::message(Definitions::E_FILE_UPLOAD_FAILED),Definitions::E_FILE_UPLOAD_FAILED);
    endif;
    $pengajuanPinjaman->{$listFields[$type]}=$realFilePath;
    if(!$pengajuanPinjaman->save()):
      $this->throwErrorDb($nasabah);
    endif;    
    return true;
  }

  public function getNearestSales($lat=0,$lon=0,$distance=5)
  {
    // Distance in km. Default 5km
    // 1Km=0.009090909 degrees

/*Distance = 0.1; // Range in degrees (0.1 degrees is close to 11km)
LatN = lat + Distance;
LatS = lat - Distance;
LonE = lon + Distance;
LonW = lon - Distance;

...Query DB with something like the following:
SELECT *
FROM table_name
WHERE 
(store_lat BETWEEN LatN AND LatS) AND
(store_lon BETWEEN LonE AND LonW)
*/
    $distanceDegre=$distance*0.009090909;
    $latN=$lat+$distanceDegre;
    $latS=$lat-$distanceDegre;
    $lonE=$lon-$distanceDegre;
    $lonW=$lon+$distanceDegre;
    $mSales=Bsm\Models\MSales::find([
      "conditions"=>"latitude <= :latn: and latitude>=:lats: AND longitude >=:lone: and longitude <=:lonw:",
      "bind"=>[
        "latn"=>$latN,
        "lats"=>$latS,
        "lone"=>$lonE,
        "lonw"=>$lonW,
      ],
      "order"=>"latitude asc,longitude asc",
    ]);
    $results=[];
    if($mSales):
      $results=$mSales;
    endif;
    return $results;

  }


  public function displayImage($path="")
  {
    $ext="png";
    $data="";
    $fileSize=0;
    if(file_exists($path)):
      $ext=pathinfo($path,PATHINFO_EXTENSION);     
      $data=file_get_contents($path);
      $fileSize=filesize($path);
    endif;
    header("Content-Type: ". $this->mimeType($ext));
    header("Content-Length: ". $fileSize);
    print $data;
    exit;
  }
  public function fieldAttachment($type="")
  {
    $listFields=[
      "ktp"=>"lampktp",
      "kk"=>"lampkk",
      "npwp"=>"lampnpwp",
      "docjaminan"=>"lampdokjaminan",
    ];
    return !empty($listFields[$type])?$listFields[$type]:"";
  }

  public function jemputUang($params)
  {
    /*$mPendidikan=\Bsm\Models\MPendidikan::findFirstByNmpendidikan($params->pendidikan_terakhir);
    $mPekerjaan=\Bsm\Models\MPekerjaan::findFirstByNmpekerjaan($params->pekerjaan);
    $mJnsjaminan=\Bsm\Models\MJnsjaminan::findFirstByNmjnsjaminan($params->jenis_jaminan);
    $mTujuanpembiayaan=\Bsm\Models\MTujuanpembiayaan::findFirstByNmtujuanpembiayaan($params->tujuan_pembiayaan);
    $mStatuskawin=\Bsm\Models\MStskawin::findFirstByNmstskawin($params->status_menikah);
    $mJnsKelamin=\Bsm\Models\MJnskelamin::findFirstByNmjnskelamin($params->jenis_kelamin);
*/
    $nasabah=new \Bsm\Models\TReqcashpickup();
    $nasabah->idreqcashpickup=$this->di->get("random")->uuid();
    $nasabah->norektabungan=$params->norektabungan;
    $nasabah->idloan=$params->idloan;
    $nasabah->idnasabah=!empty($params->idnasabah)? $params->idnasabah:null;
    $nasabah->nmnasabah=$params->nmnasabah;
    $nasabah->jumtotsetorantoday=$params->jumtotsetorantoday;
    $nasabah->tgljatuhtempo=$params->tgljatuhtempo;
    $nasabah->jumangsuranperbln=$params->jumangsuranperbln;
    $nasabah->jumpinalti=$params->jumpinalti;
    $nasabah->tglsetoran=$params->tglsetoran;
    $nasabah->catatan=$params->catatan;
    $nasabah->tglangsuran=$params->tglangsuran;
    $nasabah->lokasipengambilan=$params->lokasipengambilan;
    $nasabah->alamat=$params->alamat;
    $nasabah->waktukunjungan=$params->waktukunjungan;
    $nasabah->tunggakanpokok=$params->tunggakanpokok;
    $nasabah->tunggakanmargin=$params->tunggakanmargin;
    $nasabah->tottunggakan=$params->tottunggakan;
    $nasabah->kolektif=$params->kolektif;
    $nasabah->lamatunggakan=$params->lamatunggakan;
    $nasabah->status=$params->status;
    $nasabah->createddate=!empty($params->createddate)?$params->createddate:date("Y-m-d H:i:s");
    $nasabah->updateddate=!empty($params->updateddate)?$params->updateddate:date("Y-m-d H:i:s");;    $nasabah->idkanwil=$params->idkanwil;
    $nasabah->idarea=$params->idarea;
    $nasabah->idcabang=$params->idcabang;
    $nasabah->idoutlet=$params->idoutlet;
    $nasabah->idmitramikro=!empty($params->idmitramikro)? $params->idmitramikro:null;
    $nasabah->idsales=!empty($params->idsales)? $params->idsales:null;
    if(!$nasabah->save()):
      $messages=[];
      foreach($nasabah->getMessages() as $message):
        $messages[]=$message;
      endforeach;
      throw new Exception(Definitions::message(Definitions::E_DATABASE) ."|" . implode(",",$messages),Definitions::E_DATABASE);
    endif;

/*    
    // Ngga jadi dipake, sudah ada idloan
    if(!empty($params->idlisttagihan)):
      $tListTagihan=\Bsm\Models\TListTagihan::findFirstByIdloan($$params->idloan);
      if($tListTagihan):
        $tListTagihan->idreqcashpickup=$nasabah->idreqcashpickup;
        if(!$tListTagihan->save()):
          $this->throwErrorDb($tListTagihan);
        endif;
      endif;
    endif;
    */
    return $nasabah;

  }
  public function jemputUangUpdate($params)
  {
    /*$mPendidikan=\Bsm\Models\MPendidikan::findFirstByNmpendidikan($params->pendidikan_terakhir);
    $mPekerjaan=\Bsm\Models\MPekerjaan::findFirstByNmpekerjaan($params->pekerjaan);
    $mJnsjaminan=\Bsm\Models\MJnsjaminan::findFirstByNmjnsjaminan($params->jenis_jaminan);
    $mTujuanpembiayaan=\Bsm\Models\MTujuanpembiayaan::findFirstByNmtujuanpembiayaan($params->tujuan_pembiayaan);
    $mStatuskawin=\Bsm\Models\MStskawin::findFirstByNmstskawin($params->status_menikah);
    $mJnsKelamin=\Bsm\Models\MJnskelamin::findFirstByNmjnskelamin($params->jenis_kelamin);
*/
    $nasabah=\Bsm\Models\TReqcashpickup::findFirstByIdreqcashpickup($params->id);
    if(!$nasabah):
      throw new Exception(Definitions::message(Definitions::E_JEMPUT_UANG_NOT_EXISTS),Definitions::E_JEMPUT_UANG_NOT_EXISTS);
    endif;
//    $nasabah=new \Bsm\Models\TReqcashpickup();
//    $nasabah->idreqcashpickup=$this->di->get("random")->uuid();
    $this->di->getLogger()->info("params: " .json_encode($params));
    $nasabah->norektabungan=$params->norektabungan;
    $nasabah->idloan=$params->idloan;
    $nasabah->idnasabah=!empty($params->idnasabah)? $params->idnasabah:$nasabah->idnasabah;
    $nasabah->nmpenyetor=$params->nmpenyetor;
    $nasabah->nmnasabah=$params->nmnasabah;
    $nasabah->jumtotsetorantoday=$params->jumtotsetorantoday;
    $nasabah->tgljatuhtempo=$params->tgljatuhtempo;
    $nasabah->jumangsuranperbln=$params->jumangsuranperbln;
    $nasabah->jumpinalti=$params->jumpinalti;
    $nasabah->tglsetoran=$params->tglsetoran;
    $nasabah->catatan=$params->catatan;
    $nasabah->tglangsuran=$params->tglangsuran;
    $nasabah->lokasipengambilan=$params->lokasipengambilan;
    $nasabah->alamat=$params->alamat;
    $nasabah->waktukunjungan=$params->waktukunjungan;
    $nasabah->tunggakanpokok=$params->tunggakanpokok;
    $nasabah->tunggakanmargin=$params->tunggakanmargin;
    $nasabah->tottunggakan=$params->tottunggakan;
    $nasabah->kolektif=$params->kolektif;
    $nasabah->lamatunggakan=$params->lamatunggakan;
    $nasabah->status=$params->status;
    $nasabah->createddate=$params->createddate;
    $nasabah->updateddate=$params->updateddate;
    $nasabah->idkanwil=$params->idkanwil;
    $nasabah->idarea=$params->idarea;
    $nasabah->idcabang=$params->idcabang;
    $nasabah->idoutlet=$params->idoutlet;
    $nasabah->idmitramikro=!empty($params->idmitramikro)? $params->idmitramikro:null;
    $nasabah->idsales=!empty($params->idsales)? $params->idsales:null;
    if(!empty($params->status)):
      $nasabah->status=$params->status;
    endif;
    $noStruk="bsmitra00001";
    if($reqCash):
      $ids=explode("bsmitra",$nasabah->nostruk);
      $value=(int) $nasabah->nostruk;
      if($value<999999):
        $value++;
      else:
        $value=1;
      endif;
      $noStruk="bsmitra"  . str_pad($value,5,STR_PAD_LEFT);
    endif;
    $nasabah->nostruk=$noStruk;
    if(!$nasabah->save()):
      $messages=[];
      foreach($nasabah->getMessages() as $message):
        $messages[]=$message;
      endforeach;
      throw new Exception(Definitions::message(Definitions::E_DATABASE) ."|" . implode(",",$messages),Definitions::E_DATABASE);
    endif;
    if($nasabah->status==Definitions::STATUS_COMPLETED):
      // Send Kuitansi
      $monthAngsuran=date("F",strtotime($nasabah->tglangsuran));
      $dateCompleted=date("d/M/Y -- H:i");
      $officerName="";
      $officerPhone="";
      $officerNik="";
      $branchId="";
      if(!empty($nasabah->idsales)):
          $sales=\Bsm\Models\MSales::findFirstByIdsales($nasabah->idsales);
          if($sales):
            $officerName=$sales->nmlengkap;
            $officerPhone=$sales->notep;
            $officerNik=$sales->nip;
            $branchId=$sales->idcabang;
          endif;
      else:
        $mitra=\Bsm\Models\MMitramikro::findFirstByIdmitramikro($nasabah->idmitramikro);
        if($mitra):
          $officerName=$mitra->nmlengkap;
          $officerPhone=$mitra->notep;
          $officerNik=$mitra->nip;
          $branchId=$mitra->idcabang;
        endif;
      endif;

      // Get Cabang
      $cabang=\Bsm\Models\MCabang::findFirst([
        "conditions"=>"idcabang=:idcabang: and idkanwil=:idkanwil:",
        "bind"=>[
          "idcabang"=>$nasabah->idcabang,
          "idkanwil"=>$nasabah->idkanwil,
        ],
      ]);
      $branchName="";
      if($cabang):
        $branchName=$cabang->nmcabang;
      endif;
      $nasabahSend=\Bsm\Models\MNasabah::findFirstByIdnasabah($nasabah->idnasabah);
      $phone="";
      if($nasabahSend):
        $phone=$nasabahSend->notep;
      endif;
      // Get last Number
      $reqCash=\Bsm\Models\TReqcashpickup::findFirst([
        "order"=>"nostruk desc"
      ]);
      $content =<<<AIMI
Yth. {$nasabah->nmpenyetor} <br/><br/>
Nomor Struk: $noStruk<br/>
Tanggal/Jam Transaksi: $dateCompleted<br/>
Jenis Transaksi: Tabungan <br/>
Nama Nasabah: {$nasabah->nmnasabah}<br/>
No. Rekening: {$nasabah->norektabungan}<br/>
No. HP: {$phone}<br/>
KC/KCP: $branchName<br/>
Nama Penyetor: {$nasabah->nmpenyetor}<br/>
Nama Petugas: $officerName<br/>
No. HP Petugas: $officerPhone<br/>
NIK: $officerNik<br/>
Nominal: {$nasabah->jumtotsetorantoday}<br/>
Berita: Setoran untuk angsuran bulan {$monthAngsuran}<br/>
Status: Berhasil<br/>
Keterangan: Saldo tabungan Anda akan bertambah setelah dilakukannya Otorisasi di Cabang BSM<br/>
<br/>
Mohon simpan email ini sebagai bukti transaksi Anda. <br/>
<br/>
Terima kasih telah menggunakan layanan bsmitra.<br/>
Semoga layanan kami mendatangkan berkah bagi Anda. <br/>

AIMI;
      $nasabahSend=\Bsm\Models\MNasabah::findFirstByIdnasabah($nasabah->idnasabah);
      if($nasabahSend):
        $this->sendEmail($nasabahSend->email,"","","[BSMITRA] - Bukti Setor",$content);
        if(!empty($branchId)):
        // Get MBM Email
        $mMbm=\Bsm\Models\MMbm::findByIdcabang($branchId);
        if($mMbm):
          foreach($mMbm as $mbm):
            if(!empty($mbm->email)):
              $this->sendEmail($mbm->email,"","","[BSMITRA] - Bukti Setor (Copy Cabang)",$content);
            endif;
          endforeach;
        endif;
	endif;
      endif;
    endif;
    return $nasabah;

  }

  
  public function saveThumbnailVideo($video="",$thumbnailFile="")
  {
    $dirName=dirname($thumbnailFile);
    if(!file_exists($dirName)):
      mkdir($dirName,0755,true);
    endif;
    $ffmpeg = \FFMpeg\FFMpeg::create();
    $video=$ffmpeg->open($video);
    $frame = $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(1));
    $frame->save($thumbnailFile);
  }

  public function createChart($name,$title,$yAxis,$dataSeriesLabels,$xAxisTickValues,$dataSeriesValues,$x,$y)
  {
    $series = new DataSeries(
      DataSeries::TYPE_BARCHART, // plotType
      DataSeries::GROUPING_STANDARD, // plotGrouping
      range(0, count($dataSeriesValues) - 1), // plotOrder
      $dataSeriesLabels, // plotLabel
      $xAxisTickValues, // plotCategory
      $dataSeriesValues        // plotValues
    );
    // Set additional dataseries parameters
    //     Make it a horizontal bar rather than a vertical column graph
    $series->setPlotDirection(DataSeries::DIRECTION_COLUMN);
    // Set the series in the plot area
    $plotArea = new PlotArea(null, [$series]);
    // Set the chart legend
    $legend = new Legend(Legend::POSITION_RIGHT, null, false);
    $title = new Title($title);
    $yAxisLabel = new Title($yAxis);
    // Create the chart
    $chart = new Chart(
        $name, // name
        $title, // title
        $legend, // legend
        $plotArea, // plotArea
        true, // plotVisibleOnly
        0, // displayBlanksAs
        null, // xAxisLabel
        $yAxisLabel  // yAxisLabel
    );
    // Set the position where the chart should appear in the worksheet
    //$chart->setTopLeftPosition('A7');
    //$chart->setBottomRightPosition('H20');


    $chart->setTopLeftPosition($x);
    $chart->setBottomRightPosition($y);    
    return $chart;
  }
}
