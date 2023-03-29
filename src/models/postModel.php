<?php

require_once 'connectDB.php';

class PostModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getTopics() {
        $stmt = $this->db->prepare("SELECT * FROM topics ORDER BY title ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubtopics($topic_id) {
        $stmt = $this->db->prepare("SELECT * FROM subtopics WHERE topic_id = :topic_id ORDER BY created_at DESC");
        $stmt->bindValue(":topic_id", $topic_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getSubtopicsByUserId($userId) {
        $sql = "SELECT subtopics.*, topics.title AS topic_title FROM subtopics JOIN topics ON subtopics.topic_id = topics.topic_id WHERE user_id = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$userId]);
        return $query->fetchAll();
    }
    
    public function getSubtopicById($subtopicId) {
        $sql = "SELECT subtopics.*, topics.title AS topic_title FROM subtopics JOIN topics ON subtopics.topic_id = topics.topic_id WHERE subtopic_id = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$subtopicId]);
        return $query->fetch();
    }
    

    public function addSubtopic($title, $user_id, $topic_id) {
        $stmt = $this->db->prepare("INSERT INTO subtopics (title, user_id, topic_id) VALUES (:title, :user_id, :topic_id)");
        $stmt->bindValue(":title", $title);
        $stmt->bindValue(":user_id", $user_id);
        $stmt->bindValue(":topic_id", $topic_id);
        $stmt->execute();
        $subtopics = $this->getSubtopics($topic_id);
        return array("subtopics" => $subtopics, "lastInsertId" => $this->db->lastInsertId());
    }
    

    public function updateSubtopic($subtopic_id, $title) {
        $stmt = $this->db->prepare("UPDATE subtopics SET title = :title, updated_at = NOW() WHERE subtopic_id = :subtopic_id");
        $stmt->bindValue(":title", $title);
        $stmt->bindValue(":subtopic_id", $subtopic_id);
        return $stmt->execute();
    }

    public function deleteSubtopic($subtopic_id) {
        $stmt = $this->db->prepare("DELETE FROM subtopics WHERE subtopic_id = :subtopic_id");
        $stmt->bindValue(":subtopic_id", $subtopic_id);
        return $stmt->execute();
    } 
    
    public function addMessage($message, $user_id, $subtopic_id, $topic_id) {
        $stmt = $this->db->prepare("INSERT INTO messages (message, user_id, subtopic_id, topic_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$message, $user_id, $subtopic_id, $topic_id]);
        return $this->db->lastInsertId();
    }    
 

    public function getMessages($message_id) {
        $stmt = $this->db->prepare("SELECT messages.*, users.username FROM messages JOIN users ON messages.user_id = users.user_id WHERE parent_id = :message_id ORDER BY created_at ASC");
        $stmt->bindValue(":message_id", $message_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
     
    
    public function getMessagesBySubtopicId($subtopic_id) {
        $stmt = $this->db->prepare("SELECT messages.*, users.username FROM messages JOIN users ON messages.user_id = users.user_id WHERE subtopic_id = :subtopic_id ORDER BY created_at DESC");
        $stmt->bindValue(":subtopic_id", $subtopic_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }     
    
    public function addReply($content, $user_id, $message_id, $parent_id = null) {
        $stmt = $this->db->prepare("INSERT INTO replies (content, user_id, message_id, parent_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$content, $user_id, $message_id, $parent_id]);
        return $this->db->lastInsertId();
    }

    public function getReplies($message_id) {
        $stmt = $this->db->prepare("SELECT replies.*, users.username FROM replies JOIN users ON replies.user_id = users.user_id WHERE message_id = :message_id ORDER BY created_at ASC");
        $stmt->bindValue(":message_id", $message_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}