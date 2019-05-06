<?php t("Download");?>
<h1 style=font-size:4em;>Download</h1>
<br>
<p>Quick note before you download: This app is a work in progress and will be updated frequently. Hence, it may contain small bugs. If you'd like to receive any updates, you'll need to check back at this page for newer versions periodically, until the application is capable of checking for updates on its own (hopefully that will be soon!).</p>
<p>Please click <a class=text-link href="/license">here</a> for the program's license, before downloading or installing the application. By using the application you agree to this license.</p>
<br>
<em><p>The latest version, (<u><?php $u=false;$f=fopen("latest.txt", "r")or$u=true;echo$v=($u?"Err reading ver":trim(fgets($f)));?></u>), was released on <u><?php echo $u?"Err reading ver":trim(fgets($f));?></u> and is <?php echo $u?"Err reading ver":trim(fgets($f));?>.</p></em>
<br>
<a href="Stuff%20Installer.exe" target=_blank><div class=button">Windows Installer (<?php echo$v;?>)</div></a>
<a href="Stuff.jar" target=_blank><div class=button">Cross Platform Executable (<?php echo$v;?>)</div></a><?php b();?>