<?php

namespace Drupal\blueimp\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\image\Entity;
use Drupal\image\Entity\ImageStyle;
use Drupal\blueimp;

use Drupal\node\Entity\Node;
use Drupal\field\FieldConfigInterface;

/**
 * Provides a 'Gallery' Block
 *
 * @Block(
 *   id = "gallery_block",
 *   admin_label = @Translation("Gallery block"),
 * )
 */
class GalleryBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $data = null;

    // Retrieve an array which contains the path pieces.
    $current_path = \Drupal::service('path.current')->getPath();
    $args = explode('/', $current_path);

    // Load the current node.
    $node = \Drupal::routeMatch()->getParameter('node');
    $nid = isset($args[1]) && ($args[1] == 'node') ? $args[2] : 0;
    $nid = is_numeric($nid) ? $nid : 0;
    //$node = $nid ? \Drupal::entityManager()->getStorage('node')->load($arg1) : NULL;

    if($node && isset($node->field_galleries)) {
      $gallery_id = $node->get('field_galleries')->getValue();
      $gallery_id = isset($gallery_id[0]['target_id']) ? $gallery_id[0]['target_id'] : 0;

      $gallery = $gallery_id ? \Drupal::entityManager()->getStorage('node')->load($gallery_id) : NULL;
      if($gallery && isset($gallery->field_blueimp_gallery)) {
        $blueimp_gallery = $gallery->get('field_blueimp_gallery');
        $data = array();
        foreach ($blueimp_gallery as $key => $value) {
          $image_uri = $value->entity->getFileUri();
          $data[$key]['image'] = getImageStyles($image_uri);
          $data[$key]['url_youtube'] = NULL;
          $data[$key]['key_youtube'] = NULL;
          if(isset($value->field_video_url) &&
          ($video_url = $value->get('field_video_url')->getValue()) &&
          isset($video_url[0]['uri']) && !empty($video_url[0]['uri']) ) {
            $link  = $video_url[0]['uri'];
            $data[$key]['url_youtube']= $link;

            // For videos like http://www.youtube.com/watch?v=...
            $video_id = explode("?v=", $link);
            if (empty($video_id[1])){
                // For videos like http://www.youtube.com/watch/v/..
                $video_id = explode("/v/", $link);
            }
            $video_id = explode("&", $video_id[1]); // Deleting any other params
            $video_id = $video_id[0];

            $data[$key]['key_youtube']=$video_id;
          }
        }
      }
    }

    if (!empty($data)) {
      return array(
        '#theme' => 'block_gallery',
        '#data' => $data,
        /*'#attached' => array(
          'library' =>  array(
            'libraries/gallery'
          ),
        ),*/
      );
    }
    return array(
      '#type' => 'markup',
      '#markup' => $this->t('.'),
      );
  }
}
