<?php function anchor($target) { ?>
    <a href="#<?php echo $target;?>" class="anchor">&lt;a&gt;</a>
<?php } ?>
<?php function heading($text, $id) { 
    if(!isset($id))
        $id=$text;
?>
    <h1 class="heading" id="<?php echo $id;?>"><?php echo $text; anchor($id);?></h1>
<?php } ?>
