<?php

namespace templates;

abstract class Printer {
	private static $defaultPrinter;
	public static function getDefaultPrinter() {
		return ! isset ( self::$defaultPrinter ) ? self::$defaultPrinter = new BasicPrinter () : self::$defaultPrinter;
	}
	abstract function printTop();
	abstract function printBottom();
}