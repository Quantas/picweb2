<?php
echo form_open('sitesearch/do_search');
echo anchor('/', "Home"); ?>&nbsp;
<?php if ($user = Current_User::user()): ?>
    <?php echo anchor('albums', "Albums"); ?>&nbsp;
    <?php echo anchor('comment_feed', "Comments"); ?>&nbsp;
    <?php echo anchor('user_account/profile', 'Profile'); ?>&nbsp;
        <?php if ($user->privs > 1) echo anchor('admin', 'Admin').'&nbsp;'; ?>
	<?php echo anchor('logout', 'Logout'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><?php echo $user->first_name . " " . $user->last_name; ?></em>
        &nbsp;&nbsp;&nbsp;
        <?php   
                echo form_input('search_string',set_value('album_name'));
                //echo form_submit('submit', 'Submit'); ?>
        &nbsp;<input type="image" src="<?php echo base_url(); ?>images/search.png" alt="Submit button">
<?php else: ?>
	<?php echo anchor('login','Login'); ?>&nbsp;
	<?php echo anchor('signup/tou', 'Register'); ?>
<?php endif; ?>
        <?php        echo form_close();
        ?>