<?php

class Staff
{
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function handle_create($data, $user_id)
    {
        $filtered = [];
        foreach ($data as $field => $value) {
            $filtered[$field] = normal_text($value);
        }
        if (empty($filtered['fname'])) {
            return $this->_r(false, "Please enter name of the staff");
        }
        $field_set = $this->get_field_db_mapping();
        $cols = "";
        $vals = "";
        $c = 0;
        foreach ($field_set as $field => $column) {
            if ($c > 0) {
                $cols .= ", ";
                $vals .= ", ";
            }
            $cols .= "`staff_$column`";
            $vals .= $filtered[$field] ? "'". $filtered[$field] ."'" : "NULL";
            $c += 1;
        }
        $cols .= ", `staff_creator_id`, `staff_created`";
        $vals .= ", :u, :dt";
        $q = "INSERT INTO `staff` ($cols) VALUE ($vals)";

        $s = $this->db->prepare($q);
        $s->bindParam(":u", $user_id);
        $datetime = current_date();
        $s->bindParam(":dt", $datetime);

        if ($s->execute()) {
            return array_merge($this->_r(true, "Record is successfully created!"), ['record_id' => $this->db->lastInsertId()]);
        }
        return $this->_r(false, "Unable to create the record.");
    }


    private function _r($status, $message = "")
    {
        return ['status' => $status, 'message' => $message];
    }


    public function get_field_db_mapping()
    {
        return [
            'fname' => 'first_name',
            'mname' => 'middle_name',
            'lname' => 'last_name',
            'dob' => 'dob',
            'sex' => 'sex',
            'pf' => 'pf',
            'nationality' => 'nationality',
            'origin' => 'origin',
            'lga' => 'lga',
            'marrital' => 'marrital',
            'childern' => 'childern',
            'qualification' => 'qualification',
            'appointment-rank' => 'appointment_rank',
            'appointment-date' => 'appointment_date',
            'next-kin' => 'next_kin',
            'kin-phone' => 'next_phone',
            'kin-address' => 'next_address',
            'kin-email' => 'next_email',
            'confirmation' => 'confirmation',
            'last-promotion' => 'last_promotion',
            'present-rank' => 'rank',
            'present-grade' => 'grade',
            'cadre' => 'cadre',
            'mda' => 'mda_id',
            'mda-posted' => 'mda_posted',
            'last-posting' => 'last_posting',
            'duration-mda' => 'duration',
            'home-address' => 'home_address',
            'contact-address' => 'contact_address',
            'phone-no' => 'phone',
            'email-address' => 'email',
            'bank' => 'bank',
            'account-no' => 'account_no',
            'membership' => 'membership',
            'fund-admin' => 'fund_admin',
            'pension-pin' => 'pension_pin',
            'nhf-no' => 'nhf',
            'nin' => 'nin',
            'tin' => 'tin',
            'nhis' => 'nhis_hospital'
        ];
    }

}

