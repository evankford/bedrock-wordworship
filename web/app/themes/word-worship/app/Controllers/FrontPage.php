<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use Samrap\Acf\Acf;
use App\Imager;

class FrontPage extends Controller
{
  public static function id() {
    return  get_option( 'page_on_front' );
  }
  public static function background() {
    $img = ACF::field('background_image')->id(self::id())->get();
    new Imager($img, ['is_bg' => true]);
  }
  public static function mainImage($classes) {
    $img = ACF::field('frontpage_logo')->get();
    new Imager($img, ['is_bg' => false, 'classes' => $classes, 'max_width'=>1200]);
  }
  public static function artistsActive() {
      return ACF::field('show_artists')->get() > 0;
  }
  public static function releasesActive() {
      return ACF::field('show_releases')->get() > 0;
  }
  public static function artistsHeader() {
      return ACF::field('artist_header')->get();
  }
  public static function releasesHeader() {
      return ACF::field('releases_header')->get();
  }
}
