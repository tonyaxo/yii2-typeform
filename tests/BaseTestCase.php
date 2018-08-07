<?php


namespace yiiunit\extensions\yii2typeform;

use tonyaxo\yii2typeform\api\BaseModel;

/**
 * Class BaseTestCase
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 */
class BaseTestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @param string $className Tested class.
     * @param array $data Data to load to $className instance.
     * @param bool $expectedValidation Expected Validation result for $data.
     * @param array $expectedArray Array returned by $modelClass->toArray()
     * @param bool $expectedEmpty Value returned by $modelClass->isEmpty()
     * @throws \yii\base\NotSupportedException
     */
    protected function execTestForClass(string $className, array $data, bool $expectedValidation, array $expectedArray, bool $expectedEmpty): void
    {
        /** @var BaseModel $model */
        $model = new $className();
        $model->load($data);

        $this->assertEquals(
            $expectedValidation, $model->validate(),
            "{$className}::validate() expected return {$expectedValidation} " . print_r($model->getFirstErrors(), true)
        );

        $this->assertEquals(
            $expectedEmpty, $model->isEmpty(),
            "{$className}::isEmpty() expected return {$expectedEmpty}");

        $this->assertEquals(
            $expectedArray, $model->toArray(),
            "{$className}::toArray() expected return " . print_r($expectedArray, true)
        );
    }
}
