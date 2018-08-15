<?php

namespace tonyaxo\yii2typeform;

use tonyaxo\yii2typeform\api\forms\BaseForm;
use tonyaxo\yii2typeform\api\webhooks\Webhook;
use yii\caching\CacheInterface;
use yii\httpclient\Response;

/**
 * Class TypeForm
 *
 * @property string $personalAccessToken Read-only
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 */
class TypeForm extends AuthClient implements Creatable, Hookable
{
    const DEFAULT_CACHE_TIME = 300;

    /**
     * @var int Seconds to cache results.
     */
    public $cacheExpire = self::DEFAULT_CACHE_TIME;
    /**
     * @var string Cache component name;
     */
    public $cacheComponnt = 'cache';

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init(): void
    {
        parent::init();
        // TODO default dummy cache
        $this->cache = \Yii::$app->get($this->cacheComponnt);
    }

    /**
     * @inheritdoc
     */
    public function createForm(BaseForm $form): string
    {
        /** @var $response Response */
        $this->api("/forms", 'POST', $form->toArray(), [], $response);
        $location = $response->getHeaders()->get('Location');
        return basename($location);
    }

    /**
     * @inheritdoc
     */
    public function updateForm(BaseForm $form): void
    {
        $this->api("/forms/{$form->id}", 'PUT', $form->toArray());
    }

    /**
     * @inheritdoc
     */
    public function retrieveForm(string $formId): ?BaseForm
    {
        // caching
        $key = [__METHOD__, $formId];
        $form = $this->cache->get($key);
        if ($form !== false) {
            return $form;
        }

        $data = $this->api("forms/{$formId}", 'GET');
        $form = new BaseForm($data);
        $form->setScenario(BaseForm::SCENARIO_RETRIEVE);

        $this->cache->set($key, $form, $this->cacheExpire);
        return $form;
    }

    /**
     * @inheritdoc
     * TODO autocomplete
     */
    public function retrieveForms(?string $search = null, ?int $page = null, ?int $pageSize = null, ?string $workspace = null)
    : array
    {
        $query = ['search' => $search, 'page' => $page, 'page_size' => $pageSize, 'workspace_id' => $workspace];

        // caching
        $key = array_merge([__METHOD__], array_values($query));
        $data = $this->cache->get($key);
        if ($data !== false) {
            return $data;
        }

        $data = $this->api('forms', 'GET', $query);
        if (array_key_exists('items', $data)) {
            $this->cache->set($key, $data['items'], $this->cacheExpire);
            return $data['items'];
        }
        return [];
    }

    /**
     * @inheritdoc
     */
    public function deleteForm(string $formId): void
    {
        $this->api("forms/{$formId}", 'DELETE');
    }

    /**
     * @inheritdoc
     */
    public function createWebhook(string $formId, string $tag, string $url, bool $enabled = true): Webhook
    {
        $data = $this->api("forms/{$formId}/webhooks/{$tag}", 'PUT', [
            'url' => $url,
            'enabled' => $enabled,
        ]);
        return new Webhook($data);
    }

    /**
     * @inheritdoc
     */
    public function retrieveWebhook(string $formId, string $tag): ?Webhook
    {
        $data = $this->api("forms/{$formId}/webhooks/{$tag}", 'GET');
        return new Webhook($data);
    }

    /**
     * @inheritdoc
     */
    public function deleteWebhook(string $formId, string $tag): void
    {
        $this->api("forms/{$formId}/webhooks/{$tag}", 'DELETE');
    }

    /**
     * Personal access token for Typeform's APIs. Read-only.
     * @param string $personalAccessToken
     * @see https://developer.typeform.com/get-started/personal-access-token/
     */
    public function setPersonalAccessToken(string $personalAccessToken): void
    {
        $token = $this->createToken(['params' => [
            'access_token' => $personalAccessToken
        ]]);
        $this->setAccessToken($token);
    }
}
