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
	 * @return \Cake\Network\Response|null Modified response if replaceRunId is defined
	 */
	public function afterDispatch(Event $event) {
		$runId = XHProf::finish();
		$replaceRunId = Configure::read('XHProf.replaceRunId');

		if (empty($replaceRunId)) {
			return null;
		}

		$body = $this->_getResponse($event)->body();
		$body = str_replace($replaceRunId, $runId, $event->data['response']);

		$this->_getResponse($event)->body($body);
		return $event->data['response'];
	}

	/**
	 * @param Event $event
	 * @return \Cake\Network\Response
	 */
	protected function _getResponse($event) {
		return $event->data['response'];
	}

}
