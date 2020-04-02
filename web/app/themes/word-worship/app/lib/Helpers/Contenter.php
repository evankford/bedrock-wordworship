<?php
namespace App;
use App\Lib\Helpers\Buttons;
use App\Lib\Helpers\AOS;


class Contenter {
	static $defaults = [
		'text_align' => "center", //Add scroll effect
    'text_content' => []//Add scroll effect,
	];
	/**
		* Constructor for imager
		* @param string|object|int $img
	 	*	@param array $args
		* @param bool $render
	 */
  function __construct($content, $render = false) {
    $this->props = array_merge(self::$defaults, $content);

    if (gettype($this->props['text_align']) == "array") {
      if (sizeof($this->props['text_align']) == 0) {
        $this->props['text_align'] = 'center';
      } else {
        $this->props['text_align'] = $this->props['text_align'][0];
      }
    }

    $this->aos = new AOS();
  }


  public function renderHeader($content) {
    $label_class = "";
    if ($content['use_label_style']) {
      $label_class = "label";
    }
    $output = '';
    switch($content['Size']) {
      case "small" :
        $output = "<h4 {$this->aos->increment()} class=\"{$label_class}\">{$content['Text']}</h4>";
      break;
      case "standard" :
        $output =  "<h3 {$this->aos->increment()} class=\" h2 {$label_class}\">{$content['Text']}</h3>";
      break;
      case "large" :
        $output =  "<h2 {$this->aos->increment()} class=\" h1 mega {$label_class}\">{$content['Text']}</h2>";
      break;
    }
    return $output;
  }

  public function renderWysiwyg($content) {
    $output = "<div class=\"rte\">{$content['Content']}</div>";
    return $output;
  }
  public function renderImage($content) {
    $img = new Imager($content["Image"]['image'], ["max_width" => 1200, "classes" => "text-image size--{$content['Size']}", "rellax" => $content['Image']['rellax'], "downloader" => $content['Image']['downloader'], "Mobile Image" => $content['Image']['Mobile Image']], false);
    $output = "<div {$this->aos->increment()} class=\"text-image__wrap\">{$img->return()}</div>";
    return $output;
  }

  public function renderButtons($content) {
    ob_start();
    echo "<div class=\"button-wrap\" {$this->aos->increment()}>";
    foreach($content['buttons'] as $button) {
    Buttons::single($button);
    }
    Buttons::endWrap();
    return ob_get_clean();
  }


	public function return() {
    $output = "<div class=\"text-content align--{$this->props['text_align']}\">";
    foreach ($this->props['text_content'] as $content) {
      $layout = handleize($content['acf_fc_layout']);
        switch($layout) {
          case "header" :
            $output .= $this->renderHeader($content);
          break;
          case "wysiwyg" :
            $output .= $this->renderWysiwyg($content);
            break;
          case "image" :
            $output .= $this->renderImage($content);
            break;
          case "buttons" :
            $output .= $this->renderButtons($content);
            break;
        }
      }
    $output .='</div>';
		return $output;
	}
}