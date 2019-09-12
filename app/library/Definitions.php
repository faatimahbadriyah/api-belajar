<?php
class Definitions
{
  const E_SUCCESS=0;
  const E_UNKNOWN=-1;
  const E_USER_NOT_EXISTS=1;
  const E_INVALID_PASSWORD=2;
  const E_DATABASE=3;
  const E_INVALID_APPLICATION=4;
  const E_TOKEN_EXPIRED=5;
  const E_INVALID_TOKEN=6;
  const E_USER_NOT_ACTIVE=7;
  const E_REGISTRATION_DATA_FAILED=8;
  const E_FORMAT_DATA_INVALID=9;
  const E_INVALID_VERIFICATION_CODE=10;
  const E_INVALID_INITIALIZATION_CODE=11;
  const E_VERIFICATION_EMAIL_FAILED=12;
  const E_USER_EXISTS=13;
  const E_VERIFICATION_EMAIL_NOT_EXISTS=14;
  const E_VERIFICATION_EMAIL_VALID=15;
  const E_VERIFICATION_SEND_FAILED=16;
  const E_DATA_NOT_EXISTS=17;
  const E_INSUFFICIENT_CREDIT=18;
  const E_VERIFICATION_SEND_EMAIL_FAILED=19;
  const E_FILE_UPLOAD_INVALID=20;
  const E_FILE_UPLOAD_FAILED=21;
  const E_CLIENT_LOCATION_NOT_EXISTS=22;
  const E_FILE_NOT_FOUND=23;
  const E_INVALID_KEY=24;
  const E_PEMBIAYAAN_NOT_EXISTS=25;
  const E_PAYMENT_FAILED=26;
  const E_FILE_DELETE_FAILED=27;
  const E_POST_NUMBER_INSUFFICIENT=28;
  const E_SEND_SMS_FAILED=29;
  const E_MEMBER_MANDATORY_FAILED=30;
  const E_INVALID_APPLICATION_VERSION=31;
  const E_BANNER_NOT_EXISTS=32;
  const E_POST_NOT_EXISTS=33;
  const E_FCM_ERROR=34;
  const E_NOTIFICATION_FAILED=35;
  const E_INVALID_OTP=36;
  const E_JEMPUT_UANG_NOT_EXISTS=36;
  const E_NO_ACCESS=37;
  const E_LIMIT_SALES=38;

  const DB_DELETED=2;

  const APPLY_REJECT=0;
  const APPLY_ACCEPT=1;
  const APPLY_FAVORITE=2;
  const APPLY_NEW=3;
  const APPLY_RECOMMENDATION=4;
  const APPLY_REQUIREMENT=5; // No need to include on POST_USER_STATUS

  const POST_RECOMMENDATION_STATUS=0;
  
  const POST_USER_STATUS=[
	self::APPLY_REJECT=>"Ditolak",
	self::APPLY_ACCEPT=>"Diterima",
	self::APPLY_FAVORITE=>"Favorit",
	self::APPLY_NEW=>"Baru",
	self::APPLY_RECOMMENDATION=>"Rekomendasi",
  ];
  
  const MAX_RECOMMENDATION=10;
  const MAX_RECOMMENDATION_GENERATE=200;
  
  const SALARY_MINIMUM=0;
  const SALARY_MAXIMUM=999999999999;
  
  const CONFIG_ORDER_NUMBER="order_number";
  const CONFIG_APPLICATION_VERSION="application_version";
  const CONFIG_JOBSEEKER_UPDATE="jobseeker_update";
  const CONFIG_EMPLOYER_UPDATE="employer_update";
  const CONFIG_MATCHMAKING_EMPLOYER_POSITION="matchmaking_position";
  const CONFIG_MATCHMAKING_EMPLOYER_SALARY="matchmaking_salary";
  const CONFIG_MATCHMAKING_EMPLOYER_EDUCATION="matchmaking_education";
  const CONFIG_MATCHMAKING_EMPLOYER_LOCATION="matchmaking_location";
  const CONFIG_NOTIFICATION_MATCHMAKING_EMPLOYER="notification_matchmaking_employer";
  const CONFIG_NOTIFICATION_MATCHMAKING_EMPLOYER_RESULT="notification_matchmaking_employer_result";
  const CONFIG_NOTIFICATION_EMPLOYER_CHANGE_PASSWORD="notification_employer_change_password";
  const CONFIG_NOTIFICATION_EMPLOYER_POST="notification_employer_post";
  const CONFIG_NOTIFICATION_EMPLOYER_REGISTRATION="notification_employer_registration";


