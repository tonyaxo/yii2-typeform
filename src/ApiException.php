<?php

namespace tonyaxo\yii2typeform;

use yii\authclient\InvalidResponseException;
use yii\httpclient\Client;
use yii\httpclient\Response;

/**
 * Class ApiException
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 */
class ApiException extends InvalidResponseException
{
    private $_externalCode;

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'TypForm API Exception';
    }

    /**
     * {@inheritdoc}
     *
     * Auto fill $code and $message from response.
     */
    public function __construct(Response $response, ?string $message = null, ?string $code = null, ?\Exception $previous = null)
    {
        /** @var $response \yii\httpclient\Response */
        if ($response->getFormat() === Client::FORMAT_JSON) {
            $data = $response->getData();
            if (isset($data['code'])) {
                $this->_externalCode = $data['code'];
            }
            if (isset($data['description'])) {
                $message = $data['description'];
            }
            $code = $response->getStatusCode();
        }
        parent::__construct($response, $message, $code, $previous);
    }

    /**
     * Returns TypeForm exception code.
     * @return null|string
     */
    public function getExternalCode(): ?string
    {
        return $this->_externalCode;
    }
}
