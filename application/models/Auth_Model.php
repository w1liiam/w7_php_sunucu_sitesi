<?php
class Auth_Model extends CI_Model {
    public function getUser($email, $password) {
        $d = $this->db->get_where('users', array('email' => $email, 'password' => hash('sha256',$password)))->result_array();
        return count($d) > 0 ? $d[0] : null;
    }
    public function getUserByEmail($email) {
        $d = $this->db->get_where('users', array('email' => $email))->result_array();
        return count($d) > 0 ? $d[0] : null;
    }
    function insertUser($name, $email, $password) {
        $this->db->insert('users', array(
            'name' => strip_tags($name),
            'email' => $email,
            'password' => hash('sha256', $password),
            'balance' => 0,
            'created_date' => time(),
            'role' => 0
        ));
        return $this->db->insert_id();
    }
    function resetPassword($key, $password) {
        $this->db->query('UPDATE users SET password = "'.hash('sha256', $password).'" WHERE MD5(CONCAT(email,password,"'.date("d-m-Y").'")) = "'.$key.'"');
    }
}
?>