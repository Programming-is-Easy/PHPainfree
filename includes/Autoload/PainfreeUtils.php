<?php 
	/**
	 * PainfreeUtils.php 
	 * @author Eric Ryan Harrison <me@ericharrison.info>
	 * @copyright 2026 Programming is Easy
	 *
	 * Useful collection of simple helper functions.
	 *
	 * -- MISC. FUNCTIONS --
	 * function timed(float $microts) : string - Returns a formatted microtime
	 *
	 * -- $_REQUEST FUNCTIONS --
	 * function idparam(string $param) : int|string
	 *
	 *
	 * -- DEBUGGING/ERROR FUNCTIONS --
	 * @method spy(mixed ...$args) : void - Pretty-formatted variable dumper.
	 *
	 */


/****************************************************************************
 * Simple Miscellaneous Helper and Utility functions
 ****************************************************************************/

/**
 * This function is similar to $Painfree->safe and produces output that 
 * can be used in templates with escaped html characters.
 *
 * @param ?string $unsafe 
 * @return string $safe
 */
function ss(?string $unsafe='') : string {
	if ( ! $unsafe ) {
		return '';
	}

	return htmlspecialchars($unsafe);
}

/**
 * Takes a timestamp and returns a version formatted for performance 
 * rendering. (Used in execution time)
 *
 * @param float $microts (Start time in microseconds)
 *
 * @return string $time_delta %0.4f
*/
function timed(float $microts) : string {
	return sprintf("%0.4f", (microtime(true) - $microts));
}

/**
 * Function takes a string with some number of indentations (both tab/space)
 * and subtracts those spaces from the start of each line to preserve indentation 
 * but align the entire string as far to the left as possible.
 *
 * @example 
 * \t\t\tSELECT
 * \t\t\t\tid,name,email
 * \t\t\tFROM users 
 * \t\t\tWHERE 
 * \t\t\t\tid = ?
 * becomes:
 * SELECT 
 * \tid,name,email 
 * FROM users 
 * WHERE 
 * \tid = ?
 *
 * @param string $text 
 * @return string $deindented_text 
 */
function dedent(string $text): string {
    // Normalize line endings
    $text = str_replace(["\r\n", "\r"], "\n", $text);

    // Split into lines
    $lines = explode("\n", $text);

    // Find the minimum indentation (ignore empty lines)
    $minIndent = null;
    foreach ($lines as $line) {
        if (trim($line) === '') {
            continue;
        }

        // Match leading tabs/spaces
        if (preg_match('/^(?P<indent>[ \t]+)/', $line, $m)) {
            $indentLen = strlen($m['indent']);
            if ($minIndent === null || $indentLen < $minIndent) {
                $minIndent = $indentLen;
            }
        } else {
            $minIndent = 0;
            break;
        }
    }

    // If no indentation found, return as-is
    if (!$minIndent) {
        return $text;
    }

    // Strip that many indentation characters from each line
    $pattern = '/^[ \t]{0,' . $minIndent . '}/';
    $lines = array_map(fn($line) => preg_replace($pattern, '', $line), $lines);

    return implode("\n", $lines);
}

/**
 * This function takes an SQL query and array of parameters 
 * and replaces all placeholders "?" with the respective value in the 
 * $args array.
 *
 * WARNING: THIS IS FOR DEBUGGING PURPOSES ONLY. THE PARAMATERS 
 * ARE _NOT_ ESCAPED. THIS FUNCTION SHOULD NOT BE USED TO MAKE ACTUAL 
 * DATABASE QUERIES.
 *
 * @param string $query 
 * @param array $args 
 * @return string $prepared_query 
 */
function replaysql(string $query, array $args=[]) : string {
	$query = dedent($query);

	$index = 0;
	return preg_replace_callback('/\?/', function() use (&$index, $args) {
		return "'{$args[$index++]}'";
	}, $query);
}

/****************************************************************************
 * $_REQUEST processing and management functions. 
 *
 * Each function takes a string as the first argument which should 
 * be the name of an expected request query paramater.
 *
 * If it exists, will perform lightweight processing of that passed parameter 
 ****************************************************************************/

