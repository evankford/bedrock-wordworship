<?php


namespace EKF_Functions\Inc\Common\EkfAcf\Views;
use StoutLogic\AcfBuilder\FieldsBuilder as FieldsBuilder;

use EKF_Functions\Inc\Common\EkfAcf\Components;

class Site {
  function __construct() {


  }
  public static function create() {
    $builder = new FieldsBuilder('footer', ['label' => 'Global Options', 'display' => 'seamless', 'position' => 'acf_after_title']);

		$builder
			->addTab("Headers")
        ->addImage('header_logo', ['title'=>'Header Logo'])
        ->addRepeater('Buttons')
					->addFields(Components\Button::create())
					->setInstructions('Add links to websites, tours, etc')
					->endRepeater()
				->addRepeater('Social Links')
					->addFields(Components\IconLink::create())
					->endRepeater()
			->addTab("Footer")
				->addImage('footer_logo', ['title'=>'Footer Logo'])
				->addUrl('home_url', ['title'=>'Home URL', 'default_value'=>'https://curb.com'])
				->addText('Copyright Text')
        ->addTrueFalse('Enable Footer Menu')
      ->AddTab('Fallbacks')
        ->addText('no_releases', ['label' => 'No Release Text', 'default_value'=>"No Releases"])
      ->setLocation('options_page' , '==', 'site-options');


      return $builder;
  }

}

