<div id="picweb_form">
	
	<p class="heading">New User Signup</p>
	
	<?php echo form_open('/signup/submit'); ?>
	
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
		<td><label for="passconf">Confirm </label></td>
		<td><?php echo form_password('passconf'); ?></td>
	</tr>
    <tr>
		<td><label for="first_name">First Name </label></td>
		<td><?php echo form_input('first_name',set_value('first_name')); ?></td>
	</tr>

    <tr>
		<td><label for="last_name">Last Name </label></td>
		<td><?php echo form_input('last_name',set_value('last_name')); ?></td>
	</tr>
                <tr>
            <td><?php echo form_label('Birthday','birthday'); ?></td>
      <td><?php echo form_dropdown('months',$months). " " . form_dropdown('days',$days). " " . form_dropdown('years',$years); ?></td>
        </tr>
	<tr>
		<td><label for="email">E-mail: </label></td>
		<td><?php echo form_input('email',set_value('email')); ?></td>
	</tr>
	<tr>
            <td colspan="2"><?php echo form_submit('submit','Create my account'); ?></td>
	</tr>
        </table>
	<?php echo form_close(); ?>
</div>