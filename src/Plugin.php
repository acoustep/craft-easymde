<?php
namespace Acoustep\CraftEasyMDE;
use Acoustep\CraftEasyMDE\Fields\CraftEasyMDEField;
use yii\base\Event;
use craft\services\Fields;
use Craft;
use craft\events\RegisterComponentTypesEvent;

class Plugin extends \craft\base\Plugin
{
    public function init()
    {
        parent::init();

        // Custom initialization code goes here...
        Event::on(
            Fields::class, 
            Fields::EVENT_REGISTER_FIELD_TYPES, 
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = CraftEasyMDEField::class;
            }
        );
    }
}