/** 
 * Helper function to return the value of a request parameter that is 
 * an ID field. This field will either be processed as an int, or if 
 * the id field says "new", then "new" will be returned as a string.
 *
 * @param string $param - Request parameter to use 
 * @return int|string $value 
 */
function idparam(string $param) : int|string {
	return isset($_REQUEST[$param]) && $_REQUEST[$param] !== 'new' ? intval($_REQUEST[$param]) : 'new';
}

/** 
 * Helper function to return the exact value of a string if one is 
 * provided, and to use the value of an optional second argument if not.
 *
 * @param string $param - Request parameter to use 
 * @param mixed  $default - Default value to use if not set
 * @return mixed $value 
 */
function defaultparam(string $param, mixed $default, mixed $override=array()) : mixed {
	if ( $override ) {
		return isset($override[$param]) ? trim($override[$param]) : $default;

	}
	return isset($_REQUEST[$param]) ? trim($_REQUEST[$param]) : $default;
}

/** 
 * Nice function to ensure we store empty string in the database if a request 
 * param is not set. Return trimmed string if it is.
 *
 * @param string $param - Request parameter to use 
 * @return string $value 
 */
function nulltrimparam(string $param) : ?string {
	return isset($_REQUEST[$param]) ? trim($_REQUEST[$param]) : null;
}

/** 
 * Nice function to ensure we store empty string in the database if a request 
 * param is not set. Return trimmed string if it is.
 *
 * @param string $param - Request parameter to use 
 * @return string $value 
 */
function trimparam(string $param) : ?string {
	return isset($_REQUEST[$param]) ? trim($_REQUEST[$param]) : '';
}

/** 
 * Nice function to ensure we store null in the database if a request 
 * param is not set. Return intval() value if it is.
 *
 * @param string $param - Request parameter to use 
 * @return null|int $value 
 */
function nullintparam(string $param) : int|null {
	return isset($_REQUEST[$param]) && $_REQUEST[$param] ? intval($_REQUEST[$param]) : null;
}

/** 
 * Nice function to ensure we store null in the database if a request 
 * param is not set. Return intval() value if it is.
 *
 * @param string $param - Request parameter to use 
 * @return null|int $value 
 */
function intparam(string $param) : int|null {
	return isset($_REQUEST[$param]) ? intval($_REQUEST[$param]) : null;
}

/** 
 * Nice function to ensure we store null in the database if a request 
 * param is not set. Return float if it is.
 *
 * @param string $param - Request parameter to use 
 * @return null|float $value 
 */
function floatparam(string $param) : float|null {
	return isset($_REQUEST[$param]) ? floatval($_REQUEST[$param]) : null;
}

/** 
 * Nice function to ensure we store a float in the database if a request 
 * param is not set. Return float if it is.
 *
 * @param string $param - Request parameter to use 
 * @param float $default - Fallback float value to use
 * @return null|float $value 
 */
function defaultfloatparam(string $param, float $default) : float {
	return isset($_REQUEST[$param]) ? floatval($_REQUEST[$param]) : $default;
}

/** 
 * Nice function to ensure we store false if a request value is not set and true 
 * if it is.
 *
 * @param string $param - Request parameter to use 
 * @return bool $value 
 */
function boolparam(string $param) : bool {
	return isset($_REQUEST[$param]) ? true : false;
}

/** 
 * Nice function to ensure we store null in the database if a request 
 * param is not set.
 *
 * @param string $param - Request parameter to use 
 * @return mixed $value 
 */
function nullparam(string $param) : mixed {
	return isset($_REQUEST[$param]) ? $_REQUEST[$param] : null;
}

/** 
 * Nice function to ensure we have an array of elements from request params 
 * if provided, or an empty array if not.
 *
 * @param string $param - Request parameter to use 
 * @return array $values 
 */
function arrayparam(string $param) : array {
	return isset($_REQUEST[$param]) ? $_REQUEST[$param] : [];
}

/** 
 * Nice function to ensure we store a valid date object in the database 
 * if the param is set, or today's timestamp if not.
 *
 * @param string $param - Request parameter to use 
 * @return string $value 
 */
