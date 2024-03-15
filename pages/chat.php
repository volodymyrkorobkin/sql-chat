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
    <button class="Chat-room-buttons">1</button>
    <button class="Chat-room-buttons">2</button>
    <button class="Chat-room-buttons">3</button>
    <button class="Chat-room-buttons">4</button>
    <button class="Chat-room-buttons">5</button>
    <button class="Chat-room-buttons">6</button>
    <button class="Chat-room-buttons">7</button>
    <button class="Chat-room-buttons">8</button>
    <button class="Chat-room-buttons">9</button>
    <button class="Chat-room-buttons">+</button>
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
    <form action=""  method="post">
      <input type="file" id="new-chat-img">
      <label for="new-chat-name"></label>
      <input type="text" id="new-chat-name" placeholder="Chat name">

      <section>
        <button type="button" id="cancel-create-chat">Cancel</button>
        <button type="submit" id="create-chat">Create</button>
      </section>
    </form>
  </section>

</section>



</body>
</html>
