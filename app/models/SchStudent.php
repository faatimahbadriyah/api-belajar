<?php



class SchStudent extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $studentid;

    /**
     *
     * @var string
     */
    public $regis_no;

    /**
     *
     * @var integer
     */
    public $uid;

    /**
     *
     * @var integer
     */
    public $persid;

    /**
     *
     * @var string
     */
    public $nickname;
    public $childseq;
    public $schoolid;
    public $classid;
    public $teacherid;
    public $parentid;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->setSource("sch_student");
        $this->hasMany('studentid', 'SchActivity', 'studentid', ['alias' => 'SchActivity']);
        $this->belongsTo('schoolid', 'SchSchool', 'schoolid', ['alias' => 'SchSchool']);
        $this->belongsTo('classid', 'SchClass', 'classid', ['alias' => 'SchClass']);
        $this->belongsTo('teacherid', 'SchTeacher', 'teacherid', ['alias' => 'SchTeacher']);
        $this->belongsTo('parentid', 'SchParent', 'parentid', ['alias' => 'SchParent']);
        $this->belongsTo('persid', 'TbPerson', 'persid', ['alias' => 'TbPerson']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sch_student';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SchStudent[]|SchStudent|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SchStudent|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function findStudents($parameters=[])
    {
        $di=\Phalcon\Di::getDefault();
        if(RoleHelper::isTeacher()):
            $parameters["conditions"][]="teacherid=:teacherid:";
            $parameters["bind"]["teacherid"]=$di->get("common")->teacherId();
        endif;
        if(RoleHelper::isParent()):
            $parameters["conditions"][]="parentid=:parentid:";
            $parameters["bind"]["parentid"]=$di->get("common")->parentId();
        endif;
        if(RoleHelper::isHeadMaster()):
            $parameters["conditions"][]="a.schoolid=:schoolid:";
            $parameters["bind"]["schoolid"]=$di->get("common")->schoolId();
        endif;
        if(RoleHelper::isExpert()):
            $parameters["conditions"][]="expertid=:expertid:";
            $parameters["bind"]["expertid"]=$di->get("common")->personId();
        endif;
        if(RoleHelper::isHomeroom()):
            $parameters["conditions"][]="a.schoolid=:schoolid:";
            $parameters["conditions"][]="a.classid=:classid:";
            $parameters["bind"]["schoolid"]=$di->get("common")->schoolId();
            $parameters["bind"]["classid"]=$di->get("common")->teacherClassId();
        endif;
//        print_r($parameters);
        //return parent::find($parameters);
        $queryBuilder = $di->get("modelsManager")->createBuilder()
        ->from('TbPerson')
        ->columns('a.studentid, a.regis_no, TbPerson.tname, b.classname, a.photo')
        ->leftjoin('SchStudent', 'a.persid = TbPerson.persid', 'a')
        ->leftjoin('SchClass', 'b.classid = a.classid', 'b')
        ->orderBy('TbPerson.tname')
        ->where(implode(" AND ", $parameters["conditions"]), $parameters["bind"])
        ->limit($parameters["limit"], $parameters["offset"]);
        return $queryBuilder->getQuery()->execute();
    }

}
