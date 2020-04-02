<?php
namespace EKF_Functions\Inc\Common\EkfAcf\Components;
use StoutLogic\AcfBuilder\FieldsBuilder as FieldsBuilder;
use EKF_Functions\Inc\Common\EkfAcf\Components\IconLink;

class Button {
  function __construct() {

  }
  public static function create($lightboxOption = false, $downloadOption = false) {
    $builder = new FieldsBuilder('Button');
		$builder
    ->addFields(IconLink::create())
    ->modifyField('icon', ['required'=> false, 'instructions' => 'Not required. Use to add an icon at the beginning of the button!', 'allow_null' => true])
    ->removeField('Show Title');
    if ($lightboxOption == true ) {
      $builder->addTrueFalse('lightbox', ["label"=> "Open Lightbox?", "instructions" => "Opens video/image in a lightbox"])
      ->removeField('URL')
      ->addURL('URL', ['instructions'=>'To add a zip file, upload it under MEDIA, then copy the URL here!'])->setRequired()->conditional('lightbox', '==', "0");
    }
    if ($downloadOption == true ) {
      $builder
      ->addTrueFalse('Download')
				->setInstructions('Download File?');
    }
    return $builder;
  }
}