<?php

use tonyaxo\yii2typeform\api\webhooks\WebhookEvent;

class WebhookEventTest extends \yiiunit\extensions\yii2typeform\TestCase
{

    public function testAddEventType()
    {
        $this->markTestIncomplete();
    }

    /**
     * @dataProvider eventsDataProvider
     *
     * @param string $json
     * @param string $eventId
     * @param int|null $score
     * @param string $formId
     * @throws \yii\base\InvalidConfigException
     */
    public function testHandleFormResponse(string $json, string $eventId, ?int $score, string $formId)
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
        "calculated": {
            "score": 9
        },
        "definition": {
            "id": "lT4Z3j",
            "title": "Webhooks example",
            "fields": []
        },
        "answers": []
    }
}
JSON
                ,
                "LtWXD3crgy",
                9,
                "lT4Z3j",
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
            ]
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
            ],
        ];
    }
}
