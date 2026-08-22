<?php
/**
 * Development-only WikiPress API stubs for external plugin authors.
 *
 * This file is loaded by Composer for static analysis and IDE support. It must
 * never be included by a production plugin bootstrap.
 *
 * @package WikiPressDevStub
 */

namespace WikiPress\Includes\Plugins {

if ( ! interface_exists( PluginInterface::class ) ) {
	interface PluginInterface {
		public function get_slug(): string;
		public function get_name(): string;
		public function get_version(): string;
		public function get_author(): string;
		public function get_author_uri(): string;
		public function get_description(): string;
		public function get_uri(): string;
		public function get_license(): string;
		public function is_active(): bool;
		public function init(): void;
	}
}

if ( ! interface_exists( SettingsProviderInterface::class ) ) {
	interface SettingsProviderInterface {
		public function register_settings(): void;
	}
}

if ( ! interface_exists( SettingsPageProviderInterface::class ) ) {
	interface SettingsPageProviderInterface {
		/** @return array<string, mixed> */
		public function get_settings_page(): array;

		/** @return array<string, mixed> */
		public function sanitize_settings( $input ): array;
	}
}

if ( ! interface_exists( DatabaseProviderInterface::class ) ) {
	interface DatabaseProviderInterface {
		public function register_tables(): void;
	}
}

if ( ! interface_exists( ShortcodeProviderInterface::class ) ) {
	interface ShortcodeProviderInterface {
		/** @return array<int, array<string, mixed>> */
		public function get_shortcodes(): array;
	}
}

if ( ! interface_exists( AssetsProviderInterface::class ) ) {
	interface AssetsProviderInterface {
		public function register_assets(): void;
	}
}

if ( ! interface_exists( AdminPageProviderInterface::class ) ) {
	interface AdminPageProviderInterface {
		public function register_admin_pages(): void;
	}
}

if ( ! interface_exists( AdminMenuProviderInterface::class ) ) {
	interface AdminMenuProviderInterface extends PluginInterface {
		/** @return array<int, array<string, mixed>> */
		public function get_admin_menu(): array;
	}
}

if ( ! interface_exists( AdminSidebarProviderInterface::class ) ) {
	interface AdminSidebarProviderInterface extends PluginInterface {
		/** @return array<int, array<string, mixed>> */
		public function get_admin_sidebar(): array;
	}
}

if ( ! interface_exists( RestRouteProviderInterface::class ) ) {
	interface RestRouteProviderInterface {
		public function register_rest_routes(): void;
	}
}

if ( ! interface_exists( FrontendProviderInterface::class ) ) {
	interface FrontendProviderInterface {
		public function register_frontend(): void;
	}
}

if ( ! interface_exists( I18nProviderInterface::class ) ) {
	interface I18nProviderInterface {
		public function load_textdomain(): void;
	}
}

}

namespace WikiPress\Includes\Core {

if ( ! class_exists( Capabilities::class ) ) {
	class Capabilities {
		/**
		 * Return the core and registered extension capability definitions.
		 *
		 * @return array<string, array{group: string, label: string, description: string}>
		 */
		public static function definitions(): array {
			return [];
		}

		/**
		 * Register capability definitions contributed by a plugin.
		 *
		 * @param array<string, array{group: string, label: string, description: string}> $definitions
		 */
		public static function extend( array $definitions ): void {}

		/**
		 * Install missing registered capabilities.
		 */
		public static function install(): void {}
	}
}

}

namespace WikiPress\Includes\Core\WP {

if ( ! class_exists( SanitizationHelper::class ) ) {
	final class SanitizationHelper {
		public static function text( $value, string $fallback = '' ): string {
			return is_scalar( $value ) ? sanitize_text_field( (string) $value ) : $fallback;
		}

		public static function textarea( $value, string $fallback = '' ): string {
			return is_scalar( $value ) ? sanitize_textarea_field( (string) $value ) : $fallback;
		}

		public static function key( $value, string $fallback = '' ): string {
			if ( ! is_scalar( $value ) ) {
				return $fallback;
			}

			$sanitized = sanitize_key( (string) $value );
			return '' !== $sanitized ? $sanitized : $fallback;
		}

		public static function slug( $value, string $fallback = '' ): string {
			if ( ! is_scalar( $value ) ) {
				return $fallback;
			}

			$sanitized = sanitize_title( (string) $value );
			return '' !== $sanitized ? $sanitized : $fallback;
		}

		public static function integer( $value, int $fallback = 0 ): int {
			return is_scalar( $value ) ? absint( $value ) : $fallback;
		}

		public static function integer_range( $value, int $minimum, int $maximum, int $fallback ): int {
			if ( $minimum > $maximum ) {
				[ $minimum, $maximum ] = [ $maximum, $minimum ];
			}

			if ( ! is_scalar( $value ) || '' === trim( (string) $value ) ) {
				return max( $minimum, min( $maximum, $fallback ) );
			}

			return max( $minimum, min( $maximum, absint( $value ) ) );
		}

		public static function one_of( $value, array $allowed, $fallback ) {
			return in_array( $value, $allowed, true ) ? $value : $fallback;
		}

		/** @return array<int, string> */
		public static function terms( $terms ): array {
			if ( is_string( $terms ) ) {
				$terms = explode( ',', $terms );
			}

			if ( ! is_array( $terms ) ) {
				return [];
			}

			$terms = array_map( [ self::class, 'text' ], $terms );
			return array_values( array_unique( array_filter( $terms, 'strlen' ) ) );
		}
	}
}

if ( ! class_exists( ShortcodeHelper::class ) ) {
	final class ShortcodeHelper {
		/** @return array<string, mixed> */
		public static function define( string $tag, callable $callback, array $attributes = [], array $metadata = [] ): array {
			return array_merge(
				[
					'tag' => $tag,
					'callback' => $callback,
					'attributes' => $attributes,
					'description' => '',
					'category' => '',
					'enclosing' => false,
					'tinymce' => false,
				],
				$metadata
			);
		}

		public static function register( array $definition, bool $replace = false ): bool {
			return true;
		}

		/** @return array<int, string> */
		public static function register_many( array $definitions, bool $replace = false ): array {
			return array_values( array_filter( array_map( static function ( array $definition ): string {
				return isset( $definition['tag'] ) ? (string) $definition['tag'] : '';
			}, $definitions ) ) );
		}
	}
}

if ( ! class_exists( WPLoader::class ) ) {
	class WPLoader {
		public function add_action( string $hook, object|string|array $component, string $callback, int $priority = 10, int $accepted_args = 1 ): self {
			return $this;
		}

		public function add_filter( string $hook, object|string|array $component, string $callback, int $priority = 10, int $accepted_args = 1 ): self {
			return $this;
		}

		public function add_callable_action( string $hook, callable $callback, int $priority = 10, int $accepted_args = 1 ): self {
			return $this;
		}

		public function add_callable_filter( string $hook, callable $callback, int $priority = 10, int $accepted_args = 1 ): self {
			return $this;
		}

		public function run(): void {}
	}
}

}