function todaydtparam(string $param) : string {
	return isset($_REQUEST[$param]) && $_REQUEST[$param] ? $_REQUEST[$param] . ' 12:00:00' : date('Y-m-d') . ' 12:00:00';
}

/** 
 * Function to ensure we have the correct type when looking at a date-based 
 * request parameter. dtparam() returns an empty string if the request parameter 
 * is not set.
 *
 * @param string $param - Request parameter to use 
 * @return string $value 
 */
function dtparam(string $param) : string {
	return isset($_REQUEST[$param]) && $_REQUEST[$param] ? $_REQUEST[$param] . ' 12:00:00' : '';
}

/** 
 * Nice function to ensure we have a valid date timestamp 
 * if the param is set, or null if not.
 *
 * @param string $param - Request parameter to use 
 * @return null|string $value 
 */
function nulldtparam(string $param) : ?string {
	return isset($_REQUEST[$param]) && $_REQUEST[$param] ? $_REQUEST[$param] . ' 12:00:00' : null;
}

/** 
 * Nice function to ensure we store null a valid date object in the database 
 * if the param is set, or null if not.
 *
 * @param string $param - Request parameter to use 
 * @return null|string $value 
 */
function nulldttzparam(string $param, int $tz_offset) : ?string {
	$dt = isset($_REQUEST[$param]) && $_REQUEST[$param] ? $_REQUEST[$param] : null;
	if ( $dt ) {
		$time = strtotime($dt) + ($tz_offset * 60);
		return date('Y-m-d H:i:s', $time);
	} 

	return $dt;
}

/****************************************************************************
 * Time/date params with timezone helpers. tz_offsets should be the value 
 * of the client-side Javascript new Date().getTimezoneOffset() method 
 * and return an offset from GMT in minutes.
 ****************************************************************************/

/**
 * This function takes a date string argument and returns true if that 
 * date is in the past, and false in all other conditions. Used to check 
 * termination dates on users and similar things.
 *
 * @param mixed $date Date string (or null)
 *
 * @return bool $date_is_in_past
 */
function past_date(mixed $date) : bool {
	if ( $date ) {
		$ts = strtotime($date);
		if ( $ts && $ts > time() ) {
			return true;
		}
	}

	return false;
}

/**
 * This function takes a date and returns a valid timeago.js <span> 
 * element including bootstrap tooltips on hover.
 * 
 * If you are not using bootstrap tooltips or timeago.js, do not 
 * use this function. :)
 *
 * @param string $d - Date that can be parsed with strtotime() 
 * @param array $opts - Array of options 
 *	- tz_offset - Timezone offset (in minutes)
 *	- title-format - tiny-date, short_formal_date
 *	- title-prefix - String to prepend to the tooltip 
 *  - label-prefix - String to prepend before the <span></span> element 
 *  - class - space-separated CSS classes to add to the <span>
 * @return string $timeago_element - '<span class="timeago" datetime="$d"></span>'
 */
function timeago(string $d, array $opts=array()) : string {
	$tz_offset = 0;
	if ( isset($opts['tz_offset']) ) {
		$tz_offset = $opts['tz_offset'];
	}

	$nice_date = nice_date($d, $tz_offset);
	$title = $nice_date;

	if ( isset($opts['title-format']) ) {
		if ( $opts['title-format'] === 'tiny_date' ) {
			$title = tiny_date($d, $tz_offset);
		} else if ( $opts['title-format'] === 'short_formal_date' ) {
			$title = short_formal_date($d, $tz_offset);

		// default date format for the tooltip title popup
		} else {
			$title = short_date($d, $tz_offset);
		}
	}

	if ( isset($opts['title-prefix']) ) {
		$title = str_replace('@', '<br>@', $title);
		$title = "{$opts['title-prefix']} {$title}";
	}
	$classes = 'timeago';
	if ( isset($opts['class']) ) {
		$classes = "timeago {$opts['class']}";
	}
	$label_prefix = '';
	if ( isset($opts['label-prefix']) ) {
		$label_prefix = ss($opts['label-prefix']) . ' ';
	}
	$tiny_date = tiny_date($d, $tz_offset);
	return "{$label_prefix}<span class=\"{$classes}\" datetime=\"{$d}Z\" title=\"{$title}\" data-bs-toggle=\"tooltip\" data-bs-html=\"true\">{$tiny_date}</span>";
}

