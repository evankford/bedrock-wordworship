<?php

namespace App\Lib\Helpers;
use Samrap\Acf\Acf;
use Roots\Sage\Container;

class Icons {
	/**
		* Constructor for imager
		* @param string|object|int $img
	 	*	@param array $args
		* @param bool $render
	 */
  function __construct() {

  }
  public static function startWrap($classes='') {
    echo "<ul class=\"social-wrap {$classes}\">";
  }
  public static function endWrap() {
    echo "</ul>";
  }

  public static function single($args = ['icon' => 'facebook', 'URL' => 'https://example.com', 'Title' => 'On Facebook', 'External' => true, 'Show Title' => false]) {
    $clean = strtolower(str_replace('icon-', '', $args['icon']));
    if ($args['Show Title']) {
      $visibleTitle = " <span class=\"icon__text\">{$args['Title']}</span>";
    } else {
      $visibleTitle="";
    }

    $ext = '';
    if ($args['External']) {
      $ext = ' target="_blank" rel="nofollow"';
    }

    echo "<li>";
      echo "<a href=\"{$args['URL']}\" class=\"icon\" title=\"{$args['Title']}\" {$ext}><i class=\"icon-{$clean}\"></i>{$visibleTitle}</a>";
    echo "</li>";
  }
}