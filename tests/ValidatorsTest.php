<?php

namespace yiiunit\extensions\yii2typeform;

use tonyaxo\yii2typeform\api\TypeInterface;
use tonyaxo\yii2typeform\api\forms\Validations;

class ValidatorsTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider validatorsDataProvider
     *
     * @param array $data
     * @param array $expectedAttributes
     * @param string $expectedArray
     */
    public function testValidator(array $data, array $expectedAttributes, array $expectedArray)
    {
        $validators = new Validations();
        $validators->load($data, '');

        foreach ($expectedAttributes as $attribute => $value) {
            $this->assertEquals($value, $validators->$attribute);
        }
        $this->assertEquals($expectedArray, $validators->toArray());

        $this->markTestIncomplete('test validate()');
    }

    public function testIsEmpty()
    {
        $this->markTestIncomplete(__FUNCTION__);
    }

    /**
     * @return array
     */
    public function validatorsDataProvider()
    {
        return [
            [
                [
                    'type' => TypeInterface::TYPE_GROUP,
                    'required' => true,
                    'max_length' => 0,
                    'min_value' => 0,
                    'max_value' => 0,
                ],
                [
                    'type' => TypeInterface::TYPE_GROUP,
                    'required' => true,
                    'maxLength' => 0,
                    'minValue' => 0,
                    'maxValue' => 0,
                ],
                [],
            ],
            [
                [
                    'type' => TypeInterface::TYPE_STATEMENT,
                    'required' => true,
                    'max_length' => 0,
                    'min_value' => 0,
                    'max_value' => 0,
                ],
                [
                    'type' => TypeInterface::TYPE_STATEMENT,
                    'required' => true,
                    'maxLength' => 0,
                    'minValue' => 0,
                    'maxValue' => 0,
                ],
                [],
            ],
            [
                [
                    'type' => TypeInterface::TYPE_LONG_TEXT,
                    'required' => true,
                    'max_length' => 16,
                    'min_value' => 0,
                    'max_value' => 0,
                ],
                [
                    'type' => TypeInterface::TYPE_LONG_TEXT,
                    'required' => true,
                    'max_length' => 16,
                    'min_value' => 0,
                    'max_value' => 0,
                ],
                ['required' => true, 'max_length' => 16],
            ],
            [
                [
                    'type' => TypeInterface::TYPE_SHORT_TEXT,
                    'required' => false,
                    'max_length' => 16,
                    'min_value' => 0,
                    'max_value' => 0,
                ],
                [
                    'type' => TypeInterface::TYPE_SHORT_TEXT,
                    'required' => false,
                    'max_length' => 16,
                    'min_value' => 0,
                    'max_value' => 0,
                ],
                ['required' => false, 'max_length' => 16],
            ],
            [
                [
                    'type' => TypeInterface::TYPE_NUMBER,
                    'required' => true,
                    'max_length' => 16,
                    'min_value' => -10,
                    'max_value' => 999,
                ],
                [
                    'type' => TypeInterface::TYPE_NUMBER,
                    'required' => true,
                    'maxLength' => 16,
                    'minValue' => -10,
                    'maxValue' => 999,
                ],
                ['required' => true, 'max_length' => 16, 'min_value' => -10, 'max_value' => 999],
            ],
        ];
    }
}
