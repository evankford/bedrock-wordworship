<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use Samrap\Acf\Acf;
use App\Imager;

class Footer extends Controller
{
  public static function logo() {
    $img =  Acf::option('footer_logo')->get();
    $url = Acf::option('home_url')->get();
    if ($url) {
      echo "<a href=\"{$url}\">";
    }
    new Imager($img, ['is_bg'=>false, 'classes'=>'footer-logo', 'max_width' => 750], true);
    if ($url) {
     echo "</a>";
    }
  }
  public static function copyright() {
    return Acf::option('Copyright Text')->default('. All Rights Reserved')->escape()->get();

  }
}