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


    displayMessage(message) {
        // Display the message on the chat
    }

    sendMessage(message) {
        // Send the message to the server
        // Update the chat with the new message
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