/**
 * Feb 13th 2026
 *
 * @param ?string $date 
 * @param int $tz_offset=0 
 * @param string $invalid='n/a' 
 * @return string $formatted_date 
 */
function short_formal_date(?string $d=null, int $tz_offset=0, string $invalid='n/a') {
	if ( ! $d ) {
		return $invalid;
	}
	return date('M jS, Y', strtotime($d) - ($tz_offset * 60));
}

/**
 * Mon, February 13th, 2026
 * @param ?string $date 
 * @param int $tz_offset=0 
 * @return string $formatted_date 
 */
function formal_date(?string $d=null, int $tz_offset=0) {
	if ( ! $d ) {
		return 'n/a';
	}
	return date('D, F jS, Y', strtotime($d) - ($tz_offset * 60));
}

/**
 * Mon, February 13th, 2026 @ 4:30pm 
 * @param ?string $date 
 * @param int $tz_offset=0 
 * @return string $formatted_date 
 */
function nice_date(?string $d=null, int $tz_offset=0) {
	if ( ! $d ) {
		return 'n/a';
	}
	return date('D, F jS, Y @ h:ia', strtotime($d) - ($tz_offset * 60));
}

/**
 * 2026-02-13
 * @param ?string $date 
 * @param int $tz_offset=0 
 * @return string $formatted_date 
 */
function tiny_date_std(?string $d=null, int $tz_offset=0) {
	if ( ! $d ) {
		return 'n/a';
	}

	return date('Y-m-d', strtotime($d) - ($tz_offset * 60));
}

/**
 * 2026/02/13
 *
 * @param ?string $date 
 * @param int $tz_offset=0 
 * @return string $formatted_date 
 */
function tiny_date(?string $d=null, int $tz_offset=0) {
	if ( ! $d ) {
		return 'n/a';
	}

	return date('Y/m/d', strtotime($d) - ($tz_offset * 60));
}

/**
 * Feb 13th @ 4:30pm
 *
 * @param ?string $date 
 * @param int $tz_offset=0 
 * @return string $formatted_date 
 */
function short_date(?string $d=null, int $tz_offset=0) {
	if ( ! $d ) {
		return 'n/a';
	}
	return date('M jS @ h:ia', strtotime($d) - ($tz_offset * 60));
}

/**
 * 13 Feb 2026 @ 4:30pm
 *
 * @param ?string $date 
 * @param int $tz_offset=0 
 * @return string $formatted_date 
 */
function short_fulldatetime(?string $d=null, int $tz_offset=0) {
	if ( ! $d ) {
		return 'n/a';
	}
	return date('j M Y @ h:ia', strtotime($d) - ($tz_offset * 60));
}

/**
 * 2026-02-13 16:30:00
 *
 * @param ?string $date 
 * @param int $tz_offset=0 
 * @return string $formatted_date 
 */
function db_date(?string $d=null, int $tz_offset=0) { 
	if ( ! $d ) {
		return '';
	}
	return date('Y-m-d H:i:s', strtotime($d) - ($tz_offset * 60));
}

/**
 * Takes a strtotime() parsable date string and returns an array of 
 * information specific to that birthday such as total age, 
 * birthday next year, and birthday this year.
 *
 * @param ?string $date 
 * @param int $tz_offset=0 Timezone offset in minutes
 * @return array $birthday_info  
 */
function birthday(?string $d, int $tz_offset=0) : array {
	if ( ! $d ) {
		return array();
	}

	$cur_time = time();

	// calculate age
	$birth_ts = strtotime($d . ' 12:00:00'); 
	$diff = $cur_time - $birth_ts;
	$age = floor($diff / (365 * 60 * 60 * 24));

	// find closest birthday
	$dates = explode('-', $d);
	$cur_birthday = date('Y') . "-{$dates[1]}-{$dates[2]}";
	$cur_birthday_ts = strtotime($cur_birthday);
	$future_birthday = date('Y-m-d', strtotime('+1 year', strtotime($cur_birthday)));
	$future_birthday_ts = strtotime($future_birthday);

	// calc cur/future birthdays 
	$cur_diff = $cur_birthday_ts - $cur_time;
	$future_diff = $future_birthday_ts - $cur_time;

	return array(
		'birthday' => date('Y-m-d', $birth_ts),
		'age'      => $age,
		'this_year' => array(
			'birthday' => $cur_birthday,
			'diff'     => $cur_diff,
		),
		'next_year' => array(
			'birthday' => $future_birthday,
			'diff'     => $future_diff,
		),
	);
}

