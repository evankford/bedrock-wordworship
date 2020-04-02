<?php

namespace App;

/**
 * Theme customizer
 */
add_action('customize_register', function (\WP_Customize_Manager $wp_customize) {
    // Add postMessage support
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->selective_refresh->add_partial('blogname', [
        'selector' => '.brand',
        'render_callback' => function () {
            bloginfo('name');
        }
    ]);
});

add_action('init', function() {
    $intervener = new Intervener();
});

add_action('admin_init', function() {
    $new_plugins = ['edit.php?post_type=udb_widgets', 'wp-bruiser-settings' , 'WP-Optimize' ];
			 if (!current_user_can('manage_options')) {
                remove_menu_page('WP-Optimize');
                remove_menu_page('ninja-forms');
                remove_menu_page('wp-bruiser-settings');
                remove_menu_page('edit.php?post_type=udb_widgets');
                remove_menu_page('theseoframework-settings');
			 }
});

/**
 * Customizer JS
 */
add_action('customize_preview_init', function () {
    wp_enqueue_script('sage/customizer.js', asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
});


add_action('login_enqueue_scripts', function() {
    wp_enqueue_style(
        'sage/login.css',
        asset_path('styles/login.css'),
        false,
        null
    );
}, 100);

add_action('admin_enqueue_scripts', function() {
    wp_enqueue_style(
        'sage/admin.css',
        asset_path('styles/admin.css'),
        false,
        null
    );
}, 100);

add_filter( 'get_sample_permalink_html', function($return, $id, $new_title, $new_slug) {
    global $post;
    if($post->post_type == 'release' && $post->post_status == "publish") {
        $ret2 = $return;
        $ret2 .= '<br><strong>All Sections Preview:</strong> <span class="sample-short-permalink"><a href="' .  get_the_permalink($post) . '?previewDate=all">' .  get_the_permalink($post) . '?previewDate=all</a>';
        $ret2 .= '<br>You can also preview at a specific date adding <strong>?previewDate=YYYY-MM-DD</strong> at the end of the URL!';
        $ret2 .= '<br>To edit the URL, edit the <strong>"Slug"</strong> box to your right!';
    } else {
        $ret2 = $return;
    }
    return $ret2;
}, 10, 4 );

// functions.php

add_filter('acf-autosize/wysiwyg/min-height', function() {
	return 150;
});