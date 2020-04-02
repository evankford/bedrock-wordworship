<?php
namespace EKF_Functions\Inc\Common\EkfAcf\Components;
use StoutLogic\AcfBuilder\FieldsBuilder as FieldsBuilder;
use EKF_Functions\Inc\Common\EkfAcf\Components\IconLink;

class GeneralText {
  function __construct() {

  }
  public static function createFields($args=  ['lightbox_button' => false]) {
    $builder = new FieldsBuilder('Button');
    $builder
    ->addRadio('text_align', ['label'=>"Text Alignment", 'layout'=>"horizontal", "ui" => 1])
    ->addChoices(['left' => "Left"], ['center' => "Center"], ['right'=>"Right"])
    ->addFlexibleContent('text_content', ["label" => "Content", "min-rows"=> 1])
      ->addLayout('Header')
          ->addText("Text")
          ->addField('contcol1', 'column', ['column-type'=>"1_2"])
          ->addSelect("Size")
            ->addChoices(["small" => "Small"],["standard"=>"Standard"], ["large"=> "Large"])
          ->addField('contcol2', 'column', ['column-type'=>"1_2"])
          ->addTrueFalse('use_label_style', ["label" => "Use Label Style", "instructions"=> "Usually capitalizes and demphasizes the text"])
          ->addField('contcolreset', 'column', ['column-type'=>"1_1"])
      ->addLayout('WYSIWYG')
          ->addWysiwyg('Content')

      ->addLayout('Image')
        ->addFields(GeneralImage::create())
        ->addSelect("Size")
          ->addChoices(["small" => "Small"],["standard"=>"Standard"], ["large"=> "Large"])
      ->addLayout('Buttons')
        ->addRepeater('buttons', ['label' =>'Buttons'])
          ->addFields(Button::create($args['lightbox_button'], true))
        ->endRepeater()
      ->endFlexibleContent();


    return $builder;
  }

  public static function createSimple() {
    $simple = self::createFields();
    return $simple;
  }

  public static function create($args = ['lightbox_button' => false]) {
    $builder = new FieldsBuilder('Button');
    $builder
      ->addGroup("Content")
        ->addFields(self::createFields($args));
    return $builder;
  }
}