<?php 
t(true);
$query = new dusttoash\connections\Query('SELECT * FROM users');
$query->fetch();
b();
