<div id="picweb_form">
	<p class="heading">Search</p>
    <?php echo form_open('sitesearch/do_search'); ?>
    <p>
            <?php echo form_input('search_string',set_value('album_name')); ?>
    </p>
    <?php echo form_submit('submit', 'Submit');
    echo form_close();
    ?>
</div>