<?php


namespace tonyaxo\yii2typeform\api\webhooks;

use tonyaxo\yii2typeform\api\UnderscoresMagicMethodTrait;
use yii\base\Model;
use yii\web\JsonParser;
use yii\web\JsonResponseFormatter;
use yii\web\Request;

/**
 * Class WebhookEvent
 *
 * ```
 *  $formResponse = WebhookEvent::handle();
 *  $res = $formResponse->getResults();
 * ```
 *
 * @author Sergey Bogatyrev <sergey@bogatyrev.me>
 */
abstract class WebhookEvent extends Model
{
    use UnderscoresMagicMethodTrait;

    protected const TYPE_FORM_RESPONSE = 'form_response';

    /**
     * Event type attribute name.
     */
    const EVENT_TYPE_ATTRIBUTE = 'event_type';
    /**
     * Event id attribute name.
     */
    const EVENT_ID_ATTRIBUTE = 'event_id';

    protected static $handlers = [
        self::TYPE_FORM_RESPONSE => FormResponseEvent::class,
    ];

    /**
     * @var string
     */
    private $_eventId;
    /**
     * @var string
     */
    private $_eventType;

    /**
     * @return mixed
     */
    public function getEventId()
    {
        return $this->_eventId;
    }

    /**
     * @param mixed $eventId
     */
    public function setEventId($eventId): void
    {
        $this->_eventId = $eventId;
    }

    /**
     * @return mixed
     */
    public function getEventType()
    {
        return $this->_eventType;
    }

    /**
     * @param mixed $eventType
     */
    public function setEventType($eventType): void
    {
        $this->_eventType = $eventType;
    }

    /**
     * Handle webhook request. Return WebhookEvent object
     * @param null|Request $request
     * @return null|WebhookEvent
     * @throws \yii\base\InvalidConfigException
     */
    public static function handle(?Request $request = null): ?WebhookEvent
    {
        $request = $request ?? \Yii::$app->request;

        if (!isset($request->parsers['application/json'])) {
            $request->parsers['application/json'] = JsonParser::class;
        }

        $eventType = $request->getBodyParam(static::EVENT_TYPE_ATTRIBUTE, false);
        $eventId = $request->getBodyParam(static::EVENT_ID_ATTRIBUTE, false);

        $eventClass = self::getEventHandler($eventType);
        if ($eventClass === null) {
            return null;
        }
        /** @var WebhookEvent $event */
        $event = new $eventClass([
            static::EVENT_TYPE_ATTRIBUTE => $eventType, static::EVENT_ID_ATTRIBUTE => $eventId
        ]);
        $event->load($request->getBodyParams(), $eventType);

        return $event;
    }

    /**
     * @param string $type
     * @param null|string $handleClass
     */
    public static function addEventHandler(string $type, ?string $handleClass): void
    {
        static::$handlers[$type] = $handleClass;
    }

    public static function getEventHandler(string $type): ?string
    {
        if (!isset(static::$handlers[$type])) {
            return null;
        }
        return static::$handlers[$type];
    }
}
