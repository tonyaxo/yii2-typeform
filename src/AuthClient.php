<?php

namespace tonyaxo\yii2typeform;

use yii\authclient\OAuth2;
use yii\authclient\OAuthToken;

class AuthClient extends OAuth2
{
    /**
     * @see https://developer.typeform.com/get-started/scopes/
     */
    const SCOPE_FORMS_WRITE = 'forms:write';
    const SCOPE_FORMS_READ = 'forms:read';

    const SCOPE_IMAGES_READ = 'images:read';
    const SCOPE_IMAGES_WRITE = 'images:write';

    const SCOPE_THEMES_WRITE = 'themes:write';
    const SCOPE_THEMES_READ = 'themes:read';

    const SCOPE_WEBHOOKS_READ = 'webhooks:read';
    const SCOPE_WEBHOOKS_WRITE = 'webhooks:write';

    const SCOPE_WORKSPACES_READ = 'workspaces:read';
    const SCOPE_WORKSPACES_WRITE = 'workspaces:write';

    const SCOPE_RESPONSES_READ = 'responses:read';

    public $authUrl = 'https://api.typeform.com/oauth/authorize';

    public $tokenUrl = 'https://api.typeform.com/oauth/token';

    public $apiBaseUrl = 'https://api.typeform.com';

    public $scope;

    private $_scopes;

    public function init()
    {
        parent::init();
        $this->initScope();
    }

    /**
     * @inheritdoc
     */
    public function initUserAttributes()
    {
        return $this->api('me', 'GET');
    }

    /**
     * @inheritdoc
     * @param \yii\httpclient\Request $request HTTP request instance.
     * @param OAuthToken $accessToken access token instance.
     */
    public function applyAccessTokenToRequest($request, $accessToken)
    {
        $request->getHeaders()->set('Authorization', 'Bearer '. $accessToken->getToken());
    }

    /**
     * Return all available scopes.
     * @return array
     * @throws \ReflectionException
     */
    public function getScopes(): array
    {
        if ($this->_scopes === null) {
            $consts = (new \ReflectionClass(__CLASS__))->getConstants();
            foreach ($consts as $name => $value) {
                $pos = strpos($name, 'SCOPE_');
                if ($pos === 0) {
                    $this->_scopes[$name] = $value;
                }
            }
            if ($this->_scopes === null) {
                $this->_scopes = [];
            }
        }
        return $this->_scopes;
    }

    /**
     * {@inheritdoc}
     */
    protected function defaultName()
    {
        return 'typeform';
    }

    /**
     * {@inheritdoc}
     */
    protected function defaultTitle()
    {
        return 'TypeForm';
    }

    /**
     * @throws \ReflectionException
     */
    protected function initScope(): void
    {
        if ($this->scope === null) {
            $scopes = $this->getScopes();
            $prefix = $suffix = '';
            if (count($scopes) > 0) {
                $prefix = '{';
                $suffix = '}';
            }
            $this->scope = $prefix . implode('}+{', $scopes) . $suffix;
        }
    }
}
