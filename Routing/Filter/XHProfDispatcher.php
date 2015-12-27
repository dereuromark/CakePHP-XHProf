<?php

namespace XHProf\Routing\Filter;

use Cake\Core\Configure;
use Cake\Routing\DispatcherFilter;
use XHProf\Lib\XHProf;

/**
 * XHProf Dispatcher Filter
 *
 */
class XHProfDispatcher extends DispatcherFilter {

/**
 * Start the profiler
 *
 * @param Event $event
 * @return void
 */
	public function beforeDispatch(Event $event) {
		XHProf::start();
	}

/**
 * Stop the profiler
 *
 * @return mixed Void or modified response if replaceRunId is defined
 */
	public function afterDispatch(Event $event) {
		$runId = XHProf::finish();
		$replaceRunId = Configure::read('XHProf.replaceRunId');

		if (!empty($replaceRunId)) {
			$body = $event->data['response']->body();
			$body = str_replace($replaceRunId, $runId, $event->data['response']);

			$event->data['response']->body($body);
			return $event->data['response'];
		}
	}

}
