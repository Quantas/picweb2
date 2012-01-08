<?php
 $CI= &get_instance();
echo doctype('html5'); ?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>404 Page Not Found | PicWeb</title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/main.css" type="text/css" media="all">
</head>
<body>
    <div id="header">
        <div id="nav">

            <div><?php $CI->load->view('menu'); ?></div>
        </div>
    </div>
    <div id="shell">
        <div id="container">
        	<div id="content"><?php $CI->load->view('banner_messages'); ?>
				<div>
					<h1><?php echo $heading; ?></h1>
					<?php echo $message; ?>
				</div>
        	</div>
        </div>
        <div id="bottom">
            <!--Page rendered in {elapsed_time} seconds<br />-->
            <font size="1pt">
            &copy;2011 Quantasnet&nbsp;|&nbsp;<?php echo anchor('about', 'About'); ?>&nbsp;|&nbsp;<?php echo anchor('about/tou', 'Terms of Use'); ?>&nbsp;|&nbsp;<?php echo anchor('about/pp', 'Privacy Policy'); ?>
            </font>
        </div>
    </div>
    <br/>
    <br/>
</body>
</html>
