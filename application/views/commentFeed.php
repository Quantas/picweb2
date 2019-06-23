<div id="picweb_comment">
    <table>
        <?php foreach($comments as $comment): ?>
            <tr>
            	<td>
                    <a href="<?php echo site_url("gallery/pictureView/".$comment->Picture->album_id."/".$comment->Picture->id); ?>"><?php if($comment->Picture->nsfw == 0 || ($comment->Picture->nsfw == 1 && $nsfw_pref == 1)){ ?><img src="<?php echo site_url()."displaypic.php?size=thumb&pic=".$comment->Picture->id; ?>" height="100px" alt="<?php echo $comment->Picture->name; ?>"  /><?php }else{ ?> <img src="<?php echo base_url();?>images/mature.png" /> <?php } ?></a>
                </td>
                <td>
                <?php echo $comment->User->first_name . " " . $comment->User->last_name; ?> - <?php echo $comment->updated_at; ?><br />
                <?php echo $comment->comment; ?>
                </td>
            </tr>
        <?php endforeach; ?>
</table>
</div>