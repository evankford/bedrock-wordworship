<?php
namespace EKF_Functions\Inc\Common\EkfAcf\Components;
use StoutLogic\AcfBuilder\FieldsBuilder as FieldsBuilder;

class GeneralSettings {
  function __construct() {

  }
  public static function create() {
    $builder = new FieldsBuilder('Settings');
    $builder
    ->addField('settingscol1', 'column', ['column-type'=>'1_2'])
    ->addColorPicker('Content Background Color' , ['instructions' => "Leave blank to use default"])
    ->addColorPicker('Content Text Color', ['instructions' => "Leave blank to use default"])
    ->addField('settingscol3', 'column', ['column-type'=>'1_2'])
    ->addText('id', ['label' => "ID", 'instructions' => "A unique ID to use for custom styling. Developer use only!"])
    ->addDateTimePicker('Enable Date', ['instructions' => "Section will show after this date, unless the disable date below has passed!", 'display_format' => 'm/d/Y g:i a', 'return_format' => 'm/d/Y g:i a'])
    ->addDateTimePicker('Disable Date', ['instructions' => "Section will show until this date", 'display_format' => 'm/d/Y g:i a', 'return_format' => 'm/d/Y g:i a' ])
    ->addField('settingscolreset', 'column', ['column-type'=>'1_1']);
    return $builder;
  }
}