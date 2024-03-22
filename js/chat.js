function openNewChatOverlay() {
    document.getElementById("new-chat-overlay").style.display = "flex";
}

function closeNewChatOverlay() {
    document.getElementById("new-chat-overlay").style.display = "none";
}

function getNewMessages(chatId, lastMessageId) {
    // Get new messages from the server
    // Update the chat with the new messages
}


//Status: 0 UpToDate, 1 New, 2 Edited, 3 Deleted
// status {
//    status: 0,
//    time: timestamp
//}


class Message {
    constructor(messaageId, sender, time, body) {
        this.messageId = messaageId;
        this.sender = sender;
        this.time = time;
        this.body = body;
        this.status = null;
    }
}

class Chat {
    constructor(chatId, name, messages = []) {
        this.chatId = chatId;
        this.name = name;
        this.messages = messages;
    }


    getInitialMessages() {
        // Get initial messages from the server
        // Update the chat with the initial messages
        fetch(`../api/getInitialMessages.php?chatId=${chatId}`, {
            method: 'GET',
        })
        .then(response => response.json())
        .then(data => {
            data.forEach(message => {
                let messageObj = new Message(message.messageId, message.sender, message.time, message.body);
                this.messages.push(messageObj);
                this.displayMessage(messageObj);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }


    displayMessage(message) {
        // Display the message on the chat
    }

    sendMessage(message) {
        // Send the message to the server
        // Update the chat with the new message
        let newMessage = new Message(null, userId, Date.now(), message);
        this.messages.push(newMessage);
        this.displayMessage(newMessage);

    }

    updatemessage(messageId) {
        // Update the message on the front end
    }

    changeMessage(messageId, newBody) {
        // Change the message on the server
        // Update the chat with the new message
    }

    deleteMessage(messageId) {
        // Delete the message on the server
        // Update the chat with the new message
    }

    getNewMessages() {
        // Get new messages from the server
        // Update the chat with the new messages
    }

    getOldMessages() {
        // Get old messages from the server
        // Update the chat with the old messages
    }

    displayChat() {
        // Display the chat on the screen
    }
}

let chat;

addEventListener('DOMContentLoaded', () => {
    if (typeof chatId === 'undefined') {
        return;
    }

    chat = new Chat(chatId, "TODO", []);
    chat.getInitialMessages();
    chat.displayChat();
});


addEventListener('keydown', (event) => {
    if (event.key === 'Enter') {
        console.log(chat.messages);
    }
});
