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

    public function get_all_cadre() {
        return ['A' => 'Admin', 'E' => 'Executive'];
    }

    public function get_all_grades()
    {
        return [
            '17+' => 'Permanent Secretary', 
            '17' => 'Director', 
            '16' => 'Deputy Director', 
            '15' => 'Assistant Director', 
            '14' => 'Chief', 
            '13' => 'Assistant Chief', 
            '12' => 'Principal', 
            '11' => 'Senior',
            '9' => 'Admin G1',
            '8' => 'Admin Officer'
        ];
    }

    public function get_all_origins()
    {
        $q = "SELECT * FROM `states`";
        $s = $this->db->prepare($q);
        if ($s->execute()) {
            return $s->fetchAll();
        }
        return [];
    }

    public function get_all_lgas()
    {
        $q = "SELECT * FROM `lgas`";
        $s = $this->db->prepare($q);
        if ($s->execute()) {
            return $s->fetchAll();
        }
        return [];
    }

    public function get_lgas_by ($col, $val)
    {
        $q = "SELECT * FROM `lgas` WHERE `$col` = :v";
        $s = $this->db->prepare($q);
        $s->bindParam(":v", $val);
        if ($s->execute()) {
            return $s->fetchAll();
        }
        return [];
    }

    public function get_all_banks ()
    {
        return [
            'abp' => 'Access Bank Plc',
            'cnl' => 'Citibank Nigeria Limited',
            'cmb' => 'Coronation Merchant Bank',
            'enp' => 'Ecobank Nigeria Plc',
            'fbmb' => 'FBNQuest Merchant Bank',
            'fsmb' => 'FSDH Merchant Bank',
            'fbp' => 'Fidelity Bank Plc',
            'fmbl' => 'Finca Microfinance Bank Limited',
            'fbnl' => 'First Bank of Nigeria Limited',
            'fcmbl' => 'First City Monument Bank Limited',
            'gbl' => 'Globus Bank Limited',
            'gtbp' => 'Guaranty Trust Bank Plc',
            'jbp' => 'Jaiz Bank Plc',
            'kbl' => 'Keystone Bank Limited',
            'kb' => 'Kuda Bank',
            'mtmb' => 'Mutual Trust Microfinance Bank',
            'nmb' => 'Nova Merchant Bank',
            'pbl' => 'Polaris Bank Limited',
            'prbl' => 'Providus Bank Limited',
            'rmb' => 'Rand Merchant Bank',
            'rb' => 'Rubies Bank',
            'sibp' => 'Stanbic IBTC Bank Plc',
            'sc' => 'Standard Chartered',
            'sbp' => 'Sterling Bank Plc',
            'sbnl' => 'SunTrust Bank Nigeria Limited',
            'tl' => 'TAJBank Limited',
            'ttbl' => 'Titan Trust Bank Limited',
            'ubnp' => 'Union Bank of Nigeria Plc',
            'ubap' => 'United Bank for Africa Plc',
            'ubp' => 'Unity Bank Plc',
            'vfd' => 'VFD MFB',
            'wbp' => 'Wema Bank Plc',
            'zbp' => 'Zenith Bank Plc'
        ];
    }

    public function get_all_ranks ()
    {
        $q = "SELECT * FROM `ranks` ORDER BY `rank_sort` ASC";
        $s = $this->db->prepare($q);
        if ($s->execute()) {
            return $s->fetchAll();
        }
        return [];
    }

    public function get_rank_by ($col, $val, $multiple = false)
    {
        $q = "SELECT * FROM `ranks` WHERE `$col` = :v";
        $s = $this->db->prepare($q);
        $s->bindParam(':v', $val);
        if ($s->execute()) {
            if ($multiple) {
                return $s->fetchAll();
            }
            return $s->fetch();
        }
        return [];
    }

    public function insert_rank ($rankRank, $grade, $years, $sort)
    {
        $q = "INSERT INTO `ranks` (`rank_rank`, `rank_grade`, `rank_years`, `rank_sort`, `rank_created_on`) VALUE (:r, :g, :y, :s, :dt)";
        $s = $this->db->prepare($q);
        $s->bindParam(":r", $rankRank);
        $s->bindParam(":g", $grade);
        $s->bindParam(":y", $years);
        $s->bindParam(":s", $sort);
        $datetime = current_date();
        $s->bindParam(":dt", $datetime);

        return $s->execute();
    }

    public function update_ranks ($ranks)
    {
        try {
            $this->db->beginTransaction();

            $q = "UPDATE `ranks` SET `rank_rank` = :r, `rank_grade` = :g, `rank_years` = :y, `rank_sort` = :s WHERE `rank_id` = :i";
            $s = $this->db->prepare($q);
            
            foreach ($ranks as $rank) {
                $s->bindParam(":r", $rank['rank_rank']);
                $s->bindParam(":g", $rank['rank_grade']);
                $s->bindParam(":y", $rank['rank_years']);
                $s->bindParam(":s", $rank['sort']);
                $s->bindParam(":i", $rank['rank_id']);
                if (!$s->execute()) {
                    throw new Exception("I can't!");
                }
            }
            
            $this->db->commit();
            
            return true;
            
        } catch (Exception $e){
            $this->db->rollback();
            return false;
        }
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

    public function post_staff_mda ($old_mda, $new_mda, $staff_id)
    {
        $q = "UPDATE `staff` SET `staff_mda_id` = :m, `staff_mda_posted` = :dt, `staff_last_posting` = :o WHERE `staff_id` = :i";
        $s = $this->db->prepare($q);
        $s->bindParam(':m', $new_mda);
        $datetime = current_date();
        $s->bindParam(':dt', $datetime);
        $s->bindParam(':o', $old_mda);
        $s->bindParam(':i', $staff_id);
        
        return $s->execute();
    }

    public function post_staff_mda_approval ($new_mda, $staff_id)
    {
        global $logged;

        $q = "UPDATE `staff` SET `staff_mda_next` = :m, `staff_mda_next_by` = :id, `staff_status` = 'AO' WHERE `staff_id` = :i";
        $s = $this->db->prepare($q);
        $s->bindParam(':m', $new_mda);
        $s->bindParam(':id', $logged['user_id']);
        $s->bindParam(':i', $staff_id);
        
        return $s->execute();
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
        $staff = $this->get_all_staff_everything();

        $promotion = [];
        foreach ($staff as $person) {
            if ($person['staff_rank']) {
                if ($person['rank_sort'] === '1') {
                    continue;
                }
                if ($person['staff_last_promotion']) {
                    $timepassed = $this->getAge($person['staff_last_promotion'], current_date());                    
                    $years_needed = (int)$person['rank_years'];
                    
                    if ($timepassed['years'] > $years_needed || ($timepassed['years'] === $years_needed && $timepassed['months'] >= 0)) {
                        array_push($promotion, $person);
                        $promotion[count($promotion)-1]['retirement_type'] = "Same level for " . $timepassed['years'] . ' years ' . $timepassed['months'] .' months.';
                        continue;
                    }
                }
            }
        }
        
        return $promotion;
    }

    public function get_next_level($rank_id)
    {
        $current = $this->get_rank_by('rank_id', $rank_id);
        
        if (empty($current)) {
            return false;
        }

        if ($current['rank_sort'] === '1') {
            return false;
        }

        $sort = $current['rank_sort'] - 1;

        $next = $this->get_rank_by('rank_sort', $sort);

        if (empty($next)) {
            return false;
        }

        return [$next['rank_id'], $next['rank_grade']];
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
    public function mark_promote($rank_id, $staff_id)
    {
        $s = $this->db->prepare("UPDATE `staff` SET `staff_rank` = :r, `staff_last_promotion` = :dt, `staff_status` = 'A' WHERE `staff_id` = :i");
        $s->bindParam(":r", $rank_id);
        $s->bindParam(":i", $staff_id);
        $datetime = current_date();
        $s->bindParam(":dt", $datetime);

        if ($s->execute()) {
            return true;
        }
        return false;
    }
    public function make_promote_approval($user_id, $staff_id)
    {
        $s = $this->db->prepare("UPDATE `staff` SET `staff_status` = 'AP', `staff_promotion_requested_by` = :r WHERE `staff_id` = :i");
        $s->bindParam(":r", $user_id);
        $s->bindParam(":i", $staff_id);

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
        $q = "SELECT * FROM `staff` JOIN `mda` ON `staff_mda_id` = `mda_id` WHERE `staff_status` != 'R'";
        $s = $this->db->prepare($q);
        if ($s->execute()) {
            return $s->fetchAll();
        }
        return [];
    }
    public function get_all_staff_everything()
    {
        $q = "SELECT * FROM `staff` JOIN `mda` ON `staff_mda_id` = `mda_id` JOIN `ranks` ON `staff_rank` = `rank_id` WHERE `staff_status` != 'R'";
        $s = $this->db->prepare($q);
        if ($s->execute()) {
            return $s->fetchAll();
        }
        return [];
    }
    public function get_all_retired_staff()
    {
        $q = "SELECT * FROM `staff` JOIN `mda` ON `staff_mda_id` = `mda_id` WHERE `staff_status` = 'R'";
        $s = $this->db->prepare($q);
        if ($s->execute()) {
            return $s->fetchAll();
        }
        return [];
    }

    public function get_all_staff_by($col, $val)
    {
        $q = "SELECT * FROM `staff` JOIN `mda` ON `staff_mda_id` = `mda_id` JOIN `ranks` ON `staff_rank` = `rank_id` WHERE `$col` = :v AND `staff_status` != 'R'";
        $s = $this->db->prepare($q);
        $s->bindParam(":v", $val);
        if ($s->execute()) {
            return $s->fetchAll();
        }
        return [];
    }

    public function get_all_retired_staff_by($col, $val)
    {
        $q = "SELECT * FROM `staff` JOIN `mda` ON `staff_mda_id` = `mda_id` WHERE `$col` = :v AND `staff_status` = 'R'";
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

    public function get_staff_by_everything ($col, $val)
    {
        $q = "SELECT * FROM `staff` JOIN `mda` ON `staff_mda_id` = `mda_id` JOIN `ranks` ON `staff_rank` = `rank_id` JOIN `lgas` ON `staff_lga` = `lga_id` JOIN `states` ON `lga_state_id` = `state_id` WHERE `$col` = :v AND `staff_status` != 'R'";
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
            'cadre' => 'cadre',
            'mda' => 'mda_id',
            'mda-posted' => 'mda_posted',
            'last-posting' => 'last_posting',
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

