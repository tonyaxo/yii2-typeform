<?php


namespace yiiunit\extensions\yii2typeform\data;

use yii\httpclient\Request;
use yii\httpclient\Response;

/**
 * Class Server
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 */
class Service
{
    const DEFAULT_RESPONSE_HEADERS = [
        'content-type' =>  'application/json; charset=UTF-8',
        'http-code' => '200',
    ];

    /**
     * Process request for api.
     * @param Request $request
     * @return Response
     * @throws \yii\base\InvalidConfigException
     */
    public function response(Request $request): Response
    {
        if ($this->checkAuthorization($request) === false) {
            return $this->unauthorized();
        }

        return $this->process($request);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function checkAuthorization(Request &$request): bool
    {
        $auth = $request->getHeaders()->get('Authorization');
        if (empty($auth)) {
            return false;
        }
        $auth = strtolower($auth);
        [$bearer, $key] = explode(' ', $auth, 2);
        if ($bearer !== 'bearer' || empty($key)) {
            return false;
        }
        return true;
    }

    /**
     * @return Response
     * @throws \yii\base\InvalidConfigException
     */
    protected function unauthorized(): Response
    {
        return $this->createResponse(
            '{"code":"unauthorized","description":"Failed to verify authentication"}',
            ['http-code' => '403']
        );
    }

    /**
     * @return Response
     * @throws \yii\base\InvalidConfigException
     */
    protected function notFound(): Response
    {
        return $this->createResponse(
            '{"code":"NOT_FOUND","description":"Endpoint not found"}',
            ['http-code' => '404']
        );
    }

    /**
     * @param null|string $content
     * @param array $headers
     * @return Response
     * @throws \yii\base\InvalidConfigException
     */
    protected function createResponse(?string $content = null, array $headers = []): Response
    {
        $config['class'] = Response::class;
        /** @var Response $response */
        $response = \Yii::createObject($config);
        if ($content !== null) {
            $response->setContent($content);
        }
        $headers = array_merge(self::DEFAULT_RESPONSE_HEADERS, $headers);
        $response->setHeaders($headers);

        return $response;
    }

    /**
     * Process request.
     * @param Request $request
     * @return Response
     * @throws \yii\base\InvalidConfigException
     */
    protected function process(Request &$request): Response
    {
        $requestString  = $request->getMethod() . ' ' . $request->getUrl();
        foreach ($this->rules() as $pattern => $callback) {
            if (preg_match($pattern, $requestString, $matches)) {
                $params = array_merge([$request], $this->prepareParams($matches));
                return call_user_func_array($callback, $params);
            }
        }
        return $this->notFound();
    }

    /**
     * Removes all elements indexed by int keys.
     * @param array $matches
     * @return array
     */
    protected function prepareParams(array $matches): array
    {
        $result = [];
        foreach ($matches as $key => $value) {
            if (!is_int($key)) {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    /**
     * @return array
     */
    protected function rules(): array
    {
        return [
            '%PUT forms/(?<formId>\w+)/webhooks/(?<tag>\w+)%i' => [$this, 'createWebhookAction'],
            '%GET forms/(?<formId>\w+)/webhooks/(?<tag>\w+)%i' => [$this, 'retrieveWebhookAction'],
            '%DELETE forms/(?<formId>\w+)/webhooks/(?<tag>\w+)%i' => [$this, 'deleteWebhookAction'],
        ];
    }

    /**
     * @param Request $request
     * @param string $formId
     * @param string $tag
     * @return Response
     * @throws \yii\base\InvalidConfigException
     */
    public function createWebhookAction(Request $request, string $formId, string $tag)
    {
        $data = $request->getData();

        $url = $data['url'] ?? null;
        $enabled = array_key_exists('enabled', $data)
            ? $data['enabled'] ? 'true' : 'false'
            : null;
        if ($url === null || !filter_var($url, \FILTER_VALIDATE_URL) || $enabled === null) {
            return $this->unauthorized();
        }
        $content =  // language=JSON
        '{
            "id": "yRtagDm8AT0",
            "form_id": "' . $formId. '",
            "tag": "' . $tag. '",
            "url": "' . $url. '",
            "enabled": ' . $enabled. ',
            "created_at": "2016-11-21T12:23:26Z",
            "updated_at": "2016-11-21T12:23:26Z"
        }';
        return $this->createResponse($content);
    }

    /**
     * @param Request $request
     * @param string $formId
     * @param string $tag
     * @return Response
     * @throws \yii\base\InvalidConfigException
     */
    public function retrieveWebhookAction(Request $request, string $formId, string $tag)
    {
        $data = $this->getWebhooksData();
        $index = $formId.$tag;
        if (array_key_exists($index, $data)) {
            return $this->createResponse($data[$index]);
        }
        return $this->notFound();
    }

    /**
     * @param Request $request
     * @param string $formId
     * @param string $tag
     * @return Response
     * @throws \yii\base\InvalidConfigException
     */
    public function deleteWebhookAction(Request $request, string $formId, string $tag)
    {
        $data = $this->getWebhooksData();
        $index = $formId.$tag;
        if (array_key_exists($index, $data)) {
            return $this->createResponse(null, array_merge(self::DEFAULT_RESPONSE_HEADERS, [
                'http-code' => '204',
            ]));
        }
        return $this->notFound();
    }

    /**
     * @return array
     */
    protected function getWebhooksData(): array
    {
        return require(__DIR__ . '/webhooks.php');
    }
}
