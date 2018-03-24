<?php
$meta_title = Theme::get("title");
$meta_title = !empty($meta_title) ? $meta_title : NULL;

$meta_keywords = Theme::get("metakeywords");
$meta_keywords = !empty($meta_keywords) ? $meta_keywords : NULL;

$meta_description = Theme::get("metadescription");
$meta_description = !empty($meta_description) ? $meta_description : NULL;

//$canonical_tag = Theme::get("canonical");
//$canonical_tag = !empty($canonical_tag) ? $canonical_tag : NULL;

$canonical_tag = "http";
if(isset($_SERVER['HTTPS'])){
	$canonical_tag .= "s";
}
$canonical_tag .= "://".str_replace("m.", "www.", $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
?>
<?php if (!is_null($meta_title)): ?>
    <title><?php echo $meta_title; ?></title>
<?php endif; ?>
<?php if (!is_null($meta_keywords)): ?><meta name="keywords" content="<?php echo $meta_keywords; ?>">
<?php endif; ?>
<?php if (!is_null($meta_description)): ?><meta name="description" content="<?php echo $meta_description; ?>">
<?php endif; ?>
<?php if (!is_null($canonical_tag)): ?>
<link rel="canonical" href="<?php echo $canonical_tag;?>" />
<?php endif; ?>
