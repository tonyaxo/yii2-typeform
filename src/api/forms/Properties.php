<?php


namespace tonyaxo\yii2typeform\api\forms;


use tonyaxo\yii2typeform\api\BaseModel;

/**
 * Class Properties represents Field properties.
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 *
 * @property array $choices;
 * @property bool $allowMultipleSelection;
 * @property bool $allowOtherChoice;
 * @property bool $verticalAlignment;
 * @property bool $showLabels;
 * @property bool $alphabeticalOrder;
 * @property bool $hideMarks;
 * @property object $labels;
 * @property bool $startAtOne;
 * @property object $price;
 */
class Properties extends BaseProperties
{
    const SHAPE_CAT = 'cat';
    const SHAPE_CIRCLE = 'circle';
    const SHAPE_CLOUD = 'cloud';
    const SHAPE_CROWN = 'crown';
    const SHAPE_DOG = 'dog';
    const SHAPE_DROPLET = 'droplet';
    const SHAPE_FLAG = 'flag';
    const SHAPE_HEART = 'heart';
    const SHAPE_LIGHTBULB = 'lightbulb';
    const SHAPE_PENCIL = 'pencil';
    const SHAPE_SKULL = 'skull';
    const SHAPE_START = 'start';
    const SHAPE_HUNDERBOLT = 'hunderbolt';
    const SHAPE_TICKT = 'tickt';
    const SHAPE_ROPHY = 'rophy';
    const SHAPE_UP = 'up';
    const SHAPE_USER = 'user';

    const STRUCTURE_MMDDYYYY = 'MMDDYYYY';
    const STRUCTURE_DDMMYYYY = 'DDMMYYYY';
    const STRUCTURE_YYYYMMDD = 'YYYYMMDD';

    const CURRENCY_AUD = 'AUD';
    const CURRENCY_BRL = 'BRL';
    const CURRENCY_CAD = 'CAD';
    const CURRENCY_CHF = 'CHF';
    const CURRENCY_DKK = 'DKK';
    const CURRENCY_EUR = 'EUR';
    const CURRENCY_GBP = 'GBP';
    const CURRENCY_MXN = 'MXN';
    const CURRENCY_NOK = 'NOK';
    const CURRENCY_SEK = 'SEK';
    const CURRENCY_USD = 'USD';

    const SEPARATOR_SLASH = '/';
    const SEPARATOR_DOT = '.';
    const SEPARATOR_DASH = '-';

    /**
     * @var string Question or instruction to display for the field.
     */
    public $description;
    /**
     * @var string Contains the fields that belong in a question group.
     * Only `payment` and `group` blocks are not allowed inside a question group.
     */
    public $fields;
    /**
     * @var bool
     * true if answer choices should be presented in a new random order for each respondent.
     * false if answer choices should be presented in the same order for each respondent.
     * Available for `multiple_choice` and `picture_choice` types.
     */
    public $randomize;
    /**
     * @var bool true if you want to use larger-sized images for answer choices.
     * Otherwise, false. Available for picture_choice types.
     */
    public $supersized;
    /**
     * @var int Number of steps in the scale's range.
     * Minimum is 5 and maximum is 11. Available for `opinion_scale` and `rating types`.
     */
    public $steps;
    /**
     * @var string Default: "star"
     * Shape to display on the scale's steps. Available for opinion_scale and rating types.
     */
    public $shape;
    /**
     * @var string Default: "DDMMYYYY"
     * Valid values:"MMDDYYYY", "DDMMYYYY", "YYYYMMDD".
     * Format for month, date, and year in answer. Available for `date` types.
     */
    public $structure;
    /**
     * @var string Default: "/"
     * Character to use between month, day, and year in answer. Available for `date` types.
     */
    public $separator;
    /**
     * @var string Default: "EUR"
     * Currency of the payment. Available for payment types.
     */
    public $currency;

    /**
     * @var array
     */
    private $_choices;
    /**
     * @var bool
     */
    private $_allowMultipleSelection;
    /**
     * @var bool
     */
    private $_allowOtherChoice;
    /**
     * @var bool
     */
    private $_verticalAlignment;
    /**
     * @var bool
     */
    private $_showLabels;
    /**
     * @var bool
     */
    private $_alphabeticalOrder;
    /**
     * @var bool
     */
    private $_hideMarks;
    /**
     * @var object
     */
    private $_labels;
    /**
     * @var bool
     */
    private $_startAtOne;
    /**
     * @var object
     */
    private $_price;

    public function rules()
    {
        return parent::rules();
    }

    public function fields()
    {
        parent::fields();
    }

    /**
     * @return array
     */
    public function getChoices(): array
    {
        return $this->_choices;
    }

    /**
     * @param array $choices
     */
    public function setChoices(array $choices): void
    {
        $this->_choices = $choices;
    }

    /**
     * @return bool
     */
    public function isAllowMultipleSelection(): ?bool
    {
        return $this->_allowMultipleSelection;
    }

    /**
     * @param bool $allowMultipleSelection
     */
    public function setAllowMultipleSelection(bool $allowMultipleSelection): void
    {
        $this->_allowMultipleSelection = $allowMultipleSelection;
    }

    /**
     * @return bool
     */
    public function isAllowOtherChoice(): ?bool
    {
        return $this->_allowOtherChoice;
    }

    /**
     * @param bool $allowOtherChoice
     */
    public function setAllowOtherChoice(bool $allowOtherChoice): void
    {
        $this->_allowOtherChoice = $allowOtherChoice;
    }

    /**
     * @return bool
     */
    public function isVerticalAlignment(): ?bool
    {
        return $this->_verticalAlignment;
    }

    /**
     * @param bool $verticalAlignment
     */
    public function setVerticalAlignment(bool $verticalAlignment): void
    {
        $this->_verticalAlignment = $verticalAlignment;
    }

    /**
     * @return bool
     */
    public function isShowLabels(): ?bool
    {
        return $this->_showLabels;
    }

    /**
     * @param bool $showLabels
     */
    public function setShowLabels(bool $showLabels): void
    {
        $this->_showLabels = $showLabels;
    }

    /**
     * @return bool
     */
    public function isAlphabeticalOrder(): ?bool
    {
        return $this->_alphabeticalOrder;
    }

    /**
     * @param bool $alphabeticalOrder
     */
    public function setAlphabeticalOrder(bool $alphabeticalOrder): void
    {
        $this->_alphabeticalOrder = $alphabeticalOrder;
    }

    /**
     * @return bool
     */
    public function isHideMarks(): ?bool
    {
        return $this->_hideMarks;
    }

    /**
     * @param bool $hideMarks
     */
    public function setHideMarks(bool $hideMarks): void
    {
        $this->_hideMarks = $hideMarks;
    }

    /**
     * @return object
     */
    public function getLabels(): object
    {
        return $this->_labels;
    }

    /**
     * @param object $labels
     */
    public function setLabels(object $labels): void
    {
        $this->_labels = $labels;
    }

    /**
     * @return bool
     */
    public function isStartAtOne(): ?bool
    {
        return $this->_startAtOne;
    }

    /**
     * @param bool $startAtOne
     */
    public function setStartAtOne(bool $startAtOne): void
    {
        $this->_startAtOne = $startAtOne;
    }

    /**
     * @return object
     */
    public function getPrice(): object
    {
        return $this->_price;
    }

    /**
     * @param object $price
     */
    public function setPrice(object $price): void
    {
        $this->_price = $price;
    }
}
