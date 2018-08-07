<?php

namespace tonyaxo\yii2typeform\api;

use yii\base\Arrayable;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\helpers\ArrayHelper;
use yii\web\Link;
use yii\web\Linkable;

/**
 * Base model for API
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 */
class BaseModel extends Model implements EmptyCheckableInterface
{
    /**
     * @inheritdoc
     */
    public function formName()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        throw new NotSupportedException('"fields" is not implemented.');
    }

    /**
     * @var bool
     */
    private $_isEmpty = true;

    /**
     * @inheritdoc
     */
    public function isEmpty(): bool
    {
        return $this->validate() === false;
    }

    /**
     * @param bool $isEmpty
     */
    public function setEmpty(bool $isEmpty = true): void
    {
        $this->_isEmpty = $isEmpty;
    }

    /**
     * @inheritdoc
     *
     * Result array not include fields equal to empty objects and null values.
     */
    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $data = [];
        foreach ($this->resolveFields($fields, $expand) as $field => $definition) {
            $attribute = is_string($definition) ? $this->$definition : $definition($this, $field);

            // exclude from result empty fields
            $isEmpty = ($attribute instanceof EmptyCheckableInterface) ? $attribute->isEmpty() : $attribute === null;

            if (!$isEmpty && $recursive) {
                $nestedFields = $this->extractFieldsFor($fields, $field);
                $nestedExpand = $this->extractFieldsFor($expand, $field);
                if ($attribute instanceof Arrayable) {
                    $attribute = $attribute->toArray($nestedFields, $nestedExpand);
                } elseif (is_array($attribute)) {
                    $attribute = array_map(
                        function ($item) use ($nestedFields, $nestedExpand) {
                            if ($item instanceof Arrayable) {
                                return $item->toArray($nestedFields, $nestedExpand);
                            }
                            return $item;
                        },
                        $attribute
                    );
                }
            }
            if (!$isEmpty) {
                $data[$field] = $attribute;
            }
        }

        if ($this instanceof Linkable) {
            $data['_links'] = Link::serialize($this->getLinks());
        }

        return $recursive ? ArrayHelper::toArray($data) : $data;
    }

    /**
     * @param $attribute
     * @param $params
     * @param $validator
     */
    public function validateModel($attribute, $params, $validator)
    {
        if ($this->$attribute instanceof Model && $this->$attribute->validate() === false) {
            foreach ($this->$attribute->getErrors() as $name => $message) {
                $this->addErrors([
                    $attribute . '.' . $name => $message
                ]);
            }
        }
    }
}
