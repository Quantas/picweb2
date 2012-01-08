<div id="picweb_gallery">
    <h2>Search&nbsp;Results&nbsp;for&nbsp;<i><?php echo $searchString; ?></i></h2>
                <hr>
		<table style="border:0;">
        <tr>
        <?php
                        if($pictures != null)
                        {
			$count = 0;
			foreach($pictures as $picture): ?>
        	<?php if ($count > 3) {?></tr><tr><?php $count=0; } ?>
            <td>
        		<?php if(($picture->nsfw == 0 || ($picture->nsfw == 1 && $nsfw_pref == 1))){ ?><a href="<?php echo site_url()."/displaypic.php?size=image&pic=".$picture->id; ?>" rel="lytebox[picwebGallery]" title="<?php echo $picture->name; ?>" ><img src="<?php if(!$using_ie){ echo "data:".$picture->type.";base64,".stripslashes($picture->thumb); }else{ echo site_url()."displaypic.php?size=thumb&pic=".$picture->id; } ?>" height="100px" alt="<?php echo $picture->name; ?>"  /></a><?php }else{ ?> <img src="<?php echo base_url();?>images/mature.png" /> <?php } ?>
       			<br/><a href="<?php echo site_url("gallery/pictureView/")."/".$picture->album_id."/".$picture->id; ?>"><?php if (strlen($picture->name) > 15 ) { echo substr($picture->name,0,15).'...'; } else { echo $picture->name; } ?></a>
        </td>
    <?php
	$count++;
	endforeach; 
                        }
                        else
                        {?>
        <td>No Images Found.</td>
        <?php } ?>
    </tr>
    </table>
                <hr>
    <table style="border:0;">
        <tr>
        <?php
                        if($users != null)
                        {
			$count = 0;
			foreach($users as $user): ?>
        	<?php if ($count > 3) {?></tr><tr><?php $count=0; } ?>
            <td>
        		<a href="<?php echo site_url()."user_account/profile/".$user->id; ?>"><?php echo $user->username.' - '.$user->first_name.' '.$user->last_name; ?></a>
        </td>
    <?php
	$count++;
	endforeach; 
                        }
                        else
                        { ?>
        <td>No Users Found.</td>
        <?php } ?>
    </tr>
    </table>
                                <hr>
    <table style="border:0;">
        <tr>
        <?php
                        if($albums != null)
                        {
			$count = 0;
			foreach($albums as $album): ?>
        	<?php if ($count > 3) {?></tr><tr><?php $count=0; } ?>
            <td>
        		<a href="<?php echo site_url()."gallery/display/".$album->id; ?>"><?php echo $album->name; ?></a>
        </td>
    <?php
	$count++;
	endforeach;
                        }
                        else
                        { ?>
        <td>No Albums Found.</td>
        <?php } ?>
    </tr>
    </table>
</div>