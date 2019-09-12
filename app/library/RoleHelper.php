<?php

class RoleHelper
{
    static protected $di;
    public function init()
    {
        if(empty(self::$di)):
            self::$di=Phalcon\Di::getDefault();
        endif;
    }

    public static function getRoleId($roleName)
    {
        self::init();
        foreach(self::$di->get("requestApi")->data->roles as $role):
            if($role->rolename==$roleName):
                return $role->roleid;
            endif;
        endforeach;
        return -1;
    }
    public static function isTeacher()
    {
        self::init();
        return self::$di->get("requestApi")->data->application->roleid==self::getRoleId(Definitions::ROLE_TEACHER);
    }
    public static function isHomeroom()
    {
        self::init();
        return self::$di->get("requestApi")->data->application->roleid==self::getRoleId(Definitions::ROLE_HOMEROOM_TEACHER);
    }
    public static function isHeadMaster()
    {
        self::init();
        return self::$di->get("requestApi")->data->application->roleid==self::getRoleId(Definitions::ROLE_HEAD_MASTER);
    }
    public static function isExpert()
    {
        self::init();
        return self::$di->get("requestApi")->data->application->roleid==self::getRoleId(Definitions::ROLE_EXPERT);
    }
    public static function isParent()
    {
        self::init();
        return self::$di->get("requestApi")->data->application->roleid==self::getRoleId(Definitions::ROLE_PARENT);
    }

}