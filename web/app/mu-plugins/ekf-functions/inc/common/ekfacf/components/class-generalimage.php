<?php
namespace EKF_Functions\Inc\Common\EkfAcf\Components;
use StoutLogic\AcfBuilder\FieldsBuilder as FieldsBuilder;

class GeneralImage {
  function __construct() {

  }

  public static function createFields($bg = false) {
     $builder = new FieldsBuilder('Image Fields');
      $builder
        ->addField('ImageColImages', 'column', ['column-type' => '2_3'])
        ->addImage('image', ["label" => "Main Image", 'preview_size' => '600w'])
        ->setInstructions('Make sure to include alt text with this image!')
        ->addImage('Mobile Image')
        ->addField('ImageColSettings', 'column',  ['column-type' => '1_3'])
        ->addTrueFalse('rellax', ['label' => 'Enable Scrolling Effect?'])
        ->addTrueFalse('downloader', ['label' => 'Enable Image Download?'])
        ->addField('ImageColReset', 'column', ['column-type' => '1_1']);
      return $builder;
  }

  public static function createSimple() {
    $simple = self::createFields();

    $simple
    ->removeField('ImageColImages')
    ->removeField('rellax')
    ->removeField('ImageColSettings')
    ->removeField('ImageColReset')
    ->removeField('Mobile Image');

    return $simple;
  }

  public static function create($bg = false) {
    $builder = new FieldsBuilder('Image');
    $builder

      ->addGroup('Image')
        ->addFields(self::createFields($bg));
    return $builder;
  }
}