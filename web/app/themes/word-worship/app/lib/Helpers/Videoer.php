<?php
namespace App;
use Samrap\Acf\Acf;
use Roots\Sage\Container;
use App\Imager;

class Videoer {
	static $defaults = [
		'Fallback GIF' => false,
		'Fallback Image' => false,
		'fullscreen' => false,
		'classes' => '', //Extra classes
		'rellax' => false, //Add scroll effect
		'opacity' => 100,
		'downloader' => false,
		'play' => false
	];
	/**
		* Constructor for imager
		* @param string|object|int $img
	 	*	@param array $args
		* @param bool $render
	 */
  function __construct($video, $render = true) {
		$this->props = array_merge(self::$defaults, $video);
		$this->propKeys = array_keys($this->props);
		$this->prepareMarkup();
 	}

	public function prepareMarkup() {
		if ($this->props['type'] == 'URL') {
			$this->markup = "<div class=\"vidbox__video\" data-vidbox-video=\"{$this->props['url']}\"></div>";
		} else {
			$this->markup = "<video class=\"vidbox__video\" data-vidbox-video controls>";

			//Files
			if (in_array('webm', $this->propKeys) && $this->props['webm']) {
				$this->markup .= "<source type=\"video/webm\" src=\"{$this->props['webm']['url']}\">";
			}
			if ($this->props['mp4']) {
				$this->markup .= "<source type=\"video/mp4\" src=\"{$this->props['mp4']['url']}\">";
			}
			$this->markup .="</video>";
		}
	}


	public function downloader() {
		$output = "<div class=\"downloader\" data-downloader data-module=\"downloader\">";
			$output .= "<div class=\"downloader__inner\">";
			$output .="<div class=\"page-1\"><div data-progress-button class=\"download-button simple button\">". __("Download Video") . " <i class=\"icon-download\"></i></div></div>";
			$output .="<div class=\"page-2\"><a  download href=\"" . $this->props['mp4']['url'] . "\" class=\"download-button\">". __("Download Mp4") . " <i class=\"icon-download\"></i></a></div>";
			$output .="</div>";
		$output .="</div>";
		return $output;
	}


	public function return() {
		$rellax = '';
		if ($this->props['rellax']) {
			$rellax = 'rellax-bg';
		}

		$style = '';

		$opVal = $this->props['opacity']/100;

		$output = "<div data-play=\"{$this->props['play']}\" class=\"{$rellax} vidbox {$this->props['classes']}\"  style=\"opacity: {$opVal};\" data-module=\"vidbox\" data-vidbox-type=\"{$this->props['type']}\" >";
			if ($this->props['downloader']) {
				$output .= $this->downloader();
			}
			$output .= $this->markup;

			if ($this->props['type'])

			if ($this->props['Fallback GIF']) {
				$gf = new Imager($this->props['Fallback GIF'], ['is_bg' => true], false);
				$output .= '<div class="fallback fallback-gif">' . $gf->return() . '</div>';
			}
			if ($this->props['Fallback Image']) {
				$bg = new Imager($this->props['Fallback Image'], ['is_bg' => true], false);
				$output .= '<div class="fallback fallback-image">' . $bg->return() . '</div>';
			}


		$output .= "</div>";
		return $output;
	}
}