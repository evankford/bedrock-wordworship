<?php
namespace EKF_Functions\Inc\Common\EkfAcf\Components;
use StoutLogic\AcfBuilder\FieldsBuilder as FieldsBuilder;

class LinkGeneral {
  function __construct() {

  }
  public static function create() {
     $builder = new FieldsBuilder('General Link');
  $builder
			->addUrl('URL')
				->setRequired()
			->addText('Title')
				->setRequired()
			->addTrueFalse('External')
				->setInstructions('Open link in new tab?');

    return $builder;
  }
}