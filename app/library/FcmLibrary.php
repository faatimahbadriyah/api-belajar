<?php
use Phalcon\Http\Client\Request;

class FcmLibrary
{
    protected $di;
    protected $key;
    protected $params=[];
    protected $url;
    protected $projectId="";
    public function __construct()
    {
        $this->di = Phalcon\DI::getDefault();
        if(empty($this->di->getConfig()->fcm->api_key)):
            throw new Exception('API Key FCM not defined');
        endif;
        $this->url='https://android.googleapis.com/gcm/send';
        $this->key=$this->di->getConfig()->fcm->api_key;
        $this->projectId=$this->di->getConfig()->fcm->project_id;
    }


    public function setParams($params=[])
    {
        $this->params=$params;
    }
    public function getParams()
    {
        return $this->params;
    }

    public function setPProjectId($id="")
    {
        $this->projectId=$id;
    }
    public function getProjectId()
    {
        return $this->projectId;
    }

    public function generateSingle($id="",$title="",$body="")
    {
        $this->setParams([
            "to"=>$id,
            "notification"=>[
                "title"=>$title,
                "body"=>$body,
            ],
        "icon"=>"notif_kerjaku",
        ]);
    }
    public function generateDataSingle($id="",$title="",$body="")
    {
        $this->setParams([
            "to"=>$id,
            "notification"=>[
                "title"=>$title,
                "body"=>$body,
            ],
        "icon"=>"notif_kerjaku",
            "data"=>[
                "title"=>$title,
                "body"=>$body,
            //"image"=>"http://dev.api.kerjaku.net/images/notif_kerjaku.png",
            ]
        ]);
    }

    public function sendSingle($id="",$title="",$body="")
    {
        $this->generateSingle($id,$title,$body);
        return $this->send();
    }

    public function addGroup($name="",$ids=[])
    {
        $this->url='https://iid.googleapis.com/notification';
        $this->params=[
            "operation"=>"create",
            "notification_key_name"=>$name,
            "registration_ids"=>$ids,
        ];

        return $this->send();

    }
    public function delDevices($name="",$key="",$ids=[])
    {
        $this->url='https://iid.googleapis.com/notification';
        $this->params=[
            "operation"=>"remove",
            "notification_key_name"=>$name,
            "notification_key"=>$key,
            "registration_ids"=>$ids,
        ];

        return $this->send();

    }

    public function addDevices($name="",$key="",$ids=[])
    {
        $this->url='https://iid.googleapis.com/notification';
        $this->params=[
            "operation"=>"add",
            "notification_key_name"=>$name,
            "notification_key"=>$key,
            "registration_ids"=>$ids,
        ];

        return $this->send();

    }

    public function getGroupKey($name="")
    {
        $this->url='https://iid.googleapis.com/notification';
        $this->params=[
            "notification_key_name"=>$name,
        ];

        return $this->sendGet();

    }

    public function send(){
        $provider = Request::getProvider();
        $provider->setBaseUri($this->url);
        $provider->header->set('Accept', 'application/json');
        $provider->header->set('Content-Type', 'application/json');
        $provider->header->set('Authorization', 'key=' . $this->key);
        $provider->header->set('project_id',  $this->projectId);
        $bodyRequest=json_encode($this->params);
        return  $provider->post('', $bodyRequest);
    }
    public function sendPut(){
        $provider = Request::getProvider();
        $provider->setBaseUri($this->url);
        $provider->header->set('Accept', 'application/json');
        $provider->header->set('Content-Type', 'application/json');
        $provider->header->set('Authorization', 'key=' . $this->key);
        $provider->header->set('project_id',  $this->projectId);
        $bodyRequest=json_encode($this->params);
        return  $provider->put('', $bodyRequest);
    }
    public function sendGet(){
        $provider = Request::getProvider();
        $provider->setBaseUri($this->url);
        $provider->header->set('Accept', 'application/json');
        $provider->header->set('Content-Type', 'application/json');
        $provider->header->set('Authorization', 'key=' . $this->key);
        $provider->header->set('project_id',  $this->projectId);
        return  $provider->get('', $this->params);
    }

}
