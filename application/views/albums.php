<div id="gallery">
    <table style="margin: auto;">
    <?php foreach($albums as $album): ?>
        <tr>
            <td>
        <?php
            if (strlen($album->name) > 15 ) { $albumName = substr($album->name,0,15).'...'; } else { $albumName = $album->name; }
            echo anchor('gallery/display/'.$album->id, $albumName); ?></td>
            <td><a title="Download Album" href="<?php echo site_url('albums/downloadAlbum/'.$album->id); ?>"><img src="<?php echo base_url();?>images/download.png" alt="Save" /></a></td>
    </tr>
    <?php endforeach; ?>
    </table>
</div>