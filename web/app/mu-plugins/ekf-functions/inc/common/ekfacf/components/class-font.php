<?php
namespace EKF_Functions\Inc\Common\EkfAcf\Components;
use StoutLogic\AcfBuilder\FieldsBuilder as FieldsBuilder;
use EKF_Functions\Inc\Common\EkfAcf\Components\IconLink;

class Font {
  function __construct() {

  }
  public static function create() {
   $builder = new Fieldsbuilder('Fonts');
		$builder
			->addText('Font Family', ['placeholder' => 'font-family-slug, Helvetica, arial, sans-serif'])
				->setInstructions('Best used straight from google fonts/adobe fonts!')
			->addSelect('Font Weight')
				->setRequired()
				->addChoices('100', '200', '300', '400','500','600','700','800','900')
				->setDefaultValue('400')
				->conditional('Font Family', '!=' , '')
			->addRadio('Font Style')
				->setRequired()
				->addChoices('Normal', 'Italic')
				->conditional('Font Family', '!=' , '');
    return $builder;
  }
}