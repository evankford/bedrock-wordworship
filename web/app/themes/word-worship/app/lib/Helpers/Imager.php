<?php

namespace App;
use Samrap\Acf\Acf;
use Roots\Sage\Container;

class Imager {
	static $defaults = array(
		'mobile'=>false, //Uses a different image on smaller screens (breakpoint in respimg.scss)
		'is_bg' => false, //Sets the image to a background with object-fit/polyfill (in respimg.scss)
		'max_width' => false, //Stops the image loading at a certain max size
		'small_width' => 300, //Small width for inital loading image, usually stays the same
		'classes' => '', //Extra classes
		'downloader' => false,//Add download link!
		'web' => false,//URL for web download, only useful if downloader is true,
		'hires' => false,//URL for high resolution download, only useful if downloader is true,
		'rellax'=>false, //Add scroll effect
		'opacity' => 100
	);

	public static $sizes = [300, 450 , 600, 750, 900, 1200, 1500, 1800, 2100, 2400, 3000];


	/**
		* Constructor for imager
		* @param string|object|int $img
	 	*	@param array $args
		* @param bool $render
	 */
  function __construct($img = [], $args = [], $render = true) {
		$this->props = array_merge(self::$defaults, $args);
    $this->uploads =  wp_upload_dir();
		$this->small = false;
		$this->isSvg = false;
		$this->alt = '';
		$this->ratio = 1;
		$this->max = 3000;
		$this->imageId = $this->prepareImg($img);
		$this->center = ['x'=> 50, 'y', 50];
		if ($this->small == false) {
			$this->processImg();
		}
		$this->getImageCenter();

		if ($render) {
			echo $this->return();
		} else {
			$output = $this->return();
			return $output;
		}

	}


	public static function addInitSizes() {
		foreach (self::$sizes as $size) {
			$sizeString = $size . 'w';
			add_image_size($sizeString, $size);
		}
	}

	public function get_download($quality = 'web'){
		if ($quality == 'web') {
			if ($this->props['web']) {
				return $this->props['web'];
			} elseif (Acf::field('web')->id($this->imageId)->get()) {
				return Acf::field('web')->id($this->imageId)->get();
			} else {
				return wp_get_attachment_image_src($this->imageId, '1200w')[0];
			}
		} else {
			if ($this->props['hires']) {
				return $this->props['hires'];
			} elseif (Acf::field('hires')->id($this->imageId)->get()) {
				return Acf::field('hires')->id($this->imageId)->get();
			} else {
				return wp_get_attachment_image_src($this->imageId, '3000w')[0];
			}
		}

	}

	public function downloader() {
		$output = "<div class=\"downloader\" data-downloader data-module=\"downloader\">";
			$output .= "<div class=\"downloader__inner\">";
			$output .="<div class=\"page-1\"><div data-progress-button class=\"download-button simple button\">". __("Download Image") . " <i class=\"icon-download\"></i></div></div>";
			$output .="<div class=\"page-2\"><a  download href=\"" . $this->get_download('web') . "\" class=\"download-button\">". __("Web Ready") . " <i class=\"icon-download\"></i></a><a  download href=\"" . $this->get_download('hires'). "\" class=\"download-button\">". __("High-Res") . " <i class=\"icon-download\"></i></a></div>";
			$output .="</div>";
		$output .="</div>";
		return $output;
	}

	public function mobileImage() {

	}

	/**
	 *
	 * @param string|object|int $img
	 * @return int $id
	 */
	private function prepareImg($img) {
		if (gettype($img) == "string") {
			if (filter_var($img, FILTER_VALIDATE_URL) == false) {
				if (intval($img) > 0 && intval($img) < 100000) {
					return intval($img);
				}
				throw new Exception('String passed as $img, but not a valid URL');
			} else {
				return url_to_postid($img);
			}
		} elseif (gettype($img) == "integer") {
			return $img;
		} elseif (gettype($img) == "array") {
			//Skips a lot of queries if passed an image object!

			$this->small[0] = $img['sizes']['medium'];
			$this->small[1] = $img['sizes']['medium-width'];
			$this->small[2] = $img['sizes']['medium-height'];
			$this->alt = $img['alt'];
			$this->ratio = $img['height']/$img['width']*100;
			$this->isSvg = $img['subtype']=='svg+xml';
			if ($img['ID']) {
				return $img['ID'];
			}
			if ($img['post_id']) {
				return $img['post_id'];
			}
		}
	}

