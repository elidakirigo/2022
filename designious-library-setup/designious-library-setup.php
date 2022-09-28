<?php
/**
 * Plugin Name: Designious Library Setup
 * Description: Enhance Lumise with the Designious Library functionality
 * Version: 1.0.0
 * Author: Designious
 * Author URI: https://www.designious.com/
 */

class DesigniousLibrarySetup {
	const MENU_SLUG = 'designious_library';
	const ADDON_PACKAGE = 'BrainikNet/designious-lumise-addon';
	const UPLOADS_DIR = WP_CONTENT_DIR . '/uploads';
	const RELEASE_DIR = self::UPLOADS_DIR . '/designious-library-setup';
	const LUMISE_ADDONS_DIR = self::UPLOADS_DIR . '/lumise_data/addons';
	const LUMISE_ADDON_DIR_NAME = 'designious_library';
	const LUMISE_ADDON_FINAL_DIR = self::LUMISE_ADDONS_DIR . '/' . self::LUMISE_ADDON_DIR_NAME;

	private $installAttempt = false;
	private $installError = false;

	public function __construct() {
		add_action( 'admin_menu', [ &$this, 'register_menu' ], 20 );
		add_action( 'admin_head', [ &$this, 'update_link_structure' ], 20 );
		add_action( 'admin_enqueue_scripts', [ &$this, 'register_admin_css' ], 20 );
		add_action(
			'admin_print_styles-designious-library_page_designious_library_setup',
			[ &$this, 'register_admin_css' ]
		);
		add_action( 'admin_init', [ &$this, 'check_request' ], 20 );
	}

	public function check_request() {
		if ( $_POST['designious-library-setup'] && current_user_can( 'activate_plugins' ) ) {
			check_admin_referer( 'designious-library-setup' );
			$this->installAttempt = true;
			if ( wp_verify_nonce( $_POST['_wpnonce'], 'designious-library-setup' ) ) {
				$this->install_latest_addon_version();
			} else {
				error_log( 'Cannot install latest addon version: Invalid nonce.' );
				$this->installError = true;
			}
		}
	}

	public function isInstallAttempt() {
		return $this->installAttempt;
	}

	public function hasInstallError() {
		return $this->installError;
	}

	public function register_menu() {
		add_menu_page(
			'Designious Library',
			'Designious Library',
			'activate_plugins',
			self::MENU_SLUG,
			''
		);
		add_submenu_page(
			'designious_library',
			'Designious Library Setup',
			'Setup',
			'activate_plugins',
			self::MENU_SLUG . '_setup',
			[ &$this, 'render_setup_view' ]
		);
	}

	public function register_admin_css() {
		wp_enqueue_style(
			'designious_library_admin_css',
			plugins_url( '/src/assets/css/admin.css', __FILE__ ),
			false,
			'1.0.0'
		);
	}

	public function render_setup_view() {
		include __DIR__ . '/src/templates/setup_view.php';
	}

	public function update_link_structure() {
		global $submenu;

		if ( empty( $submenu[ self::MENU_SLUG ] ) || ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$key = null;
		foreach ( $submenu[ self::MENU_SLUG ] as $index => $item ) {
			if ( $item[2] === self::MENU_SLUG ) {
				$key = $index;
			}
		}

		if ( $key !== null ) {
			unset( $submenu[ self::MENU_SLUG ][ $key ] );
		}
	}

	private function install_latest_addon_version() {
		$latest = $this->get_latest_addon_version();
		if ( empty( $latest ) ) {
			error_log( 'Designious Library Setup failed: Could not connect to package repository' );
			$this->installError = true;
		}

		try {
			$this->clean_directory( self::RELEASE_DIR );
			$releasePath = $this->download_url( $latest['release_url'], $latest['tag'] );
			$this->extract_release( $releasePath );
			unlink( $releasePath );
			$dirs = scandir( self::RELEASE_DIR );
			foreach ( $dirs as $dir ) {
				if ( $dir != "." && $dir != ".." ) {
					if ( filetype( self::RELEASE_DIR . '/' . $dir ) == "dir" ) {
						$this->clean_directory( self::LUMISE_ADDON_FINAL_DIR );
						rename(
							self::RELEASE_DIR . '/' . $dir,
							self::LUMISE_ADDON_FINAL_DIR
						);
						break;
					}
				}
			}
			update_option( '_designious_library_version', $latest['tag'] );
		} catch ( \Exception $e ) {
			error_log( 'Designious Library Setup failed: ' . $e->getMessage() );
			$this->installError = true;
		}
	}

	public function get_latest_addon_version() {
		$version = get_transient( '_designious_library_addon_latest_version' );
		if ( $version === false ) {
			$client   = new WP_Http_Curl();
			$response = $client->request(
				'https://api.github.com/repos/' . self::ADDON_PACKAGE . '/releases/latest',
				[
					'headers' => [
						'User-Agent' => 'Designious Library Setup Plugin'
					]
				]
			);
			if ( ! is_wp_error( $response ) && isset( $response['body'] ) ) {
				$body    = json_decode( $response['body'], true );
				$version = [
					'tag'         => $body['tag_name'],
					'release_url' => $body['zipball_url']
				];
				set_transient( '_designious_library_addon_latest_version', $version, 3600 );
			} elseif ( is_wp_error( $response ) ) {
				error_log( 'Designious Library Setup failed: ' . $response->get_error_message() );
				$version = [];
				set_transient( '_designious_library_addon_latest_version', $version, 60 );
			} else {
				error_log( 'Designious Library Setup failed: No releases found.' );
				$version = [];
				set_transient( '_designious_library_addon_latest_version', $version, 60 );
			}
		}

		return $version;
	}

	private function clean_directory( $directory ) {
		if ( is_dir( $directory ) ) {
			$objects = scandir( $directory );
			foreach ( $objects as $object ) {
				if ( $object == '.' || $object == '..' ) {
					continue;
				}
				if ( filetype( $directory . '/' . $object ) == 'dir' ) {
					$this->clean_directory( $directory . '/' . $object );
				} else {
					unlink( $directory . '/' . $object );
				}
			}
			reset( $objects );
			rmdir( $directory );
		}
	}

	private function download_url( $url, $tag ) {
		$dir = self::RELEASE_DIR;
		if ( ! is_dir( $dir ) ) {
			mkdir( $dir );
		}
		$filepath = $dir . '/release-' . $tag . '.zip';

		$client = new WP_Http_Curl();
		$result = $client->request( $url, [
			'headers'  => [
				'User-Agent' => 'Designious Library Setup Plugin'
			],
			'stream'   => true,
			'filename' => $filepath,
		] );

		return ! is_wp_error( $result ) ? $filepath : false;
	}

	private function extract_release( $releasePath ) {
		$zip = new ZipArchive;
		$res = $zip->open( $releasePath );
		if ( $res === true ) {
			$zip->extractTo( self::RELEASE_DIR );
			$zip->close();
		} else {
			throw new \Exception( 'Release could not be extracted to designated directory.' );
		}
	}

	public function is_addon_installed() {
		global $lumise;

		$activeAddons = json_decode( $lumise->get_option( 'active_addons' ), true );

		return ( is_array( $activeAddons )
		         && ( isset( $activeAddons['designious_library'] ) || is_dir( self::LUMISE_ADDON_FINAL_DIR ) ) );
	}

	public function get_addon_version() {
		return get_option( '_designious_library_version' );
	}
}

$GLOBALS['designious_library_setup'] = new DesigniousLibrarySetup();