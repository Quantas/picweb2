<br />
<div id="tou" style="width:600px; height:200px; font-size:10pt; margin: auto; overflow:auto;">
<?php $this->load->view('tou'); ?>
</div>
<br />
By clicking on the following button you agree that you are at least 13 years of age and<br/>
you agree to the site's Terms of Use.
<p>
    <?php echo form_open('/signup/agecheck'); ?>
    <?php echo form_submit('submit','Agree'); ?> <a href="http://www.google.com"><button>Disagree</button></a>
    <?php echo form_close(); ?>
</p>