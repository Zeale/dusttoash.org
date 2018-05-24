<?php include "autoload"; ?>
<?php t(); ?>

<!-- Header tags IDs that are referred to by Anchors should be formatted either like "ContentText" below (where each word is capitalized with no spacing) or like "content-text" (where each word is lowercase and separated by a single hyphen). This is the general format/mini spec that I'll be using for anchor tags.  -->
<h1 class="heading" id="ContentText">Content Text<a href="#ContentText" class="anchor">&lt;a&gt;</a></h1>
Some regular content text; this text appears a deep, sky blue, while headers, like <span style="color: var(--secondary-color);">Message</span>, appear a <span style="color: var(--secondary-color);">coral-like color</span>.

<?php b(); ?>
