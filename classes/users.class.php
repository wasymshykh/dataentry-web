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
        }
        return false;
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

    public function create($username, $password, $role, $status)
    {
        $s = $this->db->prepare("INSERT INTO `users` (`user_username`, `user_password`, `user_role`, `user_status`, `user_created`) VALUE (:u, :p, :r, :s, :c)");
        $s->bindParam(':u', $username);
        $s->bindParam(':p', $password);
        $s->bindParam(':r', $role);
        $s->bindParam(':s', $status);
        $date_time = date('Y-m-d H:i:s');
        $s->bindParam(':c', $date_time);

        if ($s->execute()) {
            $login_user = $this->get_by_id($_SESSION['user_id']);
            $this->create_log("user_create", $login_user['user_username'] . " have added a new user '" . $username . "'");
            return true;
        }
        return false;
    }

    public function create_log ($type, $text) {
        $s = $this->db->prepare("INSERT INTO `site_logs` (`sitelog_type`, `sitelog_text`) VALUE (:st, :stx)");
        $s->bindParam(':st', $type);
        $s->bindParam(':stx', $text);
        return $s->execute();
    }

    public function clear_logs () {
        $s = $this->db->prepare("DELETE FROM `site_logs`");
        return $s->execute();
    }

    public function get_site_logs () {
        $s = $this->db->prepare("SELECT * FROM `site_logs` ORDER BY `sitelog_created` DESC");
        if($s->execute()) {
            return $s->fetchAll();
        }
        return [];
    }

    public function edit_user($values, $user_id, $log) {
        $u = "";
        $c = 0;
        foreach ($values as $col => $value) {
            if ($c > 0) {
                $u .= ", ";
            }
            $u .= "`$col` = '$value'";
            $c++;
        }

        $s = $this->db->prepare("UPDATE `users` SET $u WHERE `user_id` = :i");
        $s->bindParam(":i", $user_id);
        if ($s->execute()) {
            $this->create_log("user_edit", $log);
            return ['status' => true];
        }
        return ['status' => false, 'message' => "Cannot update the user"];
    }

    public function delete_user($user_id, $log)
    {
        $s = $this->db->prepare("DELETE FROM `users` WHERE `user_id` = :i");
        $s->bindParam(":i", $user_id);
        if ($s->execute()) {
            $this->create_log("user_delete", $log);
            return ['status' => true];
        }
        return ['status' => false, 'message' => "Cannot delete the user"];
    }


}

