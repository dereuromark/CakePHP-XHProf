<?php
/**
 * Custom Panel for https://github.com/cakephp/debug_kit
 */namespace XHProf\Lib\Panel;

use Cake\Controller\Controller;


use DebugKit\Lib\DebugPanel;

/**
 * Provides XHProf link and infos.
 *
 */
class XHProfPanel extends DebugPanel {

	/**
	 * Defines which plugin this panel is from so the element can be located.
	 *
	 * @var string
	 */
	public $plugin = 'XHProf';

	/**
	 * Not used right now
	 *
	 * @param \Controller|string $controller
	 * @return array
	 */
	public function beforeRender(Controller $controller) {

		return array();
	}

}
