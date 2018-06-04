<?php
use dusttoash\logins\Database;
class HeaderItem {
	private $name, $link;
	public function print() {
		echo "<span onclick=\"document.location.href='" . $this->link . "'\">" . $this->name . "</span>";
	}
	function __construct(string $name, string $link) {
		$this->name = $name;
		$this->link = $link;
	}
}

function t(bool $centerContent=null, bool $includeDefaults=null, HeaderItem ...$headings) { ?>
<html lang="en">

<head>
<title>Dust To Ash</title>
<link href="/index.css" rel="stylesheet" type="text/css">
<script src="/index.js" type="text/javascript"></script>

<!-- Acme font -->
<link href="https://fonts.googleapis.com/css?family=Acme"
	rel="stylesheet">
</head>

<body class="background">
	<div class="header full-width" id="Header">
		<!-- This is the navigation header -->
<?php
	
	if (count ( $headings ) == 0 || $includeDefaults) {
		array_push ( $headings, new HeaderItem ( "Home", "/" ), new HeaderItem ( "About", "/about" ) );
		if ((new Database ())->isLoggedIn ())
			array_push ( $headings, new HeaderItem ( "Sign Out", "/sign-out" ) );
		else
			array_push ( $headings, new HeaderItem ( "Login", "/login" ), new HeaderItem ( "Sign Up", "/sign-up" ) );
	}
	foreach ( $headings as $span ) {
		$span->print () . "\n";
	}
	?>
    </div>

	<div class="content-root<?php if($centerContent)echo " centered"; ?>">
        <?php } ?>
