<?php /**
 * @file
 * Contains \Drupal\blueimp\EventSubscriber\InitSubscriber.
 */

namespace Drupal\blueimp\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\blueimp;

class InitSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [KernelEvents::REQUEST => ['onEvent', 0]];
  }

  public function onEvent() {
    // @FIXME
// Could not extract the default value because it is either indeterminate, or
// not scalar. You'll need to provide a default value in
// config/install/blueimp.settings.yml and config/schema/blueimp.schema.yml.
    $settings = \Drupal::config('blueimp.settings')->get('blueimp_settings');
    /*if (blueimp_check_path($settings['visibility']['visibility'], $settings['visibility']['pages'])) {
      $module_path = drupal_get_path('module', 'blueimp');
      libraries_load('blueimp');
    }*/
  }

}
