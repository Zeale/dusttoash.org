<?php
use templates\Printer;

Printer::getDefaultPrinter ()->addHeadIncludes ( "<link href=\"..\\..\\index.css\" rel=\"stylesheet\" type=\"text/css\">" );
t ();
foreach ( glob ( "*.{[jJ][pP][eE][gG],[jJ][pP][gG],[pP][nN][gG]}", GLOB_BRACE ) as $img ) {
	echo '<img src="' . $img . '" />';
}
b ();