<?php
use templates\Printer;

$autoclose=false;
Printer::getDefaultPrinter ()->addHeadIncludes ( "<link href=\"set-3.css\" rel=\"stylesheet\" type=\"text/css\">" );
include "../generic-set.php";
foreach ( glob ( "specials/*.{[jJ][pP][eE][gG],[jJ][pP][gG],[pP][nN][gG],[gG][iI][fF]}", GLOB_BRACE ) as $img )
	echo "<hr><img src=\"$img\" style=\"display: block; margin-left: 0; margin-right: 0;\" />";
b ();