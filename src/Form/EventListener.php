<?php
namespace App\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ReCaptchaValidationListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::POST_SUBMIT => 'onPostSubmit'
        ];
    }    public function onPostSubmit(FormEvent $event)
    {
        // verify the user's response
    }
}