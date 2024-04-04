
// delete message
// clear session id once clicked on delete
// create eventkey wish is right click
//once clikced delete clear that particular chat id

// delete sqlchat.messages
// get chatid
// event button on chat bubble
// once clicked delete
// clear chatid from database


// //$sql = "SELECT * FROM (
//     SELECT messages.*, chatid
//     FROM messages 
//     ON messages.userId = users.id 
//     WHERE chatId = ? and messageId < ? 
//     ORDER BY messageId DESC 
//     LIMIT 25
// ) AS subquery 
//     ORDER BY messageId ASC;";
//--------------------------
// chatgpt stuff
// // Check if message ID is provided via GET or POST request
// if(isset($_REQUEST['delete_message_id'])) {
//     // Sanitize input to prevent SQL injection
//     $message_id = mysqli_real_escape_string($conn, $_REQUEST['delete_message_id']);

//     // Delete message from the database
//     $sql = "DELETE FROM messages WHERE messageId = $message_id";
//     if ($conn->query($sql) === TRUE) {
//         echo "Message deleted successfully";
//     } else {
//         echo "Error deleting message: " . $conn->error;
//     }
// } else {
//     echo "No message ID provided.";
// }

// $conn->close();




<?php 
include_once '../php/sql_connect.php';
include_once '../php/sql_utils.php';
include_once '../php/session.php';

$requestKeys = ['new-chat-name'];
include_once "../php/checkRequestKeys.php";
include_once "../php/checkSession.php";


foreach ($messages as $message) {
    $message = json_decode($message, true);
    $messageBody = $message['messageBody'];
    
    $sql = "DELETE FROM messages WHERE chatId = ? AND userId = ?";
    $params = [$chatId, $userId];
    runSql($sql, $params);
}


?>