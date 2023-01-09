<?php

namespace FrontendGulp\Api\Tools\WordPress;

use FrontendGulp\Api\Tools\WordPress\Interfaces\MenuItem;
use stdClass;

if ( defined( 'ABSPATH' ) ) {
	return;
}

class FE_WP_BASE {
	/**
	 * @param string $menuID
	 * @param array $args
	 * @return MenuItem[]
	 */
	static function getMenuItemsByID( $menuID, $args = [] ) {
		// TODO: Почистить от лишнего кода

		$defaults = array(
			'menu'            => '',
			'container'       => 'div',
			'container_class' => '',
			'container_id'    => '',
			'menu_class'      => 'menu',
			'menu_id'         => '',
			'echo'            => true,
			'fallback_cb'     => 'wp_page_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'item_spacing'    => 'preserve',
			'depth'           => 0,
			'walker'          => '',
			'theme_location'  => $menuID,
		);

		$args = wp_parse_args( $args, $defaults );

		if ( ! in_array( $args['item_spacing'], array( 'preserve', 'discard' ), true ) ) {
			// invalid value, fall back to default.
			$args['item_spacing'] = $defaults['item_spacing'];
		}

		/**
		 * Filters the arguments used to display a navigation menu.
		 * @param array $args Array of wp_nav_menu() arguments.
		 * @see wp_nav_menu()
		 * @since 3.0.0
		 */
		$args = apply_filters( 'wp_nav_menu_args', $args );
		$args = (object) $args;

		/**
		 * Filters whether to short-circuit the wp_nav_menu() output.
		 * Returning a non-null value to the filter will short-circuit
		 * wp_nav_menu(), echoing that value if $args->echo is true,
		 * returning that value otherwise.
		 * @param string|null $output Nav menu output to short-circuit with. Default null.
		 * @param stdClass $args An object containing wp_nav_menu() arguments.
		 * @since 3.9.0
		 * @see wp_nav_menu()
		 */
		$nav_menu = apply_filters( 'pre_wp_nav_menu', null, $args );

		if ( null !== $nav_menu ) {
			if ( $args->echo ) {
				echo $nav_menu;

				return [];
			}

			return $nav_menu;
		}

		// Get the nav menu based on the requested menu
		$menu = wp_get_nav_menu_object( $args->menu );

		// Get the nav menu based on the theme_location
		if ( ! $menu && $args->theme_location && ( $locations = get_nav_menu_locations() ) && isset( $locations[ $args->theme_location ] ) ) {
			$menu = wp_get_nav_menu_object( $locations[ $args->theme_location ] );
		}

		// get the first menu that has items if we still can't find a menu
		if ( ! $menu && ! $args->theme_location ) {
			$menus = wp_get_nav_menus();
			foreach ( $menus as $menu_maybe ) {
				if ( $menu_items = wp_get_nav_menu_items( $menu_maybe->term_id, array( 'update_post_term_cache' => false ) ) ) {
					$menu = $menu_maybe;
					break;
				}
			}
		}

		if ( empty( $args->menu ) ) {
			$args->menu = $menu;
		}

		// If the menu exists, get its items.
		if ( $menu && ! is_wp_error( $menu ) && ! isset( $menu_items ) ) {
			$menu_items = wp_get_nav_menu_items( $menu->term_id, array( 'update_post_term_cache' => false ) );
		}

		/*
		 * If no menu was found:
		 *  - Fall back (if one was specified), or bail.
		 *
		 * If no menu items were found:
		 *  - Fall back, but only if no theme location was specified.
		 *  - Otherwise, bail.
		 */
		if ( ( ! $menu || is_wp_error( $menu ) || ( isset( $menu_items ) && empty( $menu_items ) && ! $args->theme_location ) )
		     && isset( $args->fallback_cb ) && $args->fallback_cb && is_callable( $args->fallback_cb ) ) {
			return call_user_func( $args->fallback_cb, (array) $args );
		}

		if ( ! $menu || is_wp_error( $menu ) ) {
			return [];
		}


		// Set up the $menu_item variables
		_wp_menu_item_classes_by_context( $menu_items );

		return $menu_items;
	}

	static function getTreeMenuByID( $menuID ) {
		// TODO: Начать возвращать список ссылок в виде дерева
		return self::getMenuItemsByID( $menuID );
	}
}
