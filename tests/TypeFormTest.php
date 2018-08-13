<?php

namespace yiiunit\extensions\yii2typeform;

use PHPUnit\Framework\MockObject\MockObject;
use tonyaxo\yii2typeform\api\webhooks\Webhook;
use tonyaxo\yii2typeform\TypeForm;
use yii\httpclient\Response;

class TypeFormTest extends TestCase
{
    const DEFAULT_ACCESS_TOKEN = 'TESTTOKEN';

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->mockWebApplication(require(__DIR__ . '/data/config.php'));
    }

    /**
     * @throws \tonyaxo\yii2typeform\ApiException
     * @throws \yii\base\InvalidConfigException
     */
    public function testCanCreateWebhook()
    {
        [$formId, $tag, $url, $content, $headers] = [
            'TESTID',
            'TESTAG',
            'http://test-url/webhook',
            // language=JSON
            '{
                    "id": "yRtagDm8AT",
                    "form_id": "TESTID",
                    "tag": "TESTAG",
                    "url": "http://test-url/webhook",
                    "enabled": true,
                    "created_at": "2016-11-21T12:23:26Z",
                    "updated_at": "2016-11-21T12:23:26Z"
                }',
            [
                'content-type' =>  'application/json; charset=UTF-8',
                'http-code' => '200',
            ],
        ];

        $client = $this->createMockClient($content, $headers);
        /** @var TypeForm $typeForm */
        $typeForm = \Yii::$app->get('typeform');
        $typeForm->setPersonalAccessToken(self::DEFAULT_ACCESS_TOKEN);
        $typeForm->setHttpClient($client);

        $hook = $typeForm->createWebhook($formId, $tag, $url, true);

        $this->assertInstanceOf(Webhook::class, $hook);
        $this->assertEquals($formId, $hook->formId);
        $this->assertEquals($tag, $hook->tag);
        $this->assertEquals($url, $hook->url);
    }

    /**
     * @expectedException \tonyaxo\yii2typeform\ApiException
     * @expectedExceptionMessage Description of error
     * @expectedExceptionCode 403
     *
     * @throws \tonyaxo\yii2typeform\ApiException
     * @throws \yii\base\InvalidConfigException
     */
    public function testCantCreateWebhook()
    {
        [$formId, $tag, $url, $content, $headers] = [
            'TESTID',
            'TESTAG',
            'http://test-url/webhook',
            // language=JSON
            '{"code":"SOME_INTERNAL_CODE","description":"Description of error"}',
            [
                'content-type' =>  'application/json; charset=UTF-8',
                'http-code' => '403',
            ],
        ];
        $client = $this->createMockClient($content, $headers);
        /** @var TypeForm $typeForm */
        $typeForm = \Yii::$app->get('typeform');
        $typeForm->setPersonalAccessToken(self::DEFAULT_ACCESS_TOKEN);
        $typeForm->setHttpClient($client);

        $typeForm->createWebhook($formId, $tag, $url, true);
    }

    /**
     * @throws \tonyaxo\yii2typeform\ApiException
     * @throws \yii\base\InvalidConfigException
     */
    public function testCanRetrieveWhebhook()
    {
        [$formId, $tag, $url, $content, $headers] = [
            'TESTID',
            'TESTAG',
            'http://test-url/webhook',
            // language=JSON
            '{
                    "id": "yRtagDm8AT",
                    "form_id": "TESTID",
                    "tag": "TESTAG",
                    "url": "http://test-url/webhook",
                    "enabled": true,
                    "created_at": "2016-11-21T12:23:26Z",
                    "updated_at": "2016-11-21T12:23:26Z"
                }',
            [
                'content-type' =>  'application/json; charset=UTF-8',
                'http-code' => '200',
            ],
        ];

        $client = $this->createMockClient($content, $headers);
        /** @var TypeForm $typeForm */
        $typeForm = \Yii::$app->get('typeform');
        $typeForm->setPersonalAccessToken(self::DEFAULT_ACCESS_TOKEN);
        $typeForm->setHttpClient($client);

        $hook = $typeForm->retrieveWebhook($formId, $tag);

        $this->assertInstanceOf(Webhook::class, $hook);
        $this->assertEquals($formId, $hook->formId);
        $this->assertEquals($tag, $hook->tag);
        $this->assertEquals($url, $hook->url);
    }

    /**
     * @expectedException \tonyaxo\yii2typeform\ApiException
     * @expectedExceptionMessage Description of error
     * @expectedExceptionCode 404
     *
     * @throws \tonyaxo\yii2typeform\ApiException
     * @throws \yii\base\InvalidConfigException
     */
    public function testCantRetrieveWebhook()
    {
        [$formId, $tag, $content, $headers] = [
            'TESTID',
            'TESTAG',
            // language=JSON
            '{"code":"SOME_INTERNAL_CODE","description":"Description of error"}',
            [
                'content-type' =>  'application/json; charset=UTF-8',
                'http-code' => '404',
            ],
        ];
        $client = $this->createMockClient($content, $headers);
        /** @var TypeForm $typeForm */
        $typeForm = \Yii::$app->get('typeform');
        $typeForm->setPersonalAccessToken(self::DEFAULT_ACCESS_TOKEN);
        $typeForm->setHttpClient($client);

        $typeForm->retrieveWebhook($formId, $tag);
    }

    /**
     * @throws \tonyaxo\yii2typeform\ApiException
     * @throws \yii\base\InvalidConfigException
     */
    public function testCanDeleteWhebhook()
    {
        [$formId, $tag, $content, $headers] = [
            'TESTID',
            'TESTAG',
            null,
            [
                'content-type' =>  'application/json; charset=UTF-8',
                'http-code' => '204',
            ],
        ];

        $client = $this->createMockClient($content, $headers);
        /** @var TypeForm $typeForm */
        $typeForm = \Yii::$app->get('typeform');
        $typeForm->setPersonalAccessToken(self::DEFAULT_ACCESS_TOKEN);
        $typeForm->setHttpClient($client);

        $typeForm->deleteWebhook($formId, $tag);
    }

    /**
     * @expectedException \tonyaxo\yii2typeform\ApiException
     * @expectedExceptionMessage Description of error
     * @expectedExceptionCode 404
     *
     * @throws \tonyaxo\yii2typeform\ApiException
     * @throws \yii\base\InvalidConfigException
     */
    public function testCantDeleteWebhook()
    {
        [$formId, $tag, $content, $headers] = [
            'TESTID',
            'TESTAG',
            '{"code":"SOME_INTERNAL_CODE","description":"Description of error"}',
            [
                'content-type' =>  'application/json; charset=UTF-8',
                'http-code' => '404',
            ],
        ];
        $client = $this->createMockClient($content, $headers);
        /** @var TypeForm $typeForm */
        $typeForm = \Yii::$app->get('typeform');
        $typeForm->setPersonalAccessToken(self::DEFAULT_ACCESS_TOKEN);
        $typeForm->setHttpClient($client);

        $typeForm->deleteWebhook($formId, $tag);
    }

    /**
     * Creates Client that returns Response corresponding with `$responseContent` and `$responseHeaders`.
     * @param string $responseContent
     * @param array $responseHeaders
     * @return MockObject
     */
    protected function createMockClient(?string $responseContent, array $responseHeaders): MockObject
    {
        //    TypeForm::createWebhook()
        // -> TypeForm::api()
        // -> TypeForm::createApiRequest()
        // -> TypeForm::createRequest()
        // -> TypeForm::getHttpClient()
        // -> yii\httpclient\Client::createRequest()
        // -> TypeForm::sendRequest()
        // -> Request::send()
        // -> yii\httpclient\Client::send()
        // -> yii\httpclient\Transport::send()
        // -> yii\httpclient\Cleint::createResponse($responseContent, $responseHeaders = [])

        $client = $this->getMockBuilder(\yii\httpclient\Client::class)
            ->setMethods(['createResponse'])
            ->getMock();

        $client->expects($this->once())
            ->method('createResponse')
            ->willReturnCallback(function($originContent, $originHeaders) use ($responseContent, $responseHeaders, $client) {
                $config['class'] = Response::className();
                $config['client'] = $client;
                /** @var Response $response */
                $response = \Yii::createObject($config);
                $response->setContent($responseContent);
                $response->setHeaders($responseHeaders);
                return $response;
            });

        return $client;
    }
}
