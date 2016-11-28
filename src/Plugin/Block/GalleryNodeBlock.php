<?php

namespace Drupal\blueimp\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\image\Entity;
use Drupal\image\Entity\ImageStyle;
use Drupal\blueimp;

/**
 * Provides a 'Gallery Node' Block
 *
 * @Block(
 *   id = "gallery_node_block",
 *   admin_label = @Translation("Gallery Node block"),
 * )
 */
class GalleryNodeBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $data = NULL;
    // Load the current node.
    $node = \Drupal::routeMatch()->getParameter('node');
    if( $node && isset($node->field_blueimp_gallery)) {
      $blueimp_gallery = $node->get('field_blueimp_gallery');
      $data = array();

      foreach ($blueimp_gallery as $key => $value) {
        $image_uri = $value->entity->getFileUri();
        $data[$key]['image'] = getImageStyles($image_uri);
        $data[$key]['url_youtube']= NULL;
        $data[$key]['key_youtube'] = NULL;

        if( isset($value->field_video_url) &&
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

    if (!empty($data)) {
      return array(
        '#data' => $data,
        '#theme' => 'block_gallery',
      );
    }
    return array(
      '#type' => 'markup',
      '#markup' => $this->t('.'),
      );
  }
}
