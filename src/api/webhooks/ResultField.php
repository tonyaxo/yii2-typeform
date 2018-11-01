<?php

namespace tonyaxo\yii2typeform\api\webhooks;

use tonyaxo\yii2typeform\api\forms\Field;
use tonyaxo\yii2typeform\api\UnderscoresMagicMethodTrait;
use yii\base\Model;

/**
 * Class ResultField
 *
 * @property string $allowMultipleSelections
 * @property string $allowOtherChoice
 * @property string $question
 * @property Answer $answer
 *
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 */
class ResultField extends Model
{
    use UnderscoresMagicMethodTrait;

    /**
     * @var string
     */
    public $id;
    /**
     * @var string
     */
    public $type;

    public $ref;
    /**
     * @var array
     * @todo test it
     */
    public $properties;

    private $_allowMultipleSelections;
    private $_allowOtherChoice;
    /**
     * @var string
     */
    private $_question;
    /**
     * @var null|Answer
     */
    private $_answer;

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'required'],
            [['id', 'question'], 'string'],
            ['type', 'in', 'range' => Field::getTypes()],
            [['title', 'answer'], 'safe'],
        ];
    }


    /**
     * Write-only
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->_question = $title;
    }

    /**
     * @return string
     */
    public function getQuestion()
    {
        return $this->_question;
    }

    /**
     * @param string $question
     */
    public function setQuestion(string $question): void
    {
        $this->_question = $question;
    }

    /**
     * @param null|Answer $answer
     */
    public function setAnswer(?Answer $answer): void
    {
        $this->_answer = $answer;
    }

    /**
     * @return null|Answer
     */
    public function getAnswer(): ?Answer
    {
        return $this->_answer;
    }

    /**
     * @return null|string
     */
    public function getAnswerText(): ?string
    {
        return $this->_answer !== null ? $this->_answer->text : null;
    }

    /**
     * @return mixed
     */
    public function getAllowMultipleSelections()
    {
        return $this->_allowMultipleSelections;
    }

    /**
     * @param mixed $allowMultipleSelections
     */
    public function setAllowMultipleSelections($allowMultipleSelections): void
    {
        $this->_allowMultipleSelections = $allowMultipleSelections;
    }

    /**
     * @return mixed
     */
    public function getAllowOtherChoice()
    {
        return $this->_allowOtherChoice;
    }

    /**
     * @param mixed $allowOtherChoice
     */
    public function setAllowOtherChoice($allowOtherChoice): void
    {
        $this->_allowOtherChoice = $allowOtherChoice;
    }
}
