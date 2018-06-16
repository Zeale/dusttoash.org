<?php
function printListing($listings) {
}

foreach ( glob ( "data/listings/*/", GLOB_ONLYDIR ) as $item )
	echo "<div><a class='list-link' href='data/listings/" . $i . "'>" . $i . "</a></div>";