/****************************************************************************
 * DEBUGGING/ERROR Functions
 *
 * These functions are useful for printing out variables and information. 
 * Some of these functions (like bigmurder) have environment-specific handling 
 * that will display error information on development but a clean error page 
 * on production.
 ****************************************************************************/

/** 
 * This function will display the arguments provided in a nicely themed 
 * code block.
 *
 * @param mixed ...$args - one or more variables to display 
 * @return void
 */
function quietspy(mixed ...$args) : void {
	$App = get_App();

	echo '<div class="m-4 p-4 card-body bg-image-cover overlay border border-rounded rounded overlay-60 text-white" style="background-image: url(\'/images/theme/debug.jpg\'); background-size: contain;">';
	ob_start();
	debug_print_backtrace(0,2);
	$trace = nl2br(ob_get_contents());
	ob_end_clean();
	echo "<div class=\"mb-2 z-1 text-white\">{$trace}</div>";
	$db_errors = false; 
	if ( $App->db ) {
		$db_errors = $App->db->errors();
	}
	if ( $db_errors ) {
		echo '<h4 class="z-1 text-info fw-bolder">Database Errors</h4>';
		foreach ( $db_errors as $arg => $val ) {
			echo '<pre class="z-1 text-white">Error #' . $arg . ' = <span class="text-md user-select-all">' . print_r($val, true) . '</span></pre>';
		}
	}

	echo '<h4 class="z-1 text-info fw-bolder">Args</h4>';
	foreach ( $args as $arg => $val ) {
		echo '<pre class="z-1 text-white">Arg #' . $arg . ' = <span class="text-md user-select-all">' . print_r($val, true) . '</span></pre>';
	}
	echo '</div></div>';
}

/**
 * Display a stack trace at the location where this line of code is executed.
 */
function app_trace() : void {
	ob_start();
	debug_print_backtrace();
	$trace = ss(ob_get_contents());
	ob_end_clean();

	echo '<div class="m-4 p-4 card-body bg-image-cover overlay border border-rounded rounded overlay-60 text-white" style="background-image: url(\'/images/theme/debug.jpg\'); background-size: contain;">';
	echo '<h4 class="z-1 text-info fw-bolder">Stack Trace</h4>';
	echo '<pre class="z-1 text-white px-5">' . $trace . '</pre>';
	echo '</div>';
}

/** 
 * This function will display the arguments provided in a nicely themed 
 * code block.
 *
 * @param mixed ...$args - one or more variables to display 
 * @return void
 */
