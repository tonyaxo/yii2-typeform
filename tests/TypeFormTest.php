<?php

namespace yiiunit\extensions\yii2typeform;

use PHPUnit\Framework\MockObject\MockObject;
use tonyaxo\yii2typeform\api\webhooks\Webhook;
use tonyaxo\yii2typeform\TypeForm;
use yii\httpclient\Request;
use yiiunit\extensions\yii2typeform\data\Service;

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
        $client = $this->createMockClient();
        /** @var TypeForm $typeForm */
        $typeForm = \Yii::$app->get('typeform');
        $typeForm->setPersonalAccessToken(self::DEFAULT_ACCESS_TOKEN);
        $typeForm->setHttpClient($client);

        $hook = $typeForm->createWebhook('NEW_TESTID', 'NEW_TESTAG', 'http://test-url/webhook', true);

        $this->assertInstanceOf(Webhook::class, $hook);
        $this->assertEquals('NEW_TESTID', $hook->formId);
        $this->assertEquals('NEW_TESTAG', $hook->tag);
        $this->assertEquals('http://test-url/webhook', $hook->url);
    }

    /**
     * @expectedException \tonyaxo\yii2typeform\ApiException
     * @expectedExceptionMessage Failed to verify authentication
     * @expectedExceptionCode 403
     *
     * @throws \tonyaxo\yii2typeform\ApiException
     * @throws \yii\base\InvalidConfigException
     */
    public function testCantCreateWebhook()
    {
        $client = $this->createMockClient();
        /** @var TypeForm $typeForm */
        $typeForm = \Yii::$app->get('typeform');
        $typeForm->setPersonalAccessToken(self::DEFAULT_ACCESS_TOKEN);
        $typeForm->setHttpClient($client);

        $typeForm->createWebhook('NEW_TESTID', 'NEW_TESTAG', 'invalid_url', true);
    }

    /**
     * @throws \tonyaxo\yii2typeform\ApiException
     * @throws \yii\base\InvalidConfigException
     */
    public function testCanRetrieveWhebhook()
    {
        $client = $this->createMockClient();
        /** @var TypeForm $typeForm */
        $typeForm = \Yii::$app->get('typeform');
        $typeForm->setPersonalAccessToken(self::DEFAULT_ACCESS_TOKEN);
        $typeForm->setHttpClient($client);

        $hook = $typeForm->retrieveWebhook('TESTID0', 'TESTAG0');

        $this->assertInstanceOf(Webhook::class, $hook);
        $this->assertEquals('TESTID0', $hook->formId);
        $this->assertEquals('TESTAG0', $hook->tag);
        $this->assertEquals('http://test-url/webhook0', $hook->url);
    }

    /**
     * @expectedException \tonyaxo\yii2typeform\ApiException
     * @expectedExceptionMessage Endpoint not found
     * @expectedExceptionCode 404
     *
     * @throws \tonyaxo\yii2typeform\ApiException
     * @throws \yii\base\InvalidConfigException
     */
    public function testCantRetrieveWebhook()
    {
        $client = $this->createMockClient();
        /** @var TypeForm $typeForm */
        $typeForm = \Yii::$app->get('typeform');
        $typeForm->setPersonalAccessToken(self::DEFAULT_ACCESS_TOKEN);
        $typeForm->setHttpClient($client);

        $typeForm->retrieveWebhook('NOT_EXISTS_ID', 'NOT_EXISTS_TAG');
    }

    /**
     * @throws \tonyaxo\yii2typeform\ApiException
     * @throws \yii\base\InvalidConfigException
     */
    public function testCanDeleteWhebhook()
    {
        $client = $this->createMockClient();
        /** @var TypeForm $typeForm */
        $typeForm = \Yii::$app->get('typeform');
        $typeForm->setPersonalAccessToken(self::DEFAULT_ACCESS_TOKEN);
        $typeForm->setHttpClient($client);

        $typeForm->deleteWebhook('TESTID1', 'TESTAG1');
    }

    /**
     * @expectedException \tonyaxo\yii2typeform\ApiException
     * @expectedExceptionMessage Endpoint not found
     * @expectedExceptionCode 404
     *
     * @throws \tonyaxo\yii2typeform\ApiException
     * @throws \yii\base\InvalidConfigException
     */
    public function testCantDeleteWebhook()
    {
        $client = $this->createMockClient();
        /** @var TypeForm $typeForm */
        $typeForm = \Yii::$app->get('typeform');
        $typeForm->setPersonalAccessToken(self::DEFAULT_ACCESS_TOKEN);
        $typeForm->setHttpClient($client);

        $typeForm->deleteWebhook('NOT_EXISTS_ID', 'NOT_EXISTS_TAG');
    }

    /**
     * Creates \yii\httpclient\Client that makes fake requests.
     * @return MockObject
     */
    protected function createMockClient(): MockObject
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
            ->setMethods(['send'])
            ->getMock();

        $client->expects($this->once())
            ->method('send')
            ->willReturnCallback(function(Request $request) use ($client) {
                $server = new Service();
                // necessary to execute applyAccessTokenToRequest
                $request->beforeSend();
                $response = $server->response($request);
                $response->client = $client;

                return $response;
            });

        return $client;
    }
}
