<?php

namespace tonyaxo\yii2typeform\api\webhooks;

/**
 * Class FormResponseEvent
 *
 * @property array $definition
 * @property array $answers
 *
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 */
class FormResponseEvent extends WebhookEvent
{
    /**
     * @var string Unique ID for the typeform submission.
     */
    public $token;
    /**
     * @var array If your typeform includes a score calculation, the webhook response will contain this object.
     */
    public $calculated;


    /**
     * @var array
     */
    protected $results;

    /**
     * @var string
     */
    private $_formId;
    /**
     * @var string
     */
    private $_submittedAt;
    /**
     * @var string
     */
    private $_landedAt;

    /**
     * @var array
     */
    private $_definition;
    /**
     * @var array
     */
    private $_answers;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['token', 'formId', 'form_id', 'submittedAt', 'submitted_at', 'landedAt', 'landed_at'], 'string'],
            ['event_type', 'in', 'range' => [WebhookEvent::TYPE_FORM_RESPONSE]],
            ['event_id', 'string'],
            [['calculated', 'definition', 'answers'], 'safe'],
        ];
    }

    /**
     * @return string
     */
    public function getFormId(): string
    {
        return $this->_formId;
    }

    /**
     * @param string $formId
     */
    public function setFormId(string $formId): void
    {
        $this->_formId = $formId;
    }

    /**
     * @return string
     */
    public function getSubmittedAt(): string
    {
        return $this->_submittedAt;
    }

    /**
     * @param string $submittedAt
     */
    public function setSubmittedAt(string $submittedAt): void
    {
        $this->_submittedAt = $submittedAt;
    }

    /**
     * @return string
     */
    public function getLandedAt(): string
    {
        return $this->_landedAt;
    }

    /**
     * @param string $landedAt
     */
    public function setLandedAt(string $landedAt): void
    {
        $this->_landedAt = $landedAt;
    }

    /**
     * @return mixed
     */
    public function getDefinition()
    {
        return $this->_definition;
    }

    /**
     * @param array|null $definition
     */
    public function setDefinition(?array $definition): void
    {
        $this->_definition = $definition;
    }

    /**
     * @return mixed
     */
    public function getAnswers()
    {
        return $this->_answers;
    }

    /**
     * @param array|null $answers
     */
    public function setAnswers(?array $answers): void
    {
        $this->_answers = $answers;
    }

    /**
     * @return bool
     */
    public function hasScore(): bool
    {
        return is_array($this->calculated) && array_key_exists('score', $this->calculated);
    }

    /**
     * @return int|null
     */
    public function getScore(): ?int
    {
        return $this->hasScore() ? $this->calculated['score'] : null;
    }

    /**
     * Process answers and question.
     * @return bool
     */
    public function process(): bool
    {
        $this->results = [];
        $fieldsCount = $answersCount = 0;

        if (isset($this->definition['fields']) && is_array($this->definition['fields'])) {
            $fieldsCount += count($this->definition['fields']);
        }
        if (is_array($this->answers)) {
            $answersCount += count($this->answers);
        }

        if (($answersCount <=> $fieldsCount) !== 0) {
            $this->addError('results', 'Both "fields" and "answers" parameters should have an equal number of elements');
            return false;
        }

        /** @var Answer[] $answers */
        $answers = [];
        foreach ($this->answers as $answer) {

            $answer = new ResultField($answer);
            if (!$answer->validate()) {
                foreach ($answer->getErrors() as $name => $message) {
                    $this->addErrors(['answers.' . $name => $message]);
                }
            } else {
                $answers[$answer->id] = $answer;
            }
        }

        foreach ($this->definition['fields'] as $field) {
            $result = new ResultField($field);

            if (!$result->validate()) {
                foreach ($result->getErrors() as $name => $message) {
                    $this->addErrors(['definition.' . $name => $message]);
                }
            } elseif (isset($answers[$result->id])) {
                $result->setAnswer($answers[$result->id]);
                $this->results[$result->id] = $result;
            } else {
                $this->addError('answers', "Answer id {$result->id} not found");
            }
        }

        return $this->hasErrors() ? false : true;

    }

    /**
     * @return array
     */
    public function getResults(): array
    {
        if ($this->results === null) {
            $this->process();
        }
        return $this->results;
    }
}