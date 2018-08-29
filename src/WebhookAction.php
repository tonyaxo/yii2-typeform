<?php


namespace tonyaxo\yii2typeform;

use tonyaxo\yii2typeform\api\webhooks\WebhookEvent;
use yii\base\Action;

/**
 * Class WebhookAction
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 */
class WebhookAction extends Action
{
    /**
     * @var WebhookEvent Result event model.
     */
    protected $webhookEvent;

    /**
     * Handle webhook event.
     * @return \yii\console\Response|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $this->webhookEvent = WebhookEvent::handle(\Yii::$app->request);

        $response = \Yii::$app->response;
        $response->statusCode = 204;
        return $response;
    }
}
