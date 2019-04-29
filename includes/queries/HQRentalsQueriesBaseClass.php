<?php

namespace HQRentalsPlugin\HQRentalsQueries;

abstract class HQRentalsQueriesBaseClass{
	abstract public function getAllMetaKey();
    abstract public function allToFrontEnd();
    abstract public function fillModelWithPosts( $posts );
}