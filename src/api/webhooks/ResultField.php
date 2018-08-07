<?php

namespace tonyaxo\yii2typeform\api\webhooks;

use tonyaxo\yii2typeform\api\forms\Field;
use yii\base\Model;

/**
 * Class ResultField
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 */
class ResultField extends Model
{
    /**
     * @var string
     */
    public $id;
    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    private $_question;

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
            ['title', 'safe'],
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

    public function setAnswer(?Answer $answer): void
    {

    }
}
