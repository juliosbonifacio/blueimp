<?php

namespace Drupal\blueimp\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\image\Entity;
use Drupal\image\Entity\ImageStyle;

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
    if( $node && $node->get('field_blueimp_gallery') !== null ) {
      $datos = $node->get('field_blueimp_gallery');
      $data = array();

      foreach ($datos as $key => $value) {
        $image_uri = $value->entity->getFileUri();
        $data[$key]['image'] = $this->getImageStyles($image_uri);
        $data[$key]['url_youtube']= NULL;
        $data[$key]['key_youtube'] = NULL;

        if(isset($value->field_url_video2) && isset($value->field_url_video2['und'])) {
            $link  = $value['field_url_video2']['und'][0]['value'];
            $data[$key]['url_youtube']= $link;

            $video_id = explode("?v=", $link); // For videos like http://www.youtube.com/watch?v=...
            if (empty($video_id[1])){
                $video_id = explode("/v/", $link); // For videos like http://www.youtube.com/watch/v/..
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
        '#attached' => array(
          'library' =>  array(
            'blueimp/gallery'
          ),
        ),
      );
    }
    return array(
      '#type' => 'markup',
      '#markup' => $this->t('Empty Block Node...!'),
      );
  }

  protected function getImageStyles($uri) {
    $images = array();

    if (!empty($uri)) {
      $image_cover = ImageStyle::load('blueimp_gallery')->buildUrl($uri);
      $image = ImageStyle::load('large')->buildUrl($uri);
      $images = array(
        'cover' => $image_cover,
        'large' => $image
      );
      return $images;
    }
    return NULL;
  }
}
