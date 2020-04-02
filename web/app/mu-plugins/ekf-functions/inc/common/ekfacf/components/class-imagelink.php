<?php
namespace EKF_Functions\Inc\Common\EkfAcf\Components;
use StoutLogic\AcfBuilder\FieldsBuilder as FieldsBuilder;
use EKF_Functions\Inc\Common\EkfAcf\Components\LinkGeneral;


class ImageLink {
  function __construct() {

  }
  public static function create() {
    $builder = new FieldsBuilder('Button');
		$builder
    	->addImage('Image')
				->setRequired()
			->addFields(Components\LinkGeneral::create());
    return $builder;
  }
}