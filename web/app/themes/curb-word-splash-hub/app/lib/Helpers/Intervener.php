<?php
namespace App;
use function \Sober\Intervention\intervention;

class Intervener {

  // Clean up all the admin
  function __construct() {
    self::init();
	}

	 public static function init() {
		 if (function_exists('\Sober\Intervention\intervention')) {
			 // now you can use the function to call the required modules and their params
			//  echo '<div style="display:none;">S</div>'; // Fixies the ajax error, somehow?
			intervention('add-svg-support');
			intervention('remove-howdy');
			intervention('remove-taxonomies');
			intervention('remove-help-tabs');
			intervention('remove-page-components');
			intervention('remove-menu-items', ['danger-zone',  'pages', 'acf']);
			intervention('remove-menu-items', ['posts'], 'all');
			intervention('update-pagination');
			intervention('remove-update-notices');
			intervention('remove-toolbar-items');
			intervention('remove-widgets');
			intervention('remove-dashboard-items', array('right-now', 'incoming-links', 'quick-draft', 'drafts', 'news', 'ogf-rss-feed'));
		}

  }
}