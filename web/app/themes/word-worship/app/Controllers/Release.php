<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use WP_Query;
use Samrap\Acf\Acf;
use App\Imager;
use App\Lib\Helpers\Icons;
use App\Lib\Helpers\Buttons;
use App\ReleaseSection;

class Release extends Controller
{
  public static function artist() {

    $artistId = Acf::field('Artist')->get();
    $title = get_the_title($artistId);
    return $title;
  }
  public static function date() {

    $date = Acf::field('release_date')->get();
    if ($date) {
      return __("Release Date: ") . $date;
    } else {
      return;
    }
  }

  public static function checkDate($startTime = false, $endTime = false) {

    if (!$startTime && !$endTime) {
      return true;
    }
    $now = strtotime("now");
    $dateQuery = false;
    if (isset($_GET['previewDate'])) {
      $dateQuery = $_GET['previewDate'];
    }
    if (strtolower($dateQuery) === 'all') {
      return true;
    } elseif ($dateQuery && date_parse($dateQuery)) {
      $now = strtotime($dateQuery);
    }
    //Check start time
    if ($startTime && $startTime >= $now) {
      // echo 'The start time is still upcoming for this section!';
      return false;
    }

    if ($endTime && $endTime < $now) {
      // echo 'The end time has passed for this section';
      return false;
    }
    return true ;
  }




  public static function get_content() {
    return Acf::field('content')->get();
  }

  public static function section($section, $index) {
    $sectionObject = new ReleaseSection($section,$index);
    $dateStatus = self::checkDate($sectionObject->start, $sectionObject->end);
    //Hide if date status fails
    //Date status checks for the "previewDate" query string ("All"|"Y-m-d"), or uses now
    if ($dateStatus > 0) {
      $sectionObject->render();
    }
  }
}
