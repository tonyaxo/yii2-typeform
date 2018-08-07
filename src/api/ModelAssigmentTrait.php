<?php


namespace tonyaxo\yii2typeform\api;

use yii\base\InvalidConfigException;
use yii\base\Model;

/**
 * Trait ModelAssigmentTrait
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 */
trait ModelAssigmentTrait
{
    protected function assignMultiple(string $method, array $values, $modelClass)
    {
        $privateProperty = $this->getPropertyName($method, true);
        if ($privateProperty !== null) {
            foreach ($values as $data) {
                /** @var BaseModel $model */
                $model = null;
                if (is_array($data)) {
                    if ($data !== []) {
                        $model = new $modelClass();
                        $model->load($data);
                    }
                } elseif ($data instanceof $modelClass) {
                    $model = $data;
                } else {
                    throw new InvalidConfigException("Wrong data format for {$method}");
                }
                if ($model !== null)  {
                    $this->$privateProperty[] = $model;
                    $this->adjustEmpty($privateProperty);
                } else {
                    \Yii::debug("Failed to set model {$modelClass} in '" . get_class($this) . "'.", $method);
                }
            }
        }
    }

    protected function assignSingle(string $method, $value, $modelClass)
    {
        $privateProperty = $this->getPropertyName($method, true);
        if ($privateProperty !== null) {
            /** @var BaseModel $model */
            $model = null;
            if (is_array($value)) {
                if ($value !== []) {
                    $model = new $modelClass();
                    $model->load($value);
                }
            } elseif ($value instanceof $modelClass) {
                $model = $value;
            } else {
                throw new InvalidConfigException("Wrong data format for {$modelClass}");
            }
            if ($model !== null)  {
                $this->$privateProperty = $model;
                $this->adjustEmpty($privateProperty);
            } else {
                \Yii::debug("Failed to set model {$modelClass} in '" . $modelClass . "'.", __METHOD__);
            }
        }
    }

    protected function getPropertyName(string $method, bool $private = true): ?string
    {
        $method = preg_replace('/^set/', '', $method, 1, $cnt);
        if ($cnt) {
            $prefix = $private ? '_' : '';
            return $prefix . lcfirst($method);
        }
        return null;
    }

    protected function adjustEmpty(string $propertyName): void
    {
        if ($this->$propertyName instanceof EmptyCheckableInterface) {
            $empty = $this->isEmpty() && $this->$propertyName->isEmpty();
        } else {
            $empty = $this->isEmpty() && empty($this->$propertyName);
        }
        $this->setEmpty($empty);
    }
}
