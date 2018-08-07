<?php


namespace yiiunit\extensions\yii2typeform;


use tonyaxo\yii2typeform\api\forms\Properties;
use tonyaxo\yii2typeform\api\forms\ThankyouProperties;
use tonyaxo\yii2typeform\api\forms\WelcomeProperties;

class PropertiesTest extends BaseTestCase
{
    public function testEmpty()
    {
        $welcomeProps = new WelcomeProperties();
        $this->assertTrue($welcomeProps->isEmpty());

        $thankyouProps = new ThankyouProperties();
        $this->assertTrue($thankyouProps->isEmpty());

        $props = new Properties();
        $this->assertTrue($props->isEmpty());
    }

    public function testProperties()
    {
        $this->markTestIncomplete(__FUNCTION__);
    }

    /**
     * @dataProvider welcomeDataProvider
     *
     * @param array $data
     * @param bool $expectedValidation
     * @param array $expectedArray
     * @param bool $expectedEmpty
     * @throws \yii\base\NotSupportedException
     */
    public function testWelcomeProperties(array $data, bool $expectedValidation, array $expectedArray, bool $expectedEmpty)
    {
        $this->execTestForClass(WelcomeProperties::class, $data, $expectedValidation, $expectedArray, $expectedEmpty);
    }

    /**
     * @dataProvider thankyouDataProvider
     *
     * @param array $data
     * @param bool $expectedValidation
     * @param array $expectedArray
     * @param bool $expectedEmpty
     * @throws \yii\base\NotSupportedException
     */
    public function testThankyouProperties(array $data, bool $expectedValidation, array $expectedArray, bool $expectedEmpty)
    {
        $this->execTestForClass(ThankyouProperties::class, $data, $expectedValidation, $expectedArray, $expectedEmpty);
    }

    /**
     * @return array
     */
    public function thankyouDataProvider(): array
    {
        return [
            [
                [],
                true,
                [],
                true,
            ],
            [
                [
                    'button_mode' => 'wrong_mode',
                    'show_button' => true,
                    'button_text' => 'button text',
                ],
                false,
                [
                    'button_mode' => 'wrong_mode',
                    'show_button' => true,
                    'button_text' => 'button text',
                ],
                false,
            ],
            [
                [
                    'button_mode' => ThankyouProperties::BUTTON_MODE_REDIRECT,
                    'redirect_url' => 'https://some-redirect-url.com',
                ],
                true,
                [
                    'button_mode' => ThankyouProperties::BUTTON_MODE_REDIRECT,
                    'redirect_url' => 'https://some-redirect-url.com',
                ],
                false,
            ],
            [
                [
                    'button_mode' => ThankyouProperties::BUTTON_MODE_REDIRECT,
                    'redirect_url' => 'some-redirect-url',
                ],
                false,
                [
                    'button_mode' => ThankyouProperties::BUTTON_MODE_REDIRECT,
                    'redirect_url' => 'some-redirect-url',
                ],
                false,
            ],
            [
                [
                    'button_mode' => ThankyouProperties::BUTTON_MODE_RELOAD,
                    'share_icons' => 'some_string_converted_to_true',
                ],
                true,
                [
                    'button_mode' => ThankyouProperties::BUTTON_MODE_RELOAD,
                    'share_icons' => true,
                ],
                false,
            ],
        ];
    }

    /**
     * @return array
     */
    public function welcomeDataProvider(): array
    {
        return [
            [
                [],
                true,
                [],
                true,
            ],
            [
                [
                    'description' => 'description',
                    'show_button' => true,
                    'button_text' => 'button text',
                ],
                true,
                [
                    'description' => 'description',
                    'show_button' => true,
                    'button_text' => 'button text',
                ],
                false,
            ],
            [
                [
                    'description' => 'description',
                    'show_button' => 'wrong_value_converted_to_true',
                    'button_text' => 'button text',
                ],
                true,
                [
                    'description' => 'description',
                    'show_button' => true,
                    'button_text' => 'button text',
                ],
                false,
            ],
            [
                [
                    'description' => 'description',
                ],
                true,
                [
                    'description' => 'description',
                ],
                false,
            ],
        ];
    }
}
