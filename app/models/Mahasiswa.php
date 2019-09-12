<?php

class Mahasiswa extends \Phalcon\Mvc\Model
{
    /**
     *
     * @var integer
     */
    public $idmhs;

    /**
     *
     * @var string
     */
    public $namamhs;

    /**
     *
     * @var string
     */
    public $notlpmhs;

    /**
     *
     * @var string
     */
    public $tgllahirmhs;


    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->setSource("mahasiswa");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'mahasiswa';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Mahasiswa[]|Mahasiswa|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Mahasiswa|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
