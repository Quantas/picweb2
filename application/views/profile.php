<script type="text/javascript">
    function confirmDelete()
    {
        return confirm('Are you sure you want to delete this album?');
    }
    function confirmAccountDelete()
    {
        if(confirm('Are you sure you want to delete your Account?'))
        {
            return confirm('Last chance, are you really sure?');
        }
        else
        {
            return false;
        }
    }
</script>

<div style="text-align: center;">
<table style="margin: 0 auto;">
    <tr>
        <td width="50%" valign="top">
            <table class="infoTable">
                <tr>
                    <td colspan="2" style="text-align: center;"><img src="https://secure.gravatar.com/avatar/<?php echo md5(strtolower(trim($userData->email))); ?>?r=g&d=identicon&s=100" width="100px" /></td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td><?php echo $userData->username; ?></td>
                </tr>
                <?php if ($is_me) {?>
                <tr>
                    <th>Real Name</th>
                    <td><?php echo $userData->first_name." ".$userData->last_name; ?></td>
                </tr>
                <tr>
                    <th>Member Since</th>
                    <td><?php echo $userData->created_at; ?></td>
                </tr>
                <tr>
                    <th>Birthdate</th>
                    <td><?php
                                $month = substr($userData->birthdate,0,2);
                                $day = substr($userData->birthdate,3,2);
                                $year = substr($userData->birthdate,6,4);
                    echo $month."/".$day."/".$year; ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <th>Album Count</th>
                    <td><?php echo $albumCount->albumCount; ?></td>
                </tr>
                <tr>
                    <th>Image Count</th>
                    <td><?php echo $imageCount->imageCount; ?></td>
                </tr>
                <tr>
                    <th>Space Usage</th>
                    <td><?php if($userData->quota == 0) {$totalAvail = 'Unlimited'; }else{ $totalAvail = byte_Format($userData->quota); }
                                if($userData->quota == 0) { $barPct = 0; } else { $barPct = $spaceUsage->totalSize/$userData->quota*100; }
                            echo byte_Format($spaceUsage->totalSize).' / '.$totalAvail; ?><br />
                            <div class="diskspace"><p style="width:<?php echo $barPct; ?>%">&nbsp;</p></div></td>
                </tr>
                <?php if ($is_me) {?>
                <tr>
                    <th>Show Mature Content</th>
                    <td><?php if($userData->show_nsfw == 1){$show_mature = 'True'; } else{ $show_mature = 'False'; }
                            echo anchor('user_account/toggleNsfw', $show_mature); ?></td>
                </tr>
                <tr class="InfoLink">
                    <td colspan="2"><?php echo anchor('user_account/passForm', 'Change Password'); ?></td>
                </tr>
                <tr class="InfoLink">
                    <td colspan="2"><a href="<?php echo site_url('user_account/deleteAccount/'); ?>" onclick="return confirmAccountDelete();">Delete Account</a></td>
                </tr>
                <?php } ?>
            </table>
        </td>
        <td width="50%" valign="top">
            <h4>Albums</h4>
            <div id="gallery">
                <table style="margin: 0 auto;">
                    <?php foreach($albums as $album): ?>
                    <tr>
                            <td><?php 
                            if (strlen($album->name) > 15 ) { $albumName = substr($album->name,0,15).'...'; } else { $albumName = $album->name; }
                            echo anchor('gallery/display/'.$album->id, $albumName); ?></td>
                            <?php if($is_me) { ?>
                            <td><a title="Delete Album" href="<?php echo site_url('albums/delete/'.$album->id); ?>"><img src="<?php echo base_url();?>images/action_delete.png" alt="Delete" onclick="return confirmDelete();"/></a><td>
                            <?php } ?>
                            <td><a title="Download Album" href="<?php echo site_url('albums/downloadAlbum/'.$album->id); ?>"><img src="<?php echo base_url();?>images/download.png" alt="Save" /></a></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <br/>
            <?php if($is_me) {?>
            <div id="picweb_form">
                <h4>Create New Album</h4>
                <?php echo form_open('albums'); ?>
                <table>
                    <tr><td><label for="album_name">Name</label></td>
                <td><?php echo form_input('album_name',set_value('album_name')); ?></td></tr>
                <tr><td colspan="2"><?php echo form_submit('submit', 'Submit'); ?></td></tr>
                </table>
                <?php echo form_close();
                ?>
            </div>
            <?php } ?>
        </td>
    </tr>
</table>
</div>