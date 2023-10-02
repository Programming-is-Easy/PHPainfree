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
	public $Version  = '0.11.0';
	public $URI      = null;
	public $route    = '';
	public $Root     = '';
	public $db       = null;
	public $Autoload = array();
	public $__debug  = array(); // this is somewhat special.

	/* private members */
	private $options = array();

	public function logic() {
		return $this->options['LogicFolder'] . '/' . $this->options['ApplicationController'];
	}
	public function view() {
		return $this->options['TemplateFolder'] . '/' . $this->options['BaseView'];
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
