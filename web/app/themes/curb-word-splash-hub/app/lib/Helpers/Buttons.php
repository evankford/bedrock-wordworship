<?php

namespace App\Lib\Helpers;
use Samrap\Acf\Acf;
use Roots\Sage\Container;

class Buttons {
	/**
		* Constructor for imager
		* @param string|object|int $img
	 	*	@param array $args
		* @param bool $render
	 */
  function __construct() {

  }
  public static function startWrap($classes='', $align="center") {
    echo "<div class=\"button-wrap {$classes} align--{$align}\">";
  }
  public static function endWrap() {
    echo "</div>";
  }

  public static $defaults = ['icon' => 'facebook', 'URL' => 'https://example.com', 'Title' => 'Button Text', 'External' => true, 'lightbox' => false];

  public static function single($args = [], $classes ="") {
    $props = array_merge(self::$defaults, $args);

    $clean = strtolower(str_replace('icon-', '', $props['icon']));
    $visibleTitle = "<span data-text=\"{$props['Title']}\" class=\"button__text\">{$props['Title']}</span>";
    if (gettype($clean) === 'string' &&  strlen($clean) > 0) {
      $icon = "<i class=\"icon-{$clean}\"></i> ";
    }

    $ext = '';
    if ($props['External']) {
      $ext = ' target="_blank" rel="nofollow"';
    }

    $dl = '';
    if ($props['Download']) {
      $ext = ' download ';
    }

    $lb = '';
    if ($props['lightbox'] == true) {
      $lb = 'data-lightbox-button';
    }

    echo "<a href=\"{$props['URL']}\" data-lightbox-button class=\"button {$classes}\" title=\"{$props['Title']}\" {$ext} {$dl}>{$icon}{$visibleTitle}</a>";
  }
}