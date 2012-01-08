<?php echo doctype('html5'); ?>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php if ($title != null) { echo $title; } ?> | PicWeb 2.0</title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/new.php" type="text/css" media="all">
</head>
<body>
    <div id="shell">
    	<div id="header">
        	<h1><font color="#FFFFFF">PicWeb 2.0</font></h1>
        </div>
        <div id="container">
        	<div id="nav"><ul id="menu"><li><a href="">Temp</a></li></ul></div>
        	<div id="content">
            Welcome to the PicWeb Setup Script.<br />
            If you can see this page, your database is configured correctly and you are ready<br />
            to procede.
            <table class="infoTable">
            	<tr>
                	<th>Hostname</th><td><?php echo $dbData['hostname']; ?></td>
            	</tr>
            	<tr>
                	<th>Database</th><td><?php echo $dbData['database']; ?></td>
            	</tr>
                <tr>
                	<th>Username</th><td><?php echo $dbData['username']; ?></td>
            	</tr>
                <tr>
                	<th>Password</th><td><?php echo "********"; ?></td>
            	</tr>
                <tr>
                	<th>DB Driver</th><td><?php echo $dbData['dbdriver']; ?></td>
            	</tr>
            </table>
            <?php if (!isset($vars['setup'])) {?>
            <div id="picweb_form">
            <?php echo form_open('setup/do_setup_tasks'); ?>
    		<?php echo form_submit('do_setup_tasks', 'Submit');
    				echo form_close();
    		?>
            </div>
            <?php } else { ?>
            <?php echo $vars['mysqlDrop'] . '<br />';
			echo $vars['mysqlCreate'] . '<br />';
			echo $vars['mysqlLoad'] . '<br />';
			echo $vars['mysqlSessionCreate']; ?>
            <?php } ?>
			</div>
        </div>
    
        <div id="footer">&copy;2010 PicWeb 2.0</div>
        <div id="bottom">Page rendered in {elapsed_time} seconds</div>
    </div>
    <br/>
    <br/>
   
</body>
</html>