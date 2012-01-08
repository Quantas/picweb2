<?php

function using_ie()
{
    return (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE);
}