  const ROLE_TEACHER="TEACHER";
  const ROLE_HOMEROOM_TEACHER="HOMEROOM";
  const ROLE_PARENT="PARENT";
  const ROLE_EXPERT="EXPERT";
  const ROLE_HEAD_MASTER="HEADMASTER";
  const ROLE_ADMIN="SCADMIN";

  
  const MIME_TYPES=[
	"png"=>"image/png",
	"jpg"=>"image/jpg",
	"jpeg"=>"image/jpg",
	"bmp"=>"image/bmp",
  "gif"=>"image/gif",
  "mp4"=>"video/mp4",
	
  ];
  static function message($status=-1)
  {
    $statusTexts=[
      self::E_SUCCESS=>"Success",
      self::E_UNKNOWN=>"Unknown",
      self::E_USER_NOT_EXISTS=>"User does not exists",
      self::E_INVALID_PASSWORD=>"Invalid Password",
      self::E_DATABASE=>"Database Error",
      self::E_INVALID_APPLICATION=>"Unauthoried Application",
      self::E_TOKEN_EXPIRED=>"Token Expired",
      self::E_INVALID_TOKEN=>"Token Invalid",
      self::E_USER_NOT_ACTIVE=>"User Not Active",
      self::E_REGISTRATION_DATA_FAILED=>"Registration Data Invalid",
      self::E_FORMAT_DATA_INVALID=>"Format Data Invalid",
      self::E_INVALID_VERIFICATION_CODE=>"Verification code Invalid",
      self::E_INVALID_INITIALIZATION_CODE=>"Initialize code Invalid",
      self::E_VERIFICATION_EMAIL_FAILED=>"Failed Generate Email Verification",
      self::E_USER_EXISTS=>"User sudah terdaftar",
      self::E_VERIFICATION_EMAIL_NOT_EXISTS=>"Email Verifikasi tidak ditemukan",
      self::E_VERIFICATION_EMAIL_VALID=>"Email Verifikasi valid",
      self::E_VERIFICATION_SEND_FAILED=>"Kirim SMS Verifikasi Gagal",
      self::E_DATA_NOT_EXISTS=>"Data tidak ada",
      self::E_INSUFFICIENT_CREDIT=>"Credit tidak cukup",
      self::E_VERIFICATION_SEND_EMAIL_FAILED=>"Kirim Email Verifikasi Gagal",
      self::E_FILE_UPLOAD_INVALID=>"File upload salah",
      self::E_FILE_UPLOAD_FAILED=>"File upload gagal",
      self::E_CLIENT_LOCATION_NOT_EXISTS=>"Lokasi client tidak ada",
      self::E_FILE_NOT_FOUND=>"File tidak ditemukan",
      self::E_INVALID_KEY=>"Key salah",
      self::E_PEMBIAYAAN_NOT_EXISTS=>"Pembiayaan tidak terdaftar",
      self::E_PAYMENT_FAILED=>"Pembayaran gagal",
      self::E_FILE_DELETE_FAILED=>"Hapus file gagal",
      self::E_POST_NUMBER_INSUFFICIENT=>"Jumlah Post tidak mencukupi",
      self::E_SEND_SMS_FAILED=>"Gagal kirim SMS",
      self::E_MEMBER_MANDATORY_FAILED=>"Field Mandatory belum terisi semua",
      self::E_INVALID_APPLICATION_VERSION=>"Ayo Update Apps untuk melanjutkan",
      self::E_BANNER_NOT_EXISTS=>"Banner tidak ada",
      self::E_POST_NOT_EXISTS=>"Posting tidak ada",
      self::E_FCM_ERROR=>"FCM Issue",
      self::E_NOTIFICATION_FAILED=>"Kirim Notifikasi gagal",
      self::E_INVALID_OTP=>"OTP salah",
      self::E_JEMPUT_UANG_NOT_EXISTS=>"Jemput Uang tidak terdaftar",
      self::E_NO_ACCESS=>"Tidak punya akses",
      self::E_LIMIT_SALES=>"Sales melebihi limit alokasi",
    ];
    return isset($statusTexts[$status])?  $statusTexts[$status]: $statusTexts[self::E_UNKNOWN];
  }

  const EDUCATION_LEVEL_CONVERT=[
    "D1"=>"PT",
    "D2"=>"PT",
    "D3"=>"PT",
    "S1"=>"PT",
    "S2"=>"PT",
  ];


  const STATUS_PROGRESS=0;
  const STATUS_COMPLETED=1;
  const STATUS_REJECTED=2; // BSM Rejected
  const STATUS_CONFIRM=3;
  const STATUS_CANCELED=4; // User canceled
}
