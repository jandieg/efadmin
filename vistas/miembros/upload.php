<?php
if(is_array($_FILES)) {
if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
$sourcePath = $_FILES['userImage']['tmp_name'];
$info = pathinfo($_FILES['userImage']['name']);
$targetPath = "../../public_html/i/".$_POST['codigo'].".".$info['extension'];
if(move_uploaded_file($sourcePath,$targetPath) && in_array($info['extension'], array("jpg", "jpeg", "JPG", "JPEG"))) {
?>
<img class="image-preview" src="<?php echo $targetPath; ?>" class="upload-preview" />
<?php
}
}
}
?>
<?php print_r($_FILES); ?>

