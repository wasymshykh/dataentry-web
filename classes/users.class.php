<?php

class Users
{
    
    private $db;
    private $logs;

    public function __construct(PDO $db) {
        $this->logs = new Logs($db);
        $this->db = $db;
    }

    public function get_users()
    {
        $stmt = $this->db->prepare("SELECT * FROM `users`");

        if ($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            return [];
        }
    }

    public function get_by_id($user_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM `users` WHERE `user_id` = :ui");
        $stmt->bindParam(":ui", $user_id);

        if ($stmt->execute()) {
            return $stmt->fetch();
        } else {
            return false;
        }
    }

    public function get_by_username($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM `users` WHERE `user_username` = :usr");
        $stmt->bindParam(":usr", $username);

        if ($stmt->execute()) {
            return $stmt->fetch();
        } else {
            return false;
        }
    }


}

