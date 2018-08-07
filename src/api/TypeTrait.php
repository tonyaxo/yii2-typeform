<?php

namespace tonyaxo\yii2typeform\api;


trait TypeTrait
{
    /**
     * @var array
     */
    private static $_types;

    public static function getTypes(): array
    {
        if (static::$_types === null) {
            $consts = (new \ReflectionClass(__CLASS__))->getConstants();
            foreach ($consts as $name => $value) {
                $pos = strpos($name, 'TYPE_');
                if ($pos === 0) {
                    static::$_types[$value] = $value;
                }
            }
            if (static::$_types === null) {
                static::$_types = [];
            }
        }
        return static::$_types;
    }
}