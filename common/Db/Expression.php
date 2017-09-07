<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-22
 * Time: 8:41
 */

namespace Common\Db;


class Expression
{
    /**
     * @var string the DB expression
     */
    public $expression;
    /**
     * @var array list of parameters that should be bound for this expression.
     * The keys are placeholders appearing in [[expression]] and the values
     * are the corresponding parameter values.
     */
    public $params = [];


    /**
     * Constructor.
     * @param string $expression the DB expression
     * @param array $params parameters
     * @param array $config name-value pairs that will be used to initialize the object properties
     */
    public function __construct($expression, $params = [])
    {
        $this->expression = $expression;
        $this->params = $params;
    }

    /**
     * String magic method
     * @return string the DB expression
     */
    public function __toString()
    {
        return $this->expression;
    }

}