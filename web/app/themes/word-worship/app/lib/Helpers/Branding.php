<?php

namespace App\Lib\Helpers;
use Samrap\Acf\Acf;

class Branding {

	/**
		* Constructor for Release Sections
	 	*	@param array $section - This should always be an ACF Flexible content section
	 */
  function __construct($postId, $postType) {
    $this->id = $postId;
    $this->type = $postType;
  }


  public function return() {
    ob_start();
    echo $this->startWrap();
    echo $this->getColors();
    echo $this->getFonts();
    echo $this->endWrap();
    echo $this->fontUrl();
    echo $this->custom();
    $output = ob_get_clean();
    return $output;
  }


  /* Returns the custom css from the ACF Artist/release editor */
  private function custom() {
    return Acf::field('Custom CSS')->id($this->id)->default('')->expect('string')->get();
  }

  private function startWrap() {
    //Include some styling in the section definition
    $output = "<style> \n";
    if ($this->type == 'artist') {
      //Less specificity for artist!
      $output .= "body.single { \n";
    } else {
      $output .= "body.single.single-release { \n";
    }
    return $output;

  }

  private function fontUrl() {
    return Acf::field('Font Embed Code')->id($this->id)->default('')->expect('string')->get();
  }

  private function getColors() {
    $output ='/* Rendering Branding-Level Color Variables */';
    $colors = ['Background Color', 'Text Color', 'Accent Color', 'Accent Inverse Color'];

    foreach ($colors as $color) {
      $colorObj = Acf::field($color)->id($this->id)->get();
      if (strlen($colorObj) > 2) {
        $output .= '--color-' . preg_replace('/\s+/', '-', strtolower(str_replace(' Color', '', $color))) . ": {$colorObj};\n";
      }
    }
    return $output;
  }

  private function getFonts() {
    $output ='/* Rendering Branding-Level Font Variables */';

    $fonts = ['Primary Font', 'Header Font', 'Extra Font'];
    // $bodyFont =
    foreach ($fonts as $font) {
      $fontObj = Acf::field($font)->id($this->id)->get();
      $family = $fontObj['Font Family'];
      if (gettype($family) == 'string' && strlen($family) > 0) {
       //Other fields are required, so we can just go from here;
       if ($font == 'Primary Font') {
         $output .= "
          /*Variables where supported */
          --font-family:{$family};
          --font-weight:{$fontObj["Font Weight"]};
          --font-style:{$fontObj["Font Style"]};";

       } else {
         if ($font == 'Header Font') {
           $output .=
           "--font-family-heading:{$family};
            --font-weight-heading:{$fontObj["Font Weight"]};
            --font-style-heading:{$fontObj["Font Style"]};";
         }
         if ($font == 'Extra Font') {
           $output .=
            "--font-family-extra:{$family};
            --font-weight-extra:{$fontObj["Font Weight"]};
            --font-style-extra:{$fontObj["Font Style"]};";
         }
        }

      }
    }
    return $output;
  }

  private function endWrap() {
    return "} </style>";//Ending the class declaration and the tag
  }
}