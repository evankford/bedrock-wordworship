<?php
namespace EKF_Functions\Inc\Common\EkfAcf\Components;
use StoutLogic\AcfBuilder\FieldsBuilder as FieldsBuilder;
use EKF_Functions\Inc\Common\EkfAcf\Components\IconLink;
use EKF_Functions\Inc\Common\EkfAcf\Components\Font;

class Branding {
  function __construct() {

  }
  public static function create() {
    $builder = new FieldsBuilder('Branding');
		$builder
			->addMessage('Instructions', "This is the section for overriding Artist and Theme default styling for this specific release. When in doubt, leave these settings empty, so they'll use the site/artist defaults!")
			->addAccordion('Fonts',  ['wrapper' => ['class' => 'ekf-acf__message']])
			->addField('Font Embed Code' , 'acf_code_field' , ['placeholder' =>'Google/Adobe fonts code here'])
			->addGroup('Primary Font', ['layout' => 'row'])
				->addFields(Font::create())
				->setInstructions('Select a font to be used for body text')
				->endGroup()
			->addGroup('Header Font', ['layout' => 'row'])
				->addFields(Font::create())
				->setInstructions('Select a font to be used for Headers')
				->endGroup()
			->addGroup('Extra Font', ['layout' => 'row'])
				->addFields(Font::create())
				->setInstructions('Select a font to be used for Extra-large headers and buttons')
				->endGroup()
			->addAccordion('Colors',   ['wrapper' => ['class' => 'ekf-acf__message']])
			->addColorPicker('Background Color', ['default' =>'#fafafa'])
			->addColorPicker('Text Color', ['default'=>'#3f3f3f'])
			->addColorPicker('Accent Color', ['default' => 'd47b0b'])
			->addColorPicker('Accent Inverse Color', ['default', '#2f2f2f'])
				->setInstructions('Should be a color with sufficient contrast from the Accent color!')
			->addAccordion('Styles',  ['wrapper' => ['class' => 'ekf-acf__message']])
			->addSelect('Header Style')
				->addChoices('Standard', 'Large', "All Caps", 'All Caps - Spaced')
			->addSelect('Button Text Style')
				->addChoices('Standard', 'Large', "All Caps", 'All Caps - Spaced')
			->addSelect('Button Style')
				->addChoices('Standard', 'Bordered', "Minimal")
			->addSelect('Button Font')
				->addChoices('Body', 'Header', "Extra")
			->addField('Custom CSS' , 'acf_code_field', ['placeholder' => 'Insert HTML/CSS/JS'])
				->setInstructions('Use with caution, outputs directly in the page!');
    return $builder;
  }
}