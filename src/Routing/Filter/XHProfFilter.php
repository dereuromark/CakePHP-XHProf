<?php

namespace XHProf\Routing\Filter;

use Cake\Core\Configure;
use Cake\Routing\DispatcherFilter;
use XHProf\Lib\XHProf;
use Cake\Event\Event;

/**
 * XHProf Dispatcher Filter
 *
 */
class XHProfFilter extends DispatcherFilter {

/**
 * Start the profiler
 *
 * @param \Cake\Event\Event $event
 * @return void
 */
	public function beforeDispatch(Event $event) {
		XHProf::start();
	}

	/**
	 * Stop the profiler
	 *
	 * @param \Cake\Event\Event $event
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
