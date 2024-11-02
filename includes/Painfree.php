<?php
/************************** PHPainfree **************************
Name: Painfree.php

Author: Eric Ryan Harrison
	me@ericharrison.info
	http://ericharrison.info

Usage:
	This script should be called by index.php in your document
	root.

	YOU MUST HAVE A FILE CALLED PainfreeConfig.php
	in your includes/ directory. Define application
	"configuration" in that file. You really don't
	ever need to do anything with this file.

	Close your text editor now. This isn't the code you're
	looking for.
****************************************************************/
$__painfree_start_time = microtime(true);

require 'PainfreeConfig.php'; // you must have this file

$Painfree = new PHPainfree($PainfreeConfig);
$Painfree->URI = $_SERVER['SERVER_PORT'] == 80 ? 'http://' : 'https://';
$Painfree->URI .= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// process Autoload folder
$loaders = $Painfree->autoload();
foreach ( $loaders as $load ) {
	include $load;
}

include $Painfree->logic(); // load the application logic controller and process the request
include $Painfree->view();  // load the view

class PHPainfree {
	/* public members */
	// make sure we don't error if anything is relying on a version number
	public $Version  = '2.2.1';
	public $URI      = null;
	public $route    = '';
	public $Root     = '';
	public $db       = null;
	public $Autoload = array();
	public $__debug  = array(); // this is somewhat special.

	/* private members */
	private $options = array();

	/**
	 * Public Helper Functions
	 * - load_view($view, $missing='404') - Returns path to view template.
	 * - load_js($view, $defer=true) - Return a rendered <script> tag.
	 * - load_css($view) - Return a rendered <link> tag.
	 * - safe($string) - Returns a sanitized string safe for template output.
	 * - debug($heading, $obj) - Stores an object dump for later inspection.
	 */

	/**
	 * load_view() accepts a "view" as it's main argument and will return
	 * a path to a view template if it exists. If it does not exist, will 
	 * return a path to a "404" template that can be used to tell your user
	 * that the page they have requested was not found.
	 *
	 * This function will _always_ return a path to a file that you can 
	 * pass directly to `include`, `include_once`, `require`, or `require_once`.
	 *
	 * @requires `includes/Core/EmptyInclude.php`
	 *
	 * @param string $view The name of the template file to search for.
	 * @param string $missing The name of a template to use as a fallback.
	 *
	 * @returns string $path_to_file (defaults to EmptyInclude path)
	 */
	public function load_view($view, $missing='404') : string {
		$template_path = "{$this->Root}/{$this->options['TemplateFolder']}";
		$dynamic_path = "{$template_path}/{$this->options['DynamicFolder']}";

		if ( file_exists("{$template_path}/{$view}.php") ) {
			return "{$template_path}/{$view}.php";
		}
		if ( file_exists("{$dynamic_path}/{$view}.php") ) {
			return "{$dynamic_path}/{$view}.php";
		}

		return "{$this->Root}/{$this->options['LogicFolder']}/core/EmptyInclude.php";
	}

	/**
	 * load_js() accepts a "view" as it's main argument and will return
	 * a formatted script tag for the public file if it exists
	 * in the path. If the file does not exist, it will return an empty
	 * string so that it can safely be output in an HTML template.
	 *  
	 * Do **NOT** pass an extension to this function.
	 *
	 * @param string $view The name of the JS file to search for in the public path.
	 * @param bool $defer Boolean to specify if the defer tag should be included.
	 *
	 * @returns string $html_script_tag Either an empty string or an HTML script tag.
	 */
	public function load_js(string $view, $defer = true) : string {
		$content_path = "{$this->Root}/{$this->options['PublicFolder']}";
		$public_path  = "{$this->options['JsFolder']}";
		$dynamic_path = "{$public_path}/{$this->options['DynamicFolder']}";

		// Look for the "view" in both locations:
		// 1. top-level JS folder 
		// 2. dynamic "views" folder
		$public_url = false;
		if ( file_exists("{$content_path}/{$public_path}/{$view}.js") ) {
			$public_url = "{$public_path}/{$view}.js";
		}
		if ( file_exists("{$content_path}/{$dynamic_path}/{$view}.js") ) {
			$public_url = "{$dynamic_path}/{$view}.js";
		}

		// Return quickly if the file does not exist.
		if ( ! $public_url ) {
			return '';
		}

		if ( $defer ) {
			$defer = 'defer';
		} else {
			$defer = '';
		}
		return "<script src=\"/{$public_url}\" {$defer}></script>";
	}

