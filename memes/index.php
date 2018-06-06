<?php
t ();
foreach ( glob ( "*.{[jJ][pP][eE][gG],[jJ][pP][gG],[pP][nN][gG]}", GLOB_BRACE ) as $img ) {
	echo '<img src="' . $img . '" />';
}
b ();