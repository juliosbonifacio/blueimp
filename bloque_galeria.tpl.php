<?php

/**
 * @file
 * tpl file for theming a single menu dropdown link
 *
 * Available variables:
 * - $link: The href for the link
 * - $title: Title to be displayed for the link
 * - $content: The content inside the dropdown
 * - $mlid: The unique id of the menu
 */


?>




     
  <div class="galeritopia">
    <ul class="fotosinner">
          <?php $counter = 0; ?>
          <?php foreach ($data as $key => $value) : ?>
            

            <?php  if (($counter +1 % 8) == 0): ?>
            <li id="blockfotos<?php ($counter ==0) ? print $counter : print $counter - 7 ; ?>" class="blockfotos">
             <?php  endif ; ?>  


              <div class="col-sm-3 <?php print $counter; ?>">
                     <?php  if($value['url_youtube']==NULL) : ?>
                          <a data-gallery="#blueimp-gallery" href="<?php print image_style_url("slide_portada", $value['url_imagen']);?>">      
                          <img alt="" src="<?php print image_style_url("large", $value['url_imagen']);?>" />    
                          </a>
                     <?php  else : ?>

                          <a data-gallery="#blueimp-video-carousel" data-poster="<?php print image_style_url("slide_portada", $value['url_imagen']);?>" data-youtube="<?php print $value['key_youtube'];?>"
                          href="<?php print $value['url_youtube'];?>" title="Video" type="text/html"> 
                          <img alt="" src="<?php print image_style_url("large", $value['url_imagen']);?>" />
                          </a>

                   <?php  endif ; ?>     
             </div>

            <?php  if ($counter > 0 && ($counter +1  % 8) == 0): ?>
            </li>
            <?php  endif ; ?> 
         
            <?php  $counter ++ ; ?> 

          <?php endforeach; ?>
    </ul>
</div>


