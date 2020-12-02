<?php

namespace common\components;

use yii\base\Component;
use yii\base\Event;

/**
 * Attaches events to all app models.
 */
class EventManager extends Component
{
    public array $events = [];

    /** @inheritdoc */
    public function init()
    {
        parent::init();

        $this->attachEvents($this->events);
    }

    public function attachEvents(array $eventConfig)
    {
        foreach ($eventConfig as $className => $events) {
            foreach ($events as $eventName => $handlers) {
                foreach ($handlers as $handler) {
                    if (is_array($handler) && is_callable($handler[0])) {
                        $data = isset($handler[1]) ? array_pop($handler) : null;
                        $append = isset($handler[2]) ? array_pop($handler) : null;
                        Event::on($className, $eventName, $handler[0], $data, $append);
                    } else if (is_callable($handler)) {
                        Event::on($className, $eventName, $handler);
                    }
                }
            }
        }
    }
}