function spy(...$args) {
	$App = get_App();
	global $_SERVER;

	echo '<div class="m-4 p-4 card-body bg-image-cover overlay border border-rounded rounded overlay-60 text-white" style="background-image: url(\'/images/theme/debug.jpg\'); background-size: contain;">';
	echo '<h1 class="z-1 text-orange fw-bolder border-bottom border-yellow mb-4">Data Spy!</h1>';
	echo "<h4 class=\"z-1 text-white\"><span class=\"text-info\">Route:</span> <a href=\"/{$App->route}\">/{$App->route}</a></h4>";
	if ( isset($_SERVER['HTTP_REFERER']) ) {
		echo "<h4 class=\"z-1 text-white\"><span class=\"text-info\">Referrer:</span> <a href=\"/{$_SERVER['HTTP_REFERER']}\">{$_SERVER['HTTP_REFERER']}</a></h4>";
	}

	$db_errors = false;
	if ( $App->db ) {
		$db_errors = $App->db->errors();
	}

	ob_start();
	debug_print_backtrace();
	$trace = ss(ob_get_contents());
	ob_end_clean();
	echo '<h4 class="z-1 text-info fw-bolder">Stack Trace</h4>';
	echo '<pre class="z-1 text-white px-5">' . $trace . '</pre>';

	if ( $db_errors ) {
		echo '<h4 class="z-1 text-orange fw-bolder">DATABASE ERRORS</h4>';
		foreach ( $db_errors as $arg => $val ) {
			$err_message = '';
			if ( gettype($val) === 'array' ) {
				if ( str_contains($val['error'], 'near') ) {
					$err_parts = explode('near', $val['error']);
					$err_message = $err_parts[0] . "near\n<span class=\"text-warning\">" . dedent("\t" . $err_parts[1]) . '</span>';
				} else {
					$err_message = $val['error'];
				}
				echo '<pre class="z-1 text-yellow">Error #' . $arg . ' = <span class="text-md user-select-all text-white">' . print_r($err_message, true) . '</span></pre>';
				echo '<pre class="z-1 text-yellow">Query #' . $arg . ' = <span class="text-md user-select-all text-white">' . print_r($val['query'], true) . '</span></pre>';
			} else {
				$err_message = $val;
				echo '<pre class="z-1 text-yellow">Error #' . $arg . ' = <span class="text-md user-select-all text-white">' . print_r($err_message, true) . '</span></pre>';
			}
		}
	}

	// $vars = get_defined_vars();
	echo '<h4 class="z-1 text-info fw-bolder">Args</h4>';

	foreach ( $args as $arg => $val ) {
		if ( gettype($val) === 'array' && isset($val['compare']) && isset($val['compare']['a']) && isset($val['compare']['b']) ) {
			echo "
				<div class=\"table-responsive\">
					<table class=\"table table-sm\">
						<thead class=\"table-dark text-white\">
							<tr>
								<th colspan=\"2\" class=\"text-white fs-4\">Array Comparison</th>
							</tr>
							<tr>
								<th>Obj A</th>
								<th>Obj B</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<pre class=\"mvw-50 overflow-auto z-1 text-white\"><span class=\"user-select-all\">" . print_r($val['compare']['a'], true) . "</span></pre>
								</td>
								<td>
									<pre class=\"mvw-50 overflow-auto z-1 text-white\"><span class=\"user-select-all\">" . print_r($val['compare']['b'], true) . "</span></pre>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			";
		} else {
			echo '<pre class="z-1 text-white">Arg #' . $arg . ' = <span class="text-md user-select-all">' . print_r($val, true) . '</span></pre>';
		}
	}
	echo '</div>';
}

/** 
 * This function will display the arguments provided, but output them 
 * inside an HTML comment.
 *
 * @param mixed ...$args - one or more variables to display 
 * @return void
 */
function sneaky_spy(mixed ...$args) : void {
	ob_start();
	spy(...$args);
	$output = ob_get_contents();
	ob_end_clean();
	$output = str_replace('Data Spy', 'Error', $output);
	echo "
<!-- 
{$output} 
-->
	";
}

/**
 * The murder() function is a helpful wrapper around die() and adds 
 * pretty-printed arguments wrapped in a <pre> tag.
 *
 * Use this in place of quick `die('<pre>' . print_r($whatever,true) . '</pre>');`
 *
 * @param mixed ...$args - Any number of parameters will be printed in the page output.
 * @return void - This function exits with die() 
 */
function murder(mixed ...$args) : void {
	ob_start();
	spy(...$args);
	$output = ob_get_contents();
	ob_end_clean();
	$output = str_replace('Data Spy', 'Error', $output);
	die($output);
}

/**
 * The murder() function is a helpful wrapper around die() and adds 
 * pretty-printed arguments wrapped in a <pre> tag.
 *
 * Use this in place of quick `die('<pre>' . print_r($whatever,true) . '</pre>');`
 *
 * @param mixed ...$args - Any number of parameters will be printed in the page output.
 * @return void - This function exits with die() 
 */
