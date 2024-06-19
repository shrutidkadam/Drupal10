<?php

namespace Drupal\custom_exports\EventSubscriber;

use Drupal\Core\Config\ConfigCrudEvent;
use Drupal\user\Event\UserEvent;
use Drupal\Core\Config\ConfigEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ConfigEventsSubscriber implements EventSubscriberInterface {
  public static function getSubscribedEvents() {
    return[
      ConfigEvents::SAVE => 'configsave',
      ConfigEvents::DELETE => 'delete',
//      KernelEvents::REQUEST => 'onUserLogin'
    ];
  }
  public function configsave(ConfigCrudEvent $event) {

    \Drupal::messenger()->addStatus('Saved config: test ');
  }

  public function delete(ConfigCrudEvent $event) {
    \Drupal::messenger('deleted');
  }

  public function userLoginCallback(ConfigCrudEvent $event) {

  }
}
