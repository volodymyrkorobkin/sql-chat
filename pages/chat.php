<?php
include_once '../php/session.php';
include_once '../php/chat.php';

// Session check
session_start();
if (!isset($_SESSION["id"])) {
  header("Location: sign_in.php");
  return;
}
if (!isValidSession($_SESSION["id"])) {
  header("Location: sign_in.php");
  return;
}

// Sidebar
$chats = [];
$chatsSqlResponse = getUserChats(getUserBySession($_SESSION["id"]));

foreach($chatsSqlResponse as $chatRow) {
  $chatId = $chatRow['chatId'];
  $chatName = getChatNameById($chatId);

  $chats[$chatId] = [
    "name" => $chatName
  ];
}


//Acces check
if (!isset($_GET["chatId"])) {
  header("Location: chat.php?chatId=" . array_key_first($chats));
  return;
} else {
  //Check is user member of chat
  if (!array_key_exists($_GET["chatId"], $chats)) {
    header("Location: chat.php?chatId=" . array_key_first($chats));
    return;
  }
}
?>



<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <title>Chatroom</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="../js/chat.js"></script>
  <link rel="stylesheet" href="../style.css">
</head>
<html>

<body>

<aside id="chat-room-aside">
  <div class="button-container">


    <?php
    foreach($chats as $chatId => $chat) {
      $shortChatName = substr($chat['name'], 0, 2);

      echo "<a href='?chatId={$chatId}'>";
      echo "<button class='Chat-room-buttons'>{$shortChatName}</button>";
      echo "</a>";
    }
    ?>






    <button class="Chat-room-buttons" onclick="openNewChatOverlay()">+</button>
  </div>
</aside>

<!-- HEADER CODE-->
<section id="header-Chat">
<h1 class="text-Header">CHAT GROUP NAME RAAAH </h1>
  <article id="settings-Members">
    <h1 class="text-Header">5 :members<h1>
<input type="checkbox" id="menu-toggle">
<label for="menu-toggle" id="menu-icon">&#129416;</label>
<nav id="navMain">
         <a>settings</a>
         <a>leave-group</a>
         <a>log-out</a>
      </nav>
  </article>
</section>


<section id="footer-Chat">
<div id="type-balk">
    <input type="text" class="input-field" placeholder="Start typing here...">
</div>
</section>



  <section id="new-chat-overlay">
    <section id="new-chat-overlay-content">
      <h2>Create a new chat</h2>
      <form action="../api/createNewChat.php" method="post">
        <input type="text" name="session" value="<?php echo $_SESSION['id']?>" class="hiden">

        <input type="file" id="new-chat-img" name="new-chat-img" class="hiden">
        <label for="new-chat-img" class="img">Upload an image</label>
        <label for="new-chat-name"></label>
        <input type="text" name="new-chat-name" id="new-chat-name" placeholder="Chat name" required>

        <section>
          <button type="button" id="cancel-create-chat" onclick="closeNewChatOverlay()">Cancel</button>
          <input type="submit" value="Create" name="submit">
        </section>
      </form>
    </section>

</section>



</body>

</html>