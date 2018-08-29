<?php

namespace tonyaxo\yii2typeform\widgets;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;

/**
 * @see https://developer.typeform.com/embed/
 *
 * @property array $hiddenFields
 * @property array $url
 *
 * @todo beforeHiddenFields
 */
class EmbeddedTypeForm extends Widget
{
    /**
     * Use a popup to embed the typeform in a modal window.
     * @see https://developer.typeform.com/embed/modes/#widget-mode
     */
    const TYPE_WIDGET = 'widget';
    /**
     * Use a popup to embed the typeform in a modal window.
     * @see https://developer.typeform.com/embed/modes/#popup-mode
     */
    const TYPE_POPUP = 'popup';

    /**
     * Full-screen popup.
     */
    const POPUP_MODE_DEFAULT = 'popup';
    /**
     * Popup slides in from the left.
     */
    const POPUP_MODE_DRAWER_LEFT = 'drawer_left';
    /**
     * popup slides in from the right.
     */
    const POPUP_MODE_DRAWER_RIGHT = 'drawer_right';

    private const DEFAULT_WIDTH = '500px';
    private const DEFAULT_HEIGHT = '300px';

    /**
     * @var string style property for widget width.
     * Example: 100%, 200px etc
     */
    public $width;
    /**
     * @var string style property for widget height.
     * Example: 100%, 200px etc
     */
    public $height;
    /**
     * @var string Type of embed. One of TYPE_WIDGET or TYPE_POPUP.
     */
    public $type = self::TYPE_WIDGET;
    /**
     * @var array the HTML attributes for the widget container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];
    /**
     * @var array
     * @see https://developer.typeform.com/embed/modes/
     */
    public $clientOptions = [];
    /**
     * @var array the options for rendering the toggle button tag for TYPE_POPUP.
     * The toggle button is used to toggle the visibility of the modal window.
     * If this property is false, no toggle button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to 'Show'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     */
    public $toggleButton = false;

    /**
     * @var string Url of created form.
     */
    private $_url;
    /**
     * @var array
     */
    private $_hiddenFields = [];

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();

        $this->initOptions();

        if ($this->url === null) {
            throw new InvalidConfigException('Property "url" is empty');
        }
        if ($this->width === null) {
            $this->width = self::DEFAULT_WIDTH;
        }
        if ($this->height === null) {
            $this->height = self::DEFAULT_HEIGHT;
        }
    }

    /**
     * @inheritdoc
     */
    public function run(): ?string
    {
        TypeFormAsset::register($this->getView());

        if ($this->isPopup()) {
            return $this->renderPopup();
        } else {
            return $this->renderWidget();
        }
    }

    /**
     * Renders the TYPE_POPUP content.
     * @return string|null
     */
    protected function renderPopup(): ?string
    {
        $this->getView()->registerJs($this->getPopupJs(), View::POS_END);
        return $this->renderToggleButton();
    }

    /**
     * Renders the TYPE_WIDGET content.
     * @return string|null
     */
    protected function renderWidget(): ?string
    {
        $options = $this->options;
        Html::addCssStyle($options, ['width' => $this->width, 'height' => $this->height]);
        $this->getView()->registerJs($this->getWidgetJs(), View::POS_END);
        return Html::tag('div', '', $options);
    }

    /**
     * Renders the toggle button.
     * @return string the rendering result
     */
    protected function renderToggleButton(): ?string
    {
        if (($toggleButton = $this->toggleButton) !== false) {
            $tag = ArrayHelper::remove($toggleButton, 'tag', 'button');
            $label = ArrayHelper::remove($toggleButton, 'label', 'Show');
            if ($tag === 'button' && !isset($toggleButton['type'])) {
                $toggleButton['type'] = 'button';
            }
            return Html::tag($tag, $label, $toggleButton);
        } else {
            return null;
        }
    }

    /**
     * @return bool
     */
    public function isPopup(): bool
    {
        return $this->type == self::TYPE_POPUP;
    }

    /**
     * Return widget js code.
     * @return string
     */
    protected function getWidgetJs(): string
    {
        if ($this->clientOptions !== false) {
            $options = empty($this->clientOptions) ? '{}' : Json::htmlEncode($this->clientOptions);
        }
        $widgetId = $this->getId();
        return <<<JS
            window.addEventListener("DOMContentLoaded", function() {
                var el = document.getElementById("{$widgetId}");
                window.typeformEmbed.makeWidget(el, "{$this->url}", $options);
            });
JS;
    }

    /**
     * Return popup js code.
     * @return string
     */
    protected function getPopupJs(): string
    {
        if ($this->clientOptions !== false) {
            $options = empty($this->clientOptions) ? '{}' : Json::htmlEncode($this->clientOptions);
        }

        $formJsVar = Inflector::variablize($this->options['id'] . '_typeform');
        $js = <<<JS
            var {$formJsVar};
            window.addEventListener("DOMContentLoaded", function() {
                {$formJsVar} = window.typeformEmbed.makePopup("{$this->url}", $options);
            });
JS;
        if ($this->toggleButton !== false && array_key_exists('id', $this->toggleButton)) {
            $js .= <<<JS
                document.getElementById("{$this->toggleButton['id']}").addEventListener("click", function () {
                    {$formJsVar}.open();
                });
JS;
        }
        return $js;
    }

    /**
     * Initializes the widget options.
     * This method sets the default values for various options.
     */
    protected function initOptions(): void
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        Html::addCssClass($this->options, ['widget' => 'typeform']);

        if ($this->clientOptions !== false) {
            $this->clientOptions = array_merge(['hideScrollbars' => true], $this->clientOptions);
            if (array_key_exists('onSubmit', $this->clientOptions) && !($this->clientOptions['onSubmit'] instanceof JsExpression)) {
                $this->clientOptions['onSubmit'] = new JsExpression($this->clientOptions['onSubmit']);
            }
        }
        if ($this->isPopup() && $this->toggleButton !== false) {
            $this->toggleButton = array_merge([
                'id' => $this->options['id'] . '_button',
            ], $this->toggleButton);
        }
    }

    /**
     * Return form url with hidden fields.
     * @return string
     */
    public function getUrl(): string
    {
        $hiddenFields = $this->getHiddenFields();
        if (empty($hiddenFields)) {
            return $this->_url;
        }
        $query = http_build_query($hiddenFields, 'field_', '&', PHP_QUERY_RFC3986);
        return $this->_url . '?' . $query;
    }

    /**
     * Sets form url and parse hidden fields.
     * Note: values of hidden fields from url won’t replace values sets directly.
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $query = parse_url($url, PHP_URL_QUERY);
        if ($query === null) {
            $this->_url = $url;
        } else {
            parse_str($query, $hiddenFields);
            if (is_array($hiddenFields)) {
                $this->setHiddenFields($hiddenFields, false);
            }
            $len = mb_strpos($url, '?');
            $this->_url = mb_strcut($url, 0, $len);
        }
    }

    /**
     * @return array
     * @see https://developer.typeform.com/create/hidden-fields/
     */
    public function getHiddenFields(): array
    {
        return $this->_hiddenFields;
    }

    /**
     * @param array $hiddenFields name=>value pairs.
     * @param bool $rewrite whether or not exists values.
     */
    public function setHiddenFields(array $hiddenFields, bool $rewrite = true): void
    {
        if ($rewrite) {
            $this->_hiddenFields = array_merge($this->_hiddenFields, $hiddenFields);
        } else {
            $this->_hiddenFields = array_merge($hiddenFields, $this->_hiddenFields);
        }
    }
}
