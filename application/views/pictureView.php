<script type="text/javascript">
    $(document).ready(function() {
        ajaxLoadComments();
   });
   
   function ajaxLoadComments()
   {
       $.post("<?php echo site_url("comments/getComments")."/".$pic_id; ?>",
            function(data){ $("#commentArea").html(data); });
   }


   function ajaxSubmit()
   {
        event.preventDefault();
        $(".commentTable").css({ opacity: 0.5 });

        var url = '<?php echo site_url('comments/addComment'); ?>';
        $.post(url,$("#commentForm").serialize(),function(response){
            ajaxLoadComments();
    });
   }
</script>
<div id="sidebar">
            <table class="sidebarTable">
                                    <tr>
                                        <th>Type</th><td><?php echo substr($pic_type, 6); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Size</th><td><?php echo byte_format($pic_size); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Dimensions</th><td><?php echo $pic_width . "x" . $pic_height; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Uploaded At</th><td><?php echo $uploaded; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Uploader</th><td><?php echo $pic_owner; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Mature Content</th><td><?php if($pic_nsfw == 0){ echo 'No'; }else{ echo 'Yes'; } ?></td>
                                    </tr>
                                    <tr>
                                        <th>Views</th><td><?php echo $pic_views; ?></td>
                                    </tr>
                                    <?php if($exif) { if(!($exif->make == "")) { ?>
                                    <tr>
                                        <th>Make</th><td><?php echo $exif->make; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if(!($exif->model == "")) { ?>
                                    <tr>
                                        <th>Model</th><td><?php echo $exif->model; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if(!($exif->Exposure == "")) { ?>
                                    <tr>
                                        <th>Exposure</th><td><?php echo $exif->Exposure; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if(!($exif->FNumber == "")) { ?>
                                    <tr>
                                        <th>Aperture</th><td><?php echo $exif->FNumber; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if(!($exif->ISOSpeed == "")) { ?>
                                    <tr>
                                        <th>ISO Speed</th><td><?php echo $exif->ISOSpeed; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if(!($exif->flash == "")) { ?>
                                    <tr>
                                        <th>Flash</th><td><?php echo $exif->flash; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if(!($exif->dateTaken == "")) { ?>
                                    <tr>
                                        <th>Date Taken</th><td><?php echo $exif->dateTaken; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if(!($exif->gpsLat == "")) { ?>
                                    <tr>
                                        <th>Lat</th><td><?php echo $exif->gpsLat; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if(!($exif->gpsLon == "")) { ?>
                                    <tr>
                                        <th>Lon</th><td><?php echo $exif->gpsLon; ?></td>
                                    </tr>
                                    <?php }} ?>
                                </table>
</div>
<div id="pictureView">
    <table>
            <tr>
                <td colspan="3" width="800px">
                    <?php if($pic_nsfw == 0 || ($pic_nsfw == 1 && $nsfw_pref == 1)){ ?><img <?php if ($pic_width >775) {?> width="775px"<?php } else { ?>width="<?php echo $pic_width."px"; ?>"<?php } ?> src="<?php if(!$using_ie){ echo "data:".$pic_type.";base64,".stripslashes($pic_data); }else{ echo site_url()."displaypic.php?size=image&pic=".$pic_id; } ?>" /><?php }else{ echo 'Mature Filter is currently On.'; } ?>
                </td>
            </tr>
            <tr>
                <td width="100%" valign="middle" style="font-weight:bold; color:#fff;">
                    <?php echo $pic_name; ?><br />
                    <?php if (($current_pos - 1) != 0 ) {?><a title="Back" href="<?php echo site_url("gallery/pictureView/")."/".$album_id."/".$previous_id->id; ?>"><img src="<?php echo base_url();?>images/arrow_back.png" /></a><?php } ?>
                    <a title="Back To Album" href="<?php echo site_url("gallery/display/") . "/" . $album_id; ?>"><img src="<?php echo base_url();?>images/folder_files.png" /></a>
                    <a title="Download Picture" href="<?php echo site_url("image/getPic/")."/".$pic_id; ?>"><img src="<?php echo base_url();?>images/download.png" /></a>
                    <?php if ($is_mine == TRUE) { ?>
                    <a title="Rename"  href="<?php echo site_url("gallery/renameImage/") . "/" . $pic_id; ?>"><img src="<?php echo base_url();?>images/reply.png" /></a>
                    <a title="Delete"  href="<?php echo site_url("gallery/deleteImage/")."/" . $pic_id; ?>"><img src="<?php echo base_url();?>images/action_delete.png" /></a>
                    <a title="Toggle Mature Flag"  href="<?php echo site_url("gallery/toggleNsfw/")."/" . $pic_id; ?>"><img src="<?php echo base_url();?>images/login.png" /></a>
                    <?php } else {?>
                    <a title="Flag as Mature"  href="<?php echo site_url("gallery/flagNsfw/")."/" . $pic_id; ?>"><img src="<?php echo base_url();?>images/action_check.png" /></a>
                    <?php } ?>
                    <?php if ($current_pos < $max_pos) {?><a title="Next" href="<?php echo site_url("gallery/pictureView/")."/".$album_id."/".$next_id->id; ?>"><img src="<?php echo base_url();?>images/arrow_next.png" /></a><?php } ?>
                </td>
            </tr>
    </table>
    <br />
    <div id="info">
        <font style="font-weight:bold;">Comments</font>
        <div id="commentArea">
        </div>
    </div>
</div>