<?php

namespace tonyaxo\yii2typeform\api\forms;

use tonyaxo\yii2typeform\api\BaseModel;
use tonyaxo\yii2typeform\api\ModelAssigmentTrait;

/**
 * Base screen/
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 *
 * @property BaseProperties $properties
 * @property Attachment $attachment
 */
abstract class BaseScreen extends BaseModel
{
    use ModelAssigmentTrait;

    /**
     * @var string Readable name you can use to reference the thank you screen.
     */
    public $ref;
    /**
     * @var string Title for the thank you screen.
     */
    public $title;

    /**
     * @var WelcomeProperties|ThankyouProperties
     */
    private $_properties;
    /**
     * @var Attachment
     */
    private $_attachment;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['title', 'required'],
            [['title', 'ref'], 'string'],
            ['properties', 'validateModel'],
            ['attachment', 'validateModel'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'ref',
            'title',
            'properties',
            'attachment',
        ];
    }

    /**
     * @inheritdoc
     */
    public function isEmpty(): bool
    {
        return parent::isEmpty() || (empty($this->ref) && $this->title === null
            && ($this->properties === null || $this->properties->isEmpty())
            && ($this->attachment === null || $this->attachment->isEmpty()));
    }

    /**
     * @return null|WelcomeProperties|ThankyouProperties
     */
    public function getProperties()
    {
        return $this->_properties;
    }

    /**
     * @param array|BaseProperties $properties
     */
    public function setProperties($properties): void
    {
        $this->assignSingle(__FUNCTION__, $properties, BaseProperties::class);
    }

    /**
     * @return Attachment
     */
    public function getAttachment(): ?Attachment
    {
        return $this->_attachment;
    }

    /**
     * @param array|Attachment $attachment
     */
    public function setAttachment($attachment): void
    {
        $this->assignSingle(__FUNCTION__, $attachment, Attachment::class);
    }
}
