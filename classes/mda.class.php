<?php

class Mda
{
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }


    public function get_mda_by ($column, $value, $multiple = false)
    {
        $s = $this->db->prepare("SELECT * FROM `mda` WHERE `$column` = :v");
        $s->bindParam(":v", $value);
        if ($s->execute()) {
            if ($multiple) {
                return $s->fetchAll();
            }
            return $s->fetch();
        }
        return false;
    }

    public function create($name)
    {
        $s = $this->db->prepare("INSERT INTO `mda` (`mda_name`, `mda_created`) VALUE (:n, :dt)");
        $s->bindParam(":n", $name);
        $datetime = current_date();
        $s->bindParam(":dt", $datetime);
        if ($s->execute()) {
            return $this->_r(true);
        }
        return $this->_r(false, "Couldn't insert the name.");
    }

    public function update($name, $id)
    {
        $s = $this->db->prepare("UPDATE `mda` SET `mda_name` = :n WHERE `mda_id` = :i");
        $s->bindParam(":n", $name);
        $s->bindParam(":i", $id);
        if ($s->execute()) {
            return $this->_r(true);
        }
        return $this->_r(false, "Couldn't update the MDA.");
    }

    public function delete($id)
    {
        $s = $this->db->prepare("DELETE FROM `mda` WHERE `mda_id` = :i");
        $s->bindParam(":i", $id);
        if ($s->execute()) {
            return $this->_r(true);
        }
        return $this->_r(false, "Couldn't delete the MDA.");
    }

    public function get_all ()
    {
        $s = $this->db->prepare("SELECT * FROM `mda`");
        if ($s->execute()) {
            return $s->fetchAll();
        }
        return [];
    }

    
    private function _r($status, $message = "")
    {
        return ['status' => $status, 'message' => $message];
    }

}
