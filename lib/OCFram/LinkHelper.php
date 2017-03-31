<?php


namespace OCFram;


interface LinkHelper {
	static function getLinkTo( $action, $format = 'html', array $args = [] );
}