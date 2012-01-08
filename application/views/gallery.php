<div id="picweb_gallery">
		<?php if (isset($search)) echo $search; ?>
		<table style="border:0;">
        <tr>
        <?php 
			$count = 0;
			foreach($pictures as $picture): ?>
        	<?php if ($count > 3) {?></tr><tr><?php $count=0; } ?>
            <td>
        		<?php if(($picture->nsfw == 0 || ($picture->nsfw == 1 && $nsfw_pref == 1))){ ?><a href="<?php echo site_url()."displaypic.php?size=image&pic=".$picture->id; ?>" rel="lytebox[picwebGallery]" title="<?php echo $picture->name; ?>" ><img src="<?php if(!$using_ie){ echo "data:".$picture->type.";base64,".stripslashes($picture->thumb); }else{ echo site_url()."displaypic.php?size=thumb&pic=".$picture->id; } ?>" height="100px" alt="<?php echo $picture->name; ?>"  /></a><?php }else{ ?> <img src="<?php echo base_url();?>images/mature.png" /> <?php } ?>
       			<br/><a href="<?php echo site_url("gallery/pictureView/")."/".$picture->album_id."/".$picture->id; ?>"><?php if (strlen($picture->name) > 15 ) { echo substr($picture->name,0,15).'...'; } else { echo $picture->name; } ?></a>
        </td>
    <?php
	$count++;
	endforeach; ?>
    <?php if (isset($empty) && $empty != NULL) echo "<td>".$empty."</td>"; ?>
    </tr>
    </table>
</div>
<?php if (isset($pagination)): ?>
    <div class="pagination">
        Pages: <?php echo $pagination; ?>
    </div>
<?php endif; ?>

<br/>
<?php if ($is_mine == TRUE) { ?>
<div id="picweb_form">
    <?php 
  	echo form_open_multipart('gallery');
	echo form_hidden('album_id', $album_id);
    echo form_upload('userfile');
    echo form_submit('upload', 'Upload');
    echo form_close();
    ?>
</div>
<?php } ?>