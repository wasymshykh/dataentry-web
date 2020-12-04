<?php

class Auth {
    private $db;
    private $users;

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->users = new Users($db);
    }


    public function check_auth()
    {
        if (isset($_SESSION['logged']) && isset($_SESSION['user_id']) && $_SESSION['logged'] && !empty($_SESSION['user_id'])) {
            return $this->users->get_by_id($_SESSION['user_id']);
        }

        if (isset($_COOKIE['x-log-s']) && !empty($_COOKIE['x-log-s']) && is_string($_COOKIE['x-log-s'])) {
            $session_id = normal_text($_COOKIE['x-log-s']);
            $session = $this->get_session_by_id($session_id);

            if ($session) {
                return $this->users->get_by_id($session['session_user']);
            } else {
                return false;
            }
        }

        return false;
    }

    public function login ($username, $password)
    {
        $user = $this->users->get_by_username($username);

        if (!$user) {
            return ['status'=> false, 'message' => 'No user found'];
        }
        
        if (!password_verify($password, $user['user_password'])) {
            return ['status' => false, 'message' => 'Password is invalid'];
        }

        if ($user['user_status'] != "A") {
            return ['status' => false, 'message' => 'Account is not active'];
        }

        $this->record_login($user['user_id']);

        $_SESSION['logged'] = true;
        $_SESSION['user_id'] = $user['user_id'];

        return ['status' => true];
    }

    public function record_login($user_id)
    {
        $user_ip = get_ip();
        if (PROJECT_MODE === 'development') {
            $user_ip = "161.192.75.180";
        }

        $s = $this->db->prepare("INSERT INTO `login_logs` (`loginlog_user_id`, `loginlog_ip`, `loginlog_created`) VALUE (:ui, :ip, :dt)");
        $s->bindParam(":ui", $user_id);
        $s->bindParam(":ip", $user_ip);
        $date_time = date('Y-m-d H:i:s');
        $s->bindParam(":dt", $date_time);
    }


    public function get_session_by_id($session_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM `user_session` WHERE `session_id` = :id");
        $stmt->bindParam(":id", $session_id);
        if ($stmt->execute()) {

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch();
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    public function insert_session_data($session_id, $user_id)
    {
        $session = $this->get_session_by_id($session_id);

        if ($session) {
            $next_stmt = $this->db->prepare("UPDATE `user_session` SET `session_user` = :u, `session_updated` = :du WHERE `session_id` = :id");
            $date_time = date('Y-m-d H:i:s');
            $next_stmt->bindParam(":du", $date_time);
        } else {
            $next_stmt = $this->db->prepare("INSERT INTO `user_session` (`session_id`, `session_user`) VALUE (:id, :u)");
        }

        $next_stmt->bindParam(":id", $session_id);
        $next_stmt->bindParam(":u", $user_id);
        if ($next_stmt->execute()) {
            setcookie("x-log-s", session_id(),  time() + ((SESSION_EXPIRE_TIME)));
        }
    }

}
