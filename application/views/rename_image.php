<div id="picweb_form">
    <?php 
  	echo form_open_multipart('gallery/doRenameImage/'.$picName->id);
    echo form_input('image_name',$picName->name);
    echo form_submit('rename', 'Rename');
    echo form_close();
    ?>
</div>