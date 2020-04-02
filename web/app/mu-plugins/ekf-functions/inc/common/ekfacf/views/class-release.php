<?php

namespace EKF_Functions\Inc\Common\EkfAcf\Views;
use StoutLogic\AcfBuilder\FieldsBuilder as FieldsBuilder;
use EKF_Functions\Inc\Common\EkfAcf\Components;

class Release {
  function __construct() {

  }

  public static function create() {
    $builder =  new FieldsBuilder('Release Options', ['style' => 'seamless', 'position' => 'acf_after_title']);

    $builder
    ->addTab('Content')
      ->addFlexibleContent('content', ['button_label' => 'Add Content'])
        ->addLayout(self::justImage())
        ->addLayout(self::contentOverBackground())
        ->addLayout(self::videoBanner())
        ->addLayout(self::gallery())
        ->addLayout(self::embed())
      ->endFlexibleContent()
    ->addTab('Branding')
      ->addFields(Components\Branding::create())
    ->setLocation('post_type' , '==' , 'release');

    return $builder;
  }

  public static function settings() {
    $builder = new FieldsBuilder('Release Settings', ['position'=>'side']);

    $builder
      ->addTab('Settings')
        ->addPostObject('release_artist', ['label'=>'Release Artist','required'=>1, 'post_type'=>['artist', "returns"=> 'id']])
        ->addDatePicker('release_date' , ['label'=>'Release Date','required'=>1, 'return_format' => 'F j, Y', 'display_format' => 'F j, Y'])
      ->addTab('Sections')
        ->addSelect('header_location', ['label' => 'Branding Location', 'default_value'=>'top'])
          ->addChoices(['top' => 'Top (Header)'], [ 'bottom' => 'Footer' ], ['disabled' => 'Disabled'])
      ->setLocation('post_type' ,'==' , 'release');

    return $builder;
  }

  public static function contentOverBackground() {
    $builder = new FieldsBuilder('Content Over Background');
    $builder
      ->addTab('background')
        ->addField('col1', 'column', ['column-type' => '1_2'])
          ->addRadio("background_type", ["label" => "Background Type", "layout"=>"horizontal", "stylized_ui" => 1])
            ->addChoices("Video", "Image")
        ->addField('col2', 'column', ['column-type' => '1_2'])
          ->addRange('opacity', ['label'=>"Background Opacity", "default_value" => 70, "append" => "%", "instructions" => "Set background color in the settings tab above"])
        ->addField('colreset',  'column', ['column-type' => '1_1'])
        ->addGroup("Image")
          ->conditional("background_type", "==", "Image")
          ->addFields(Components\GeneralImage::createFields(true))
        ->endGroup()
        ->addGroup("Video" , ["conditional" => [[["field"=>"background_type", "operator" => "==", "Video"]]]])
          ->conditional("background_type", "==", "Video")
          ->addFields(Components\GeneralVideo::createFields(true))
        ->endGroup()
      ->addTab('content')
        ->addFields(Components\GeneralText::create(['lightbox_button' => true]))
      ->addTab('settings')
        ->addFields(Components\GeneralSettings::create());

    return $builder;
  }
  public static function justImage() {
    $builder = new FieldsBuilder('Image Banner');
    $builder
    ->addTab('image')
      ->addFields(Components\GeneralImage::create(false))
    ->addTab('settings')
      ->addFields(Components\GeneralSettings::create());

    return $builder;
  }
  public static function videoBanner() {
    $builder = new FieldsBuilder('Video Banner');
     $builder
    ->addTab('Video')
      ->addFields(Components\GeneralVideo::create(true))
    ->addTab('Content')
      ->addGroup('Content')
      ->addFields(Components\GeneralText::create(['lightbox_button' => true]))
      ->endGroup()
    ->addTab('Settings')
      ->addFields(Components\GeneralSettings::create())
      ->addTrueFalse('Full Size Background',  ['ui' => 1, 'ui_on_text'=>'Full Size', 'ui_off_text'=>'Standard', 'default'=>0]);

    return $builder;
  }
  public static function gallery() {
    $gallery = new FieldsBuilder('Gallery');
    $gallery
     ->addTab('Header')
      ->addGroup('header', ["Label" => "Header"])
        ->addFields(Components\GeneralText::createSimple())
       ->endGroup()
    ->addTab('Gallery')
      ->addFields(Components\GeneralGallery::create(true))
    ->addTab('Settings')
      ->addRadio('layout', ["label"=>"Gallery Layout", "default_value" => "standard"])
        ->addChoices([["standard"=>"Standard"], ["swiper"=> "Slider"], ["wide", "Wide"]])
      ->addFields(Components\GeneralSettings::create());
      // ->addTrueFalse('Full Size Background',  ['ui' => 1, 'ui_on_text'=>'Full Size', 'ui_off_text'=>'Standard', 'default'=>0]);

    return $gallery;
  }
  public static function embed() {

    $builder = new FieldsBuilder('Embed');
     $builder
      ->addTab('Header')
        ->addGroup('header', ["Label" => "Header"])
        ->addFields(Components\GeneralText::createSimple())
       ->endGroup()
    ->addTab('Embeds')
      ->addFields(Components\GeneralEmbed::createGroup())
      ->addRepeater("Buttons")
        ->addFields(Components\Button::create())
      ->endRepeater()
    ->addTab('settings')
      ->addFields(Components\GeneralSettings::create())
      ->addTrueFalse('Full Size Background',  ['ui' => 1, 'ui_on_text'=>'Full Size', 'ui_off_text'=>'Standard', 'default'=>0]);

    return $builder;
  }
}