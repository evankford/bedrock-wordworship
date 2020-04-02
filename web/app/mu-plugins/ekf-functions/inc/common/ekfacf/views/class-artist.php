<?php


namespace EKF_Functions\Inc\Common\EkfAcf\Views;
use StoutLogic\AcfBuilder\FieldsBuilder as FieldsBuilder;

use EKF_Functions\Inc\Common\EkfAcf\Components;

class Artist {
  function __construct() {

  }
  public static function create() {
   $builder = new FieldsBuilder('Artist Options', ['style' => 'seamless', 'position' => 'acf_after_title']);
		$builder
			->addTab('Details')
			->addImage('Artist Logo')->setRequired()

			->addTab('Links')
				->addRepeater('Buttons')
					->addFields(Components\Button::create())
					->setInstructions('Add links to websites, tours, etc')
					->endRepeater()
				->addRepeater('Social Links')
					->addFields(Components\IconLink::create())
					->endRepeater()
			->addTab('Branding')
				->addFields(Components\Branding::create())
        ->setLocation('post_type' ,'==' , 'artist');

    return $builder;

  }

}

