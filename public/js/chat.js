// Utils
const MESSAGES_BUFFER = 20;

let editingmessageId = null;


function formatTime(sendTime) {
    return sendTime.split(" ")[1];
}
function getCurrentFormattedDate() {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    
    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}

// Classes
class Message {
    constructor(messageId, senderId, sender, sendTime, messageBody, htmlObj = null) {
        this.messageId = messageId;
        this.senderId = senderId;
        this.sender = sender;
        this.sendTime = sendTime;
        this.messageBody = messageBody;
        this.htmlObj = htmlObj;
    }




    createCard() {
        let containerDiv = document.createElement("div");
    
        if (userId == this.senderId) {
            containerDiv.classList.add("LeftStroke");
        } else {
            containerDiv.classList.add("RightStroke");
        }
    
        let profilePictureImg = document.createElement("img");
        profilePictureImg.src = "../img/YEAH.jpg";
        profilePictureImg.alt = "avatar";
        profilePictureImg.classList.add("profilePicture");
        let leftMessageDiv = document.createElement("p");
        leftMessageDiv.classList.add("leftMessage");
        leftMessageDiv.innerText = this.sender + ": " + this.messageBody;
        let time = document.createElement("div");  
        time.classList.add("time-left");
        time.innerHTML = formatTime(this.sendTime);

        containerDiv.appendChild(profilePictureImg);
        containerDiv.appendChild(leftMessageDiv);
        leftMessageDiv.appendChild(time);

        if (userId == this.senderId) {

            let settingsChat = document.createElement("div");
            settingsChat.classList.add("settingsChat");
            settingsChat.id = "settings";
            
            // Settings button
            const settingsbutton = document.createElement("button");
            settingsbutton.innerHTML = "⚙️";

            settingsChat.appendChild(settingsbutton);
            const overlayWrapper = document.createElement("div");
            overlayWrapper.classList.add("overlay-wrapper");
            settingsChat.appendChild(overlayWrapper);

            settingsbutton.addEventListener("click", () => {
                console.log("Settings clicked");

                overlayWrapper.innerHTML = "";
                overlayWrapper.classList.add("open");


                const overlay = document.createElement("div");
                overlay.classList.add("overlay");

                const deleteButton = document.createElement("button");
                deleteButton.innerText = "🗑️";
                deleteButton.addEventListener("click", () => {
                    console.log("Delete clicked");

                    fetch(`../api/deleteMessage.php`, {
                        method: 'POST',
                        body: JSON.stringify({
                            messageId: this.messageId
                        }),
                    });
                });
                overlay.appendChild(deleteButton);


                //Edit button
                const editButton = document.createElement("button");
                editButton.innerText = "✏️";
                editButton.addEventListener("click", () => {
                    console.log("Edit clicked");
                    document.getElementById("input-field").value = this.messageBody;
                    editingmessageId = this.messageId;

                    const input = document.getElementById("input-field");
                    input.focus();
                    overlayWrapper.innerHTML = "";
                    overlayWrapper.classList.remove("open");
                });

                overlay.appendChild(editButton);


                overlayWrapper.appendChild(overlay);
            })
            settingsChat.addEventListener("mouseleave", () => {
                overlayWrapper.innerHTML = "";
                overlayWrapper.classList.remove("open");
            });
            console.log("Settings created")
            containerDiv.appendChild(settingsChat);
        }
        this.htmlObj = containerDiv;
        return containerDiv;
    }

    updateBody() {
        if (!this.htmlObj) return;
        const message = this.htmlObj.querySelector(".leftMessage");
        message.innerHTML = this.sender + ": " + this.messageBody + this.htmlObj.querySelector(".time-left").outerHTML;
    }

    updateTime() {
        if (!this.htmlObj) return;
        const time = this.htmlObj.querySelector(".time-left");
        time.innerHTML = formatTime(this.sendTime);
    }
}

class Chat {
    constructor(chatId, messages = []) {
        this.chatId = chatId;
        this.messages = messages;
        this.sendMessagesQueue = [];
        this.sendingMessages = new Set();
        this.messagesIds = new Set();
        this.currentChangeId = NaN;
        
        this.initChat();
    }

    async initChat() { 
        this.messagesTextArea = document.getElementById("text-area");

        
        await this.loadInitialChatMessages();
        this.startLongPolling(); // Start long polling updates
        this.startProcessingMessagesLoop();
        this.loadPreviousMessagesLoop();
    }
    

    async loadInitialChatMessages() {
        const [changeId, messages] = await this.fetchInitialChatMessages();
        this.currentChangeId = parseInt(changeId);
        for (let message of messages) {
            this.insertMessage(message);
        }

        this.messagesTextArea.scrollTop = this.messagesTextArea.scrollHeight;
    }

    async fetchInitialChatMessages() {
        const response = await fetch(`../api/getInitialMessages.php?chatId=${chatId}`, {
            method: 'GET',
        });
        const data  = await response.json();
        const changeId = data.changeId;
        const messages = data.messages.map(message => new Message(message.messageId, message.userId, message.username, message.sendTime, message.messageBody, true));
    
        return [changeId, messages];
    }

