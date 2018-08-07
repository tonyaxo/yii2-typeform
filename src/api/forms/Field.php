<?php

namespace tonyaxo\yii2typeform\api\forms;


use tonyaxo\yii2typeform\api\TypeInterface;
use tonyaxo\yii2typeform\api\TypeTrait;
use yii\base\Model;

class Field extends Model implements TypeInterface
{
    use TypeTrait;

    /**
     * @var string Readable name you can use to reference the field.
     */
    public $ref;
    /**
     * @var string Readable name you can use to reference the field.
     */
    public $title;
    /**
     * @var string The type of field.
     */
    public $type;

    public $properties;
    public $validations;
    public $attachment;

    /**
     * @var string[]
     */
    private static $_types;

    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['ref', 'title', 'type'], 'string'],
            ['type', 'in', 'range' => static::getTypes()],
        ];
    }
    
    public function fields()
    {
        return [
            'ref',
            'title',
            'type',
            'properties',
            'validations',
            'attachment',
        ];
    }
}
