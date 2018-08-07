<?php

namespace tonyaxo\yii2typeform\api\forms;

/**
 * Allows you to display images and videos.
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 */
class Attachment extends ImageAttachment
{
    const TYPE_VIDEO = 'video';

    const SCALE_04 = '0.4';
    const SCALE_06 = '0.6';
    const SCALE_08 = '0.8';
    const SCALE_10 = '1';

    /**
     * URL for the image or video you want to display.
     * Images must already exist in your account---use the image's Typeform URL,
     * such as `https://images.typeform.com/images/kbn8tc98AHb`. For videos, use the video's YouTube.com URL.
     * @var string
     */
    public $href;

    /**
     * @var string Optional parameter for responsively scaling videos. Available only for "video" type.
     * Default value is 0.6
     */
    public $scale = self::SCALE_06;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'href'], 'required'],
            ['scale', 'default', 'value' => self::SCALE_06],
            ['scale', 'in', 'range' => [self::SCALE_04, self::SCALE_06, self::SCALE_08, self::SCALE_10]],
            ['type', 'in', 'range' => [self::TYPE_IMAGE, self::TYPE_VIDEO]],
            ['href', 'url'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();
        if ($this->isVideo()) {
            $fields[] = 'scale';
        }
        return $fields;
    }

    /**
     * @return bool
     */
    public function isImage(): bool
    {
        return $this->type == self::TYPE_IMAGE;
    }

    /**
     * @return bool
     */
    public function isVideo(): bool
    {
        return $this->type == self::TYPE_VIDEO;
    }
}
