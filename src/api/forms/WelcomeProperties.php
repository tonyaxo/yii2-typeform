<?php

namespace tonyaxo\yii2typeform\api\forms;

/**
 * Welcome screen properties
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 */
class WelcomeProperties extends BaseProperties
{
    /**
     * @var string Description of the welcome screen.
     */
    public $description;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['description', 'string'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'show_button' => 'showButton',
            'button_text' => 'buttonText',
            'description',
        ];
    }

    /**
     * @inheritdoc
     */
    public function isEmpty(): bool
    {
        return parent::isEmpty() && $this->description === null;
    }
}
