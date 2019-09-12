<?php



class ScRole extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $roleid;

    /**
     *
     * @var string
     */
    public $rolename;

    /**
     *
     * @var string
     */
    public $desc;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->setSource("sc_role");
        $this->hasMany('roleid', 'ScUserRole', 'roleid', ['alias' => 'ScUserRole']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sc_role';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ScRole[]|ScRole|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ScRole|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