    insertMessage(message) {
        if (message.messageId === null) {
            this.insertMessageToTheEnd(message);
            this.messages.push(message);
            return;
        }

        let index = 0;
        for (let i = 0; i < this.messages.length; i++) {
            if (!this.messages[i].messageId) continue;
            if (this.messages[i].messageId < message.messageId) {
                index = i + 1;
            }
        }

        this.messages.splice(index, 0, message);

        if (this.messages.length != 0 && index === this.messages.length - 1) {
            this.insertMessageToTheEnd(message);
        } else {
            this.insertMessageBefore(message, index);
        }

        this.messagesIds.add(message.messageId);
    }

    insertMessageToTheEnd(message) {
        this.messagesTextArea.appendChild(message.createCard());
    }

    insertMessageBefore(message, index) {
        this.messagesTextArea.insertBefore(message.createCard(), this.messages[index + 1].htmlObj);
    }

    async loadPreviousMessages() {
        const messages = await this.fetchPreviousMessages();

        const scrollHeight = this.messagesTextArea.scrollHeight;
        const scrollTop = this.messagesTextArea.scrollTop;
        for (let message of messages) {
            this.insertMessage(message);
        }


        // Do it only on ios devices

        if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
            this.messagesTextArea.style.overflowY = 'hidden';  
            this.messagesTextArea.scrollTop = scrollTop + this.messagesTextArea.scrollHeight - scrollHeight;
            this.messagesTextArea.style.overflowY = 'auto';
        } else {
            this.messagesTextArea.scrollTop = scrollTop + this.messagesTextArea.scrollHeight - scrollHeight;
        }

