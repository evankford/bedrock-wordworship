<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use Samrap\Acf\Acf;
use App\Imager;

use App\Lib\Helpers\Icons;
use App\Lib\Helpers\Buttons;
use App\Lib\Helpers\Branding;

class App extends Controller
{
    public function siteName()
    {
        return get_bloginfo('name');
    }

    public static function title()
    {
        global $post;
        if (is_archive()) {
            return post_type_archive_title();
        }
        if ($post->post_type == 'artist') {
            return __('Releases', 'Sage');
        }
        if ($post->post_type == 'release') {
            return __('', 'Sage');
        }

        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'sage');
        }

        if (is_search()) {
            return sprintf(__('Search Results for %s', 'sage'), get_search_query());
        }
        if (is_404()) {
            return __('Not Found', 'sage');
        }
        return get_the_title();
    }

    public static function headerBackground() {
        $img = get_post_thumbnail_id();

        if (!$img || is_archive()) {
            $img = Acf::option('general_header')->get();
        }

        if ($img) {
            $imgArgs = [
                'classes'=>'standard-bg',
                'rellax' => true,
                'is_bg' => true
            ];
            echo '<div class="page-header__image">';
                new Imager($img, $imgArgs, true);
            echo '</div>';
        }
    }

    public static function logo() {
        $logo = Acf::option('header_logo')->get();
        new Imager($logo);
    }

    public static function links() {
        $links = Acf::option('Buttons')->get();
        if (gettype($links) == 'array' && sizeof($links) > 0) {
            Buttons::startWrap();
                foreach ($links as $link) {
                    Buttons::single($link);
                }
            Buttons::endWrap();
        }

    }
    public static function icons() {
        $icons = Acf::option('Social Links')->get();
        if (gettype($icons) == 'array' && sizeof($icons) > 0) {
            Icons::startWrap();
                foreach($icons as $icon) {
                    Icons::single($icon);
                }
            Icons::endWrap();
        }
    }

    public static function style() {
        $output = '';

        global $post;
        //Gets branding for Artist and Release
        if ($post->post_type == 'release') {
            $artistBranding = new Branding(Artist::id(), $post->post_type);
            $output .= $artistBranding->return();
        }

        $branding = new Branding($post->ID, $post->post_type);
        $output .= $branding->return();
        return $output;
    }
}