namespace WikiPress\Includes\Functions\Helpers {

if ( ! class_exists( WASMHelper::class ) ) {
	final class WASMHelper {
		public const FILTER = 'wikipress_admin_sidebar_menus';
		/** @return array<string, mixed> */
		public static function define( string $name, string $slug, string $icon, string $parent = '' ): array { return [ 'parent' => $parent, 'name' => $name, 'slug' => $slug, 'icon' => $icon ]; }
		/** @param array<int, array<string, mixed>> $menus @return array<int, array<string, mixed>> */
		public static function filter( array $menus ): array { return $menus; }
		public static function get_url( string $slug ): string { return ''; }
	}
}

if ( ! class_exists( WAMHelper::class ) ) {
	final class WAMHelper {
		public const FILTER = 'wikipress_admin_menus';
		/** @return array<string, mixed> */
		public static function define( string $name, string $slug, string $icon = 'dashicons-admin-generic', string $parent = '' ): array { return [ 'parent' => $parent, 'name' => $name, 'slug' => $slug, 'icon' => $icon ]; }
		/** @param array<int, array<string, mixed>> $menus @return array<int, array<string, mixed>> */
		public static function filter( array $menus ): array { return $menus; }
	}
}

if ( ! class_exists( LoaderHelper::class ) ) {
	class LoaderHelper extends \WikiPress\Includes\Core\WP\WPLoader {
		public function register_component( object|string|array $component, array $hooks ): self {
			return $this;
		}
	}
}

}

namespace WikiPress\Includes\Settings {

if ( ! class_exists( Settings::class ) ) {
	final class Settings {
		public static function get( string $key, $default = null ) { return $default; }
		public static function get_string( string $key, string $default = '' ): string { return $default; }
		public static function get_key( string $key, string $default = '' ): string { return $default; }
		public static function get_slug( string $key, string $default = '' ): string { return $default; }
		public static function get_int( string $key, int $default = 0 ): int { return $default; }
		public static function get_bool( string $key, bool $default = false ): bool { return $default; }
		public static function set( string $key, $value ): bool { return true; }
		public static function delete( string $key ): bool { return true; }
		public static function has( string $key ): bool { return false; }
		public static function get_group( string $group, ?array $default = null ): ?array { return $default; }
		public static function set_group( string $group, array $settings ): bool { return true; }
		public static function register_group( string $group, array $defaults = [] ): bool { return true; }
		public static function register_key( string $key, string $group, $default = null ): bool { return true; }
		public static function get_all(): array { return []; }
	}
}

}

namespace {
	if ( ! function_exists( 'sanitize_textarea_field' ) ) { function sanitize_textarea_field( $value ) { return (string) $value; } }
	if ( ! function_exists( 'absint' ) ) { function absint( $value ) { return abs( (int) $value ); } }
	if ( ! function_exists( 'sanitize_key' ) ) { function sanitize_key( $key ) { return (string) $key; } }
	if ( ! function_exists( 'sanitize_title' ) ) { function sanitize_title( $title ) { return (string) $title; } }
	if ( ! function_exists( 'sanitize_text_field' ) ) { function sanitize_text_field( $value ) { return (string) $value; } }
	if ( ! function_exists( '__' ) ) { function __( $text, $domain = null ) { return $text; } }
	if ( ! function_exists( 'esc_html' ) ) { function esc_html( $text ) { return (string) $text; } }
	if ( ! function_exists( 'shortcode_atts' ) ) { function shortcode_atts( $pairs, $atts, $shortcode = '' ) { return array_merge( $pairs, (array) $atts ); } }
	if ( ! function_exists( 'is_file' ) ) { function is_file( $filename ) { return false; } }
}
