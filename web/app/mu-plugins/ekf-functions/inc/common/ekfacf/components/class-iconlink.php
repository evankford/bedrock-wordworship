<?php
namespace EKF_Functions\Inc\Common\EkfAcf\Components;
use StoutLogic\AcfBuilder\FieldsBuilder as FieldsBuilder;
use EKF_Functions\Inc\Common\EkfAcf\Components\LinkGeneral;

class IconLink {


  function __construct() {
  }

  public static $icons = [
    ['amazon' =>  'Amazon'],
    ['amazon-music' =>'Amazon Music'],
    ['apple-music' =>'Apple Music'],
    ['deezer' => 'Deezer'],
    ['doc-text' => 'Document'] ,
    ['download' => 'Download'],
    ['facebook' => 'Facebook'],
    ['google-play' => 'Google Play'],
    ['globe' => 'Globe'],
    ['instagram' => 'Instagram'],
    ['note-beamed' => 'Music Notes'],
    ['pandora' => 'Pandora'],
    ['play' => 'Play Button'],
    ['shopping-bag' => 'Shopping Bag'],
    ['basket' => 'Shopping Cart'] ,
    ['soundcloud' => 'SoundCloud'],
    ['spotify' => 'Spotify'],
    ['twitter' => 'Twitter' ],
    ['youtube' => 'YouTube']
  ];


  public static function create() {
    $builder = new FieldsBuilder('Icon Link');
    $builder
      ->addSelect('icon', ['label', 'Icon', 'ui' => true])
      ->setRequired()
      ->setInstructions('Type a few letters to search for your icon')
      ->addChoices(self::$icons)
      ->addFields(LinkGeneral::create())
      ->addTrueFalse('Show Title')
      ->setInstructions('Set to true to show title after icon. Otherwise, it will just be accessability text for screen readers');
    return $builder;
  }
}