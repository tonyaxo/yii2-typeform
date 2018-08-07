<?php

namespace tonyaxo\yii2typeform\api\webhooks;

use tonyaxo\yii2typeform\api\UnderscoresMagicMethodTrait;
use yii\base\Model;

/**
 * Class Whebhook
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 */
class Webhook extends Model
{
    use UnderscoresMagicMethodTrait;

    /**
     * @var string Unique ID for the webhook.
     */
    public $id;
    /**
     * @var string Unique name you want to use for the webhook.
     */
    public $tag;
    /**
     * @var string Webhook URL.
     */
    public $url;
    /**
     * @var bool True if you want to send responses to the webhook immediately. Otherwise, false.
     */
    public $enabled;

    /**
     * @var string
     */
    private $_formId;
    /**
     * @var string Date and time when webhook was created. In ISO 8601 format, UTC time, to the second,
     * with T as a delimiter between the date and time.
     */
    private $_createdAt;
    /**
     * @var string Date of last update to webhook. In ISO 8601 format, UTC time, to the second,
     * with T as a delimiter between the date and time.
     */
    private $_updatedA;

    /**
     * @return string
     */
    public function getFormId(): string
    {
        return $this->_formId;
    }

    /**
     * @param string $formId
     */
    public function setFormId(string $formId): void
    {
        $this->_formId = $formId;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->_createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->_createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedA(): string
    {
        return $this->_updatedA;
    }

    /**
     * @param string $updatedA
     */
    public function setUpdatedA(string $updatedA): void
    {
        $this->_updatedA = $updatedA;
    }
}