	private function getImageCenter() {
		$this->center['x'] = ACF::field('horizontal')->id($this->imageId)->default(50)->get();
		$this->center['y'] = ACF::field('vertical')->id($this->imageId)->default(50)->get();
	}

	private function getClosest($search, $arr) {
		$closest = null;
		foreach ($arr as $item) {
				if ($closest === null || abs($search - $closest) > abs($item - $search)) {
					$closest = $item;
				}
		}
		return $closest;
	}

	private function processImg() {
		$this->small = wp_get_attachment_image_src($this->imageId, $this->getClosest($this->props['small_width'], self::$sizes) . 'w');
		$this->isSvg = $this->checkSvg($this->small[0]);
		$this->ratio = ($this->small[2]/$this->small[1])*100;
			$this->alt = get_post_meta($this->imageId , 'alt', true);

    if ($this->props['max_width'] !== false) {
      $this->max =  $this->getClosest($this->props['max_width'], self::$sizes);

    }
	}

  private function checkSvg($filePath = 'path/to/file') {
		$file_path = str_replace( '/app/uploads', $this->uploads['basedir'], $filePath );
    if (gettype($file_path) == 'string'){
      if (realpath($file_path)) {
        if (file_exists($file_path)) {
          return 'image/svg+xml' === mime_content_type($file_path);
        }
      }
		}
		return false;
	}

	private function getImageSet() {
		$output = '';
		$i = 0;
		$prevSize = 0;

		foreach (self::$sizes as $size) {
			$sizeString = $size . 'w';
			$comma = ', ';
			if ($i == 0) {
				$comma = '';
			}
			if ($i + 1 < sizeof(self::$sizes)) {
				$src = wp_get_attachment_image_src($this->imageId, $sizeString, false);

				//Stops if we've reached max height!
				if ($prevSize == $src[1]) {
					break;
				} else {

					$prevSize = $src[1];
				}


				$output .= $comma .  $src[0] . ' ' . $src[1] .'w ' . $src[2] .'h';
				$i++;
				if ($size == $this->max) {
					break;
				}
			}
		}
		return $output;
	}

	public function return() {
		$output = '';
		$style = '';
		$bg = '';
		$svg = '';
		$rellax = '';
		$center = "";
		$opacity = "";

		if ($this->props['rellax']) {
			$rellax = 'rellax';
		}

		if ($this->props['is_bg']) {
			$bg = ' bg' ;
			$style = '';

			$center = ".image--{$this->imageId} img {
				object-position:{$this->center['x']}% {$this->center['y']}% !important;
				font-family: \"object-fit:cover; object-position:{$this->center['x']}% {$this->center['y']}%;
			}";
			if ($this->props['rellax']) {
				$rellax = 'rellax-bg';
			}
		}

		if ($this->props['opacity'] > 100) {
			$opVal = $this->props['opacity'] / 100;
			$opacity = ".image--{$this->imageId} img {
				opacity: {$opVal};
			}";
		}

		if ($this->isSvg) {
		$svg = ' svg';
		}

		$output .=	"<picture class=\"respimg__wrapper{$svg}{$bg} {$rellax} image--{$this->imageId} {$this->props['classes']}\" >";

		if ($this->ratio > 0) {
			$output .="
			<style>
				.image--{$this->imageId}::before {content:''; display: block; padding-bottom: {$this->ratio}%;}
				{$center}
				{$opacity}
			</style>";
		}


		if ($this->isSvg !== false) {
			$output .= 	"<img data-sizes=\"auto\" class=\"respimg lazyload lazypreload\" src=\"{$this->small[0]}\">";
		} else {
			$output.= "<img data-sizes=\"auto\" alt=\"{$this->alt}\" class=\"respimg lazyload\" src=\"{$this->small[0]}\" data-srcset=\"{$this->getImageSet()}\">";
		}
		if ($this->props['downloader'] == true) {
			$output .= $this->downloader();
		}
		$output .= 	"</picture>";

		return $output;
	}
}