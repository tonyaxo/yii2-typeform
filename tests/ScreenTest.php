<?php

namespace yiiunit\extensions\yii2typeform;


use tonyaxo\yii2typeform\api\forms\Attachment;
use tonyaxo\yii2typeform\api\forms\ThankyouScreen;
use tonyaxo\yii2typeform\api\forms\WelcomeProperties;
use tonyaxo\yii2typeform\api\forms\WelcomeScreen;

class ScreenTest extends BaseTestCase
{
    public function testEmpty()
    {
        $wc = new WelcomeScreen();
        $this->assertTrue($wc->isEmpty(), WelcomeScreen::class . ' is not empty');

        $ty = new ThankyouScreen();
        $this->assertTrue($ty->isEmpty(), ThankyouScreen::class . ' is not empty');
    }

    /**
     * @dataProvider welcomeDataProvider
     *
     * @param array $data
     * @param bool $expValidation
     * @param array $expArray
     * @param bool $expEmpty
     * @param null|string $expProperties
     * @param null|string $expAtachment
     * @throws \yii\base\NotSupportedException
     */
    public function testWelcome(array $data, bool $expValidation, array $expArray, bool $expEmpty, ?string $expProperties, ?string $expAttachment)
    {
        $this->execTestForClass(WelcomeScreen::class, $data, $expValidation, $expArray, $expEmpty);
        
        $ws = new WelcomeScreen();
        $ws->load($data);

        if ($expProperties === null) {
            $this->assertNull($ws->properties);
        } else {
            $this->assertInstanceOf(WelcomeProperties::class, $ws->properties);
        }
        if ($expAttachment === null) {
            $this->assertNull($ws->attachment);
        } else {
            $this->assertInstanceOf(Attachment::class, $ws->attachment);
        }
    }

    /**
     *
     * @param array $data
     * @param bool $expectedValidation
     * @param array $expectedArray
     * @param bool $expectedEmpty
     */
    public function testThankyou()
    {
        //$this->execTestForClass(Attachment::class, $data, $expectedValidation, $expectedArray, $expectedEmpty);

        $this->markTestIncomplete(__FUNCTION__);
    }

    /**
     * @return array
     */
    public function welcomeDataProvider()
    {
        return [
            'full empty' => [
                [],
                false,
                [],
                true,
                null,
                null,
            ],
            'only plain attributes' => [
                [
                    'ref' => 'some_ref',
                    'title' => 'some_title',
                ],
                true,
                [
                    'ref' => 'some_ref',
                    'title' => 'some_title',
                ],
                false,
                null,
                null,
            ],
            'full load' => [
                [
                    'ref' => 'some_ref',
                    'title' => 'some_title',
                    'properties' => [
                        'description' => 'description',
                        'show_button' => true,
                        'button_text' => 'button text',
                    ],
                    'attachment' => [
                        'type' => Attachment::TYPE_VIDEO,
                        'href' => 'https://images.typeform.com/images/4bcd3',
                    ],
                ],
                true,
                [
                    'ref' => 'some_ref',
                    'title' => 'some_title',
                    'properties' => [
                        'description' => 'description',
                        'show_button' => true,
                        'button_text' => 'button text',
                    ],
                    'attachment' => [
                        'type' => Attachment::TYPE_VIDEO,
                        'href' => 'https://images.typeform.com/images/4bcd3',
                        'scale' => Attachment::SCALE_06,
                    ],
                ],
                false,
                WelcomeProperties::class,
                Attachment::class,
            ],
            'invalid attachment' => [
                [
                    'ref' => 'some_ref',
                    'title' => 'some_title',
                    'properties' => [
                        'description' => 'description',
                        'show_button' => true,
                        'button_text' => 'button text',
                    ],
                    'attachment' => [
                        'type' => Attachment::TYPE_VIDEO,
                    ],
                ],
                false,
                [
                    'ref' => 'some_ref',
                    'title' => 'some_title',
                    'properties' => [
                        'description' => 'description',
                        'show_button' => true,
                        'button_text' => 'button text',
                    ],
                ],
                true,
                WelcomeProperties::class,
                Attachment::class,
            ],
            'empty properties' => [
                [
                    'ref' => 'some_ref',
                    'title' => 'some_title',
                    'properties' => [
                    ],
                    'attachment' => [
                        'type' => Attachment::TYPE_IMAGE,
                        'href' => 'https://images.typeform.com/images/4bcd3',
                    ],
                ],
                true,
                [
                    'ref' => 'some_ref',
                    'title' => 'some_title',
                    'attachment' => [
                        'type' => Attachment::TYPE_IMAGE,
                        'href' => 'https://images.typeform.com/images/4bcd3',
                    ],
                ],
                false,
                null,
                Attachment::class,
            ],
        ];
    }
}
