<?php
/**
 * @file
 * Contains \Drupal\blueimp\Controller\GalleryController.
 */

namespace Drupal\blueimp\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\image\Entity;
use Drupal\image\Entity\ImageStyle;

class GalleryController extends ControllerBase {
  public function blockGeneral() {
    $arg0 = arg(0);
    $arg1 = arg(1);

    $node = \Drupal::entityManager()->getStorage('node')->load($arg1);

    if(isset($node->field_galerias['und'])) {
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

        return array(
          '#theme' => 'block_gallery',
          '#data' => $data,
        );
      }
    }

    return array(
      '#type' => 'markup',
      '#markup' => $this->t('Empty Block0...!'),
    );
  }

  public function blockNode() {

    $arg0 = arg(0);
    $arg1 = arg(1);

    $node = \Drupal::entityManager()->getStorage('node')->load($arg1);

    if(isset($node->field_imagen_principal['und'])) {
      $datos = $node->field_imagen_principal['und'];
      $data = array();

      foreach ($datos as $key => $value) {
        $image_uri = $value['uri'];
        $data[$key]['imagen'] = $this->getImageStyles($image_uri);
        $data[$key]['url_youtube']= NULL;
        $data[$key]['key_youtube'] = NULL;

        if(isset($value['field_url_video2']['und'])) {
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

      return array(
        '#theme' => 'block_gallery',
        '#data' => $data,
      );
    }

    return array(
      '#type' => 'markup',
      '#markup' => $this->t('Empty Block...!'),
    );
  }

  protected function getImageStyles($uri) {
    $images = array();

    if (!empty($uri)) {
      $image_cover = ImageStyle::load('blueimp_gallery')->buildUrl($image_uri);
      $image = ImageStyle::load('large')->buildUrl($image_uri);
      $images = array(
        'cover' => $image_cover,
        'large' => $image
      );
    }

    return NULL;
  }

}
