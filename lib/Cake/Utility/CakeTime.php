<?php
/**
 * CakeTime utility class file.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       Cake.Utility
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use DateTime;
use DateTimeZone;
use DateTimeInterface;
use Exception;
use IntlDateFormatter;
use IntlGregorianCalendar;
use InvalidArgumentException;
use Locale;
  
App::uses('Multibyte', 'I18n');
App::import('Vendor', 'PHPMailer', array('file' => 'phpmailer'.DS.'src'.DS.'PHPMailer.php'));

/**
 * Time Helper class for easy use of time data.
 *
 * Manipulation of time data.
 *
 * @package       Cake.Utility
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html
 */
class CakeTime {

/**
 * The format to use when formatting a time using `CakeTime::nice()`
 *
 * The format should use the locale strings as defined in the PHP docs under
 * `strftime` (http://php.net/manual/en/function.strftime.php)
 *
 * @var string
 * @see CakeTime::format()
 */
	public static $niceFormat = '%a, %b %eS %Y, %H:%M';

/**
 * The format to use when formatting a time using `CakeTime::timeAgoInWords()`
 * and the difference is more than `CakeTime::$wordEnd`
 *
 * @var string
 * @see CakeTime::timeAgoInWords()
 */
	public static $wordFormat = 'j/n/y';

/**
 * The format to use when formatting a time using `CakeTime::niceShort()`
 * and the difference is between 3 and 7 days
 *
 * @var string
 * @see CakeTime::niceShort()
 */
	public static $niceShortFormat = '%B %d, %H:%M';

/**
 * The format to use when formatting a time using `CakeTime::timeAgoInWords()`
 * and the difference is less than `CakeTime::$wordEnd`
 *
 * @var array
 * @see CakeTime::timeAgoInWords()
 */
	public static $wordAccuracy = array(
		'year' => 'day',
		'month' => 'day',
		'week' => 'day',
		'day' => 'hour',
		'hour' => 'minute',
		'minute' => 'minute',
		'second' => 'second',
	);

/**
 * The end of relative time telling
 *
 * @var string
 * @see CakeTime::timeAgoInWords()
 */
	public static $wordEnd = '+1 month';

/**
 * Temporary variable containing the timestamp value, used internally in convertSpecifiers()
 *
 * @var int
 */
	protected static $_time = null;

/**
 * Magic set method for backwards compatibility.
 * Used by TimeHelper to modify static variables in CakeTime
 *
 * @param string $name Variable name
 * @param mixes $value Variable value
 * @return void
 */
	public function __set($name, $value) {
		switch ($name) {
			case 'niceFormat':
				static::${$name} = $value;
				break;
		}
	}

/**
 * Magic set method for backwards compatibility.
 * Used by TimeHelper to get static variables in CakeTime
 *
 * @param string $name Variable name
 * @return mixed
 */
	public function __get($name) {
		switch ($name) {
			case 'niceFormat':
				return static::${$name};
			default:
				return null;
		}
	}

/**
 * Converts a string representing the format for the function strftime and returns a
 * Windows safe and i18n aware format.
 *
 * @param string $format Format with specifiers for strftime function.
 *    Accepts the special specifier %S which mimics the modifier S for date()
 * @param string $time UNIX timestamp
 * @return string Windows safe and date() function compatible format for strftime
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::convertSpecifiers
 */
	public static function convertSpecifiers($format, $time = null) {
		if (!$time) {
			$time = time();
		}
		static::$_time = $time;
		return preg_replace_callback('/\%(\w+)/', array('CakeTime', '_translateSpecifier'), $format);
	}

/**
 * Auxiliary function to translate a matched specifier element from a regular expression into
 * a Windows safe and i18n aware specifier
 *
 * @param array $specifier match from regular expression
 * @return string converted element
 */
	protected static function _translateSpecifier($specifier) {
		switch ($specifier[1]) {
			case 'a':
				$abday = __dc('cake', 'abday', 5);
				if (is_array($abday)) {
					return $abday[date('w', static::$_time)];
				}
				break;
			case 'A':
				$day = __dc('cake', 'day', 5);
				if (is_array($day)) {
					return $day[date('w', static::$_time)];
				}
				break;
			case 'c':
				$format = __dc('cake', 'd_t_fmt', 5);
				if ($format !== 'd_t_fmt') {
					return static::convertSpecifiers($format, static::$_time);
				}
				break;
			case 'C':
				return sprintf("%02d", date('Y', static::$_time) / 100);
			case 'D':
				return '%m/%d/%y';
			case 'e':
				if (DS === '/') {
					return '%e';
				}
				$day = date('j', static::$_time);
				if ($day < 10) {
					$day = ' ' . $day;
				}
				return $day;
			case 'eS' :
				return date('jS', static::$_time);
			case 'b':
			case 'h':
				$months = __dc('cake', 'abmon', 5);
				if (is_array($months)) {
					return $months[date('n', static::$_time) - 1];
				}
				return '%b';
			case 'B':
				$months = __dc('cake', 'mon', 5);
				if (is_array($months)) {
					return $months[date('n', static::$_time) - 1];
				}
				break;
			case 'n':
				return "\n";
			case 'p':
			case 'P':
				$default = array('am' => 0, 'pm' => 1);
				$meridiem = $default[date('a', static::$_time)];
				$format = __dc('cake', 'am_pm', 5);
				if (is_array($format)) {
					$meridiem = $format[$meridiem];
					return ($specifier[1] === 'P') ? strtolower($meridiem) : strtoupper($meridiem);
				}
				break;
			case 'r':
				$complete = __dc('cake', 't_fmt_ampm', 5);
				if ($complete !== 't_fmt_ampm') {
					return str_replace('%p', static::_translateSpecifier(array('%p', 'p')), $complete);
				}
				break;
			case 'R':
				return date('H:i', static::$_time);
			case 't':
				return "\t";
			case 'T':
				return '%H:%M:%S';
			case 'u':
				return ($weekDay = date('w', static::$_time)) ? $weekDay : 7;
			case 'x':
				$format = __dc('cake', 'd_fmt', 5);
				if ($format !== 'd_fmt') {
					return static::convertSpecifiers($format, static::$_time);
				}
				break;
			case 'X':
				$format = __dc('cake', 't_fmt', 5);
				if ($format !== 't_fmt') {
					return static::convertSpecifiers($format, static::$_time);
				}
				break;
		}
		return $specifier[0];
	}

/**
 * Converts given time (in server's time zone) to user's local time, given his/her timezone.
 *
 * @param int $serverTime Server's timestamp.
 * @param string|DateTimeZone $timezone User's timezone string or DateTimeZone object.
 * @return int User's timezone timestamp.
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::convert
 */
	public static function convert($serverTime, $timezone) {
		static $serverTimezone = null;
		if ($serverTimezone === null || (date_default_timezone_get() !== $serverTimezone->getName())) {
			$serverTimezone = new DateTimeZone(date_default_timezone_get());
		}
		$serverOffset = $serverTimezone->getOffset(new DateTime('@' . $serverTime));
		$gmtTime = $serverTime - $serverOffset;
		if (is_numeric($timezone)) {
			$userOffset = $timezone * (60 * 60);
		} else {
			$timezone = static::timezone($timezone);
			$userOffset = $timezone->getOffset(new DateTime('@' . $gmtTime));
		}
		$userTime = $gmtTime + $userOffset;
		return (int)$userTime;
	}

/**
 * Returns a timezone object from a string or the user's timezone object
 *
 * @param string|DateTimeZone $timezone Timezone string or DateTimeZone object
 * 	If null it tries to get timezone from 'Config.timezone' config var
 * @return DateTimeZone Timezone object
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::timezone
 */
	public static function timezone($timezone = null) {
		static $tz = null;

		if (is_object($timezone)) {
			if ($tz === null || $tz->getName() !== $timezone->getName()) {
				$tz = $timezone;
			}
		} else {
			if ($timezone === null) {
				$timezone = Configure::read('Config.timezone');
				if ($timezone === null) {
					$timezone = date_default_timezone_get();
				}
			}

			if ($tz === null || $tz->getName() !== $timezone) {
				$tz = new DateTimeZone($timezone);
			}
		}

		return $tz;
	}

/**
 * Returns server's offset from GMT in seconds.
 *
 * @return int Offset
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::serverOffset
 */
	public static function serverOffset() {
		return date('Z', time());
	}

/**
 * Returns a timestamp, given either a UNIX timestamp or a valid strtotime() date string.
 *
 * @param int|string|DateTime $dateString UNIX timestamp, strtotime() valid string or DateTime object
 * @param string|DateTimeZone $timezone Timezone string or DateTimeZone object
 * @return int|false Parsed given timezone timestamp.
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::fromString
 */
	public static function fromString($dateString, $timezone = null) {
		if (empty($dateString)) {
			return false;
		}

		$containsDummyDate = (is_string($dateString) && substr($dateString, 0, 10) === '0000-00-00');
		if ($containsDummyDate) {
			return false;
		}

		if (is_int($dateString) || is_numeric($dateString)) {
			$date = (int)$dateString;
		} elseif ($dateString instanceof DateTime &&
			$dateString->getTimezone()->getName() != date_default_timezone_get()
		) {
			$clone = clone $dateString;
			$clone->setTimezone(new DateTimeZone(date_default_timezone_get()));
			$date = (int)$clone->format('U') + $clone->getOffset();
		} elseif ($dateString instanceof DateTime) {
			$date = (int)$dateString->format('U');
		} else {
			$date = strtotime($dateString);
		}

		if ($date === -1 || empty($date)) {
			return false;
		}

		if ($timezone === null) {
			$timezone = Configure::read('Config.timezone');
		}

		if ($timezone !== null) {
			return static::convert($date, $timezone);
		}
		return $date;
	}

/**
 * Returns a nicely formatted date string for given Datetime string.
 *
 * See http://php.net/manual/en/function.strftime.php for information on formatting
 * using locale strings.
 *
 * @param int|string|DateTime $date UNIX timestamp, strtotime() valid string or DateTime object
 * @param string|DateTimeZone $timezone Timezone string or DateTimeZone object
 * @param string $format The format to use. If null, `CakeTime::$niceFormat` is used
 * @return string Formatted date string
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::nice
 */
	public static function nice($date = null, $timezone = null, $format = null) {
		if (!$date) {
			$date = time();
		}
		$timestamp = static::fromString($date, $timezone);
		if (!$format) {
			$format = static::$niceFormat;
		}
		$convertedFormat = static::convertSpecifiers($format, $timestamp);
		return static::_strftimeWithTimezone($convertedFormat, $timestamp, $date, $timezone);
	}

/**
 * Returns a formatted descriptive date string for given datetime string.
 *
 * If the given date is today, the returned string could be "Today, 16:54".
 * If the given date is tomorrow, the returned string could be "Tomorrow, 16:54".
 * If the given date was yesterday, the returned string could be "Yesterday, 16:54".
 * If the given date is within next or last week, the returned string could be "On Thursday, 16:54".
 * If $dateString's year is the current year, the returned string does not
 * include mention of the year.
 *
 * @param int|string|DateTime $date UNIX timestamp, strtotime() valid string or DateTime object
 * @param string|DateTimeZone $timezone Timezone string or DateTimeZone object
 * @return string Described, relative date string
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::niceShort
 */
	public static function niceShort($date = null, $timezone = null) {
		if (!$date) {
			$date = time();
		}
		$timestamp = static::fromString($date, $timezone);

		if (static::isToday($date, $timezone)) {
			$formattedDate = static::_strftimeWithTimezone("%H:%M", $timestamp, $date, $timezone);
			return __d('cake', 'Today, %s', $formattedDate);
		}
		if (static::wasYesterday($date, $timezone)) {
			$formattedDate = static::_strftimeWithTimezone("%H:%M", $timestamp, $date, $timezone);
			return __d('cake', 'Yesterday, %s', $formattedDate);
		}
		if (static::isTomorrow($date, $timezone)) {
			$formattedDate = static::_strftimeWithTimezone("%H:%M", $timestamp, $date, $timezone);
			return __d('cake', 'Tomorrow, %s', $formattedDate);
		}

		$d = static::_strftimeWithTimezone("%w", $timestamp, $date, $timezone);
		$day = array(
			__d('cake', 'Sunday'),
			__d('cake', 'Monday'),
			__d('cake', 'Tuesday'),
			__d('cake', 'Wednesday'),
			__d('cake', 'Thursday'),
			__d('cake', 'Friday'),
			__d('cake', 'Saturday')
		);
		if (static::wasWithinLast('7 days', $date, $timezone)) {
			$formattedDate = static::_strftimeWithTimezone(static::$niceShortFormat, $timestamp, $date, $timezone);
			return sprintf('%s %s', $day[$d], $formattedDate);
		}
		if (static::isWithinNext('7 days', $date, $timezone)) {
			$formattedDate = static::_strftimeWithTimezone(static::$niceShortFormat, $timestamp, $date, $timezone);
			return __d('cake', 'On %s %s', $day[$d], $formattedDate);
		}

		$y = '';
		if (!static::isThisYear($timestamp)) {
			$y = ' %Y';
		}
		$format = static::convertSpecifiers("%b %eS{$y}, %H:%M", $timestamp);
		return static::_strftimeWithTimezone($format, $timestamp, $date, $timezone);
	}

/**
 * Returns a partial SQL string to search for all records between two dates.
 *
 * @param int|string|DateTime $begin UNIX timestamp, strtotime() valid string or DateTime object
 * @param int|string|DateTime $end UNIX timestamp, strtotime() valid string or DateTime object
 * @param string $fieldName Name of database field to compare with
 * @param string|DateTimeZone $timezone Timezone string or DateTimeZone object
 * @return string Partial SQL string.
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::daysAsSql
 */
	public static function daysAsSql($begin, $end, $fieldName, $timezone = null) {
		$begin = static::fromString($begin, $timezone);
		$end = static::fromString($end, $timezone);
		$begin = date('Y-m-d', $begin) . ' 00:00:00';
		$end = date('Y-m-d', $end) . ' 23:59:59';

		return "($fieldName >= '$begin') AND ($fieldName <= '$end')";
	}

/**
 * Returns a partial SQL string to search for all records between two times
 * occurring on the same day.
 *
 * @param int|string|DateTime $dateString UNIX timestamp, strtotime() valid string or DateTime object
 * @param string $fieldName Name of database field to compare with
 * @param string|DateTimeZone $timezone Timezone string or DateTimeZone object
 * @return string Partial SQL string.
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::dayAsSql
 */
	public static function dayAsSql($dateString, $fieldName, $timezone = null) {
		return static::daysAsSql($dateString, $dateString, $fieldName, $timezone);
	}

/**
 * Returns true if given datetime string is today.
 *
 * @param int|string|DateTime $dateString UNIX timestamp, strtotime() valid string or DateTime object
 * @param string|DateTimeZone $timezone Timezone string or DateTimeZone object
 * @return bool True if datetime string is today
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::isToday
 */
	public static function isToday($dateString, $timezone = null) {
		$timestamp = static::fromString($dateString, $timezone);
		$now = static::fromString('now', $timezone);
		return date('Y-m-d', $timestamp) === date('Y-m-d', $now);
	}

/**
 * Returns true if given datetime string is in the future.
 *
 * @param int|string|DateTime $dateString UNIX timestamp, strtotime() valid string or DateTime object
 * @param string|DateTimeZone $timezone Timezone string or DateTimeZone object
 * @return bool True if datetime string is in the future
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::isFuture
 */
	public static function isFuture($dateString, $timezone = null) {
		$timestamp = static::fromString($dateString, $timezone);
		return $timestamp > time();
	}

/**
 * Returns true if given datetime string is in the past.
 *
 * @param int|string|DateTime $dateString UNIX timestamp, strtotime() valid string or DateTime object
 * @param string|DateTimeZone $timezone Timezone string or DateTimeZone object
 * @return bool True if datetime string is in the past
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::isPast
 */
	public static function isPast($dateString, $timezone = null) {
		$timestamp = static::fromString($dateString, $timezone);
		return $timestamp < time();
	}

/**
 * Returns true if given datetime string is within this week.
 *
 * @param int|string|DateTime $dateString UNIX timestamp, strtotime() valid string or DateTime object
 * @param string|DateTimeZone $timezone Timezone string or DateTimeZone object
 * @return bool True if datetime string is within current week
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::isThisWeek
 */
	public static function isThisWeek($dateString, $timezone = null) {
		$timestamp = static::fromString($dateString, $timezone);
		$now = static::fromString('now', $timezone);
		return date('W o', $timestamp) === date('W o', $now);
	}

/**
 * Returns true if given datetime string is within this month
 *
 * @param int|string|DateTime $dateString UNIX timestamp, strtotime() valid string or DateTime object
 * @param string|DateTimeZone $timezone Timezone string or DateTimeZone object
 * @return bool True if datetime string is within current month
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::isThisMonth
 */
	public static function isThisMonth($dateString, $timezone = null) {
		$timestamp = static::fromString($dateString, $timezone);
		$now = static::fromString('now', $timezone);
		return date('m Y', $timestamp) === date('m Y', $now);
	}

/**
 * Returns true if given datetime string is within current year.
 *
 * @param int|string|DateTime $dateString UNIX timestamp, strtotime() valid string or DateTime object
 * @param string|DateTimeZone $timezone Timezone string or DateTimeZone object
 * @return bool True if datetime string is within current year
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::isThisYear
 */
	public static function isThisYear($dateString, $timezone = null) {
		$timestamp = static::fromString($dateString, $timezone);
		$now = static::fromString('now', $timezone);
		return date('Y', $timestamp) === date('Y', $now);
	}

/**
 * Returns true if given datetime string was yesterday.
 *
 * @param int|string|DateTime $dateString UNIX timestamp, strtotime() valid string or DateTime object
 * @param string|DateTimeZone $timezone Timezone string or DateTimeZone object
 * @return bool True if datetime string was yesterday
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::wasYesterday
 */
	public static function wasYesterday($dateString, $timezone = null) {
		$timestamp = static::fromString($dateString, $timezone);
		$yesterday = static::fromString('yesterday', $timezone);
		return date('Y-m-d', $timestamp) === date('Y-m-d', $yesterday);
	}

/**
 * Returns true if given datetime string is tomorrow.
 *
 * @param int|string|DateTime $dateString UNIX timestamp, strtotime() valid string or DateTime object
 * @param string|DateTimeZone $timezone Timezone string or DateTimeZone object
 * @return bool True if datetime string was yesterday
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::isTomorrow
 */
	public static function isTomorrow($dateString, $timezone = null) {
		$timestamp = static::fromString($dateString, $timezone);
		$tomorrow = static::fromString('tomorrow', $timezone);
		return date('Y-m-d', $timestamp) === date('Y-m-d', $tomorrow);
	}

/**
 * Returns the quarter
 *
 * @param int|string|DateTime $dateString UNIX timestamp, strtotime() valid string or DateTime object
 * @param bool $range if true returns a range in Y-m-d format
 * @return int|array 1, 2, 3, or 4 quarter of year or array if $range true
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::toQuarter
 */
	public static function toQuarter($dateString, $range = false) {
		$time = static::fromString($dateString);
		$date = (int)ceil(date('m', $time) / 3);
		if ($range === false) {
			return $date;
		}

		$year = date('Y', $time);
		switch ($date) {
			case 1:
				return array($year . '-01-01', $year . '-03-31');
			case 2:
				return array($year . '-04-01', $year . '-06-30');
			case 3:
				return array($year . '-07-01', $year . '-09-30');
			case 4:
				return array($year . '-10-01', $year . '-12-31');
		}
	}

/**
 * Returns a UNIX timestamp from a textual datetime description. Wrapper for PHP function strtotime().
 *
 * @param int|string|DateTime $dateString UNIX timestamp, strtotime() valid string or DateTime object
 * @param string|DateTimeZone $timezone Timezone string or DateTimeZone object
 * @return int Unix timestamp
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::toUnix
 */
	public static function toUnix($dateString, $timezone = null) {
		return static::fromString($dateString, $timezone);
	}

/**
 * Returns a formatted date in server's timezone.
 *
 * If a DateTime object is given or the dateString has a timezone
 * segment, the timezone parameter will be ignored.
 *
 * If no timezone parameter is given and no DateTime object, the passed $dateString will be
 * considered to be in the UTC timezone.
 *
 * @param int|string|DateTime $dateString UNIX timestamp, strtotime() valid string or DateTime object
 * @param string|DateTimeZone $timezone Timezone string or DateTimeZone object
 * @param string $format date format string
 * @return mixed Formatted date
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::toServer
 */
	public static function toServer($dateString, $timezone = null, $format = 'Y-m-d H:i:s') {
		if ($timezone === null) {
			$timezone = new DateTimeZone('UTC');
		} elseif (is_string($timezone)) {
			$timezone = new DateTimeZone($timezone);
		} elseif (!($timezone instanceof DateTimeZone)) {
			return false;
		}

		if ($dateString instanceof DateTime) {
			$date = $dateString;
		} elseif (is_int($dateString) || is_numeric($dateString)) {
			$dateString = (int)$dateString;

			$date = new DateTime('@' . $dateString);
			$date->setTimezone($timezone);
		} else {
			$date = new DateTime($dateString, $timezone);
		}

		$date->setTimezone(new DateTimeZone(date_default_timezone_get()));
		return $date->format($format);
	}

/**
 * Returns a date formatted for Atom RSS feeds.
 *
 * @param string $dateString Datetime string or Unix timestamp
 * @param string|DateTimeZone $timezone Timezone string or DateTimeZone object
 * @return string Formatted date string
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::toAtom
 */
	public static function toAtom($dateString, $timezone = null) {
		return date('Y-m-d\TH:i:s\Z', static::fromString($dateString, $timezone));
	}

/**
 * Formats date for RSS feeds
 *
 * @param int|string|DateTime $dateString UNIX timestamp, strtotime() valid string or DateTime object
 * @param string|DateTimeZone $timezone Timezone string or DateTimeZone object
 * @return string Formatted date string
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::toRSS
 */
	public static function toRSS($dateString, $timezone = null) {
		$date = static::fromString($dateString, $timezone);

		if ($timezone === null) {
			return date("r", $date);
		}

		$userOffset = $timezone;
		if (!is_numeric($timezone)) {
			if (!is_object($timezone)) {
				$timezone = new DateTimeZone($timezone);
			}
			$currentDate = new DateTime('@' . $date);
			$currentDate->setTimezone($timezone);
			$userOffset = $timezone->getOffset($currentDate) / 60 / 60;
		}

		$timezone = '+0000';
		if ($userOffset != 0) {
			$hours = (int)floor(abs($userOffset));
			$minutes = (int)(fmod(abs($userOffset), $hours) * 60);
			$timezone = ($userOffset < 0 ? '-' : '+') . str_pad($hours, 2, '0', STR_PAD_LEFT) . str_pad($minutes, 2, '0', STR_PAD_LEFT);
		}
		return date('D, d M Y H:i:s', $date) . ' ' . $timezone;
	}

/**
 * Returns either a relative or a formatted absolute date depending
 * on the difference between the current time and given datetime.
 * $datetime should be in a *strtotime* - parsable format, like MySQL's datetime datatype.
 *
 * ### Options:
 *
 * - `format` => a fall back format if the relative time is longer than the duration specified by end
 * - `accuracy` => Specifies how accurate the date should be described (array)
 *    - year =>   The format if years > 0   (default "day")
 *    - month =>  The format if months > 0  (default "day")
 *    - week =>   The format if weeks > 0   (default "day")
 *    - day =>    The format if weeks > 0   (default "hour")
 *    - hour =>   The format if hours > 0   (default "minute")
 *    - minute => The format if minutes > 0 (default "minute")
 *    - second => The format if seconds > 0 (default "second")
 * - `end` => The end of relative time telling
 * - `relativeString` => The printf compatible string when outputting past relative time
 * - `relativeStringFuture` => The printf compatible string when outputting future relative time
 * - `absoluteString` => The printf compatible string when outputting absolute time
 * - `userOffset` => Users offset from GMT (in hours) *Deprecated* use timezone instead.
 * - `timezone` => The user timezone the timestamp should be formatted in.
 *
 * Relative dates look something like this:
 *
 * - 3 weeks, 4 days ago
 * - 15 seconds ago
 *
 * Default date formatting is d/m/yy e.g: on 18/2/09
 *
 * The returned string includes 'ago' or 'on' and assumes you'll properly add a word
 * like 'Posted ' before the function output.
 *
 * NOTE: If the difference is one week or more, the lowest level of accuracy is day
 *
 * @param int|string|DateTime $dateTime Datetime UNIX timestamp, strtotime() valid string or DateTime object
 * @param array $options Default format if timestamp is used in $dateString
 * @return string Relative time string.
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::timeAgoInWords
 */
	public static function timeAgoInWords($dateTime, $options = array()) {
		$timezone = null;
		$accuracies = static::$wordAccuracy;
		$format = static::$wordFormat;
		$relativeEnd = static::$wordEnd;
		$relativeStringPast = __d('cake', '%s ago');
		$relativeStringFuture = __d('cake', 'in %s');
		$absoluteString = __d('cake', 'on %s');

		if (is_string($options)) {
			$format = $options;
		} elseif (!empty($options)) {
			if (isset($options['timezone'])) {
				$timezone = $options['timezone'];
			} elseif (isset($options['userOffset'])) {
				$timezone = $options['userOffset'];
			}

			if (isset($options['accuracy'])) {
				if (is_array($options['accuracy'])) {
					$accuracies = array_merge($accuracies, $options['accuracy']);
				} else {
					foreach ($accuracies as $key => $level) {
						$accuracies[$key] = $options['accuracy'];
					}
				}
			}

			if (isset($options['format'])) {
				$format = $options['format'];
			}
			if (isset($options['end'])) {
				$relativeEnd = $options['end'];
			}
			if (isset($options['relativeString'])) {
				$relativeStringPast = $options['relativeString'];
				unset($options['relativeString']);
			}
			if (isset($options['relativeStringFuture'])) {
				$relativeStringFuture = $options['relativeStringFuture'];
				unset($options['relativeStringFuture']);
			}
			if (isset($options['absoluteString'])) {
				$absoluteString = $options['absoluteString'];
				unset($options['absoluteString']);
			}
			unset($options['end'], $options['format']);
		}

		$now = static::fromString(time(), $timezone);
		$inSeconds = static::fromString($dateTime, $timezone);
		$isFuture = ($inSeconds > $now);

		if ($isFuture) {
			$startTime = $now;
			$endTime = $inSeconds;
		} else {
			$startTime = $inSeconds;
			$endTime = $now;
		}
		$diff = $endTime - $startTime;

		if ($diff === 0) {
			return __d('cake', 'just now', 'just now');
		}

		$isAbsoluteDate = $diff > abs($now - static::fromString($relativeEnd));
		if ($isAbsoluteDate) {
			if (strpos($format, '%') === false) {
				$date = date($format, $inSeconds);
			} else {
				$date = static::_strftime($format, $inSeconds);
			}
			return sprintf($absoluteString, $date);
		}

		$years = $months = $weeks = $days = $hours = $minutes = $seconds = 0;

		// If more than a week, then take into account the length of months
		if ($diff >= 604800) {
			list($future['H'], $future['i'], $future['s'], $future['d'], $future['m'], $future['Y']) = explode('/', date('H/i/s/d/m/Y', $endTime));
			list($past['H'], $past['i'], $past['s'], $past['d'], $past['m'], $past['Y']) = explode('/', date('H/i/s/d/m/Y', $startTime));

			$years = $future['Y'] - $past['Y'];
			$months = $future['m'] + ((12 * $years) - $past['m']);

			if ($months >= 12) {
				$years = floor($months / 12);
				$months = $months - ($years * 12);
			}
			if ($future['m'] < $past['m'] && $future['Y'] - $past['Y'] === 1) {
				$years--;
			}

			if ($future['d'] >= $past['d']) {
				$days = $future['d'] - $past['d'];
			} else {
				$daysInPastMonth = date('t', $startTime);
				$daysInFutureMonth = date('t', mktime(0, 0, 0, $future['m'] - 1, 1, $future['Y']));

				if ($isFuture) {
					$days = ($daysInFutureMonth - $past['d']) + $future['d'];
				} else {
					$days = ($daysInPastMonth - $past['d']) + $future['d'];
				}

				if ($future['m'] != $past['m']) {
					$months--;
				}
			}

			if (!$months && $years >= 1 && $diff < ($years * 31536000)) {
				$months = 11;
				$years--;
			}

			if ($months >= 12) {
				$years = $years + 1;
				$months = $months - 12;
			}

			if ($days >= 7) {
				$weeks = floor($days / 7);
				$days = $days - ($weeks * 7);
			}
		} else {
			$days = floor($diff / 86400);
			$diff = $diff - ($days * 86400);

			$hours = floor($diff / 3600);
			$diff = $diff - ($hours * 3600);

			$minutes = floor($diff / 60);
			$diff = $diff - ($minutes * 60);

			$seconds = $diff;
		}

		$accuracy = $accuracies['second'];
		if ($years > 0) {
			$accuracy = $accuracies['year'];
		} elseif (abs($months) > 0) {
			$accuracy = $accuracies['month'];
		} elseif (abs($weeks) > 0) {
			$accuracy = $accuracies['week'];
		} elseif (abs($days) > 0) {
			$accuracy = $accuracies['day'];
		} elseif (abs($hours) > 0) {
			$accuracy = $accuracies['hour'];
		} elseif (abs($minutes) > 0) {
			$accuracy = $accuracies['minute'];
		}

		$accuracyNum = str_replace(array('year', 'month', 'week', 'day', 'hour', 'minute', 'second'), array(1, 2, 3, 4, 5, 6, 7), $accuracy);

		$relativeDate = array();
		if ($accuracyNum >= 1 && $years > 0) {
			$relativeDate[] = __dn('cake', '%d year', '%d years', $years, $years);
		}
		if ($accuracyNum >= 2 && $months > 0) {
			$relativeDate[] = __dn('cake', '%d month', '%d months', $months, $months);
		}
		if ($accuracyNum >= 3 && $weeks > 0) {
			$relativeDate[] = __dn('cake', '%d week', '%d weeks', $weeks, $weeks);
		}
		if ($accuracyNum >= 4 && $days > 0) {
			$relativeDate[] = __dn('cake', '%d day', '%d days', $days, $days);
		}
		if ($accuracyNum >= 5 && $hours > 0) {
			$relativeDate[] = __dn('cake', '%d hour', '%d hours', $hours, $hours);
		}
		if ($accuracyNum >= 6 && $minutes > 0) {
			$relativeDate[] = __dn('cake', '%d minute', '%d minutes', $minutes, $minutes);
		}
		if ($accuracyNum >= 7 && $seconds > 0) {
			$relativeDate[] = __dn('cake', '%d second', '%d seconds', $seconds, $seconds);
		}
		$relativeDate = implode(', ', $relativeDate);

		if ($relativeDate) {
			$relativeString = ($isFuture) ? $relativeStringFuture : $relativeStringPast;
			return sprintf($relativeString, $relativeDate);
		}

		if ($isFuture) {
			$strings = array(
				'second' => __d('cake', 'in about a second'),
				'minute' => __d('cake', 'in about a minute'),
				'hour' => __d('cake', 'in about an hour'),
				'day' => __d('cake', 'in about a day'),
				'week' => __d('cake', 'in about a week'),
				'year' => __d('cake', 'in about a year')
			);
		} else {
			$strings = array(
				'second' => __d('cake', 'about a second ago'),
				'minute' => __d('cake', 'about a minute ago'),
				'hour' => __d('cake', 'about an hour ago'),
				'day' => __d('cake', 'about a day ago'),
				'week' => __d('cake', 'about a week ago'),
				'year' => __d('cake', 'about a year ago')
			);
		}

		return $strings[$accuracy];
	}

/**
 * Returns true if specified datetime was within the interval specified, else false.
 *
 * @param string|int $timeInterval the numeric value with space then time type.
 *    Example of valid types: 6 hours, 2 days, 1 minute.
 * @param int|string|DateTime $dateString UNIX timestamp, strtotime() valid string or DateTime object
 * @param string|DateTimeZone $timezone Timezone string or DateTimeZone object
 * @return bool
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::wasWithinLast
 */
	public static function wasWithinLast($timeInterval, $dateString, $timezone = null) {
		$tmp = str_replace(' ', '', $timeInterval);
		if (is_numeric($tmp)) {
			$timeInterval = $tmp . ' ' . __d('cake', 'days');
		}

		$date = static::fromString($dateString, $timezone);
		$interval = static::fromString('-' . $timeInterval);
		$now = static::fromString('now', $timezone);

		return $date >= $interval && $date <= $now;
	}

/**
 * Returns true if specified datetime is within the interval specified, else false.
 *
 * @param string|int $timeInterval the numeric value with space then time type.
 *    Example of valid types: 6 hours, 2 days, 1 minute.
 * @param int|string|DateTime $dateString UNIX timestamp, strtotime() valid string or DateTime object
 * @param string|DateTimeZone $timezone Timezone string or DateTimeZone object
 * @return bool
 */
	public static function isWithinNext($timeInterval, $dateString, $timezone = null) {
		$tmp = str_replace(' ', '', $timeInterval);
		if (is_numeric($tmp)) {
			$timeInterval = $tmp . ' ' . __d('cake', 'days');
		}

		$date = static::fromString($dateString, $timezone);
		$interval = static::fromString('+' . $timeInterval);
		$now = static::fromString('now', $timezone);

		return $date <= $interval && $date >= $now;
	}

/**
 * Returns gmt as a UNIX timestamp.
 *
 * @param int|string|DateTime $dateString UNIX timestamp, strtotime() valid string or DateTime object
 * @return int UNIX timestamp
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::gmt
 */
	public static function gmt($dateString = null) {
		$time = time();
		if ($dateString) {
			$time = static::fromString($dateString);
		}
		return gmmktime(
			(int)date('G', $time),
			(int)date('i', $time),
			(int)date('s', $time),
			(int)date('n', $time),
			(int)date('j', $time),
			(int)date('Y', $time)
		);
	}

/**
 * Returns a formatted date string, given either a UNIX timestamp or a valid strtotime() date string.
 * This function also accepts a time string and a format string as first and second parameters.
 * In that case this function behaves as a wrapper for TimeHelper::i18nFormat()
 *
 * ## Examples
 *
 * Create localized & formatted time:
 *
 * ```
 *   CakeTime::format('2012-02-15', '%m-%d-%Y'); // returns 02-15-2012
 *   CakeTime::format('2012-02-15 23:01:01', '%c'); // returns preferred date and time based on configured locale
 *   CakeTime::format('0000-00-00', '%d-%m-%Y', 'N/A'); // return N/A becuase an invalid date was passed
 *   CakeTime::format('2012-02-15 23:01:01', '%c', 'N/A', 'America/New_York'); // converts passed date to timezone
 * ```
 *
 * @param int|string|DateTime $date UNIX timestamp, strtotime() valid string or DateTime object (or a date format string)
 * @param int|string|DateTime $format date format string (or UNIX timestamp, strtotime() valid string or DateTime object)
 * @param bool|string $default if an invalid date is passed it will output supplied default value. Pass false if you want raw conversion value
 * @param string|DateTimeZone $timezone Timezone string or DateTimeZone object
 * @return string Formatted date string
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::format
 * @see CakeTime::i18nFormat()
 */
	public static function format($date, $format = null, $default = false, $timezone = null) {
		//Backwards compatible params re-order test
		$time = static::fromString($format, $timezone);

		if ($time === false) {
			return static::i18nFormat($date, $format, $default, $timezone);
		}
		return date($date, $time);
	}

/**
 * Returns a formatted date string, given either a UNIX timestamp or a valid strtotime() date string.
 * It takes into account the default date format for the current language if a LC_TIME file is used.
 *
 * @param int|string|DateTime $date UNIX timestamp, strtotime() valid string or DateTime object
 * @param string $format strftime format string.
 * @param bool|string $default if an invalid date is passed it will output supplied default value. Pass false if you want raw conversion value
 * @param string|DateTimeZone $timezone Timezone string or DateTimeZone object
 * @return string Formatted and translated date string
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::i18nFormat
 */
	public static function i18nFormat($date, $format = null, $default = false, $timezone = null) {
		$timestamp = static::fromString($date, $timezone);
		if ($timestamp === false && $default !== false) {
			return $default;
		}
		if ($timestamp === false) {
			return '';
		}
		if (empty($format)) {
			$format = '%x';
		}
		$convertedFormat = static::convertSpecifiers($format, $timestamp);
		return static::_strftimeWithTimezone($convertedFormat, $timestamp, $date, $timezone);
	}

/**
 * Get list of timezone identifiers
 *
 * @param int|string $filter A regex to filter identifier
 * 	Or one of DateTimeZone class constants (PHP 5.3 and above)
 * @param string $country A two-letter ISO 3166-1 compatible country code.
 * 	This option is only used when $filter is set to DateTimeZone::PER_COUNTRY (available only in PHP 5.3 and above)
 * @param bool|array $options If true (default value) groups the identifiers list by primary region.
 * 	Otherwise, an array containing `group`, `abbr`, `before`, and `after` keys.
 * 	Setting `group` and `abbr` to true will group results and append timezone
 * 	abbreviation in the display value. Set `before` and `after` to customize
 * 	the abbreviation wrapper.
 * @return array List of timezone identifiers
 * @since 2.2
 * @link https://book.cakephp.org/2.0/en/core-libraries/helpers/time.html#TimeHelper::listTimezones
 */
	public static function listTimezones($filter = null, $country = null, $options = array()) {
		if (is_bool($options)) {
			$options = array(
				'group' => $options,
			);
		}
		$defaults = array(
			'group' => true,
			'abbr' => false,
			'before' => ' - ',
			'after' => null,
		);
		$options += $defaults;
		$group = $options['group'];

		$regex = null;
		if (is_string($filter)) {
			$regex = $filter;
			$filter = null;
		}
		if (version_compare(PHP_VERSION, '5.3.0', '<')) {
			if ($regex === null) {
				$regex = '#^((Africa|America|Antartica|Arctic|Asia|Atlantic|Australia|Europe|Indian|Pacific)/|UTC)#';
			}
			$identifiers = DateTimeZone::listIdentifiers();
		} else {
			if ($filter === null) {
				$filter = DateTimeZone::ALL;
			}
			$identifiers = DateTimeZone::listIdentifiers($filter, $country);
		}

		if ($regex) {
			foreach ($identifiers as $key => $tz) {
				if (!preg_match($regex, $tz)) {
					unset($identifiers[$key]);
				}
			}
		}

		if ($group) {
			$return = array();
			$now = time();
			$before = $options['before'];
			$after = $options['after'];
			foreach ($identifiers as $key => $tz) {
				$abbr = null;
				if ($options['abbr']) {
					$dateTimeZone = new DateTimeZone($tz);
					$trans = $dateTimeZone->getTransitions($now, $now);
					$abbr = isset($trans[0]['abbr']) ?
						$before . $trans[0]['abbr'] . $after :
						null;
				}
				$item = explode('/', $tz, 2);
				if (isset($item[1])) {
					$return[$item[0]][$tz] = $item[1] . $abbr;
				} else {
					$return[$item[0]] = array($tz => $item[0] . $abbr);
				}
			}
			return $return;
		}
		return array_combine($identifiers, $identifiers);
	}

/**
 * Multibyte wrapper for strftime.
 *
 * Handles utf8_encoding the result of strftime when necessary.
 *
 * @param string $format Format string.
 * @param int $timestamp Timestamp to format.
 * @return string formatted string with correct encoding.
 */
	protected static function _strftime($format, $timestamp) {
		$format = static::strftime($format, $timestamp);

		$encoding = Configure::read('App.encoding');
		if (!empty($encoding) && $encoding === 'UTF-8') {
			if (function_exists('mb_check_encoding')) {
				$valid = mb_check_encoding($format, $encoding);
			} else {
				$valid = Multibyte::checkMultibyte($format);
			}
			if (!$valid) {
				$format = mb_convert_encoding($format, 'UTF-8', 'ISO-8859-1');
			}
		}
		return $format;
	}

/**
 * Multibyte wrapper for strftime.
 *
 * Adjusts the timezone when necessary before formatting the time.
 *
 * @param string $format Format string.
 * @param int $timestamp Timestamp to format.
 * @param int|string|DateTime $date Timestamp, strtotime() valid string or DateTime object.
 * @param string|DateTimeZone $timezone Timezone string or DateTimeZone object.
 * @return string Formatted date string with correct encoding.
 */
	protected static function _strftimeWithTimezone($format, $timestamp, $date, $timezone) {
		$serverTimeZone = date_default_timezone_get();
		if (
			!empty($timezone) &&
			$date instanceof DateTime &&
			$date->getTimezone()->getName() != $serverTimeZone
		) {
			date_default_timezone_set($timezone);
		}
		$result = static::_strftime($format, $timestamp);
		date_default_timezone_set($serverTimeZone);
		return $result;
	}

