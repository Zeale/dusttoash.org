<?php

namespace templates;

use dusttoash\logins\Database;

class BasicPrinter extends Printer {
	
	// boolean values. Free to be changed by client code.
	public $centerContent, $includeDefaultHeaders;
	
	// Array values. Must be kept arrays and simply be edited by calling code.
	private $headerItems = array (), $headIncludes = array (), $stylesheets = array ();
	public function addHeaderItems(HeaderItem ...$headerItems) {
		// Empty inputs and other things going into array_push probably need to be checked.
		array_push ( $this->headerItems, ...$headerItems );
	}
	public function removeHeaderItems(HeaderItem ...$headerItems) {
		array_diff ( $this->headerItems, $headerItems );
	}
	public function addHeadIncludes(string ...$headIncludes) {
		array_push ( $this->headIncludes, ...$headIncludes );
	}
	public function removeHeadIncludes(string ...$headIncludes) {
		array_diff ( $this->headIncludes, $headIncludes );
	}
    public function addStylesheets(string ...$stylesheets) {
        array_push ( $this->stylesheets, ...$stylesheets );
    }
    public function removeStylesheets(string ...$stylesheets) {
        array_diff( $this->stylesheets, $stylesheets );
    }
	function printTop() {
		?>
<html lang="en">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-92180284-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-92180284-1');
</script>

<title>Dust To Ash</title><?php
		
		foreach ( $this->headIncludes as $include )
			echo $include;
		?>
<link href="/index.css" rel="stylesheet" type="text/css">
<?php foreach ($this->stylesheets as $sheet) {
            ?><link href="/stylesheets/<?php echo $sheet;?>.css" rel="stylesheet" type="text/css">
<?php } ?>
<script src="/index.js" type="text/javascript"></script>

<!-- Acme font -->
<link href="https://fonts.googleapis.com/css?family=Acme"
	rel="stylesheet">
</head>

<body class="background">
	<div class="header full-width" id="Header">
		<!-- This is the navigation header -->
<?php
		
		if (count ( $this->headerItems ) == 0 || $this->includeDefaultHeaders) {
			array_push ( $this->headerItems, new HeaderItem ( "Home", "/" )/*, new HeaderItem ( "About", "/about" ) */ );
			if ((new Database ())->isLoggedIn ()){
            array_push ( $this->headerItems, new HeaderItem( "Console", "/console" ) );
				array_push ( $this->headerItems, new HeaderItem ( "Sign Out", "/sign-out" ) );
        }
			else
				array_push ( $this->headerItems, new HeaderItem ( "Login", "/login" ), new HeaderItem ( "Sign Up", "/sign-up" ) );
		}
		foreach ( $this->headerItems as $span ) {
			$span->print () . "\n";
		}
		?>
    </div>

	<div
		class="content-root<?php if($this->centerContent)echo " centered"; ?>">
        <?php
	}
	function printBottom() {
		?>
</div>

	<footer>
		<span id="FooterTitle"> <strong> Dust To Ash </strong>
		</span> <a id="CopyrightNotice" style="display: block;"
			href="/copyright-info"><span>Website by Zeale.</span><span style="color: gold"><sup>&copy;</sup></span> <span
			style="color: blue;">More Info.</span></a>
	</footer>
</body>

</html>
<?php
	}
}