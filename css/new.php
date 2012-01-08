<?php
header("Content-type: text/css");
$bg = "#212426";
$fg = "black";
$highlight = "#2580a2";
?>
body
{
    font-family: Arial, Helvetica, sans-serif;
    background-color: <?php echo $bg; ?>;
    color:<?php echo $fg; ?>;
}

img{
border:0;
}

/* Everything needs a shell, right?*/
#shell {
	width: 800px;
	margin: auto;
}

#header{

}

#sidebar{
        position: absolute;
        width: 300px;
        right: -304px;
}

#header a{
    text-decoration:none;
    font-weight:bold;
    color:#fff;
}
#header a:visited,a:active{
    font-weight:bold;
    color:#fff;
}
#header a:hover{
    color:<?php echo $highlight; ?>;
}

#nav{
height:auto;
overflow:hidden;
background-color:#B9AA81;
color:#fff;
text-align:center;
-moz-border-radius-topleft: 6px;
-moz-border-radius-topright: 6px;
-webkit-border-top-left-radius: 6px;
-webkit-border-top-right-radius: 6px;
}

#menu {
	float: left;
	list-style: none;
	margin: 0;
	padding: 0;
	width: 100%;
}
#menu li {
	float: left;
        font-weight:bold;
	margin: 0;
	padding: 0;
}
#menu a {
	background: #B9AA81;
	color: #fff;
	display: block;
	float: left;
	margin: 0;
	padding: 8px 12px;
	text-decoration: none;
}
#menu a:hover {
	background: <?php echo $highlight; ?>;
	color: #fff;
	padding-bottom: 8px;
}

#content{
text-align:center;
position:relative;
padding:4px;
background-color:#fff;
color:#000;
-moz-border-radius-bottomleft: 6px;
-moz-border-radius-bottomright: 6px;
-webkit-border-bottom-left-radius: 6px;
-webkit-border-bottom-right-radius: 6px;
}

#content a{
    text-decoration:none;
    font-weight:bold;
    color:#000;
}
#content a:visited,a:active{
    font-weight:bold;
    color:#000;
}
#content a:hover{
    text-decoration:underline;
}

#footer a,a:visited,a:active{
	text-decoration:none;
	color:#fff;
}

#footer a:hover{
	text-decoration:underline;
}

#footer{
text-align:center;
margin-top:10px;
padding:2px;
background-color:#B9AA81;
color:black;
/* border-style:solid;
border-width:thin;
border-color:#ff7100;*/
    -moz-border-radius: 6px;
    -moz-border-radius: 6px;
    -webkit-border-radius: 6px;
    -webkit-border-radius: 6px;
overflow:hidden;
}

#bottom{
    text-align:center;
    margin-top:5px;
    font-size:small;
    color:white;
}

/* picweb Info Table------------*/
table.infoTable td {
	padding: 2px;
	background-color: white;
        font-size: 14px;
        text-align: left;
}

table.infoTable th {
	padding: 2px;
	background-color: white;
        text-align: right;
        font-weight:bold;
        font-size:14px;
}

/* picweb Sidebar Table------------*/
table.sidebarTable td {
	padding: 2px;
        font-size: small;
        text-align: left;
        color:white;
}

table.sidebarTable th {
	padding: 2px;
        text-align: right;
        font-weight:bold;
        font-size:small;
        color:white;
}

/* picweb Comment Table------------*/
table.commentTable {
	background-color: white;
}

table.commentTable tr {
        border-bottom-width: 2px;
        border-style: hidden;
        background-color: #B9AA81;
        color: #ffffff;
}

table.commentTable td {
	border-bottom-width: 2px;
	padding: 2px;
	border-style: hidden;
        text-align: left;
}

table.commentTable th {
	border-bottom-width: 2px;
	padding: 2px;
	border-bottom-style: hidden;
	background-color: #ffffff;
        color: #000000;
}

.commentDate {
        font-size:small;
}

/* picweb pictureView TABLE-------------------------------*/
#pictureView table,th,td {
	border-width: 0px;
    margin-left:auto;
    margin-right:auto;
}

/* picweb GALLERY TABLE-------------------------------*/
#picweb_gallery table,th,td {
	border-width: 0px;
    margin-left:auto;
    margin-right:auto;
}

/* picweb FORM ------------------------------------*/
#picweb_form	{margin: auto; width: 360px; font-size: 16px;}
#picweb_form .heading {
	text-align: center;	font-size: 22px; font-weight: bold;	color: #B9AA81;
}
#picweb_form form {
	background-color: #B9AA81;
	padding: 10px;
	-moz-border-radius: 8px;
	-webkit-border-radius: 8px;
}
#picweb_form form label {font-weight: bold;	color: #11151E;}
#picweb_form form input[type=text],input[type=password] {
	width: 316px;
	font-weight: bold;
	padding: 8px;
	border: 1px solid #FFF;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
}
#picweb_form form input[type=submit] {
	display: block;
	margin: auto;
	width: 200px;
	font-size: 18px;
	background-color: #FFF;
	border: 1px solid #BBB;
}
#picweb_form form input[type=submit]:hover {border-color: #000;}
#picweb_form .error {font-size: 13px; color: #690C07; font-style: italic; }
    
.user_controls {float: right; text-align: right; color:#ffffff;}

div#PM_error, div#PM_info{
	color: #000;
	background-color: #ffbbbb;
	border: 1px solid #ff0000;
	margin: 3px;
	padding: 2px;
	text-align: left;
}
div#PM_error ul, div#PM_info ul{
	margin: 0;
}

div#PM_info{
	background-color: #bbbbff;
	border-color: #0000ff;
}
