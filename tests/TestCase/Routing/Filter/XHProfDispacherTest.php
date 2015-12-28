<?php

namespace XHProf\TestCase\Routing\Filter;

use Cake\TestSuite\TestCase;
use XHProf\Routing\Filter\XHProfDispatcher;
use Cake\Event\Event;
use Cake\Network\Response;
use XHProf\Test\Lib\TestXHProf;

/**
 * XHProfDispatcher test case
 *
 */
class XHProfDispatcherTest extends TestCase {

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		parent::tearDown();

		TestXHProf::reset();
	}

	/**
	 * Test that beforeDispatcher replaces run id
	 *
	 * @return void
	 */
	public function testReplaceRunId() {
		$filter = new XHProfDispatcher();
		$response = new Response();
		$response->body('Run id: %XHProfRunId%.');

		$event = new Event('DispatcherTest', $this, compact('response'));
		$filter->beforeDispatch($event);
		$this->assertSame($response, $filter->afterDispatch($event));
		$this->assertRegExp('/^Run id: [0-9a-f]{13}\.$/', $response->body());
	}

}
