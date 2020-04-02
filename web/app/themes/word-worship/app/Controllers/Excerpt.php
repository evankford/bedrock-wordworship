<?php

namespace App\Controllers;

use Sober\Controller\Controller;
// use Samrap\Acf\Acf;
use App\Imager;

class Excerpt extends Controller
{
   public static function background() {
      global $post;
      $img =  get_post_thumbnail_id($post->ID);
      new Imager($img, ['is_bg'=>true, 'classes'=>'', 'max_width' => 1200], true);
   }
}
