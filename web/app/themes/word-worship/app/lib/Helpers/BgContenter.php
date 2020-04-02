<?php
namespace App;
use App\Imager;
use App\Lib\Helpers\Buttons;
use App\Lib\Helpers\AOS;

class BgContenter {
  function __construct($object) {
    $this->aos = new AOS();
    $this->obj = $object;
    $this->keys = array_keys($object);
  }

  public function prepareBackground() {
    $op = $this->obj['opacity']/100;
    $bg = "<div {$this->aos::custom('fade-in', 800)} class=\"section-content__background\" style=\"opacity: {$op}\" >";
      if ($this->obj['background_type']== "Video") {
        $vidObj = array_merge($this->obj['Video'], ['fullscreen' => true, 'classes' => 'video-banner']);
        $vid = new Videoer($vidObj, false);
        $bg .= $vid->return();
      }
      if ($this->obj['background_type']== "Image") {
        $img = new Imager($this->obj["Image"]['image'], ['is_bg' => true, "rellax" => $this->obj['Image']['rellax'], "downloader" => $this->obj['Image']['downloader'], "mobile" => $this->obj['Image']['Mobile Image']],false);
        $bg .= $img->return();
      }
    return $bg.='</div><!--end __background-->';
  }


  public function prepareContent() {
    $maker = new Contenter($this->obj['Content']);
    $content = "<div class=\"section-content__content\">";
    $content .= $maker->return();
    return $content.='</div><!--end __content-->';
  }

  public function render() {

      $output = $this->prepareBackground();
      $output .= $this->prepareContent();
     return $output ;
  }
}