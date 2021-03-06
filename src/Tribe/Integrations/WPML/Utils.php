<?php


/**
 * Class Tribe__Events__Integrations__WPML__Utils
 *
 * A utility class offering WPML related convenience methods.
 */
class Tribe__Events__Integrations__WPML__Utils {

	/**
	 * Returns the translation of an array of strings using WPML supported languages to do so.
	 *
	 * @param array $strings
	 *
	 * @return array
	 */
	public static function get_wpml_i18n_strings( array $strings ) {
		$tec = Tribe__Events__Main::instance();

		$domains = apply_filters (
			'tribe_events_rewrite_i18n_domains', array(
				'default'             => true, // Default doesn't need file path
				'the-events-calendar' => $tec->pluginDir . 'lang/',
			)
		);

		global $sitepress;

		// Grab all languages
		$langs = $sitepress->get_active_languages();

		foreach ( $langs as $lang ) {
			$languages[] = $sitepress->get_locale( $lang['code'] );
		}

		// Prevent Duplicates and Empty langs
		$languages = array_filter( array_unique( $languages ) );

		// Query the Current Language
		$current_locale = $sitepress->get_locale( $sitepress->get_current_language() );

		// Get the strings on multiple Domains and Languages
		// WPML filter is unhooked to avoid the locale being set to the default one
		remove_filter( 'locale', array( $sitepress, 'locale_filter' ) );
		$translations = $tec->get_i18n_strings( $strings, $languages, $domains, $current_locale );
		add_filter( 'locale', array( $sitepress, 'locale_filter' ) );

		return $translations;
	}
}
