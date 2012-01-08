<table>
<?php foreach($stories as $story): ?>
    <tr>
        <td><?php echo $story->title; ?></td>
        <td><?php echo $story->story; ?></td>
        <td><?php echo $story->User->first_name; ?></td>
        <td><?php echo $story->created_at; ?></td>
    </tr>
<?php endforeach; ?>
</table>