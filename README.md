# CakePHP XHProf Plugin

[![Build Status](https://secure.travis-ci.org/renan/CakePHP-XHProf.png?branch=master)](http://travis-ci.org/renan/CakePHP-XHProf)
[![Coverage Status](https://coveralls.io/repos/renan/CakePHP-XHProf/badge.png)](https://coveralls.io/r/renan/CakePHP-XHProf)
[![Latest Stable Version](https://poser.pugx.org/renan/cakephp-xhprof/v/stable.svg)](https://packagist.org/packages/renan/cakephp-xhprof)


Plugin that quickly enables XHProf profiling for your CakePHP application.

## Requirements

* PHP 5.4+
* CakePHP 3
* XHProf

## Installation
First, make sure you enabled the xhprof extension and downloaded [phacility/xhprof](https://github.com/phacility/xhprof).

### Composer / Packagist

Extra information can be found at [Packagist](https://packagist.org/packages/renan/cakephp-xhprof).

This would install the latest 0.1 version to `Plugin/XHProf`:

```json
{
	"require": {
		"renan/cakephp-xhprof": "dev-master"
	},
	"repositories": [
		{
			"type": "vcs",
			"url": "git@github.com:dereuromark/CakePHP-XHProf.git"
		}
	],
}
```
You might want to use "require-dev" if you only plan to use this for development.

## Configuration

The basic configuration consists of loading the plugin and pointing where the `xhprof_lib` directory is located on your system.

In your `config/bootstrap.php` file:

```php
// Load XHProf Plugin
Plugin::load('XHProf');

// XHProf Configuration
Configure::write('XHProf', [
	'library' => '/usr/local/Cellar/php54-xhprof/270b75d/xhprof_lib',
]);
```

Options:

* `library`: Path to your xhprof_lib directory (required)
* `namespace`: Namespace to save your xhprof runs, default is your application directory name
* `flags`: Flags passed over to profiler, default is `0`. For a list of flags visit: http://php.net/xhprof.constants.php
* `ignored_functions`: Array of functions to ignore, default is `call_user_func` and `call_user_func_array`
* `replaceRunId`: Placeholder used to replace the run id in order to display a link in the page, set `false` to disable, default is `%XHProfRunId%`. Read the usage for more information

All options example:

```php
Configure::write('XHProf', [
	'library' => '/usr/local/Cellar/php54-xhprof/270b75d/xhprof_lib',
	'namespace' => 'myapp',
	'flags' => XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY,
	'ignored_functions' => [
		'my_function',
		'my_other_function',
	],
	'replaceRunId' => false,
]);
```

## Usage

### Dispatcher Filter

Just include the `XHProfFilter` in your dispatcher filters list in `config/bootstrap.php` after the plugin has been loaded:

```php
DispatcherFactory::add('XHProf.XHProf');
```

Note that using `['priority' => 1]` as options array seems to cause an infinite loop. So it is better left out (default to 10).

By default it will try to replace `%XHProfRunId%` with the saved run id from the page's output.
It allows you to include a link to the XHProf report on the page.

#### Hardcoding in Template
In your `src/Template/Layout/default.ctp`:

```php
$url = sprintf(
	'/url/to/xhprof_html/index.php?run=%s&source=%s',
	Configure::read('XHProf.replaceRunId'),
	Configure::read('XHProf.namespace')
);
echo $this->Html->link('XHProf Output', $url);
```

#### DebugKit Panel
If you are using [DebugKit](https://github.com/cakephp/debug_kit), you can use the provided panel here.

Make sure you include `html` config of the URL endpoint of the `xhprof_html` folder:
```php
Configure::write('XHProf', [
	'library' => '/usr/local/Cellar/php54-xhprof/270b75d/xhprof_lib',
	'html' => 'http://path/to/xhprof_html',
]);
```

Then you can add the panel in your DebugKit Configure panels setup:
```php
// This must come before the DebugKit is loaded!
Configure::write('DebugKit.panels', ['XHProf.XHProf']);
```

Done. It should now display the new panel with the link to the result of this page output.

### Manual

This method is very useful when profiling specific points on your code.
For that, just use the `XHProf` class to assist you.

Example:

```php
// Declare the class location
use XHProf\Lib\XHProf;

// Start the profiler
XHProf::start();

// ... your application code

// Stop the profiler
// 1. Returning the profiler data
$data = XHProf::stop();

// 2. or Save the profiler data, returning the run id
$runId = XHProf::finish();
```

_Note_: There are two ways to stop the profiler as explained above. However only one can be used at each run.


## License

MIT, please see [LICENSE](LICENSE).
