<?php
require_once("../Utils/HtmlHelper.php");

$db_helper = new DatabaseHelper();
if(!empty($_POST["keyword"])) {
    $users = $db_helper->GetFilteredUsers($_POST["keyword"]);
    if(!empty($users)) {
        ?>
        <ul id="friends-list">
            <?php
            foreach($users as $user) {
                ?>
                <li onClick="selectFriend('<?php echo $user; ?>');"><?php echo $user; ?></li>
            <?php } ?>
        </ul>
    <?php } }
    ?>