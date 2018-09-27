<?php

namespace tonyaxo\yii2typeform;

use yii\authclient\InvalidResponseException;
use yii\authclient\OAuth2;
use yii\authclient\OAuthToken;
use yii\httpclient\Client;
use yii\httpclient\Response;

/**
 * Class AuthClient
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 */
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

    /**
     * @var array
     */
    private $_scopes;

    public function init(): void
    {
        parent::init();
        $this->initScope();
        $this->initHttpClient();
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
                    $this->_scopes[$value] = $value;
                }
            }
            if ($this->_scopes === null) {
                $this->_scopes = [];
            }
        }
        return $this->_scopes;
    }

    /**
     * @param array $scopes
     */
    public function setScopes(array $scopes): void
    {
        $this->_scopes = $scopes;
    }

    /**
     * @inheritdoc
     * @return Response
     * @throws InvalidResponseException
     * @throws \yii\httpclient\Exception
     */
    protected function sendRequest($request): Response
    {
        $response = $request->send();

        if (!$response->getIsOk()) {
            throw new InvalidResponseException($response, 'Request failed with code: ' . $response->getStatusCode() . ', message: ' . $response->getContent());
        }

        return $response;
    }

    /**
     * @inheritdoc
     *
     * @param null|Response $response
     * @throws ApiException
     */
    public function api($apiSubUrl, $method = 'GET', $data = [], $headers = [], ?Response &$response = null)
    {
        try {
            /** @var Response $response */
            $response = parent::api($apiSubUrl, $method, $data, $headers);
            return $response->getData();
        } catch (InvalidResponseException $e){
            throw new ApiException($e->response, $e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function defaultName(): string
    {
        return 'typeform';
    }

    /**
     * {@inheritdoc}
     */
    protected function defaultTitle(): string
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
            $this->scope = implode(' ', $scopes);
        }
    }

    /**
     * Init httpclient config.
     */
    protected function initHttpClient(): void
    {
        $client = $this->getHttpClient();
        $client->formatters[Client::FORMAT_URLENCODED] = [
            'class' => UrlEncodedFormatter::class,
            'encodingType' => PHP_QUERY_RFC1738,
        ];
        $client->requestConfig = ['format' => Client::FORMAT_JSON];
        $client->responseConfig = ['format' => Client::FORMAT_JSON];
        $this->setHttpClient($client);
    }
}
