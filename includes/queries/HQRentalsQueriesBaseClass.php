<?php

namespace HQRentalsPlugin\HQRentalsQueries;

abstract class HQRentalsQueriesBaseClass{
	abstract public function getAllMetaKey();

	public function allToFrontEnd() {
		global $wpdb;

		$all =
			$wpdb->get_results( "SELECT meta_value FROM wp_postmeta WHERE meta_key = '".$this->getAllMetaKey()."'" );
		if ( isset( $all[0]->meta_value ) ) {
			return json_decode( $all[0]->meta_value );
		}
		return false;
	}
}