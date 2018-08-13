<?php

namespace tonyaxo\yii2typeform;

use tonyaxo\yii2typeform\api\webhooks\Webhook;

/**
 * Interface Hookable
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 */
interface Hookable
{
    /**
     * Create webhook for form.
     *
     * @param string $formId Unique ID for the form. Find in your form URL.
     * @param string $tag Unique name you want to use for the webhook.
     * @param string $url Webhook URL.
     * @param bool $enabled True if you want to send responses to the webhook immediately. Otherwise, false.
     * @return bool
     * @throws ApiException
     */
    public function createWebhook(string $formId, string $tag, string $url, bool $enabled = true): ?Webhook;

    /**
     * Retrieve webhook.
     *
     * @param string $formId Unique ID for the form. Find in your form URL.
     * @param string $tag Unique name you want to use for the webhook.
     * @return null|Webhook
     * @throws ApiException
     */
    public function retrieveWebhook(string $formId, string $tag): ?Webhook;

    /**
     * @param string $formId Unique ID for the form. Find in your form URL.
     * @param string $tag Unique name you want to use for the webhook.
     * @throws ApiException
     */
    public function deleteWebhook(string $formId, string $tag): void;
}
