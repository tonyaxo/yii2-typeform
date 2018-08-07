<?php


namespace tonyaxo\yii2typeform\api\forms;

/**
 * Thankyou screen properties.
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 *
 * @property string $buttonMode
 * @property string $redirectUrl
 * @property bool $shareIcons
 */
class ThankyouProperties extends BaseProperties
{
    const BUTTON_MODE_RELOAD = 'reload';
    const BUTTON_MODE_REDIRECT = 'redirect';

    /**
     * @var string
     */
    private $_buttonMode;
    /**
     * @var string
     */
    private $_redirectUrl;
    /**
     * @var bool
     */
    private $_shareIcons;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['buttonMode', 'button_mode'], 'in', 'range' => [self::BUTTON_MODE_RELOAD, self::BUTTON_MODE_REDIRECT]],
            [['redirectUrl', 'redirect_url'], 'url'],
            [['shareIcons', 'share_icons'], 'boolean'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'show_button' => 'showButton',
            'button_text' => 'button_text',
            'button_mode' => 'buttonMode',
            'redirect_url' => 'redirectUrl',
            'share_icons' => 'shareIcons',
        ];
    }

    /**
     * @inheritdoc
     */
    public function isEmpty(): bool
    {
        return parent::isEmpty()
            && $this->buttonMode === null && $this->redirectUrl === null && $this->shareIcons === null;
    }

    /**
     * Valid values: ThankyouProperties::BUTTON_MODE_RELOAD, ThankyouProperties::BUTTON_MODE_REDIRECT.
     * Specify whether the form should reload or redirect to another URL when respondents click the 'Submit' button.
     * PRO+ feature.
     * @return string
     */
    public function getButtonMode(): ?string
    {
        return $this->_buttonMode;
    }

    /**
     * @param string $buttonMode
     * @see getButtonMode()
     */
    public function setButtonMode(string $buttonMode): void
    {
        $this->_buttonMode = $buttonMode;
    }

    /**
     * URL where the typeform should redirect after submission,
     * if you specified ThankyouProperties::BUTTON_MODE_REDIRECT for button_mode.
     * @return string
     */
    public function getRedirectUrl(): ?string
    {
        return $this->_redirectUrl;
    }

    /**
     * @param string $redirectUrl
     * @see getRedirectUrl()
     */
    public function setRedirectUrl(string $redirectUrl): void
    {
        $this->_redirectUrl = $redirectUrl;
    }

    /**
     * True to display social media sharing icons on the thank you screen
     * so respondents can post your typeform's link on Facebook, Twitter, LinkedIn, and Google+. Otherwise, false.
     * @return bool
     */
    public function getShareIcons(): ?bool
    {
        return $this->_shareIcons;
    }

    /**
     * @param bool $shareIcons
     * @see getShareIcons()
     */
    public function setShareIcons(bool $shareIcons): void
    {
        $this->_shareIcons = $shareIcons;
    }
}
