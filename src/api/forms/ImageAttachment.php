<?php

namespace tonyaxo\yii2typeform\api\forms;

use tonyaxo\yii2typeform\api\BaseModel;

/**
 * Identifies the image to use for the answer choice.
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 */
class ImageAttachment extends BaseModel
{
    const TYPE_IMAGE = 'image';

    /**
     * Type of attachment.
     * @var string
     */
    public $type;
    /**
     * URL for the image to use for the answer choice.
     * Images must already exist in your account---use the image's Typeform URL.
     * @var string
     */
    public $href;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'href'], 'required'],
            ['type', 'in', 'range' => [self::TYPE_IMAGE]],
            ['href', 'url'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'type',
            'href',
        ];
    }

    /**
     * @inheritdoc
     */
    public function isEmpty(): bool
    {
        return parent::isEmpty() || $this->type===null || $this->href === null;
    }
}

