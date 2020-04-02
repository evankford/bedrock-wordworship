<?php
namespace EKF_Functions\Inc\Common\EkfAcf\Components;
use StoutLogic\AcfBuilder\FieldsBuilder as FieldsBuilder;

class GeneralVideo {
  function __construct() {

  }




  public static function createFields($bg= false) {
    $builder = new FieldsBuilder('Video Fields');
    $builder
      ->addField('vidcol1', 'column', ['column-type' => '1_2'])
      ->addSelect('type', ['label'=>'Video Type'])
        ->addChoices('URL', 'Upload')
      ->addUrl('url', ['label' => "URL", 'instructions'=>'Only a valid youtube or vimeo URL please!'])
        ->conditional('type', '==', 'URL')
      ->addFile('mp4', ['label'=>"MP4 Video File", "required"=> 1, "mime_types"=>"mp4"])
        ->conditional('type', '==', 'Upload')
      ->addFile('webm', ['label'=>"Webm Video File",  "mime_types"=>"webm"])
        ->conditional('type', '==', 'Upload')
      ->addField('vidcol2', 'column', ['column-type' => '1_2'])
        ->addImage('Fallback Image', ["instructions"=>'Make sure to include alt text with this image!', "required"=>1])
        ->addImage('Fallback GIF')
        ->addTrueFalse('play', ["label"=> "Play Background Video", "default_value" => true])
        ->addRange('start', ['label'=>'Start Time','min'=> 0, 'max'=> 100, 'default' => 0, 'step'=>1, 'append'=>' Seconds'])
        ->addRange('end', ['label'=>'End Time','min'=> 0, 'max'=> 1000, 'default' => 0, 'step'=>1, 'append'=>' Seconds', 'instructions'=>'Set to 0 to end at the end of the video!' ])
        ->addTrueFalse('rellax', ['label' => 'Enable Scrolling Effect?'])
        ->addTrueFalse('downloader', ['label' => 'Enable Download Button?'])
          ->conditional('type' , '==', 'Upload');
      $builder
        ->addField('vidcolreset', 'column', ['column-type'=>'1_1']);
      return $builder;
  }

  public static function createSimple() {
    $simple = self::createFields(false);
    $simple
      ->removeField('mp4')
      ->removeField('webm')
      ->removeField('downloader')
      ->modifyField('type', function($new) {
        $new
        ->modifyField('type', ['choices'=>'Upload', 'required' => 1])
        ->addFile('mp4', ['label'=>"MP4 Video File", "required"=> 1, "mime_types"=>"mp4"])
        ->addTrueFalse('downloader', ['label' => 'Enable Download Button?', 'default' =>true]);
        return $new;
      })
      ->modifyField('play', ["default_value" => false])
      ->removeField('url')
      ->removeField('start')
      ->removeField('end')
      ->removeField('rellax');

    return $simple;
  }

  public static function create($bg= false) {
    $builder = new FieldsBuilder('Video');
    $builder
    ->addGroup('video')
      ->addFields(self::createFields($bg));
    return $builder;
  }
}