<?php
use templates\Printer;

Printer::getDefaultPrinter ()->addHeadIncludes ( "<link href=\"index.css\" rel=\"stylesheet\" type=\"text/css\">" );
t ();

foreach(glob("sets/*", GLOB_ONLYDIR) as $file) {
    $name = basename($file);
    echo "<div><a class='meme-set-link' href='sets/" . $name . "'>" . $name . "</a></div>";
}
b ();