<div id="picweb_form">
	<p class="heading">Change Password</p>
	<?php echo form_open('/user_account/changePassword'); ?>
	<table>
        <tr>
		<td><label for="oldpass">Old Password</label></td>
		<td><?php echo form_password('oldpass'); ?></td>
	</tr>
	<tr>
		<td><label for="password">Password</label></td>
		<td><?php echo form_password('password'); ?></td>
	</tr>
	<tr>
		<td><label for="passconf">Confirm</label></td>
		<td><?php echo form_password('passconf'); ?></td>
	</tr>

	<tr>
            <td colspan="2"><?php echo form_submit('submit','Submit'); ?></td>
	</tr>
        </table>
	<?php echo form_close(); ?>
</div>