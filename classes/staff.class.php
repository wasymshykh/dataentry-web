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


    public function handle_edit($data, $staff, $user_id)
    {
        $filtered = [];
        $changes = "";
        foreach ($data as $field => $value) {
            $filtered[$field] = normal_text($value);
        }
        if (empty($filtered['fname'])) {
            return $this->_r(false, "Please enter name of the staff");
        }
        $field_set = $this->get_field_db_mapping();
        $field_name_set = $this->get_column_name_mapping();
        $qs = "";
        $c = 0;
        foreach ($field_set as $field => $column) {
            if (!(empty($filtered[$field]) && $staff['staff_'.$column] === NULL)) {
                if ($filtered[$field] !== $staff['staff_'.$column]) {
                    $changes .= $field_name_set[$column] . ", ";
                }
            }
            if ($c > 0) {
                $qs .= ", ";
            }
            $qs .= "`staff_$column` = " . ($filtered[$field] ? "'". $filtered[$field] ."'" : "NULL");
            $c += 1;
        }

        // passport image
        $image_status = $this->create_file();
        if ($image_status['code'] === 2) {
            return $this->_r(false, $image_status['message']);
        }
        if ($image_status['code'] === 3) {
            $qs .= ", `staff_passport` = '".$image_status['message']."'";
        }
        if ($image_status['code'] !== 1) {
            $changes .= " passport picture";
        }

        if ($changes !== "") {
            $q = "UPDATE `staff` SET $qs WHERE `staff_id` = :si";
            $s = $this->db->prepare($q);
    
            $s->bindParam(":si", $staff['staff_id']);
    
            if ($s->execute()) {
                return $this->_r(true, "Record is successfully updated!, You have changed: " . $changes);
            }
            return $this->_r(false, "Unable to update the record.");
        }

        return $this->_r(true, "You didn't changed anything!");
    }

    public function create_file ()
    {

        // if snap image is uploaded

        if (isset($_POST['snapfile']) && !empty($_POST['snapfile'])) {
            $file_name = time() . '.png';
            $target_file = DIR . "static/images/uploads/" . $file_name;
            $r = file_put_contents($target_file, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['snapfile'])));

            if ($r) {
                return ['code' => 3, 'message' => $file_name];
            } else {
                return ['code' => 2, 'message' => 'Sorry could not upload the image'];
            }

        } else

        // if passport image is uploaded
        if (isset($_FILES) && isset($_FILES['passport-image']) && !empty($_FILES['passport-image']['size'])) {
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

    public function get_all_retiring()
    {
        $staff = $this->get_all_staff();
        $retiring = [];
        foreach ($staff as $person) {
            // check for birthday
            if ($person['staff_dob']) {
                $birthday = $this->getAge($person['staff_dob'], current_date());
                if ($birthday['years'] > 59 || ($birthday['years'] === 59 && $birthday['months'] >= 9)) {
                    array_push($retiring, $person);
                    $retiring[count($retiring)-1]['retirement_type'] = "Age limit, staff is " . $birthday['years'] . ' years ' . $birthday['months'] .' months old';
                    continue;
                }
            }

            if ($person['staff_confirmation']) {
                $timepassed = $this->getAge($person['staff_confirmation'], current_date());
                if ($timepassed['years'] > 35 || ($timepassed['years'] === 34 && $timepassed['months'] >= 9)) {
                    array_push($retiring, $person);
                    $retiring[count($retiring)-1]['retirement_type'] = "Working limit, staff is working for " . $birthday['years'] . ' years ' . $birthday['months'] .' months';
                    continue;
                }
            }
        }
        
        return $retiring;
    }

    public function get_all_posting()
    {
        $staff = $this->get_all_staff();
        $posting = [];
        foreach ($staff as $person) {
            if ($person['staff_mda_posted']) {
                $timepassed = $this->getAge($person['staff_mda_posted'], current_date());
                if ($timepassed['years'] > 1 || ($timepassed['years'] === 1 && $timepassed['months'] >= 0)) {
                    array_push($posting, $person);
                    $posting[count($posting)-1]['retirement_type'] = "Same MDA for " . $timepassed['years'] . ' years ' . $timepassed['months'] .' months.';
                    continue;
                }
            }
        }
        
        return $posting;
    }

    public function get_all_promotion()
    {
        $staff = $this->get_all_staff();
        $promotion = [];
        foreach ($staff as $person) {
            if ($person['staff_grade']) {
                $timepassed = $this->getAge($person['staff_last_promotion'], current_date());
                
                $years_needed = 1000;
                if ($person['staff_grade'] >= 1 && $person['staff_grade'] <= 7) {
                    $years_needed = 2;
                } else
                if ($person['staff_grade'] >= 8 && $person['staff_grade'] <= 14) {
                    $years_needed = 3;
                } else
                if ($person['staff_grade'] >= 15 && $person['staff_grade'] < 17) {
                    $years_needed = 4;
                }

                if ($timepassed['years'] > $years_needed || ($timepassed['years'] === $years_needed && $timepassed['months'] >= 0)) {
                    array_push($promotion, $person);
                    $promotion[count($promotion)-1]['retirement_type'] = "Same level for " . $timepassed['years'] . ' years ' . $timepassed['months'] .' months.';
                    continue;
                }
            }
        }
        
        return $promotion;
    }

    public function mark_retired($staff_id)
    {
        $s = $this->db->prepare("UPDATE `staff` SET `staff_status` = 'R', `staff_retired_on` = :dt WHERE `staff_id` = :i");
        $s->bindParam(":i", $staff_id);
        $datetime = current_date();
        $s->bindParam(":dt", $datetime);

        if ($s->execute()) {
            return true;
        }
        return false;
    }
    public function mark_promote($new_level, $staff_id)
    {
        $s = $this->db->prepare("UPDATE `staff` SET `staff_grade` = :g, `staff_last_promotion` = :dt WHERE `staff_id` = :i");
        $s->bindParam(":g", $new_level);
        $s->bindParam(":i", $staff_id);
        $datetime = current_date();
        $s->bindParam(":dt", $datetime);

        if ($s->execute()) {
            return true;
        }
        return false;
    }

    public function getAge($dob,$condate) { 
        $birthdate = new DateTime(date("Y-m-d",  strtotime(implode('-', array_reverse(explode('/', $dob))))));
        $today= new DateTime(date("Y-m-d",  strtotime(implode('-', array_reverse(explode('/', $condate))))));

        $diff = $birthdate->diff($today);
        $age = ['years' => $diff->y, 'months' => $diff->m, 'days' => $diff->d];
        
        return $age;
    }
    
    public function get_all_staff()
    {
        $q = "SELECT * FROM `staff` JOIN `mda` ON `staff_mda_id` = `mda_id` WHERE `staff_status` = 'A'";
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

    public function get_staff_by($col, $val)
    {
        $q = "SELECT * FROM `staff` JOIN `mda` ON `staff_mda_id` = `mda_id` WHERE `$col` = :v";
        $s = $this->db->prepare($q);
        $s->bindParam(":v", $val);
        if ($s->execute()) {
            return $s->fetch();
        }
        return false;
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

