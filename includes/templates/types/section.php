<?php

namespace PixerexElements\Includes\Templates\Types;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Pixerex_Structure_Section' ) ) {

	/**
	 * Define Pixerex_Structure_Section class
	 */
	class Pixerex_Structure_Section extends Pixerex_Structure_Base {

		public function get_id() {
            return 'premium_section';
		}

		public function get_single_label() {
			return __( 'Section', 'pixerex-elements' );
		}

		public function get_plural_label() {
			return __( 'Sections', 'pixerex-elements' );
		}

		public function get_sources() {
			return array( 'premium-api' );
		}

		public function get_document_type() {
			return array(
				'class' => 'Pixerex_Section_Document',
				'file'  => PIXEREX_ELEMENTS_PATH . 'includes/templates/documents/section.php',
			);
		}

		/**
		 * Library settings for current structure
		 *
		 * @return void
		 */
		public function library_settings() {

			return array(
				'show_title'    => false,
				'show_keywords' => true,
			);

		}

	}

}