function bigspy(...$args) {
	$App = get_App();

	$show_error = false;
	$show_trace = true;

	ob_start();
	spy(...$args);
	$output = ob_get_contents();
	ob_end_clean();
	$output = str_replace('Data Spy', 'Error', $output);

	$trace_out = $show_trace ? $output : '';

	$painfree_logo = '/images/logos/PHPainfree2-logo-rect-nobg.png';
	$nice_error = $show_error ? "
		<div style=\"padding:24px 24px 0px;\">
			<div class=\"p-4 px-md-15 mb-4\">
				<div class=\"text-center p-2 mb-4\">
					<a href=\"/\">
						<img src=\"{$painfree_logo}\" alt=\"PHPainfree Logo\" class=\"img-fluid img-thumbnail\" style=\"height:256px;\">
					</a>
				</div>
				<h1 class=\"display-6\">An unexpected error has occurred.</h1>
				<p class=\"lead\">
					The page you tried to access had an error and could not be loaded. 
					The engineering team has been notified and should have this fixed shortly.
				</p>
			</div>
			<div class=\"text-center\">
				<a href=\"/\" class=\"btn btn-primary text-lg fw-bold\">
					Reload Application
				</a>
			</div>
		</div>
	" : '';

	$html = "
		<html>
			<head>
				<title>PHPainfree Error! - [{$App->env}]</title>
				<link href=\"/css/styles.css\" rel=\"stylesheet\">
			</head>
			<body>
				{$nice_error}

				{$trace_out}
			</body>
		</html>
	";

	if ( ! $App->htmx ) {
		http_response_code(500);
	} else {
		$html = "
			<div id=\"htmx_target\">
				<div>{$nice_error}</div>
				<div>{$trace_out}</div>
			</div>
		";
	}

	die($html);
}

/**
 * The bigmurder() function is a more robust version of murder() 
 * and is expected to be called before template generation has begun.
 * This function will wrap the debug output with a fully valid HTML page 
 * and include all necessary CSS files required to display nice debugging information.
 *
 * **NOTE**: This function is safe to use on Production, as whenever the 
 * $App->env is "production", any user that doesn't have Developer permissions 
 * will be shown a nicely designed error page. If that is the case, then this 
 * function will send an email to the engineering team with that contents of 
 * the passed parameter values.
 *
 * @param mixed ...$args - Any number of parameters will be printed in the page output.
 * @return void - This function exits with die() 
 */
function bigmurder(mixed ...$args) : void {
	$App = get_App();

	$is_developer = true; // $App->User->isDeveloper();
	$http_code  = 500;
	$show_error = false;
	$show_trace = true;
	$send_email = false;
	if ( $App->env === 'production' ) {
		if ( ! $is_developer ) {
			$show_error = true;
			$show_trace = false;	
			$send_email = true;
		} else {
			$show_error = false;
			$show_trace = true;	
			$send_email = false;
		}
	}

	$hacking = false;
	if ( isset($args[0]['hacking']) ) {
		$hacking = $args[0]['hacking'];
	}
	if ( isset($args[0]['send-email']) ) {
		$send_email = $args[0]['send-email'];
	}
	if ( isset($args[0]['http-code']) ) {
		$http_code = $args[0]['http-code'];
	}

	// if ( $send_email ) {
	// 	$subject = 'Uncaught Server Error';
	// 	if ( isset($args[0]['subject']) ) {
	// 		$subject = $args[0]['subject'];
	// 	}
	// 	send_engineering_email($args, $subject);
	// }

	$return_button_url = '/';
	$return_button_label = 'Reload Application';
	if ( $hacking ) {
		$return_button_url = 'https://fbi.gov';
		$return_button_label = 'Go back to safety!';
	}

	ob_start();
	spy(...$args);
	$output = ob_get_contents();
	ob_end_clean();
	$output = str_replace('Data Spy', 'Error', $output);

	$trace_out = $show_trace ? $output : '';

	$painfree_logo = '/images/logos/PHPainfree2-logo-rect-nobg.png';
	$nice_error = $show_error ? "
		<div style=\"padding:24px 24px 0px;\">
			<div class=\"p-4 px-md-15 mb-4\">
				<div class=\"text-center p-2 mb-4\">
					<a href=\"/\">
						<img src=\"{$painfree_logo}\" alt=\"PHPainfree Logo\" class=\"img-fluid img-thumbnail\" style=\"height:256px;\">
					</a>
				</div>
				<h1 class=\"display-6\">An unexpected error has occurred.</h1>
				<p class=\"lead\">
					The page you tried to access had an error and could not be loaded. 
					The engineering team has been notified and should have this fixed shortly.
				</p>
			</div>
			<div class=\"text-center\">
				<a href=\"{$return_button_url}\" class=\"btn btn-primary text-lg fw-bold\">
					{$return_button_label}
				</a>
			</div>
		</div>
	" : '';

	$html = "
		<html>
			<head>
				<title>PHPainfree Request Error</title>
				<link href=\"/css/styles.css\" rel=\"stylesheet\">
			</head>
			<body>
				{$nice_error}

				{$trace_out}
			</body>
		</html>
	";

	$cur_http_code = http_response_code();
	if ( ! $App->htmx || isset($_REQUEST['htmx']) ) {
		if ( $cur_http_code && $http_code !== $cur_http_code && ! headers_sent() ) {
			http_response_code($http_code);
		}
	} else {
		if ( $cur_http_code && $http_code !== $cur_http_code && ! headers_sent() ) {
			http_response_code($http_code);
		}
		$html = "
			<div id=\"htmx_target\">
				<div>{$nice_error}</div>
				<div>{$trace_out}</div>
			</div>
		";
	}
	die($html);
}

