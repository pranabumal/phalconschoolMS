<?php

class Students extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $StudentID;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $LastName;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $FirstName;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $Address;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $City;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("phalcon_school");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'students';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Students[]|Students
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Students
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
