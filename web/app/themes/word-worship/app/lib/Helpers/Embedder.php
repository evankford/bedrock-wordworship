<?php
namespace App;
use Samrap\Acf\Acf;
use Roots\Sage\Container;
use App\Lib\Helpers\Buttons;


class Embedder {
	static $defaults = [

	];
	/**
		* Constructor for imager
		* @param string|object|int $img
	 	*	@param array $args
		* @param bool $render
	 */
  function __construct($content) {
    $this->props = array_merge(self::$defaults, $content);
    $this->code = $content['Embed Code'];
    $this->type = $content['embed_type'];
    $this->size = $content['embed_size'];
   }

	public function return() {
    $output = "<div class=\"embed-wrap type--{$this->type} size--{$this->size} \">{$this->code}</div>";
    return $output;
	}
}