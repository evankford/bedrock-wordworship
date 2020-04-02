<?php


namespace EKF_Functions\Inc\Common\EkfAcf\Views;
use StoutLogic\AcfBuilder\FieldsBuilder as FieldsBuilder;

use EKF_Functions\Inc\Common\EkfAcf\Components;

class Home {
  function __construct() {

  }
  public static function create() {
   $builder = new FieldsBuilder('Sitewide Options', ['style' => 'seamless', 'position' => 'acf_after_title']);
		$builder
			->addImage('frontpage_logo', ['label'=> "Logo"])->setRequired()
			->addImage('background_image', ['label'=> "Background Image"])->setRequired()
			->addTrueFalse('show_artists', ['label'=> "Show Artists"])
			->addText('artist_header', ['label'=> "Artist Header"])
				->setRequired()
				->setDefaultValue('Artists')
				->conditional('show_artists', '==', 1)
			->addTrueFalse('show_releases', ['label'=> "Show Releases"])
			->addText('releases_header' , ['label'=> "Releases Header"])
				->setRequired()
				->setDefaultValue('Recent Releases')
				->conditional('show_releases', '==', 1)
			->setLocation('page', '==', 'curb-word-content-dashboard');

    return $builder;

  }

}

