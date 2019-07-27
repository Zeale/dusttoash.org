<?php t("Changelog");$u=false;$f=fopen("../ver.txt", "r")or$u=true;?>
<h1 style=font-size:4em;>Changelog<?php echo$u?"":" (".fgets($f).")"?></h1>
<br>
<p>
Release Date: <b><?php echo fgets($f);?></b>
<br>
Release Name: <b><?php echo fgets($f);?></b>
<p style=text-align:left;>
<?php
while(!feof($f)) echo fgets($f) . "<br>";
fclose($f);?>
</p>
<?php b();