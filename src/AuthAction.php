<?php


namespace tonyaxo\yii2typeform;

use yii\authclient\AuthAction as BaseAction;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Class AuthAction
 * @property null|AuthClient $client
 *
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 */
class AuthAction extends BaseAction
{
    /**
     * @deprecated
     */
    public $clientCollection;
    /**
     * @deprecated
     */
    public $clientIdGetParamName;

    /**
     * @var string|array
     */
    private $_client = 'typeform';

    public function run()
    {
        if (!empty($this->getClient())) {
            return $this->auth($this->getClient());
        }
        throw new NotFoundHttpException();
    }

    public function setClient($client): void
    {
        $this->_client = $client;
    }

    public function getClient(): ?AuthClient
    {
        if (!($this->_client instanceof AuthClient)) {
            $this->_client = Yii::$app->get($this->_client);
            if ($this->_client === null) {
                $this->_client = Yii::createObject($this->_client);
            }
        }

        return $this->_client;
    }
}