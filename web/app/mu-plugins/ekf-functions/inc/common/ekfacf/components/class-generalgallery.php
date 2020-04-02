<?php
namespace EKF_Functions\Inc\Common\EkfAcf\Components;
use StoutLogic\AcfBuilder\FieldsBuilder as FieldsBuilder;

class GeneralGallery {
  public static function create($bg = false) {
    $builder = new FieldsBuilder('Gallery Content');
    $builder
      ->addFlexibleContent('content', ['button_label' => 'Add Content'])
        ->addLayout(self::createLayout("Image"))
        ->addLayout(self::createLayout("Video"))
        ->addLayout(self::createLayout("Embed"))
      ->endFlexibleContent();

    return $builder;
  }

  public static function createLayout($type) {
    $builder = new FieldsBuilder($type);
    $builder
      ->addTab("Content")
        ->addField('contcol1', 'column', ['column-type'=>"1_2"]);

     if ($type == 'Video') {
       $vidFields = GeneralVideo::createSimple();
       $vidFields
       ->modifyField('downloader', ['default_value'=> 1]);
       $builder->addGroup('Video')
       ->addFields($vidFields);
      }
      if ($type == 'Embed') {
        $builder->addGroup('Embed')
        ->addFields(GeneralEmbed::create([$default_type = 'standard']));
      }
      if ($type == 'Image') {
        $imgFields = GeneralImage::createSimple();
        $imgFields
        ->modifyField('downloader', ['default_value'=> 1]);
        $builder
        ->addGroup('Image')
        ->addFields($imgFields);
      }
    $builder
      ->addField('contcol2', 'column', ['column-type'=>"1_2"])
      ->addText("Introduction" , ['instructions' => "Usually just the type of media (e.g. 'Video' or 'Photo')"])
      ->addText("Title")
      ->addWysiwyg("Content", ["tabs" => "visual", "toolbar"=>"basic", "media_upload" => 0])
      ->addRepeater('buttons', ['label' => "Buttons", 'instructions' => "Feel free to leave this empty in most cases! This places buttons below the gallery item" ,"max_rows", "layout"=> "block"])
        ->addFields(Button::create())
      ->endRepeater()
      ->addField('contcolreset', 'column', ['column-type'=>"1_1"])
      ->addTab("Settings")
        ->addRadio('item_size', ['label' => "Gallery Item Size", "instructions" => "Useful for setting relative sizes (videos should be larger than photos, and logos smaller, for instance)", "default_value" => "standard"])
        ->addChoices([["small" => "Small (logos, liners, etc.)"], ["standard"=>"Standard (Photos)"], ["large"=>"Large (Videos + Featured Photos)"], ["full"=>"Full Size (Rarely used for banners"]]);

      if ($type = 'Video') {
        $builder->modifyField('item_size', ['default_value'=>"large"]);
      }
      if ($type = 'Embed') {
        $builder->modifyField('item_size', ['default_value'=>"small"]);
      }

    return $builder;
  }
}