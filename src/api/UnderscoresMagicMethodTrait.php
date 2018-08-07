<?php

namespace tonyaxo\yii2typeform\api;

use yii\base\UnknownPropertyException;
use yii\helpers\Inflector;

/**
 * Allow to use alias methods for properties like `some_property`.
 */
trait UnderscoresMagicMethodTrait
{
    /**
     * @inheritdoc
     */
    public function __set($name, $value)
    {
        try {
            parent::__set($name, $value);
        } catch (UnknownPropertyException $e) {
            $setter = 'set' . Inflector::camelize($name);
            if (method_exists($this, $setter)) {
                // set property
                $this->$setter($value);

                return;
            }
            throw $e;
        }
    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        try {
            return parent::__get($name);
        } catch (UnknownPropertyException $e) {
            $getter = 'get' . Inflector::camelize($name);
            if (method_exists($this, $getter)) {
                // set property
                return $this->$getter();
            }
            throw $e;
        }
    }
}
