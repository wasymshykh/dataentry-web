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
        
        // passport image
        $image_status = $this->create_file();
        if ($image_status['code'] === 2) {
            return $this->_r(false, $image_status['message']);
        }
        if ($image_status['code'] === 3) {
            $cols .= ", `staff_passport`";
            $vals .= ", '".$image_status['message']."'";
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

    public function create_file ()
    {
        // if passport image is uploaded
        if (isset($_FILES) && isset($_FILES['passport-image'])) {
            $check = getimagesize($_FILES["passport-image"]["tmp_name"]);
            if($check !== false) {
            
                $file_ext = strtolower(pathinfo(basename($_FILES["passport-image"]["name"]), PATHINFO_EXTENSION));
                $file_name = time() . '.' . $file_ext;
                $target_file = DIR . "static/images/uploads/" . $file_name;
    
                if ($_FILES["passport-image"]["size"] < 500000) {
                    
                    if (move_uploaded_file($_FILES["passport-image"]["tmp_name"], $target_file)) {
                        return ['code' => 3, 'message' => $file_name];
                    } else {
                        return ['code' => 2, 'message' => 'Sorry could not upload the image'];
                    }
                } else {
                    return ['code' => 3, 'message' => 'Uploaded file is not too large'];
                }
    
            } else {
                return ['code' => 4, 'message' => 'Uploaded file is not an image'];
            }
        }
        
        return ['code' => 1, 'message' => 'no image uploaded'];
    }
    
    public function get_all_staff()
    {
        $q = "SELECT * FROM `staff` JOIN `mda` ON `staff_mda_id` = `mda_id`";
        $s = $this->db->prepare($q);
        if ($s->execute()) {
            return $s->fetchAll();
        }
        return [];
    }

    public function get_all_staff_by($col, $val)
    {
        $q = "SELECT * FROM `staff` JOIN `mda` ON `staff_mda_id` = `mda_id` WHERE `$col` = :v";
        $s = $this->db->prepare($q);
        $s->bindParam(":v", $val);
        if ($s->execute()) {
            return $s->fetchAll();
        }
        return [];
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

    public function get_column_name_mapping()
    {
        return [
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'dob' => 'Date of birth',
            'sex' => 'Sex',
            'pf' => 'PF No',
            'nationality' => 'Nationality',
            'origin' => 'Origin',
            'lga' => 'LGA',
            'marrital' => 'Marrital Status',
            'childern' => 'No of childern',
            'qualification' => 'Highest Qualification',
            'appointment_rank' => 'Rank of 1st Appointment',
            'appointment_date' => 'Date of 1st Appointment',
            'next_kin' => 'Next of Kin',
            'next_phone' => 'Next of Phone No',
            'next_address' => 'Next of Kin Address',
            'next_email' => 'Next of Kin Email',
            'confirmation' => 'Confirmation Date',
            'last_promotion' => 'Last Promotion Date',
            'rank' => 'Present Rank',
            'grade' => 'Present Grade Level',
            'cadre' => 'Cadre',
            'mda_id' => 'Current MDA',
            'mda_posted' => 'Date Posted to MDA',
            'last_posting' => 'Last Posting',
            'duration' => 'Duration in MDA',
            'home_address' => 'Permanent Home Address',
            'contact_address' => 'Contact Address',
            'phone' => 'Phone No',
            'email' => 'Email Addres',
            'bank' => 'Bank',
            'account_no' => 'Account No',
            'membership' => 'Membership to professional bodies',
            'fund_admin' => 'Pension Fund Admin',
            'pension_pin' => 'Pension Pin No',
            'nhf' => 'NHF No',
            'nin' => 'NIN',
            'tin' => 'TIN',
            'nhis_hospital' => 'NHIS Hospital'
        ];
    }

}

