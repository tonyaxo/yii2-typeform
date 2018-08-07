<?php

namespace yiiunit\extensions\yii2typeform;

use yii\helpers\Json;

class BaseFormTest extends \PHPUnit\Framework\TestCase
{
    protected static $jsonFixture;
    protected static $arrayFixture;

    public static function setUpBeforeClass()
    {
        static::$jsonFixture = <<<JSON
        {
           "id":"id",
           "title":"title",
           "language":"en",
           "fields":[
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
           ],
           "hidden":[
              "string"
           ],
           "welcome_screens":[
              {
                 "ref":"nice-readable-welcome-ref",
                 "title":"Welcome Title",
                 "properties":{
                    "description":"Cool description for the welcome",
                    "show_button":true,
                    "button_text":"start"
                 },
                 "attachment":{
                    "type":"image",
                    "href":"https://images.typeform.com/images/4bcd3",
                    "scale":0
                 }
              }
           ],
           "thankyou_screens":[
              {
                 "ref":"nice-readable-thank-you-ref",
                 "title":"Thank you Title",
                 "properties":{
                    "show_button":true,
                    "button_text":"start",
                    "button_mode":"redirect",
                    "redirect_url":"http://www.typeform.com",
                    "share_icons":true
                 },
                 "attachment":{
                    "type":"image",
                    "href":"https://images.typeform.com/images/4bcd3",
                    "scale":0
                 }
              }
           ],
           "logic":[
              {
                 "type":"type",
                 "ref":"ref",
                 "actions":[
                    {
                       "action":"action",
                       "details":{
                          "to":{
                             "type":"type",
                             "value":"value"
                          },
                          "target":{
                             "type":"type",
                             "value":"value"
                          },
                          "value":{
                             "type":"type",
                             "value":0
                          }
                       },
                       "condition":{
                          "op":"op",
                          "vars":[
                             {
                                "type":"type",
                                "value":{
        
                                }
                             }
                          ]
                       }
                    }
                 ]
              }
           ],
           "theme":{
              "href":"https://api.typeform.com/themes/Fs24as"
           },
           "workspace":{
              "href":"https://api.typeform.com/workspaces/Aw33bz"
           },
           "_links":{
              "display":"https://subdomain.typeform.com/to/abc123"
           },
           "settings":{
              "language":"language",
              "is_public":true,
              "progress_bar":"proportion",
              "show_progress_bar":true,
              "show_typeform_branding":true,
              "meta":{
                 "allow_indexing":true,
                 "description":"description",
                 "image":{
                    "href":"href"
                 }
              },
              "redirect_after_submit_url":"redirect_after_submit_url",
              "google_analytics":"google_analytics",
              "facebook_pixel":"facebook_pixel",
              "notifications":{
                 "self":{
                    "enabled":true,
                    "recipients":[
                       "string"
                    ],
                    "reply_to":"reply_to",
                    "subject":"You received a response to your typeform {{form:title}}!",
                    "message":"message"
                 },
                 "respondent":{
                    "enabled":true,
                    "recipient":"recipient",
                    "reply_to":[
                       "string"
                    ],
                    "subject":"Thank you for completing the typeform {{form:title}}!",
                    "message":"message"
                 }
              }
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
