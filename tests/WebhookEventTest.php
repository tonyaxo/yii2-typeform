<?php

use tonyaxo\yii2typeform\api\webhooks\WebhookEvent;

class WebhookEventTest extends \yiiunit\extensions\yii2typeform\TestCase
{
    public function testCanAddEventType()
    {
        WebhookEvent::addEventHandler('testType', '\test\TestHandlerClass');
        $handler = WebhookEvent::getEventHandler('testType');
        $this->assertEquals('\test\TestHandlerClass', $handler);

        $handler = WebhookEvent::getEventHandler('unknownType');
        $this->assertNull($handler);
    }

    /**
     * @dataProvider eventsDataProvider
     *
     * @param string $json
     * @param string $eventId
     * @param int|null $score
     * @param string $formId
     * @param array $hidden
     * @param bool $complete
     * @throws \yii\base\InvalidConfigException
     */
    public function testHandleFormResponse(string $json, string $eventId, ?int $score, string $formId, ?array $hidden, bool $complete)
    {
        $request = $this->getMockBuilder(\yii\web\Request::class)
            ->setMethods(['getContentType', 'getRawBody'])
            ->getMock();

        $request->expects($this->any())
            ->method('getContentType')
            ->willReturn('application/json; charset=UTF-8');
        $request->expects($this->any())
            ->method('getRawBody')
            ->willReturn($json);

        /** @var \tonyaxo\yii2typeform\api\webhooks\FormResponseEvent $result */
        $result = WebhookEvent::handle($request);

        $this->assertInstanceOf(\tonyaxo\yii2typeform\api\webhooks\FormResponseEvent::class, $result);
        $this->assertEquals($eventId, $result->getEventId());
        $this->assertEquals($score, $result->getScore());
        $this->assertEquals($formId, $result->getFormId());
        $this->assertEquals($hidden, $result->hidden);
        $this->assertEquals($complete, $result->isComplete());
    }

    /**
     * @return array
     */
    public function eventsDataProvider(): array
    {
        return [
            'empty form response' => [
                // language=JSON
                <<<JSON
                {
                    "event_id": "LtWXD3crgy",
                    "event_type": "form_response",
                    "form_response": {
                        "form_id": "lT4Z3j",
                        "token": "a3a12ec67a1365927098a606107fac15",
                        "submitted_at": "2018-01-18T18:17:02Z",
                        "landed_at": "2018-01-18T18:07:02Z",
                        "definition": {
                            "id": "lT4Z3j",
                            "title": "Webhooks example",
                            "fields": [],
                            "calculated": {}
                        },
                        "answers": []
                    }
                }
JSON
                ,
                "LtWXD3crgy",
                null,
                "lT4Z3j",
                null,
                false,
            ],
            'without score' => [
                // language=JSON
                <<<JSON
                {
                    "event_id": "LtWXD3crgy",
                    "event_type": "form_response",
                    "form_response": {
                        "form_id": "lT4Z3j",
                        "token": "a3a12ec67a1365927098a606107fac15",
                        "submitted_at": "2018-01-18T18:17:02Z",
                        "landed_at": "2018-01-18T18:07:02Z",
                        "calculated": null,
                        "definition": {
                            "id": "lT4Z3j",
                            "title": "Webhooks example",
                            "fields": [
                                {
                                    "id": "DlXFaesGBpoF",
                                    "title": "Thanks, {{answer_60906475}}! What's it like where you live? Tell us in a few sentences.",
                                    "type": "long_text",
                                    "ref": "[readable_ref_long_text",
                                    "allow_multiple_selections": false,
                                    "allow_other_choice": false
                                }
                            ],
                            "calculated": {}
                        },
                        "answers": [
                            {
                                "type": "text",
                                "text": "It's cold right now! I live in an older medium-sized city with a university. Geographically, the area is hilly.",
                                "field": {
                                    "id": "DlXFaesGBpoF",
                                    "type": "long_text"
                                }
                            }
                        ]
                    }
                }
JSON
                ,
                "LtWXD3crgy",
                null,
                "lT4Z3j",
                null,
                true,
            ],
            'hidden fields' => [
                // language=JSON
                <<<JSON
                {
                  "event_id": "hQJi65uTRz",
                  "event_type": "form_response",
                  "form_response": {
                    "form_id": "fbnRZu",
                    "token": "4969bac7b56e83a82ad060f0ae57faed",
                    "landed_at": "2018-08-12T15:11:04Z",
                    "submitted_at": "2018-08-12T15:11:04Z",
                    "hidden": {
                      "email": "hidden_value",
                      "user_name": "hidden_value"
                    },
                    "definition": {
                      "id": "fbnRZu",
                      "title": "Тестовая форма Разработчиков",
                      "fields": [
                        {
                          "id": "jHW6FSA1j3IV",
                          "title": "Земля плоская?",
                          "type": "yes_no",
                          "ref": "9ee40c10-1340-4dbb-b76d-a5d58d31d8e3",
                          "properties": {}
                        }
                      ],
                      "calculated": {}
                    },
                    "answers": [
                      {
                        "type": "boolean",
                        "boolean": true,
                        "field": {
                          "id": "jHW6FSA1j3IV",
                          "type": "yes_no"
                        }
                      }
                    ]
                  }
                }
JSON
                ,
                "hQJi65uTRz",
                null,
                "fbnRZu",
                [
                    'email' => 'hidden_value',
                    'user_name' => 'hidden_value'
                ],
                true,
            ],
            'score' => [
                // language=JSON
                <<<JSON
                {
                  "event_id": "hQJi65uTRz",
                  "event_type": "form_response",
                  "form_response": {
                    "form_id": "fbnRZu",
                    "token": "4969bac7b56e83a82ad060f0ae57faed",
                    "landed_at": "2018-08-16T18:28:13Z",
                    "submitted_at": "2018-08-16T18:28:13Z",
                    "calculated": {
                      "score": 42
                    },
                    "definition": {
                      "id": "fbnRZu",
                      "title": "Тестовая форма Разработчиков",
                      "fields": [
                        {
                          "id": "jHW6FSA1j3IV",
                          "title": "Земля плоская?",
                          "type": "yes_no",
                          "ref": "9ee40c10-1340-4dbb-b76d-a5d58d31d8e3",
                          "properties": {}
                        }
                      ],
                      "calculated": {
                        "score": true
                      }
                    },
                    "answers": [
                      {
                        "type": "boolean",
                        "boolean": true,
                        "field": {
                          "id": "jHW6FSA1j3IV",
                          "type": "yes_no"
                        }
                      }
                    ]
                  }
                }
JSON
                ,
                "hQJi65uTRz",
                42,
                "fbnRZu",
                null,
                true,
            ],
        ];
    }
}
