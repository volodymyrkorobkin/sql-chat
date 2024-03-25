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
    constructor(chatId, messages = []) {
        this.chatId = chatId;
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
                let messageObj = new Message(message.messageId, message.userId, message.sendTime, message.messageBody);
                this.messages.push(messageObj);
                
                this.displayMessage(messageObj, 0);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }


    displayMessage(message, index) {
        const textArea = document.getElementById("text-area");
        const messageCard = createMessageCard(message);

        if (index === 0) {
            textArea.appendChild(messageCard);
        } else {
            textArea.insertBefore(messageCard, textArea.querySelector(`#message-${this.messages[index].messageId}`));
        }
        
        textArea.scrollTop = textArea.scrollHeight;
    }

    sendMessage(message) {
        // Send the message to the server
        // Update the chat with the new message
        let newMessage = new Message(null, userId, new Date().toLocaleString('en-US', { timeZone: 'Europe/Amsterdam' }), message);
        this.messages.push(newMessage);
        this.displayMessage(newMessage, 0);

        fetch(`../api/sendMessage.php`, {
            method: 'POST',
            body: JSON.stringify({
                chatId: chatId,
                userId: userId,
                body: newMessage.body
            }),
            
        }).then(response => response.text()).then(data => {
            console.log(data);
        });
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


function createMessageCard(message) {

    // left-side of the message
    let containerDiv = document.createElement("div");
    containerDiv.id = "message-" + message.messageId
    containerDiv.classList.add("LeftStroke");
    let profilePictureImg = document.createElement("img");
    profilePictureImg.src = "../img/YEAH.jpg";
    profilePictureImg.alt = "avatar";
    profilePictureImg.classList.add("profilePicture");
    let leftMessageDiv = document.createElement("p");
    leftMessageDiv.classList.add("leftMessage");
    leftMessageDiv.innerText = message.body;
    let time = document.createElement("div");  
    time.classList.add("time-left");
    time.innerHTML = message.time.split(" ")[1].split(":").slice(0, 2).join(":");


    // Append elements
    containerDiv.appendChild(profilePictureImg);
    containerDiv.appendChild(leftMessageDiv);
    leftMessageDiv.appendChild(time);

    return containerDiv;
}


addEventListener('DOMContentLoaded', () => {
    if (typeof chatId === 'undefined') {
        return;
    }

    const input = document.getElementById("input-field");
    input.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            if (input.value.trim() !== "") { // Check if input is not empty
                document.getElementById("button").click();
                document.getElementById("input-field").value = "";
            } else {
                event.preventDefault();
            }
        }
    });

    chat = new Chat(chatId, []);
    chat.getInitialMessages();
});


function savedInput() {
    const savedInput = document.getElementById("input-field").value;
    chat.sendMessage(savedInput);
}
