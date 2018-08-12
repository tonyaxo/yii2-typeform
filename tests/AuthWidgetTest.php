<?php

namespace yiiunit\extensions\yii2typeform;

use tonyaxo\yii2typeform\widgets\Auth;


class AuthWidgetTest extends TestCase
{
    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->mockWebApplication(require(__DIR__ . '/data/config.php'));
    }

    /**
     * @inheritdoc
     */
    public function tearDown()
    {
        Auth::$counter = 0;
        Auth::$stack = [];
        parent::tearDown();
    }

    /**
     * Data provider for `testWidget`
     * @return array test data
     */
    public function dataProviderOptions()
    {
        return [
            [
                [
                    'baseAuthUrl' => ['/authorize'],
                    'linkOptions' => [
                        'class' => 'btn btn-info'
                    ],
                ],
                '<div id="w0"><a class="btn btn-info auth-link" href="/index.php?r=authorize" title="TypeForm">Auth with TypeForm.com</a></div>',
            ],
            [
                [
                    'baseAuthUrl' => ['/authorize'],
                    'linkText' => 'Test text'
                ],
                '<div id="w0"><a class="typeform auth-link" href="/index.php?r=authorize" title="TypeForm">Test text</a></div>',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderOptions
     * @group auth-widget
     *
     * @param array $options
     * @param string $expectedHtml
     * @throws \Exception
     */
    public function testWidget(array $options, string $expectedHtml)
    {
        $out = Auth::widget($options);

        $this->assertEqualsWithoutLE($expectedHtml, $out);
    }
}
