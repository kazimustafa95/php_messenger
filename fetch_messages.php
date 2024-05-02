<?php
include('db/dbcon.php');
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '0'; // Default user ID if not provided
$receiver_id = isset($_GET['receiver_id']) ? $_GET['receiver_id'] : '0'; // Default receiver ID if not provided
$lastTimestamp = isset($_GET['lastTimestamp']) ? $_GET['lastTimestamp'] : '1970-01-01 00:00:00';

$sql = "SELECT * FROM `msg` WHERE ((`s_id` = '$user_id' AND `r_id` = '$receiver_id') OR (`s_id` = '$receiver_id' AND `r_id` = '$user_id')) AND `timestamp` > '$lastTimestamp' ORDER BY `timestamp`";
$result = $conn->query($sql);

$messages = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}
echo json_encode($messages);
?>
