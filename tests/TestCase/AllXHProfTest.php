<?php

/**
 * Run All XHProf Tests in one
 *
 */namespace XHProf\Test\Case;

use Cake\Core\Plugin;


class AllXHProfTest extends PHPUnit_Framework_TestSuite {

/**
 * Suite define the tests for this suite
 *
 * @return void
 */
	public static function suite() {
		$path = Plugin::path('XHProf');

		$suite = new CakeTestSuite('All XHProf tests');
		$suite->addTestDirectoryRecursive($path . 'Test' . DS . 'Case' . DS);
		
		return $suite;
	}
}