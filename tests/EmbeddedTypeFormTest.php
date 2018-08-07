<?php

namespace yiiunit\extensions\yii2typeform;

use tonyaxo\yii2typeform\widgets\EmbeddedTypeForm;

class EmbeddedTypeFormTest extends TestCase
{
    /**
     * @inheritdoc
     */
    public function tearDown()
    {
        EmbeddedTypeform::$counter = 0;
        EmbeddedTypeform::$stack = [];
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
                    'url' => 'https://admin.typeform.com/to/cVa5IG',
                    'type' => EmbeddedTypeform::TYPE_WIDGET,
                ],
                '<div id="w0" class="typeform" style="width: 500px; height: 300px;"></div>',
            ],
            [
                [
                    'url' => 'https://admin.typeform.com/to/cVa5IG',
                    'type' => EmbeddedTypeform::TYPE_WIDGET,
                    'width' => '100%',
                    'height' => '500px',
                    'options' => ['class' => 'test-class'],
                ],
                '<div id="w0" class="test-class typeform" style="width: 100%; height: 500px;"></div>',
            ],
            [
                [
                    'url' => 'https://admin.typeform.com/to/cVa5IG',
                    'type' => EmbeddedTypeform::TYPE_POPUP,
                ],
                '',
            ],
            [
                [
                    'url' => 'https://admin.typeform.com/to/cVa5IG',
                    'type' => EmbeddedTypeform::TYPE_POPUP,
                    'toggleButton' => ['label' => 'click me'],
                ],
                '<button type="button" id="w0_button">click me</button>',
            ],
            [
                [
                    'url' => 'https://admin.typeform.com/to/cVa5IG',
                    'type' => EmbeddedTypeform::TYPE_POPUP,
                    'toggleButton' => ['label' => 'click me', 'tag' => 'a', 'class' => 'test-class'],
                ],
                '<a id="w0_button" class="test-class">click me</a>',
            ],
        ];
    }

    /**
     * Data provider for `testHiddenFields`
     * @return array test data
     */
    public function dataProviderUrl()
    {
        return [
            [
                ['url' => 'https://admin.typeform.com/to/cVa5IG'],
                'https://admin.typeform.com/to/cVa5IG',
            ],
            [
                ['url' => 'https://admin.typeform.com/to/cVa5IG?'],
                'https://admin.typeform.com/to/cVa5IG?',
            ],
            [
                ['url' => 'https://admin.typeform.com/to/cVa5IG?field_1=value 1'],
                'https://admin.typeform.com/to/cVa5IG?' . $this->httpBuildQuery(['field_1' => 'value 1'])
            ],
            [
                ['url' => 'https://admin.typeform.com/to/cVa5IG?field_1=значение 1'],
                'https://admin.typeform.com/to/cVa5IG?' . $this->httpBuildQuery(['field_1' => 'значение 1']),
            ],
            [
                [
                    'url' => 'https://admin.typeform.com/to/cVa5IG?field_1=value_1',
                    'hiddenFields' => ['field_2' => 'value_2'],
                ],
                'https://admin.typeform.com/to/cVa5IG?' . $this->httpBuildQuery(['field_1' => 'value_1', 'field_2' => 'value_2']),
            ],
            [
                [
                    'url' => 'https://admin.typeform.com/to/cVa5IG?field_1=value_1',
                    'hiddenFields' => ['field_1' => 'new_value', 'field_2' => 'value_2'],
                ],
                'https://admin.typeform.com/to/cVa5IG?' . $this->httpBuildQuery(['field_1' => 'new_value', 'field_2' => 'value_2']),
            ],
        ];
    }

    /**
     * @dataProvider dataProviderOptions
     *
     * @param array $options
     * @param string $expectedHtml
     * @throws \Exception
     */
    public function testWidget(array $options, string $expectedHtml)
    {
        $out = EmbeddedTypeform::widget($options);

        $this->assertEqualsWithoutLE($expectedHtml, $out);
    }

    /**
     * @dataProvider dataProviderUrl
     *
     * @param array $options
     * @param string $expectedUrl
     */
    public function testHiddenFields(array $options, string $expectedUrl)
    {
        $widget = EmbeddedTypeform::begin($options);
        $this->assertEquals($expectedUrl, $widget->getUrl());
    }

    /**
     * Short alias for http_build_query()
     * @param array $data
     * @return null|string
     */
    protected function httpBuildQuery(array $data): ?string
    {
        return http_build_query($data, 'field_', '&', PHP_QUERY_RFC3986);
    }
}