        return messages.length;
    }

    async fetchPreviousMessages() {
        const response = await fetch(`../api/getOldMessages.php?chatId=${chatId}&olderThan=${this.messages[0].messageId}`, {
            method: 'GET',
        });
        const data  = await response.json();
        const messages = data.map(message => new Message(message.messageId, message.userId, message.username, message.sendTime, message.messageBody, true));
        return messages;
    }

    async sendMessage(messageText) {
        let newMessage = new Message(null, userId, username, getCurrentFormattedDate(), messageText);
        this.insertMessage(newMessage);

        this.sendMessagesQueue.push(newMessage);
        this.sendingMessages.add(newMessage);

        this.messagesTextArea.scrollTop = this.messagesTextArea.scrollHeight;
    }

    isMessageSending(message) {
        for (let sendingMessage of this.sendingMessages) {

            if (sendingMessage.messageBody != message.messageBody) continue;
            if (sendingMessage.senderId != message.senderId) continue;
            if (Math.abs(sendingMessage.time - message.time) > 60) continue;

            return true;
        }
        return false;
    }

    bundleMessagesForSending() {
        const messages = [];
        const messagesJson = [];

        while (this.sendMessagesQueue.length > 0) {
            const message = this.sendMessagesQueue.shift();
            const messageJson = JSON.stringify({
                messageBody: message.messageBody,
                sendTime: message.sendTime
            });

            messagesJson.push(messageJson);
            messages.push(message);
        }

        return { messages, messagesJson };
    }

    async sendMessagesToServer(messagesJson) {
        const response = await fetch(`../api/sendMessages.php`, {
            method: 'POST',
            body: JSON.stringify({
                chatId: chatId,
                userId: userId,
                messages: messagesJson
            }),
        });
        return await response.json();
    }

    processConfirmedMessages(responceData, messages) {
        for (let i = 0; i < messages.length; i++) {
            const message = messages[i];
            message.messageId = responceData[i]["messageId"];
            message.sendTime = responceData[i]["sendTime"];

            this.sendingMessages.delete(message);
            this.updateMessage(message);
        }
    }


    async sendQueuedMessages() {
        const { messages, messagesJson } = this.bundleMessagesForSending();
        const responceData = await this.sendMessagesToServer(messagesJson);
        this.processConfirmedMessages(responceData, messages);
    }

    async startProcessingMessagesLoop() {
        while (true) {
            while (this.sendMessagesQueue.length == 0) await new Promise(resolve => setTimeout(resolve, 100));
            await this.sendQueuedMessages();
        }
    }

    updateMessage(message) {

        //Find new place for the message
        let index = 0;
        for (let i = 0; i < this.messages.length; i++) {
            if (!this.messages[i].messageId) continue;
            if (this.messages[i].messageId < message.messageId) {
                index = i + 1;
            }
        }

        const children = this.messagesTextArea.children;
        const childrenArray = Array.prototype.slice.call(children);

        const messageIndex = childrenArray.indexOf(message.htmlObj);

        // If the message is in the same place do nothing
        if (index === messageIndex) {
            this.messagesIds.add(message.messageId);

            message.updateTime();
            return;
        }
        
        message.htmlObj.remove();
        this.messages = this.messages.filter(msg => msg.messageId !== message.messageId);
        this.insertMessage(message);
    }

    changeMessage(messageId, newBody) {
        // Change the message on the server
        // Update the chat with the new message
        this.messages.forEach(message => {
            if (message.messageId === messageId) {
                message.messageBody = newBody;
                message.updateBody();
                return;
            }
        });
    }

    deleteMessage(messageId) {
        // Delete the message on the server
        // Delete the message from the chat
        this.messages.forEach((message, index) => {
            if (message.messageId === messageId) {
                this.messagesTextArea.removeChild(message.htmlObj);
                this.messages.splice(index, 1);
                this.messagesIds.delete(messageId);

                if (index === MESSAGES_BUFFER) {
                    if (this.messages.length > MESSAGES_BUFFER) this.observedElement = this.messages[MESSAGES_BUFFER].htmlObj;
                }
                return;
            }
        });
    }

    handleNewMessages(newMessages) {
        if (!newMessages) return;
        newMessages.forEach(message => {
            const messageObj = new Message(message.messageId, message.userId, message.username, message.sendTime, message.messageBody);
            
            if (!this.isMessageSending(messageObj) && !this.messagesIds.has(messageObj.messageId)) {
                // Check if textarea is scrolled to the bottom

                const isScrolledToBottom = this.messagesTextArea.scrollHeight - this.messagesTextArea.scrollTop - this.messagesTextArea.clientHeight < 20;
                this.insertMessage(messageObj);     
                
                if (isScrolledToBottom) {
                    this.messagesTextArea.scrollTop = this.messagesTextArea.scrollHeight;
                }
            }
        });
    }

    handleChangedMessages(changedMessages) {
        if (!changedMessages) return;
        changedMessages.forEach(message => {
            if (message.isDeleted) {
                this.deleteMessage(message.messageId);
            } else {
                this.changeMessage(message.messageId, message.messageBody);
            }
        });
    }

    handleUpdates(data) {
        // Possible updates:
        // newMessages
        // changedMessages

        this.handleNewMessages(data.newMessages);
        this.handleChangedMessages(data.changedMessages);

        if (data.lastChangeId) {
            this.currentChangeId = data.lastChangeId;
        }
    }
    
    getLastValidMessageId() {
        for (let i = this.messages.length - 1; i >= 0; i--) {
            if (this.messages[i].messageId !== null) {
                return this.messages[i].messageId;
            }
        }
        return 0;
    }

    async startLongPolling() {
        let lastMessageId = 0;
        while (true) {
            lastMessageId = this.getLastValidMessageId();

            try {
                const response = await fetch(`../api/whatsApp.php?chatId=${chatId}&lastMessageId=${lastMessageId}&lastChangeId=${this.currentChangeId}`, {
                    method: 'GET',
                });
                if (response.ok) {
                    const data = await response.json();
                    this.handleUpdates(data);
                }

            } catch (error) {
                console.error('Fetch error: ', error);
            }
            await new Promise(resolve => setTimeout(resolve, 100));
        }
    }

    async loadPreviousMessagesLoop() {
        if (this.messages.length < MESSAGES_BUFFER + 1) return;
        this.observedElement = this.messages[MESSAGES_BUFFER].htmlObj;
        while (true) {
            if (this.messagesTextArea.scrollTop - this.observedElement.offsetTop < 0) {
                let loadedCnt = await this.loadPreviousMessages();

                if (loadedCnt === 0) {
                    return;
                }
                this.observedElement = this.messages[MESSAGES_BUFFER].htmlObj;
            }
            await new Promise(resolve => setTimeout(resolve, 500));
        }
    }
}

let chat;

addEventListener('DOMContentLoaded', () => {
    // IF no chat selected return
    if (typeof chatId === 'undefined') return;

    chat = new Chat(chatId, []);

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

    // Usefull feature to save scroll position
    const buttons = document.querySelectorAll("a .Chat-room-buttons");
    buttons.forEach(button => {
        button.addEventListener("click", () => {
            const buttonsContainer = document.querySelector("#chat-room-aside");
            const scrollPosition = buttonsContainer.scrollTop;
            localStorage.setItem("scrollPosition", scrollPosition);
            console.log("Saved scroll position", scrollPosition);
        });
    });

    const scrollPosition = localStorage.getItem("scrollPosition");

    if (scrollPosition) {
        const buttonsContainer = document.querySelector("#chat-room-aside");
        buttonsContainer.scrollTop = scrollPosition;
    }
});





function openNewChatOverlay() {
    document.getElementById("new-chat-overlay").style.display = "flex";
    document.getElementById("new-chat-name").focus();
}
function closeNewChatOverlay() {
    document.getElementById("new-chat-overlay").style.display = "none";
}
function savedInput() {
    const savedInput = document.getElementById("input-field").value;
    if (!editingmessageId) {
        chat.sendMessage(savedInput);
    } else {
        chat.changeMessage(editingmessageId, savedInput);
        fetch(`../api/editMessage.php`, {
            method: 'POST',
            body: JSON.stringify({
                messageId: editingmessageId,
                messageBody: savedInput
            }),
        });
        editingmessageId = null;
    }
}