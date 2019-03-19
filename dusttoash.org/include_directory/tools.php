<?php function anchor($target) { ?>
    <a href="#<?php echo $target;?>" class="anchor">&lt;a&gt;</a>
<?php } ?>
<?php function heading($text, $id=null) { 
    if($id==null)
        $id=$text;
?>
    <h1 class="heading" id="<?php echo $id;?>"><?php echo $text; anchor($id);?></h1>
<?php } ?>

<?php

/**
* This method also handles the outer div element.
*/
function printCode($file) {
    if(!$file)throw new Exception("Couldn't print the code for the given resource.");
    echo "<div class=\"code-block\"><pre>";
    
    while(($line=fgets($file))!==false){
        ?><code><?php echo $line;?></code><?php }
    echo "</pre></div>";
}