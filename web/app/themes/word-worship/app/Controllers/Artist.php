<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use WP_Query;
use Samrap\Acf\Acf;
use App\Imager;
use App\Lib\Helpers\Icons;
use App\Lib\Helpers\Buttons;

class Artist extends Controller
{
  public static function id() {
    global $post;
    $id = $post->ID;
    if ($post->post_type == 'release') {
      $id = ACF::field('release_artist')->get()->ID;
    }
    return $id;
  }

  public static function background() {
    global $post;
      $img =  get_post_thumbnail_id($post->ID);
      new Imager($img, ['is_bg'=>true], true);
   }
  public static function logo($classes = '') {
    $img = ACF::field('Artist Logo')->id(self::id())->get();
    new Imager($img, ['is_bg' => false, 'classes' => $classes, 'max_width'=>1200, 'rellax'=>false]);
  }

   public static function icons() {
      $icons = ACF::field('Social Links')->id(self::id())->get();
      if (sizeof($icons) > 0) {
        Icons::startWrap();
          foreach($icons as $icon) {
            Icons::single($icon);
          }
        Icons::endWrap();
      }
  }

  public static function links() {
    $links = ACF::field('Buttons')->id(self::id())->get();
    if (sizeof($links) > 0) {
      Buttons::startWrap();
        foreach ($links as $link) {
          Buttons::single($link);
        }
      Buttons::endWrap();
    }
  }

  public static function fallback() {
    return '<h3 class="fallback-text">' . Acf::option('no_releases')->default('No Current Releases')->get() . '</h3>';
  }

  public static function releases() {
    $args = [
      'numberposts' => -1,
      'post_type' => 'release',
      'meta_key' => 'release_artist',
      'meta_value'=> self::id()
    ];
    $releaseQuery = new WP_Query($args);

    return $releaseQuery;
  }
}
