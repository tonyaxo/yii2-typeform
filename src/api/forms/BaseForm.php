<?php

namespace tonyaxo\yii2typeform\api\forms;

use tonyaxo\yii2typeform\api\BaseModel;
use tonyaxo\yii2typeform\api\ModelAssigmentTrait;
use tonyaxo\yii2typeform\api\UnderscoresMagicMethodTrait;
use yii\web\Linkable;

class BaseForm extends BaseModel implements Linkable
{
    use UnderscoresMagicMethodTrait;
    use ModelAssigmentTrait;

    const SCENARIO_RETRIEVE = 'Retrieve';
    const SCENARIO_CREATE = 'Create';
    const SCENARIO_UPDATE = 'Update';

    /**
     * @var string
     */
    public $id;
    /**
     * @var string
     */
    public $title;
    /**
     * @var string
     */
    public $language;
    /**
     * @var object
     */
    public $theme;
    /**
     * @var
     */
    public $variables;
    /**
     * @var object
     */
    public $workspace;

    /**
     * @var array
     */
    private $_links;
    /**
     * @var string[]
     */
    private $_hiddenFields = [];
    /**
     * @var array Field[]
     */
    private $_fields = [];

    private $_welcomeScreens = [];
    private $_thankyouScreens = [];
    private $_logic = [];
    /**
     * @var Settings
     */
    private $_settings;

    public function rules()
    {
        return parent::rules();
    }

    public function fields()
    {
        return [
            'id',
            'title',
            'language',
            'fields',
            'hidden',
            'welcome_screens' => 'welcomeScreens',
            'thankyou_screens' => 'thankyouScreens',
            'logic',
            'theme',
            'workspace',
            'settings',
        ];
    }

    /**
     * @inheritdoc
     */
    public function isEmpty(): bool
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return array_key_exists('display', $this->_links) && !empty($this->_links['display']) ? [
            'display' => $this->_links['display'],
        ] : null;
    }

    /**
     * @param array $links
     */
    public function setLinks(array $links)
    {
        $this->_links = $links;
    }

    /**
     * @param Field[] $fields
     */
    public function setFields(array $fields): void
    {
        $this->assignMultiple(__FUNCTION__, $fields, Field::class);
    }

    public function getFields(): array
    {
        return $this->_fields;
    }

    /**
     * @param string[] $hiddenFields
     */
    public function setHidden(array $hiddenFields): void
    {
        $this->_hiddenFields = $hiddenFields;
    }

    /**
     * @return array
     */
    public function getHidden(): array
    {
        return $this->_hiddenFields;
    }

    public function setWelcomeScreens(array $welcomeScreens): void
    {
        $this->assignMultiple(__FUNCTION__, $welcomeScreens, WelcomeScreen::class);
    }

    public function getWelcomeScreens(): array
    {
        return $this->_welcomeScreens;
    }

    public function setThankyouScreens(array $thankyouScreens): void
    {
        $this->assignMultiple(__FUNCTION__, $thankyouScreens, ThankyouScreen::class);
    }

    public function getThankyouScreens(): array
    {
        return $this->_thankyouScreens;
    }

    public function setLogic(array $logic): void
    {
        $this->assignMultiple(__FUNCTION__, $logic, Logic::class);
    }

    public function getLogic(): array
    {
        return $this->_logic;
    }

    public function setSettings($settings): void
    {
        $this->assignSingle(__FUNCTION__, $settings, Settings::class);
    }

    public function getSettings(): ?Settings
    {
        return $this->_settings;
    }
}
