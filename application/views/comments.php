<table class="commentTable">
    <?php foreach($comments as $comment): ?>
            <tr>
                <td>
                    <div class="commentRow">
                        <table width="400px">
                            <tr>

                                <td width="50px"><img src="https://secure.gravatar.com/avatar/<?php echo md5(strtolower(trim($comment->User->email))); ?>?r=g&d=identicon&s=50" width="50px" /></td>
                                <td width="350px">
                                    <a href="<?php echo site_url("user_account/profile/")."/" . $comment->user_id; ?>"><?php echo $comment->User->first_name . " " . $comment->User->last_name; ?></a>&nbsp;<span class="commentDate"><?php echo $comment->updated_at; ?></span>
                                    <br /><?php echo $comment->comment; ?>
                                    
                                </td>

                            </tr>
                        </table>
                    </div>
                </td>
        </tr>
    <?php endforeach;?>
        <tr>
            <td>
                <div id="picweb_form">
                    
                    <?php 
                    $attributes = array('id' => 'commentForm');
                    echo form_open('comments/addComment', $attributes); ?>
                        <table><tr><td>
                    <?php $commentData = array(
                                          'name'        => 'comment',
                                          'id'          => 'comment',
                                          'maxlength'   => '48',
                                        );
 
                        echo form_input($commentData); ?></td></tr>
                        <tr><td>
                    <?php echo form_hidden('picture_id', $pic_id); ?>
                    <?php echo form_hidden('album_id', $album_id); ?>
                    <?php
                    $js = 'onClick="ajaxSubmit(); return false;"';
                    $attr = array(
                              'name'        => 'commentSubmit',
                              'id'          => 'commentSubmit',
                              'value'       => 'Submit'
                            );
                    echo form_submit('commentSubmit', 'Submit', $js);
                    ?>
                            </td></tr>
                    </table>
                    <?php echo form_close(); ?>
                </div>
            </td>
        </tr>
</table>

