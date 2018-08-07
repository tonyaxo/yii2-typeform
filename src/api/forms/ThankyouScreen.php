<?php


namespace tonyaxo\yii2typeform\api\forms;

/**
 * Class ThankyouScreen
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 *
 * @property ThankyouProperties $properties
 */
class ThankyouScreen extends BaseScreen
{
    /**
     * @param array|ThankyouProperties $properties
     */
    public function setProperties($properties): void
    {
        $this->assignSingle(__FUNCTION__, $properties, ThankyouProperties::class);
    }
}
