<?php

namespace tonyaxo\yii2typeform\api\forms;

use tonyaxo\yii2typeform\api\TypeInterface;
use tonyaxo\yii2typeform\api\TypeTrait;
use tonyaxo\yii2typeform\api\UnderscoresMagicMethodTrait;
use yii\base\Model;

/**
 * Class Validations
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 *
 * @property int maxLength
 * @property int minValue
 * @property int maxValue
 */
class Validations extends Model implements TypeInterface
{
    use UnderscoresMagicMethodTrait;
    use TypeTrait;

    /**
     * @var string Field::type
     */
    public $type;
    /**
     * @var bool
     */
    public $required;

    /**
     * @var int
     */
    private $_maxLength;
    /**
     * @var int
     */
    private $_minValue;
    /**
     * @var int
     */
    private $_maxValue;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['type', 'required'],
            ['type', 'in', 'range' => Field::getTypes()],
            ['required', 'boolean'],
            [[
                'maxLength', 'minValue', 'maxValue',
                'max_length', 'min_value', 'max_value',
            ], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $result = [];
        if ($this->requiredAvailable()) {
            $result[] = 'required';
        }
        if ($this->maxLengthAvailable()) {
            $result['max_length'] = 'maxLength';
        }
        if ($this->valueAvailable()) {
            $result['min_value'] = 'minValue';
            $result['max_value'] = 'maxValue';
        }
        return $result;
    }

    /**
     * @return mixed
     */
    public function getMaxLength()
    {
        return $this->_maxLength;
    }

    /**
     * @param mixed $maxLength
     */
    public function setMaxLength($maxLength): void
    {
        $this->_maxLength = $maxLength;
    }

    /**
     * @return mixed
     */
    public function getMinValue()
    {
        return $this->_minValue;
    }

    /**
     * @param mixed $minValue
     */
    public function setMinValue($minValue): void
    {
        $this->_minValue = $minValue;
    }

    /**
     * @return mixed
     */
    public function getMaxValue()
    {
        return $this->_maxValue;
    }

    /**
     * @param mixed $maxValue
     */
    public function setMaxValue($maxValue): void
    {
        $this->_maxValue = $maxValue;
    }

    /**
     * @return bool
     */
    protected function requiredAvailable()
    {
        if ($this->type == self::TYPE_GROUP || $this->type == self::TYPE_STATEMENT) {
            return false;
        }
        return true;
    }

    /**
     * @return bool
     */
    protected function maxLengthAvailable()
    {
        if ($this->type == self::TYPE_LONG_TEXT || $this->type == self::TYPE_NUMBER || $this->type == self::TYPE_SHORT_TEXT) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    protected function valueAvailable()
    {
        if ($this->type == self::TYPE_NUMBER) {
            return true;
        }
        return false;
    }
}
