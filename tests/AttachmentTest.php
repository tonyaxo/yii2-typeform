<?php

namespace yiiunit\extensions\yii2typeform;

use tonyaxo\yii2typeform\api\forms\Attachment;
use tonyaxo\yii2typeform\api\forms\ImageAttachment;

class AttachmentTest extends BaseTestCase
{
    public function testEmpty()
    {
        $image = new ImageAttachment();
        $this->assertTrue($image->isEmpty());

        $attachment = new ImageAttachment();
        $this->assertTrue($attachment->isEmpty());
    }

    /**
     * @dataProvider imageAttachmentDataProvider
     *
     * @param array $data
     * @param bool $expectedValidation
     * @param array $expectedArray
     * @param bool $expectedEmpty
     */
    public function testImageAttachment(array $data, bool $expectedValidation, array $expectedArray, bool $expectedEmpty)
    {
        $this->execTestForClass(ImageAttachment::class, $data, $expectedValidation, $expectedArray, $expectedEmpty);
    }

    /**
     * @dataProvider imageAttachmentDataProvider
     * @dataProvider attachmentDataProvider
     *
     * @param array $data
     * @param bool $expectedValidation
     * @param array $expectedArray
     * @param bool $expectedEmpty
     */
    public function testAttachment(array $data, bool $expectedValidation, array $expectedArray, bool $expectedEmpty)
    {
        $this->execTestForClass(Attachment::class, $data, $expectedValidation, $expectedArray, $expectedEmpty);
    }

    /**
     * @return array
     */
    public function attachmentDataProvider()
    {
        return [
            [
                [
                    'type' => Attachment::TYPE_VIDEO,
                    'href' => 'https://images.typeform.com/images/4bcd3',
                ],
                true,
                [
                    'type' => Attachment::TYPE_VIDEO,
                    'href' => 'https://images.typeform.com/images/4bcd3',
                    'scale' => Attachment::SCALE_06,
                ],
                false,
            ],
            [
                [
                    'type' => Attachment::TYPE_VIDEO,
                    'href' => 'https://images.typeform.com/images/4bcd3',
                    'scale' => '10',
                ],
                false,
                [
                    'type' => Attachment::TYPE_VIDEO,
                    'href' => 'https://images.typeform.com/images/4bcd3',
                    'scale' => '10',
                ],
                true,
            ],
            [
                [
                    'type' => 'unknown_type',
                    'href' => 'https://images.typeform.com/images/4bcd3',
                ],
                false,
                [
                    'type' => 'unknown_type',
                    'href' => 'https://images.typeform.com/images/4bcd3',
                ],
                true,
            ],
        ];
    }

    /**
     * @return array
     */
    public function imageAttachmentDataProvider()
    {
        return [
            [
                [],
                false,
                [],
                true,
            ],
            [
                [
                    'type' => Attachment::TYPE_IMAGE,
                    'href' => 'https://images.typeform.com/images/4bcd3',
                ],
                true,
                [
                    'type' => Attachment::TYPE_IMAGE,
                    'href' => 'https://images.typeform.com/images/4bcd3',
                ],
                false,
            ],
            [
                [
                    'type' => Attachment::TYPE_IMAGE,
                    'href' => 'images.typeform.com/images/4bcd3',
                ],
                false,
                [
                    'type' => Attachment::TYPE_IMAGE,
                    'href' => 'images.typeform.com/images/4bcd3',
                ],
                true,
            ],
            [
                [
                    'href' => 'https://images.typeform.com/images/4bcd3',
                ],
                false,
                [
                    'href' => 'https://images.typeform.com/images/4bcd3',
                ],
                true,
            ],
        ];
    }
}
