<?php

namespace tonyaxo\yii2typeform\widgets;

use tonyaxo\yii2typeform\TypeForm;
use yii\authclient\widgets\AuthChoice;
use yii\helpers\Url;

/**
 * Auth widget for TypeForm.
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 */
class Auth extends AuthChoice
{
    const DEFAULT_POPUP_WIDTH = 320;
    const DEFAULT_POPUP_HEIGHT = 500;

    /**
     * @var string Name of typeform component;
     */
    public $component = 'typeform';
    /**
     * @var string
     */
    public $linkText = 'Auth with TypeForm.com';
    /**
     * @var array
     */
    public $linkOptions = [];
    /**
     * @deprecated
     */
    public $clientCollection;
    /**
     * @deprecated
     */
    public $clientIdGetParamName;
    /**
     * @deprecated
     */
    public $clients;

    public $clientOptions = [
        'popup' => [
            'scrollbars' => 'yes',
            'width' => self::DEFAULT_POPUP_WIDTH,
            'height' => self::DEFAULT_POPUP_HEIGHT,
        ],
    ];

    /**
     * @inheritdoc
     */
    public function renderMainContent()
    {
        /** @var TypeForm $client */
        $client = \Yii::$app->get($this->component);

        return $this->clientLink($client, $this->linkText, $this->linkOptions);
    }

    /**
     * @inheritdoc
     */
    public function createClientUrl($client)
    {
        $this->autoRender = false;
        $url = $this->getBaseAuthUrl();

        return Url::to($url);
    }
}
