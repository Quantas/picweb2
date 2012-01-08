<div id="admin_page">
    <div id="admin_userHead">
        Users
    </div>
    <div id="admin_userData">
        <table>
            <tr>
                <th>Username</th>
                <th>Real Name</th>
                <th>Join Date</th>
                <th>Birth Date</th>
                <th>E-Mail</th>
                <th>Albums</th>
                <th>Pictures</th>
                <th>Space</th>
            </tr>
            <?php $count=0;
                   foreach($userData->result() as $userInfo): ?>
            <?php $count++; if($count%2) $row='Even'; else $row='Odd'; ?>
                <tr class="highlight">
                    <Td><?php echo $userInfo->username; ?></Td>
                    <Td><?php echo $userInfo->fullname; ?></Td>
                    <Td><?php echo $userInfo->joindate; ?></Td>
                    <Td><?php echo $userInfo->birthdate; ?></Td>
                    <Td><?php echo $userInfo->email; ?></Td>
                    <Td><?php echo $userInfo->albumCount; ?></Td>
                    <Td><?php echo $userInfo->pictureCount; ?></Td>
                    <Td><?php echo byte_Format($userInfo->spaceUsed).'/'.byte_Format($userInfo->quota); ?></Td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <br />
    <div id="admin_albumsHead">
    Albums
    </div>
    <div id="admin_albumsData">
        <table>
            <?php foreach($albumData->result() as $albumInfo): ?>
                <tr>
                    <Td><?php echo $albumInfo->name; ?></Td>
                    <Td><?php echo $albumInfo->pictureCount; ?></Td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<script type="text/javascript">
    $('#admin_userData').hide();
    $('#admin_albumsData').hide();
    
    $('#admin_userHead').click(function() {
        $('#admin_userData').toggle('slow');
    });
    $('#admin_albumsHead').click(function() {
        $('#admin_albumsData').toggle('slow');
    });
</script>