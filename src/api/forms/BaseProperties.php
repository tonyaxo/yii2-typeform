<?php


namespace tonyaxo\yii2typeform\api\forms;

use tonyaxo\yii2typeform\api\BaseModel;
use tonyaxo\yii2typeform\api\UnderscoresMagicMethodTrait;

/**
 * Base screen properties.
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 *
 * @property bool $showButton
 * @property string $buttonText
 */
abstract class BaseProperties extends BaseModel
{
    use UnderscoresMagicMethodTrait;

    /**
     * @var bool
     */
    private $_showButton;
    /**
     * @var string
     */
    private $_buttonText;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['show_button', 'showButton'], 'boolean'],
            [['button_text', 'buttonText'], 'string'],
        ];
    }

    /**
     * @return bool
     */
    public function getShowButton(): ?bool
    {
        return $this->_showButton;
    }

    /**
     * True to display button.
     * @param bool $showButton
     */
    public function setShowButton(bool $showButton): void
    {
        $this->_showButton = $showButton;
    }

    /**
     * @return string
     */
    public function getButtonText(): ?string
    {
        return $this->_buttonText;
    }

    /**
     * @param string $buttonText
     */
    public function setButtonText(string $buttonText): void
    {
        $this->_buttonText = $buttonText;
    }

    /**
     * @inheritdoc
     */
    public function isEmpty(): bool
    {
        return parent::isEmpty() || ($this->showButton === null && $this->buttonText === null);
    }
}
