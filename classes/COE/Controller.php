<?php

namespace COE;

class Controller {

	const VERSION = '1.0.0';
	const VERSION_CSS = '1.0.0';
	const VERSION_JS = '1.0.0';
	const OPTION_VERSION = 'coe_version';

	public $attributes;

	/**
	 *
	 */
	public function activate()
	{
		add_option( self::OPTION_VERSION, self::VERSION );
	}

	/**
	 *
	 */
	public function init()
	{
		add_thickbox();
		wp_enqueue_script( 'coe-js', plugin_dir_url( dirname( __DIR__ ) ) . 'js/coe.js', array ( 'jquery' ), ( WP_DEBUG ) ? time() : self::VERSION_JS, TRUE );
		wp_enqueue_style( 'coe-css', plugin_dir_url( dirname( __DIR__ ) ) . 'css/coe.css', array (), ( WP_DEBUG ) ? time() : self::VERSION_CSS );
		wp_enqueue_style( 'coe-bootstrap-css', plugin_dir_url( dirname( __DIR__ ) ) . 'css/bootstrap.css', array (), ( WP_DEBUG ) ? time() : self::VERSION_CSS );
	}

	/**
	 * @param $attributes
	 *
	 * @return string
	 */
	public function short_code( $attributes )
	{
		$this->attributes = shortcode_atts( array (
			'display' => ''
		), $attributes );

		ob_start();
		include( dirname( dirname( __DIR__ ) ) . '/includes/shortcode.php' );
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	/**
	 * @param $attribute
	 *
	 * @return string
	 */
	public function get_attribute( $attribute )
	{
		if ( is_array( $this->attributes ) && array_key_exists( $attribute, $this->attributes ) )
		{
			return $this->attributes[ $attribute ];
		}

		return '';
	}

	/**
	 * @param array $links
	 *
	 * @return array
	 */
	public function instructions_link( $links )
	{
		$link = '<a href="options-general.php?page=' . plugin_basename( dirname( dirname( __DIR__ ) ) ) . '">' . __( 'Instructions', 'fit-spokane' ) . '</a>';
		$links[] = $link;

		return $links;
	}

	/**
	 *
	 */
	public function print_instructions_page()
	{
		include( dirname( dirname( __DIR__ ) ) . '/includes/instructions.php' );
	}

	/**
	 * @param array $links
	 *
	 * @return array
	 */
	public function settings_link( $links )
	{
		$link = '<a href="options-general.php?page=' . plugin_basename( dirname( dirname( __DIR__ ) ) ) . '">' . __( 'Settings', 'fit-spokane' ) . '</a>';
		$links[] = $link;

		return $links;
	}

	/**
	 *
	 */
	public function settings_page()
	{
		add_options_page(
			'Fit Spokane ' . __( 'Settings', 'fit-spokane' ),
			'Fit Spokane',
			'manage_options',
			plugin_basename( dirname( dirname( __DIR__ ) ) ),
			array ( $this, 'print_settings_page' )
		);
	}

	/**
	 *
	 */
	public function print_settings_page()
	{
		include( dirname( dirname( __DIR__ ) ) . '/includes/settings.php' );
	}

	/**
	 *
	 */
	public function admin_scripts()
	{
		wp_enqueue_media();
		wp_enqueue_script( 'coe-admin-js', plugin_dir_url( dirname( __DIR__ ) ) . 'js/coe-admin.js', array ( 'jquery' ), ( WP_DEBUG ) ? time() : self::VERSION_JS, TRUE );
		wp_enqueue_style( 'coe-admin-css', plugin_dir_url( dirname( __DIR__ ) ) . 'css/coe-admin.css', array (), ( WP_DEBUG ) ? time() : self::VERSION_CSS );
	}

	/**
	 *
	 */
	public function register_settings()
	{
		register_setting( 'coe_settings', 'setting_name' );
	}

	/**
	 *
	 */
	public function form_capture()
	{
		if ( isset( $_POST['coe_action'] ) )
		{
			if ( wp_verify_nonce( $_POST['_wpnonce'], 'coe_nonce' ) )
			{
				if ( $_POST['coe_action'] == 'some_action' )
				{

				}
			}
		}
	}

	/**
	 *
	 */
	public function create_post_types()
	{
		$post_types = array(
			array( College::TITLE, College::PLURAL, College::POST_TYPE ),
			array( Program::TITLE, Program::PLURAL, Program::POST_TYPE ),
			array( ProgramCategory::TITLE, ProgramCategory::PLURAL, ProgramCategory::POST_TYPE ),
			array( Award::TITLE, Award::PLURAL, Award::POST_TYPE )
		);

		foreach ( $post_types as $post_type )
		{
			$labels = array (
				'name' => $post_type[ 1 ],
				'singular_name' => $post_type[ 0 ],
				'add_new_item' => __( 'Add New', 'coe' ) . ' ' . $post_type[ 0 ],
				'edit_item' => __( 'Edit', 'coe' ) . ' ' . $post_type[ 0 ],
				'new_item' => __( 'New', 'coe' ) . ' ' . $post_type[ 0 ],
				'view_item' => __( 'View', 'coe' ) . ' ' . $post_type[ 0 ],
				'search_items' => __( 'Search', 'coe' ) . ' ' . $post_type[ 1 ],
				'not_found' => __( 'No', 'coe' ) . ' ' . $post_type[ 1 ] . ' ' . __( 'Found', 'coe' )
			);

			$args = array (
				'labels' => $labels,
				'hierarchical' => FALSE,
				'description' => $post_type[ 1 ],
				'supports' => array ( 'title' ),
				'show_ui' => TRUE,
				'show_in_menu' => 'coe',
				'show_in_nav_menus' => TRUE,
				'publicly_queryable' => TRUE,
				'exclude_from_search' => FALSE,
				'has_archive' => TRUE,
				'public' => FALSE
			);

			register_post_type( $post_type[ 2 ], $args );
		}
	}

	/**
	 *
	 */
	public function admin_menus()
	{
		add_menu_page( 'COE', 'COE', 'manage_options', 'coe', array ( $this, 'print_settings_page' ), 'dashicons-welcome-learn-more' );
		add_submenu_page( 'coe', __( 'Settings', 'coe' ), __( 'Settings', 'coe' ), 'manage_options', 'coe' );
		add_submenu_page( 'coe', __( 'Instructions', 'coe' ), __( 'Instructions', 'coe' ), 'manage_options', 'coe_instructions', array( $this, 'print_instructions_page' ) );
	}

	/**
	 * @param array $actions
	 *
	 * @return array
	 */
	public function remove_row_actions( $actions )
	{
		if ( get_post_type() == College::POST_TYPE || get_post_type() == Program::POST_TYPE || get_post_type() == ProgramCategory::POST_TYPE || get_post_type() == Award::POST_TYPE )
		{
			unset( $actions['view'] );
		}

		return $actions;
	}

	/**
	 * @param array $messages
	 *
	 * @return array
	 */
	public function custom_post_type_messages( $messages )
	{
		if ( get_post_type() == College::POST_TYPE )
		{
			$messages[ 'post' ][ 1 ] =  College::TITLE . ' has been updated! <a href="edit.php?post_type=' . College::POST_TYPE . '">Back to List</a>';
		}
		elseif ( get_post_type() == Program::POST_TYPE )
		{
			$messages[ 'post' ][ 1 ] =  Program::TITLE . ' has been updated! <a href="edit.php?post_type=' . Program::POST_TYPE . '">Back to List</a>';
		}
		elseif ( get_post_type() == ProgramCategory::POST_TYPE )
		{
			$messages[ 'post' ][ 1 ] =  ProgramCategory::TITLE . ' has been updated! <a href="edit.php?post_type=' . ProgramCategory::POST_TYPE . '">Back to List</a>';
		}
		elseif ( get_post_type() == Award::POST_TYPE )
		{
			$messages[ 'post' ][ 1 ] =  Award::TITLE . ' has been updated! <a href="edit.php?post_type=' . Award::POST_TYPE . '">Back to List</a>';
		}

		return $messages;
	}
}
