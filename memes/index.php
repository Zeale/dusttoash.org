<?php
use templates\Printer;

Printer::getDefaultPrinter ()->addHeadIncludes ( "<link href=\"index.css\" rel=\"stylesheet\" type=\"text/css\">" );
t ();

for($i = 1;$i < sizeof(glob ( "set-*/")) + 1; $i++)
    echo "<div><a class='meme-set-link' href='set-" . $i . "'>Set-" . $i . "</a></div>";
b ();