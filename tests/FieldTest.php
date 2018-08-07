<?php

namespace yiiunit\extensions\yii2typeform;

use yii\helpers\Json;

class FieldTest extends \PHPUnit\Framework\TestCase
{
    protected static $jsonFixture;
    protected static $arrayFixture;

    public static function setUpBeforeClass()
    {
        static::$jsonFixture = <<<JSON
        {
            "ref":"ref",
            "title":"title",
            "type":"number",
            "properties":{
            "description":"description",
            "choices":[
               {
                  "ref":"ref",
                  "label":"label",
                  "attachment":{
                     "type":"type",
                     "href":"href"
                  }
               }
            ],
            "fields":[
               null
            ],
            "allow_multiple_selection":true,
            "randomize":true,
            "allow_other_choice":true,
            "vertical_alignment":true,
            "supersized":true,
            "show_labels":true,
            "alphabetical_order":true,
            "hide_marks":true,
            "button_text":"Continue",
            "steps":0,
            "shape":"star",
            "labels":{
               "left":"left",
               "right":"right",
               "center":"center"
            },
            "start_at_one":true,
            "structure":"DDMMYYYY",
            "separator":"/",
            "currency":"EUR",
            "price":{
               "type":"type",
               "value":"value"
            },
            "show_button":true
            },
            "validations":{
                "required":true,
                "max_length":0,
                "min_value":0,
                "max_value":0
            },
            "attachment":{
                "type":"image",
                "href":"https://images.typeform.com/images/4bcd3",
                "scale":0
            }
        }
JSON;
        static::$arrayFixture = Json::decode(static::$jsonFixture, true);
    }


    public function testRetrieve()
    {
        $this->markTestIncomplete(__FUNCTION__);
    }

    public function testIsEmpty()
    {
        $this->markTestIncomplete(__FUNCTION__);
    }
}