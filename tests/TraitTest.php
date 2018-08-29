<?php

namespace yiiunit\extensions\yii2typeform;

use PHPUnit\Framework\TestCase;
use tonyaxo\yii2typeform\api\TypeTrait;
use tonyaxo\yii2typeform\api\UnderscoresMagicMethodTrait;
use yii\base\Model;

class TraitTest extends TestCase
{
    public function testTypeTrait()
    {
        $class = new class {
            use TypeTrait;

            const TYPE_TEST1 = 'type1';
            const TYPE_TEST2 = 'type2';
            const NO_TYPE = 'no_type';
        };
        $this->assertEquals(['type1' => 'type1', 'type2' => 'type2'], $class::getTypes());
        $this->assertArrayNotHasKey('no_type', $class::getTypes());
    }

    public function testUnderscoresMagicMethodTrait()
    {
        $class = new class(['private_var' => 'var_value']) extends Model {
            use UnderscoresMagicMethodTrait;

            private $_privateVar;

            public function setPrivateVar(string $value)
            {
                $this->_privateVar = $value;
            }

            public function getPrivateVar(): string
            {
                return $this->_privateVar;
            }
        };

        $this->assertEquals('var_value', $class->privateVar);
    }

    public function testModelAssigmentTrait()
    {
        $this->markTestIncomplete();
    }
}
