<?php


namespace tonyaxo\yii2typeform\api\forms;

/**
 * Class WelcomeScreen
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 *
 * @property WelcomeProperties $properties
 */
class WelcomeScreen extends BaseScreen
{
    /**
     * @param array|WelcomeProperties $properties
     */
    public function setProperties($properties): void
    {
        $this->assignSingle(__FUNCTION__, $properties, WelcomeProperties::class);
    }
}
