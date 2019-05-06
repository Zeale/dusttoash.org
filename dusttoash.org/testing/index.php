<?php t(true, null, array("console")); ?>
<?php heading("Code Blocks"); ?>
<div>A call to the
    <pre class="inline-code">printCode(resource)</pre>, given the CSS file that styles the code, produces the following:</div>
<?php printCode(fopen("C:\wamp64\dusttoash\dusttoash.org\stylesheets\console.css", "r")); ?>
<?php b(); ?>
