<?php
namespace App;
use App\Imager;
use App\Lib\Helpers\Buttons;
use App\Lib\Helpers\AOS;

class Galleryer {
	static $defaults = [
		'is_swiper' => false
	];
	/**
		* Constructor for imager
		* @param string|object|int $img
	 	*	@param array $args
		* @param bool $render
	 */
  function __construct($obj) {

		$this->props = self::$defaults;
		$this->obj = $obj;

		$this->aos = new AOS();

		if ($this->obj['layout'] == 'swiper') { $this->props['is_swiper'] = true ;}

	 }

	public static function renderItemHeader($item) {
		$output = '';
		if ($item['Introduction'] != false || $item['Title'] != false) {
			$output .= "<h4 class=\"label gallery-item__header\"> ";
			if ($item['Introduction'] != false) {
				$output .= "<span class=\"pre-label\">{$item['Introduction']}</span>";
			}
			if ($item['Title'] != false) {
				$output .= "<span>{$item['Title']}</span>";
			}
			$output .="</h4>";
		 }
		 return $output;
	}

	 public static function renderGalleryItem($item) {
		  // .gallery-item__header+.gallery-item__main+.gallery-item__footer
		$layout = $item['acf_fc_layout'];

    $header = self::renderItemHeader($item);

    $content ='';

    if ($layout == 'Video') {
      $vid = new Videoer($item['Video']);
      $content = $vid->return();
    }
    if ($layout == 'Image') {
      $imgArgs = array('downloader' => $item['Image']['downloader']);
      $img = new Imager($item['Image']['image'], $imgArgs, false);
      $content = $img->return();
    }
    if ($layout == 'Embed') {
    	$embed = new Embedder($item['Embed']);
      $content = $embed->return();
		}

		if ($item['Content']) {
			$content.="<div class=\"rte gallery-text\">{$item['Content']}</div>";
		}

    $footer = '';
    if ($item['buttons']) {
      if (gettype($item['buttons']) == "Array") {
        Buttons::startWrap();
        foreach($item['buttons'] as $button) {
          Buttons::single($button);
        }
        Buttons::endWrap();
      }
    }

    $markup ="<div class=\"gallery-item__inner layout--{$layout}\">
              {$header}
              <div class=\"gallery-item__content\">{$content}</div>
              <div class=\"\">{$footer}</div>
              </div><!-- end .gallery-item__inner-->";

    return $markup;
	 }

	 public function swiperModule() {
		$swiperModule = "";
		if ($this->props['is_swiper']) {
			$swiperModule = ' data-module="gallery-swiper" ';
		}
		return $swiperModule ;
	 }

	 public function renderGallery() {



    $gallery.= "<div class=\"gallery layout--{$this->obj['layout']} swiper-container\" data-module=\"gallery\" data-layout=\"{$this->obj['layout']}\" {$this->swiperModule()}>";
    $gallery .= "<div class=\"gallery__inner swiper-wrapper\">";
    $content = $this->obj['content'];
    foreach ($content as $item) {
      $gallery.="<div {$this->aos->increment()} class=\"swiper-slide gallery-item size--{$item['item_size']}\">";
        $gallery.= self::renderGalleryItem($item);
      $gallery.="</div><!--end .gallery-item-->";
    }
    $gallery .= "</div><!--end .gallery__inner--></div><!--end .gallery-->";
    return $gallery;
	 }

}