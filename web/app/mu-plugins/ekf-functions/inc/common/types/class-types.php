<?php

namespace EKF_Functions\Inc\Common\Types;
use JohnBillion\ExtendedCpts;


/**
 * Fired during plugin activation
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @author     Your Name or Your Company
 **/


class Types {

	/**
	 * Short Description.
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */

	public static $custom_posts =[ 'release'];
  public function __construct() {
	}


	public static function create_types() {
		register_extended_post_type('artist', [
			# Add the post type to the site's main RSS feed:
		'show_in_feed' => true,
		# Add the post true to the 'Recently Published' section of the dashboard:
		'dashboard_activity' => true,
		// 'rewrite'           => false,
		'rewrite' => [
			'slug' => 'artists',
			'with_front' => false
		],
		'has_archive', true,
		'enter_title_here' => 'Artist Name',
		'menu_icon' => 'dashicons-admin-users'
		]);
		register_extended_post_type('release', [
			'show_in_feed' => true,
			'rewrite'           => false,
			// 'rewrite' => [
			// 	'slug' => '/',
			// 	'with_front' => false
			// ],
			// 'has_archive', true,

			# Add the post type to the 'Recently Published' section of the dashboard:
			'enter_title_here' => 'Release Name',
			'menu_icon' => 'dashicons-format-audio'
		]);
	}

	private function custom_post_type_rewrites($post) {
    add_rewrite_rule( '[^/]+/attachment/([^/]+)/?$', 'index.php?attachment=$matches[1]', 'bottom');
    add_rewrite_rule( '[^/]+/attachment/([^/]+)/trackback/?$', 'index.php?attachment=$matches[1]&tb=1', 'bottom');
    add_rewrite_rule( '[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$', 'index.php?attachment=$matches[1]&feed=$matches[2]', 'bottom');
    add_rewrite_rule( '[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$', 'index.php?attachment=$matches[1]&feed=$matches[2]', 'bottom');
    add_rewrite_rule( '[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$', 'index.php?attachment=$matches[1]&cpage=$matches[2]', 'bottom');
    add_rewrite_rule( '[^/]+/attachment/([^/]+)/embed/?$', 'index.php?attachment=$matches[1]&embed=true', 'bottom');
    add_rewrite_rule( '([^/]+)/embed/?$', 'index.php?'.$post.'=$matches[1]&embed=true', 'bottom');
    add_rewrite_rule( '([^/]+)/trackback/?$', 'index.php?'.$post.'=$matches[1]&tb=1', 'bottom');
    add_rewrite_rule( '([^/]+)/page/?([0-9]{1,})/?$', 'index.php?'.$post.'=$matches[1]&paged=$matches[2]', 'bottom');
    add_rewrite_rule( '([^/]+)/comment-page-([0-9]{1,})/?$', 'index.php?'.$post.'=$matches[1]&cpage=$matches[2]', 'bottom');
    add_rewrite_rule( '([^/]+)(?:/([0-9]+))?/?$', 'index.php?'.$post.'=$matches[1]', 'bottom');
    add_rewrite_rule( '[^/]+/([^/]+)/?$', 'index.php?attachment=$matches[1]', 'bottom');
    add_rewrite_rule( '[^/]+/([^/]+)/trackback/?$', 'index.php?attachment=$matches[1]&tb=1', 'bottom');
    add_rewrite_rule( '[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$', 'index.php?attachment=$matches[1]&feed=$matches[2]', 'bottom');
    add_rewrite_rule( '[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$', 'index.php?attachment=$matches[1]&feed=$matches[2]', 'bottom');
    add_rewrite_rule( '[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$', 'index.php?attachment=$matches[1]&cpage=$matches[2]', 'bottom');
    add_rewrite_rule( '[^/]+/([^/]+)/embed/?$', 'index.php?attachment=$matches[1]&embed=true', 'bottom');
}

	public function filter_permalinks($post_link, $post, $leavename) {

		foreach(self::$custom_posts as $custom_post_type) {
			if (isset($post->post_type) && $custom_post_type == $post->post_type ) {
				$post_link = home_url($post->post_name);
			}
		}

		return $post_link;

	}
	public function add_rewrites() {
		foreach (self::$custom_posts as $custom_post_type) {
			$this->custom_post_type_rewrites($custom_post_type);
		}
	}


	public function prevent_slug_duplicates( $slug, $post_ID, $post_status, $post_type, $post_parent, $original_slug ) {
    $check_post_types = array(
        'post',
        'page',
    );

    if ( ! in_array( $post_type, $check_post_types ) && ! in_array($post_type, self::$custom_posts) ) {
        return $slug;
    }

    if ( in_array( $post_type, self::$custom_posts ) ) {
        // Saving a custom_post_type post, check for duplicates in POST or PAGE post types
        $post_match = get_page_by_path( $slug, 'OBJECT', 'post' );
        $page_match = get_page_by_path( $slug, 'OBJECT', 'page' );

        if ( $post_match || $page_match ) {
            $slug .= '-duplicate';
        }
    } else {
			// Saving a POST or PAGE, check for duplicates in custom_post_type post type
			foreach (self::$custom_posts as $cp) {
				$custom_post_type_match = get_page_by_path( $slug, 'OBJECT', $cp );
				if ( $custom_post_type_match ) {
						$slug .= '-duplicate';
				}
			}
    }

    return $slug;
}



	public function parse_request( $query ) {

			if ( ! $query->is_main_query() || 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
					return;
			}

			if ( ! empty( $query->query['name'] ) ) {
					$query->set( 'post_type', array( 'post', 'artist', 'release', 'page' ) );
			}
	}

	public function remove_slugs( $post_link, $post ) {
		if ( ('artist' === $post->post_type && 'publish' === $post->post_status) || ('release' === $post->post_type && 'publish' === $post->post_status) ) {
		$post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
		}
		return $post_link;
	}

	public function remove_slug_from_permalink( $url ) {
		if ( ('artist' === $post->post_type) ||('release' === $post->post_type) ) {
		$post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
		}
		return $url;
	}


	public function add_to_query( $query ) {
		// Bail if this is not the main query.
		if ( ! $query->is_main_query() ) {
			return;
		}
		// Bail if this query doesn't match our very specific rewrite rule.
		if ( ! isset( $query->query['page'] ) || 2 !== count( $query->query ) ) {
			return;
		}
		// Bail if we're not querying based on the post name.
		if ( empty( $query->query['name'] ) ) {
			return;
		}
		// Add CPT to the list of post types WP will include when it queries based on the post name.
		$query->set( 'post_type', array( 'post', 'page', 'artist', 'release' ) );
	}

}