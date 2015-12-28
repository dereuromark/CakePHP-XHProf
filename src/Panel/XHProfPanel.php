<?php
/**
 * Custom Panel for https://github.com/cakephp/debug_kit
 */
namespace XHProf\Panel;

use Cake\Controller\Controller;

use DebugKit\DebugPanel;

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

}
