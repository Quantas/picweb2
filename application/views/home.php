<div id="picweb_news">
    <table style=" width:700px; margin-left:auto; margin-right:auto; border:0px;">
        <tr>
            <td>
                <a href="<?php echo site_url("gallery/pictureView/".$randomImage[0]['album_id']."/".$randomImage[0]['id']); ?>"><img src="<?php if(!($using_ie)) { echo "data:".$randomImage[0]['type'].";base64,".stripslashes($randomImage[0]['image']); } else { echo site_url()."displaypic.php?size=image&pic=".$randomImage[0]['id']; } ?>" height="350px" alt="<?php echo $randomImage[0]['name']; ?>"  /></a>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;"><span style="font-size:small;"><span style="font-weight:bold;">DB Size</span> <?php echo byte_format($db_size[0]['db_size']); ?> &bull; <span style="font-weight:bold;">Image Count</span> <?php echo $image_count[0]['image_count']; ?> &bull; <span style="font-weight:bold;">User Count</span> <?php echo $user_count[0]['user_count']; ?></span></td>
        </tr>
    </table>
</div>