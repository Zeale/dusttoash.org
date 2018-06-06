<?php
use templates\Printer;

// This will modify the default printer. The default printer can also be modified to affect the output of this method (so long as a value in the default printer isn't overridden by a parameter to this method).
function t(bool $centerContent = null, bool $includeDefaults = null, HeaderItem ...$headings) {
	if (isset ( $headings ) && $headings)
		Printer::getDefaultPrinter ()->addHeaderItems ( ...$headings );
	if (isset ( $centerContent ))
		Printer::getDefaultPrinter ()->centerContent = $centerContent;
	if (isset ( $includeDefaults ))
		Printer::getDefaultPrinter ()->includeDefaultHeaders = $includeDefaults;
	Printer::getDefaultPrinter ()->printTop ();
}


        