  /**
   * Locale-formatted strftime using IntlDateFormatter (PHP 8.1 compatible)
   * This provides a cross-platform alternative to strftime() for when it will be removed from PHP.
   * Note that output can be slightly different between libc sprintf and this function as it is using ICU.
   *
   * Usage:
   * use function \PHP81_BC\strftime;
   * echo strftime('%A %e %B %Y %X', new \DateTime('2021-09-28 00:00:00'), 'fr_FR');
   *
   * Original use:
   * \setlocale(LC_TIME, 'fr_FR.UTF-8');
   * echo \strftime('%A %e %B %Y %X', strtotime('2021-09-28 00:00:00'));
   *
   * @param  string $format Date format
   * @param  integer|string|DateTime $timestamp Timestamp
   * @param  string|null $locale locale
   * @return string
   * @throws InvalidArgumentException
   * @author BohwaZ <https://bohwaz.net/>
   */
  protected static function strftime (string $format, $timestamp = null, ?string $locale = null) : string {
    if (!($timestamp instanceof DateTimeInterface)) {
      $timestamp = is_int($timestamp) ? '@' . $timestamp : (string) $timestamp;

      try {
        $timestamp = new DateTime($timestamp);
      } catch (Exception $e) {
        throw new InvalidArgumentException('$timestamp argument is neither a valid UNIX timestamp, a valid date-time string or a DateTime object.', 0, $e);
      }

      $timestamp->setTimezone(new DateTimeZone(date_default_timezone_get()));
    }

    $locale = Locale::canonicalize($locale ?? (Locale::getDefault() ?? setlocale(LC_TIME, '0')));

    $intl_formats = [
      '%a' => 'ccc',	// An abbreviated textual representation of the day	Sun through Sat
      '%A' => 'EEEE',	// A full textual representation of the day	Sunday through Saturday
      '%b' => 'LLL',	// Abbreviated month name, based on the locale	Jan through Dec
      '%B' => 'MMMM',	// Full month name, based on the locale	January through December
      '%h' => 'MMM',	// Abbreviated month name, based on the locale (an alias of %b)	Jan through Dec
    ];

    $intl_formatter = function (DateTimeInterface $timestamp, string $format) use ($intl_formats, $locale) {
      $tz = $timestamp->getTimezone();
      $date_type = IntlDateFormatter::FULL;
      $time_type = IntlDateFormatter::FULL;
      $pattern = '';

      switch ($format) {
        // %c = Preferred date and time stamp based on locale
        // Example: Tue Feb 5 00:45:10 2009 for February 5, 2009 at 12:45:10 AM
        case '%c':
          $date_type = IntlDateFormatter::LONG;
          $time_type = IntlDateFormatter::SHORT;
          break;

        // %x = Preferred date representation based on locale, without the time
        // Example: 02/05/09 for February 5, 2009
        case '%x':
          $date_type = IntlDateFormatter::SHORT;
          $time_type = IntlDateFormatter::NONE;
          break;

        // Localized time format
        case '%X':
          $date_type = IntlDateFormatter::NONE;
          $time_type = IntlDateFormatter::MEDIUM;
          break;

        default:
          $pattern = $intl_formats[$format];
      }

      // In October 1582, the Gregorian calendar replaced the Julian in much of Europe, and
      //  the 4th October was followed by the 15th October.
      // ICU (including IntlDateFormattter) interprets and formats dates based on this cutover.
      // Posix (including strftime) and timelib (including DateTimeImmutable) instead use
      //  a "proleptic Gregorian calendar" - they pretend the Gregorian calendar has existed forever.
      // This leads to the same instants in time, as expressed in Unix time, having different representations
      //  in formatted strings.
      // To adjust for this, a custom calendar can be supplied with a cutover date arbitrarily far in the past.
      $calendar = IntlGregorianCalendar::createInstance();
      // NOTE: IntlGregorianCalendar::createInstance DOES NOT return an IntlGregorianCalendar instance when
      // using a non-Gregorian locale (e.g. fa_IR)! In that case, setGregorianChange will not exist.
      if ($calendar instanceof IntlGregorianCalendar) {
        $calendar->setGregorianChange(PHP_INT_MIN);
      }

      return (new IntlDateFormatter($locale, $date_type, $time_type, $tz, $calendar, $pattern))->format($timestamp);
    };

    // Same order as https://www.php.net/manual/en/function.strftime.php
    $translation_table = [
      // Day
      '%a' => $intl_formatter,
      '%A' => $intl_formatter,
      '%d' => 'd',
      '%e' => function ($timestamp) {
        return sprintf('% 2u', $timestamp->format('j'));
      },
      '%j' => function ($timestamp) {
        // Day number in year, 001 to 366
        return sprintf('%03d', $timestamp->format('z')+1);
      },
      '%u' => 'N',
      '%w' => 'w',

      // Week
      '%U' => function ($timestamp) {
        // Number of weeks between date and first Sunday of year
        $day = new DateTime(sprintf('%d-01 Sunday', $timestamp->format('Y')));
        return sprintf('%02u', 1 + ($timestamp->format('z') - $day->format('z')) / 7);
      },
      '%V' => 'W',
      '%W' => function ($timestamp) {
        // Number of weeks between date and first Monday of year
        $day = new DateTime(sprintf('%d-01 Monday', $timestamp->format('Y')));
        return sprintf('%02u', 1 + ($timestamp->format('z') - $day->format('z')) / 7);
      },

      // Month
      '%b' => $intl_formatter,
      '%B' => $intl_formatter,
      '%h' => $intl_formatter,
      '%m' => 'm',

      // Year
      '%C' => function ($timestamp) {
        // Century (-1): 19 for 20th century
        return floor($timestamp->format('Y') / 100);
      },
      '%g' => function ($timestamp) {
        return substr($timestamp->format('o'), -2);
      },
      '%G' => 'o',
      '%y' => 'y',
      '%Y' => 'Y',

      // Time
      '%H' => 'H',
      '%k' => function ($timestamp) {
        return sprintf('% 2u', $timestamp->format('G'));
      },
      '%I' => 'h',
      '%l' => function ($timestamp) {
        return sprintf('% 2u', $timestamp->format('g'));
      },
      '%M' => 'i',
      '%p' => 'A', // AM PM (this is reversed on purpose!)
      '%P' => 'a', // am pm
      '%r' => 'h:i:s A', // %I:%M:%S %p
      '%R' => 'H:i', // %H:%M
      '%S' => 's',
      '%T' => 'H:i:s', // %H:%M:%S
      '%X' => $intl_formatter, // Preferred time representation based on locale, without the date

      // Timezone
      '%z' => 'O',
      '%Z' => 'T',

      // Time and Date Stamps
      '%c' => $intl_formatter,
      '%D' => 'm/d/Y',
      '%F' => 'Y-m-d',
      '%s' => 'U',
      '%x' => $intl_formatter,
    ];

    $out = preg_replace_callback('/(?<!%)%([_#-]?)([a-zA-Z])/', function ($match) use ($translation_table, $timestamp) {
      $prefix = $match[1];
      $char = $match[2];
      $pattern = '%'.$char;
      if ($pattern == '%n') {
        return "\n";
      } elseif ($pattern == '%t') {
        return "\t";
      }

      if (!isset($translation_table[$pattern])) {
        throw new InvalidArgumentException(sprintf('Format "%s" is unknown in time format', $pattern));
      }

      $replace = $translation_table[$pattern];

      if (is_string($replace)) {
        $result = $timestamp->format($replace);
      } else {
        $result = $replace($timestamp, $pattern);
      }

      switch ($prefix) {
        case '_':
          // replace leading zeros with spaces but keep last char if also zero
          return preg_replace('/\G0(?=.)/', ' ', $result);
        case '#':
        case '-':
          // remove leading zeros but keep last char if also zero
          return preg_replace('/^[0\s]+(?=.)/', '', $result);
      }

      return $result;
    }, $format);

    $out = str_replace('%%', '%', $out);
    return $out;
  }
  

}