/**
 * The big404() is a duplicate of bigmurder() but will display a 404 page 
 * to a user and set the correct 404 http_response_code.
 *
 * The email that it sends to the engineering team will distinguish itself 
 * from a bigmurder() server error with a 404-style subject line.
 *
 * @param mixed ...$args - Any number of parameters will be printed in the page output.
 * @return void - This function exits with die() 
 */
function big404(mixed ...$args) : void {
	$App = get_App();

	$is_developer = true; //$App->User->isDeveloper();
	$show_error = false;
	$show_trace = true;
	$send_email = false;
	if ( $App->env === 'production' ) {
		if ( ! $is_developer ) {
			$show_error = true;
			$show_trace = false;	
			$send_email = true;
		} else {
			$show_error = false;
			$show_trace = true;	
			$send_email = false;
		}
	}

	// If you have a function that will send you email notifications to 
	// your engineering team. Uncomment this line below or replace it with 
	// your own.
	// if ( $send_email ) {
	// 	send_engineering_email($args, 'Uncaught Server Error (404 Style)');
	// }

	ob_start();
	spy(...$args);
	$output = ob_get_contents();
	ob_end_clean();
	$output = str_replace('Data Spy', 'Error', $output);

	$trace_out = $show_trace ? $output : '';

	$painfree_logo = '/images/logos/PHPainfree2-logo-rect-nobg.png';
	$nice_error = $show_error ? "
		<div style=\"padding:24px 24px 0px;\">
			<div class=\"p-4 px-md-15 mb-4\">
				<div class=\"text-center p-2 mb-4\">
					<a href=\"/\">
						<img src=\"{$painfree_logo}\" alt=\"PHPainfree Logo\" class=\"img-fluid img-thumbnail\" style=\"height:256px;\">
					</a>
				</div>
				<h1 class=\"display-6\">File Not Found</h1>
				<p class=\"lead\">
					The page you tried to access either does not exist or is not available to your account.
				</p>
			</div>
			<div class=\"text-center\">
				<a href=\"/\" class=\"btn btn-primary text-lg fw-bold\">
					Reload Application
				</a>
			</div>
		</div>
	" : '';

	$html = "
		<html>
			<head>
				<title>PHPainfree2 Error! - [{$App->env}]</title>
				<link href=\"/css/styles.css\" rel=\"stylesheet\">
			</head>
			<body>
				{$nice_error}

				{$trace_out}
			</body>
		</html>
	";

	$http_code = http_response_code();
	if ( ! $App->htmx || isset($_REQUEST['htmx']) ) {
		if ( ! $http_code || $http_code !== 404 ) {
			http_response_code(404);
		}
	} else {
		$html = "
			<div id=\"htmx_target\">
				<div>{$nice_error}</div>
				<div>{$trace_out}</div>
			</div>
		";
	}
	die($html);
}

