<?php

class HeaderItem {
    
    private $name, $link;
    
    public function print() {
        echo "<span onclick=\"document.location.href='" . $this->link . "'\">" . $this->name . "</span>";
    }
    
    function __construct(string $name, string $link){
        $this->name=$name;
        $this->link=$link;
    }

}

?>
<?php function t($centerContent=true, HeaderItem ...$headings) { ?>
<html lang="en">

<head>
    <title>Dust To Ash</title>
    <link href="/index.css" rel="stylesheet" type="text/css">
    <script src="/index.js" type="text/javascript"></script>

    <!-- Acme font -->
    <link href="https://fonts.googleapis.com/css?family=Acme" rel="stylesheet">
</head>

<body class="background">
    <div class="header full-width" id="Header">
        <!-- This is the navigation header -->
<?php if(count($headings)==0):?>
        <span onclick="document.location.href='/'">Home</span>
        <span onclick="document.location.href='/login'">Login</span>
        <span onclick="document.location.href='/about'">About</span>
        <?php 
else:
    foreach($headings as $span) {
        $span->print() . "\n";
    }
endif;
?>
    </div>

    <div class="content-root<?php if($centerContent)echo " centered"; ?>">
        <?php } ?>
