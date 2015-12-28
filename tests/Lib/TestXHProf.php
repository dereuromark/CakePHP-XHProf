<?php

namespace XHProf\Test\Lib;

use XHProf\Lib\XHProf;

/**
 * XHProf extended class to set the state of it
 */
class TestXHProf extends XHProf {

	/**
	 * @return void
	 */
	public static function reset() {
		self::$_initiated = false;

		if (self::started()) {
			self::stop();
		}
	}

}
