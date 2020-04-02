<?php
namespace EKF_Functions\Inc\Common\EkfAcf\Components;
use StoutLogic\AcfBuilder\FieldsBuilder as FieldsBuilder;

class GeneralEmbed {

  public static function create($defaultType = 'video') {

    $builder = new FieldsBuilder('Embed Fields');
    $builder
    ->addField('Embed Code' , 'acf_code_field' , ['placeholder' =>'Enter Embed code here'])
    ->addField('embedcol1' , 'column',  ['column-type' => '1_2'])
    ->addRadio('embed_type'  , ['label' =>'Embed Type'])
    ->  addChoices(['standard' => "Standard"],['video' => "Video"], ['short' => "Short"])
    ->addField('embedcol2' ,  'column', ['column-type' => '1_2'])
    ->addRadio('embed_size'  , ['label' =>'Embed Size'])
    ->addChoices(['small' => "Small"], ['normal' => "Normal"], ['full' => "Full"])
    ->addField('embedcolreset' , 'column',  ['column-type' => '1_1']);

    if ($defaultType != 'video') {
      $builder ->modifyField('embed_type', ['default_value' => $defaultType]);
    }

    return $builder;
  }
  public static function createGroup() {
    $group =  new FieldsBuilder('Embed Group');
    $group
      ->addGroup("Embed")
      ->addFields(self::create());
    return $group;
  }

}