	/**
	 * load_css() accepts a "view" as it's main argument and will return
	 * a formatted link tag for the public file if it exists
	 * in the path. If the file does not exist, it will return an empty
	 * string so that it can safely be output in an HTML template.
	 *
	 * Do **NOT** pass an extension to this function.
	 *
	 * @param string $view The name of the CSS file to search for in the public path.
	 *
	 * @returns string $html_link_tag Either an empty string or an HTML link tag.
	 */
	public function load_css(string $view) : string {
		$content_path = "{$this->Root}/{$this->options['PublicFolder']}";
		$public_path  = "{$this->options['CssFolder']}";
		$dynamic_path = "{$public_path}/{$this->options['DynamicFolder']}";

		// Look for the "view" in both locations:
		// 1. top-level CSS folder 
		// 2. dynamic "views" folder
		$public_url = false;
		if ( file_exists("{$content_path}/{$public_path}/{$view}.css") ) {
			$public_url = "{$public_path}/{$view}.css";
		}
		if ( file_exists("{$content_path}/{$dynamic_path}/{$view}.css") ) {
			$public_url = "{$dynamic_path}/{$view}.css";
		}

		// Return quickly if the file does not exist.
		if ( ! $public_url ) {
			return '';
		}

		return "<link href=\"/{$public_url}\" rel=\"stylesheet\" />";
	}

	/* string $Painfree->safe($unsafe_string)
		While $Painfree->safe() doesn't provide any form of guaranteed output
		security, it will at least be a convenient way to make output "safe-ish"
		for display. This method will probably need to evolve over time to
		provide more robust output sanitization.
	*/
	public function safe($unsafe='') : string {
		// null arguments to htmlspecialchars() is deprecated
		if ( ! $unsafe ) {
			return '';
		}
		return htmlspecialchars($unsafe);
	}

	public function debug($heading,$obj,$abort=false) {
		if ( $abort ) {
			die('<pre>' . $heading . ' = ' . print_r($obj,true) . '</pre>');
		}
		$this->__debug[$heading] = print_r($obj,true);
	}

	/**
	 * Internal Functions
	 * - autoload() - loads all scripts inside `includes/Autoload`
	 * - logic() - loads the script defined as `ApplicationController`
	 * - view() - loads the script defined as `BaseView`
	 *
	 * ------- CHANGE OR MODIFY WITH CAUTION --------
	 */
	public function autoload() {
		// process Autoload folder
		$auto_load_path = $this->Root . $this->options['LogicFolder'] . '/Autoload/*.php';
		$loaders = glob($auto_load_path);
		if ( is_array($loaders) && count($loaders) ) {
			foreach ( $loaders as $autoload ) {
				list($junk,$file_name) = explode('Autoload/', $autoload);
				$this->Autoload[$file_name] = $autoload;
			}
		}

		return $this->Autoload;
	}
	
	public function logic() {
		return $this->options['LogicFolder'] . '/' . $this->options['ApplicationController'];
	}

	public function view() {
		return $this->options['TemplateFolder'] . '/' . $this->options['BaseView'];
	}

	public function __construct($options) {
		$this->options = $options;

		// $this->Root is the root installation directory of PHPainfree
		list($root_path,$junk) = explode($this->options['LogicFolder'], __FILE__);
		$this->Root = $root_path;
	
		$this->route = isset($_REQUEST[$this->options['RouteParameter']]) ?
			$_REQUEST[$this->options['RouteParameter']] :
			$this->options['DefaultRoute'];

		// process database configuration
		if ( count($options['Database']) ) {
			include_once 'core/DBI.php';
			$this->DBI = new DBI($options['Database']);
			$this->db = $this->DBI->handle();
		}
	}
}
