DROP DATABASE IF EXISTS sqlChat;
CREATE DATABASE sqlChat;

SET GLOBAL event_scheduler = ON;



CREATE TABLE sqlChat.users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    username VARCHAR(32),
    password VARCHAR(64),

    PRIMARY KEY (id)
);

CREATE TABLE sqlChat.emails (
    id INT UNSIGNED NOT NULL,
    email VARCHAR(320),
    
    FOREIGN KEY (id) REFERENCES sqlChat.users(id)
);

CREATE TABLE sqlChat.sessions (
    session VARCHAR(256) NOT NULL unique,
    userId INT UNSIGNED NOT NULL,
    expires DATETIME DEFAULT (CURRENT_TIMESTAMP + INTERVAL 7 DAY),
    
    FOREIGN KEY (userId) REFERENCES sqlChat.users(id)
);

CREATE TABLE sqlChat.chats (
    chatId INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(32),
    membersCount INT UNSIGNED,
    
    PRIMARY KEY (chatId)
);

CREATE TABLE sqlChat.chatsMembers (
    chatId INT UNSIGNED NOT NULL,
    userId INT UNSIGNED NOT NULL,
    
    FOREIGN KEY (chatId) REFERENCES sqlChat.chats(chatId),
    FOREIGN KEY (userId) REFERENCES sqlChat.users(id)
);

CREATE TABLE sqlChat.messages (
	messageId INT UNSIGNED NOT NULL unique auto_increment,
    chatId INT UNSIGNED NOT NULL,
    userId INT UNSIGNED NOT NULL,
    sendTime DATETIME default (CURRENT_TIMESTAMP),
    editTime DATETIME default NULL,
    isDeleted boolean NOT NULL default false,
    messageBody VARCHAR(4000),
    
    FOREIGN KEY (chatId) REFERENCES sqlChat.chats(chatId),
    FOREIGN KEY (userId) REFERENCES sqlChat.users(id),
    PRIMARY KEY (messageId)
);

CREATE TABLE sqlChat.messageUpdates (
	changeId INT UNSIGNED NOT NULL unique auto_increment,
	chatId INT UNSIGNED NOT NULL,
    messageId INT UNSIGNED NOT NULL,
    changeTime DATETIME DEFAULT (CURRENT_TIMESTAMP),
    
    FOREIGN KEY (chatId) REFERENCES sqlChat.chats(chatId),
    FOREIGN KEY (messageId) REFERENCES sqlChat.messages(messageId)
);

CREATE TABLE sqlChat.inviteLinks (
	linkCode VARCHAR(16) NOT NULL,
    chatId INT UNSIGNED NOT NULL,
    
    FOREIGN KEY (chatId) REFERENCES sqlChat.chats(chatId)
);



# EVENTS
use sqlChat;
CREATE EVENT IF NOT EXISTS ev_delete_expired_sessions
ON SCHEDULE EVERY 5 MINUTE
DO
  DELETE FROM sqlChat.sessions
  WHERE expires < NOW();
  
CREATE EVENT IF NOT EXISTS ev_delete_marked_messages
ON SCHEDULE EVERY 5 MINUTE
DO
  DELETE sqlChat.messages, sqlChat.messageUpdates
  FROM sqlChat.messages
  JOIN sqlChat.messageUpdates ON sqlChat.messages.messageId = sqlChat.messageUpdates.messageId
  WHERE sqlChat.messages.isDeleted = TRUE
    AND sqlChat.messageUpdates.changeTime < NOW() - INTERVAL 10 MINUTE;


CREATE EVENT IF NOT EXISTS ev_cleanup_message_updates
ON SCHEDULE EVERY 5 MINUTE
DO
  DELETE FROM sqlChat.messageUpdates
  WHERE changeTime < NOW() - INTERVAL 10 MINUTE
    AND messageId NOT IN (
      SELECT messageId FROM sqlChat.messages WHERE isDeleted = TRUE
    );