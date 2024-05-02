<?php
    include('db/dbcon.php');

    // Check if the request is a POST request
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sender_id = $_POST['sender_id'];
        $receiver_id = $_POST['receiver_id'];
        $message = $conn->real_escape_string($_POST['message']);

        $date = date('m-d-Y');
        $time = date('H:i');

        // Insert message into the database
        $sql = "INSERT INTO `msg`(`s_id`, `r_id`, `msg`, `time`, `date`, `status`) 
        VALUES ('$sender_id','$receiver_id','$message','$time','$date','0')";
        if ($conn->query($sql) === TRUE) {
            echo "Message sent successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

?>

