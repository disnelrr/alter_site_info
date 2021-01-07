<?php 

namespace Drupal\alter_site_info\Controller;

use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * Simple Controller to check if correct Site API key is passed in as a parameter,
 * along with a node identifier.
 */
class Controller extends ControllerBase {
  /**
   * Returns a json representation of a given page if Site API Key is provided.
   */
  public function content($apikey, $nid, Request $request) {
    $nid = $request->attributes->get('_raw_variables')->get('nid');
    $argapikey = $request->attributes->get('_raw_variables')->get('apikey');
    $node = Node::load($nid);
    $sisapikey = \Drupal::config('system.site')->get('siteapikey');
    if ( $sisapikey == $argapikey ) {
      return [
        '#theme' => 'alter_site_info_json_page',
        '#apikey' => $message,
        '#nid' => $nid,
        '#node' => \Drupal::service('serializer')->serialize($node, 'json'),
      ];
    } else {
        return [
          '#markup' => $this->t('Access Denied!'),
        ];
    }
  }

} 
