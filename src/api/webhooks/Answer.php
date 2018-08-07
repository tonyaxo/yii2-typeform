<?php


namespace tonyaxo\yii2typeform\api\webhooks;


use tonyaxo\yii2typeform\api\TypeTrait;
use yii\base\Model;
use yii\base\UnknownPropertyException;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

/**
 * Class Answer
 * @property string $text read-only
 *
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 */
class Answer extends Model
{
    use TypeTrait;

    /**
     * For `short_text` and `long_text`;
     */
    const TYPE_TEXT = 'text';
    /**
     * For `dropdown`, `multiple_choice`, and `picture_choice`;
     */
    const TYPE_CHOICE = 'choice';
    /**
     * For `dropdown`, `multiple_choice`, and `picture_choice` when the "multiple selections" option is activated;
     */
    const TYPE_CHOICES = 'choices';
    /**
     * For `date`;
     */
    const TYPE_DATE = 'date';
    /**
     * For `legal` and `yes_no`;
     */
    const TYPE_BOOLEAN = 'boolean';
    /**
     * For `rating`, `opinion_scale`, and `number`;
     */
    const TYPE_NUMBER = 'number';
    /**
     * For `file_upload`;
     */
    const TYPE_FILE_URL = 'file_url';
    /**
     * For `payment`.
     */
    const TYPE_PAYMENT = 'payment';

    /**
     * @var string Unique ID for the field. You can use the field id to match questions with answers.
     */
    public $id;
    /**
     * @var string Type of the answer:
     * _text_ for `short_text` and `long_text`;
     * _choice_ for `dropdown`, `multiple_choice`, and `picture_choice`;
     * _choices_ for `dropdown`, `multiple_choice`, and `picture_choice` when the "multiple selections" option is activated;
     * _date_ for `date`;
     * _boolean_ for `legal` and `yes_no`;
     * _number_ for `rating`, `opinion_scale`, and `number`;
     * _file_url_ for `file_upload`;
     * _payment_ for `payment`.
     */
    public $type;

    /**
     * @var string
     */
    protected $text;

    public function setField(array $field): void
    {
        $this->id = $field['id'] ?? null;
    }

    /**
     * @inheritdoc
     */
    public function __set($name, $value)
    {
        try {
            parent::__set($name, $value);
        } catch (UnknownPropertyException $e) {
            if (array_key_exists($name, static::getTypes())) {

                $converter = Inflector::variablize($name) . '2Text';
                if (method_exists($this, $converter)) {
                    $this->text = $this->$converter($value);

                    return;
                }
                throw $e;
            }
            throw $e;
        }
    }
    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return string
     */
    public function text2Text(string $text): string
    {
        return $text;
    }

    /**
     * @param string $email
     * @return string
     */
    public function email2Text(string $email): string
    {
        return $email;
    }

    /**
     * @param array $choice
     * @return string
     */
    public function choice2Text(array $choice): string
    {
        return ArrayHelper::getValue($choice, 'label' , '');
    }

    /**
     * @param array $choices
     * @return string
     */
    public function choices2Text(array $choices): string
    {
        return implode(',', ArrayHelper::getValue($choices, 'labels' , []));
    }

    /**
     * @param string $date
     * @return string
     */
    public function date2Text(string $date): string
    {
        return $date;
    }

    /**
     * @param bool $boolean
     * @return string
     */
    public function boolean2Text(bool $boolean): string
    {
        return $boolean ? 'Yes' : 'No';
    }

    /**
     * @param int $number
     * @return string
     */
    public function number2Text(int $number): string
    {
        return $number;
    }

    /**
     * @param string $url
     * @return string
     */
    public function url2Text(string $url): string
    {
        return $url;
    }

    /**
     * @param array $payment
     * @return string
     */
    public function payment2Text(array $payment): string
    {
        $result = [];
        if (isset($payment['success'])) {
            $result[] = ($payment['success'] ? 'successful' : 'unsuccessful') . ' payment' ;
        }
        foreach (['from' => 'name', 'card' => 'last4', 'total' => 'amount'] as $title => $key) {
            if (isset($payment[$key])) {
                $result[] = $title . ' ' . $payment[$key];
            }
        }
        return ucfirst(implode(', ', $result));
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->text;
    }
}
