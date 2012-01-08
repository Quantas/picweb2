<div id="picweb_form">

	<p class="heading">User Login</p>

	<?php echo form_open('login/submit'); ?>

	<?php echo validation_errors('<p class="error">','</p>'); ?>
        <table>
	<tr>
		<td><label for="username">Username </label></td>
		<td><?php echo form_input('username',set_value('username')); ?></td>
	</tr>
	<tr>
		<td><label for="password">Password </label></td>
		<td><?php echo form_password('password'); ?></td>
	</tr>
	<tr>
            <td colspan="2"><?php echo form_submit('submit','Login'); ?></td>
	</tr>
        </table>
	<?php echo form_close(); ?>
</div>