<?php

namespace App;

use App\Lib\Helpers\Icons;
use App\Lib\Helpers\Buttons;
use App\Lib\Helpers\Branding;



class ReleaseSection {

	/**
		* Constructor for Release Sections
	 	*	@param array $section - This should always be an ACF Flexible content section
	 */
  function __construct($section, $index) {
    $this->index = $index;
    $this->populateProps($section);
    $this->dateStatus = $this->checkDate();
  }

  public function render() {
    ob_start();
    echo $this->startWrap();
    echo $this->date_preview();
    echo $this->style();
    echo $this->content();
    echo $this->endWrap();
    $output = ob_get_clean();
    echo $output;
  }

  public function handleImage()  {
    if (in_array('Image', $this->keys)) {
      $this->imageArgs=[
        'downloader'=>$this->obj['Image']['downloader'],
        'rellax' => $this->obj['Image']['rellax'],
        'mobile' => $this->obj['Image']['Mobile Image'],
        'opacity' => $this->obj['Image']['Mobile Image']
      ];
      return $this->obj['Image']['image'];
    } else {
      return false;
    }
  }

  public function populateProps($acf_object) {
    //Generate list of array keys to check against (silences "Undefined index" errors)
    $this->obj = $acf_object;
    $this->keys = array_keys($acf_object);
    //Falses
    $this->image = false;
    $this->mobileImg = false;
    $this->video = false;
    $this->content = false;
    $this->buttons = false;
    $this->embed = false;
    $this->id = '';
    if (in_array('id', $this->keys)) {
      $this->id = 'section--' . $this->obj['id'];
    }


    //Layout
    $this->layout = handleize($this->obj['acf_fc_layout']);


    $this->image = $this->handleImage();
    if (in_array('Mobile Image', $this->keys)) {
      $this->mobileImg = $this->obj['Mobile Image'];
    }

    if (in_array('video', $this->keys)) {
      $this->video = $this->obj['video'];
    }

    if (in_array('Content', $this->keys)) {
      $this->content = $this->obj['Content'];
    }
    if (in_array('Embed', $this->keys)) {
      $this->embed = $this->obj['Embed'];
    }
    if (in_array('Buttons', $this->keys)) {
      $this->buttons = $this->obj['Buttons'];
    }

    if (in_array('Enable Date', $this->keys)) {
      $this->start = strtotime($this->obj['Enable Date']);
    } else {
      $this->start = false;
    }

    if (in_array('Disable Date', $this->keys)) {
      $this->end = strtotime($this->obj['Disable Date']);
    } else {
      $this->end = false;
    }


    $this->style = ['color_background' => $this->obj['Content Background Color'], 'color_text' => $acf_object['Content Text Color'], 'spacing' => handleize($acf_object['Content Spacing']), 'size' => handleize($acf_object['Content Size'])];

  }

  private function section_video() {
     $sub = '<div class="section-content__background">';

        $this->video['fullscreen'] = true;
        $this->video['classes'] = 'video-banner';
        $video =  new Videoer($this->video, false);
        $sub .= $video->return();

      $sub .= '</div><!--end section-background--><div class="section-content__inner">';
        $content = new Contenter($this->content);
        $sub.= $content->return();
      $sub .= '</div>';
      return $sub;
  }

  private function section_bgcontent() {
      $bgcontent = new BgContenter($this->obj);
      return $bgcontent->render();
  }

  private function section_embed() {
    $sub = '<div class="section-content__inner">';
        $header = new Contenter($this->obj['header']);
        $embed = new Embedder($this->embed);

        $buttons = '';
        if ($this->buttons && sizeof($this->buttons) > 0 ) {
          ob_start();
          Buttons::startWrap('section-content__buttons');
            foreach($this->buttons as $button) {
              Buttons::single($button);
            }
          Buttons::endWrap();
          $buttons = ob_get_clean();
        }

        $sub .= "<div class=\"section-content__header\">{$header->return()}</div>";
        $sub .= "<div class=\"section-content__embed type--{$this->obj['Embed']['embed_type']} size--{$this->obj['Embed']['embed_size']}\">{$embed->return()}</div>{$buttons}";
      $sub .= '</div>';
      return $sub;
  }

  private function section_gallery() {

    $sub = '<div class="section-content__inner gallery-section__inner">';
    $sub.="<header class=\"gallery-header align--{$this->obj['header']['text_align']}\">";
      $header =  new Contenter($this->obj['header']);
      $sub .= $header->return();
      $sub .= "</header>";

    $gallery = new Galleryer($this->obj);
    // var_dump($gallery);
    $sub .= $gallery->renderGallery();
    $sub .="</div><!--end .gallery-section__inner-->";
    return $sub;
  }

  private function style() {
    $output ='';
    if ($this->style['color_background'] || $this->style['color_text']) {
      $output = '<style>';
      $output .= ".release-section--{$this->index} {";
        if ($this->style['color_background']) {
          $output.="background-color: {$this->style['color_background']};";
          $output.="--color-background: {$this->style['color_background']};";
        }
        if ($this->style['color_background']) {
          $output.="color: {$this->style['color_text']};";
          $output.="--color-text: {$this->style['color_text']};";
        }

      $output .= "} /*Close section style tag*/";
      $output .= '</style>';

      return $output;
    }
  }

  private function content() {
    $output = '<div class="section-content">';


    //Banner image, just loads an image, that's it
    if ($this->layout =='image-banner' && $this->image) {
      $image =  new Imager($this->image, $this->imageArgs, false);
      $output .= $image->return();
    }

    if ($this->layout == 'video-banner' && $this->video) {
      $output .= $this->section_video();
    }

    if ($this->layout == 'gallery') {
      $output .= $this->section_gallery();
    }

    if ($this->layout == 'embed') {
      $output .= $this->section_embed();
    }
    if ($this->layout == 'content-over-background') {
      $output .= $this->section_bgcontent();
    }



    $output .= '</div><!--end .section-content-->';
    return $output;
  }

  private function startWrap() {
    //Include some styling in the section definition
    return "<section id=\"{$this->id}\" class=\"release-section release-section--{$this->index} layout--{$this->layout} {$this->id} \">";

  }

  private function endWrap() {
    return '</section>';
  }

  private function checkDate() {
    if ($this->start && $this->start >  strtotime("now")) {
      return "date--preview";
    }
    if ($this->end && $this->end < strtotime("now")) {
      return "date--past";
    }
    return "normal";
  }

  private  function date_preview() {
    $output = '';
    if ($this->dateStatus != 'normal') {
      $endPretty = date('g:ia \o\n l jS F Y',$this->end);
      $contentSub = "";
      if ($this->dateStatus == "date--preview") {
        $startPretty = date('g:ia \o\n l jS F Y', $this->start);
        $contentSub = "It will be enabled at <b>{$startPretty}</b>.";
      }
      if ($this->dateStatus == "date--past") {
        $endPretty = date('g:ia \o\n l jS F Y', $this->end);
        $contentSub = "It will be enabled at <b>{$endPretty}</b>.";
      }

      $content = "<p>This is a preview of this section. This section is not currently public. {$contentSub} </p>";
      $output = "<aside class=\"date-banner {$this->dateStatus}\">{$content}</aside>";
    }
    return $output;
  }
}