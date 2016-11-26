<?php

namespace Drupal\blueimp\Plugin\Block;

use Drupal\Core\Block\BlockBase;

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
    //$controller = new GalleryController;
    //$data = $controller->blockGeneral();
    //
    //$arg0 = arg(0);
    //$arg1 = arg(1);

    $data = null;

    // Retrieve an array which contains the path pieces.
    $current_path = \Drupal::service('path.current')->getPath();
    $args = explode('/', $current_path);

    // Load the current node.
    //$node = \Drupal::routeMatch()->getParameter('node');
    $nid = isset($args[1]) && ($args[1] == 'node') ? $args[2] : 0;
    $nid = is_numeric($nid) ? $nid : 0;

    $node = $nid ? \Drupal::entityManager()->getStorage('node')->load($arg1) : NULL;

    if($node && isset($node->field_galerias['und'])) {
      $id_galeria = $node->field_galerias['und'][0]['target_id'];
      $galeria = \Drupal::entityManager()->getStorage('node')->load($id_galeria);

      if(isset($galeria->field_imagen_principal['und'])) {
        $datos = $galeria->field_imagen_principal['und'];
        $data = array();

        foreach ($datos as $key => $value) {
          $image_uri = $value['uri'];
          $data[$key]['imagen'] = $this->getImageStyles($image_uri);
          $data[$key]['url_youtube'] = NULL;
          $data[$key]['key_youtube'] = NULL;

          if(isset($value['field_url_video2']['und'])) {

            $link  = $value['field_url_video2']['und'][0]['value'];
            $data[$key]['url_youtube']= $link;

            $video_id = explode("?v=", $link); // For videos like http://www.youtube.com/watch?v=...
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
        '#attached' => array(
          'library' =>  array(
            'libraries/gallery'
          ),
        ),
      );
    }
    return array(
      '#type' => 'markup',
      '#markup' => $this->t('Empty Block0...!'),
      );
  }
}
