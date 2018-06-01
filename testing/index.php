<?php t(true); ?>
<span>This page attempts to create a user account given some information. If you find this page, please do not input any sensitive information, at all!</span>
<span style="color: var(--soft-<?php 
    $result = createNewUser("Zeale", "zeale@dusttoash.org", 453); 
    if($result===true)
        echo "green";
    else echo "gold";
?>);">
<?php
if($result===true) 
    echo "Successfully created a record!";
else
    echo "Failed to create a record. Error message: \n\n" . $result;
?>
</span>
<?php b(); ?>
