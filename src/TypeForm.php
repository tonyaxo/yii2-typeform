<?php

namespace tonyaxo\yii2typeform;

use tonyaxo\yii2typeform\api\forms\BaseForm;
use yii\caching\CacheInterface;

/**
 * @property string $personalAccessToken Read-only
 */
class TypeForm extends AuthClient implements CreateApiInterface
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
    public function init()
    {
        parent::init();
        $this->cache = \Yii::$app->get($this->cacheComponnt);
    }

    public function createForm(BaseForm $form): string
    {
        // TODO: Implement createForm() method.
    }

    /**
     * @param string $formId
     * @return BaseForm
     */
    public function retrieveForm(string $formId): BaseForm
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
     * @param string $search Returns items that contain the specified string.
     * @param int $page The page of results to retrieve. Default `1` is the first page of results.
     * @param int $pageSize Number of results to retrieve per page. Default is `10`. Maximum is `200`.
     * @param string $workspace Retrieve typeforms for the specified workspace.
     * @return array
     *
     * TODO autocomplete
     */
    public function forms(?string $search = null, ?int $page = null, ?int $pageSize = null, ?string $workspace = null)
    : array
    {
        $query = ['search' => $search, 'page' => $page, 'page_size' => $pageSize, 'workspace_id' => $workspace];

        // caching
        $key = array_merge([__METHOD__], array_values($query));
        $data = $this->cache->get($key);
        if ($data !== false) {
            return $data;
        }

        $data = $this->api("forms", 'GET', $query);
        if (array_key_exists('items', $data)) {
            $this->cache->set($key, $data['items'], $this->cacheExpire);
            return $data['items'];
        }
        return [];
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
