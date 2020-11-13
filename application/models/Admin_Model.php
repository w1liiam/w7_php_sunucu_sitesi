<?php
class Admin_Model extends CI_Model {
    public function getUserById($id) {
        $d = $this->db->get_where('users', array('id' => $id))->result_array();
        return count($d) > 0 ? $d[0] : null;
    }
    public function getUserByEmail($email) {
        $d = $this->db->get_where('users', array('email' => $email))->result_array();
        return count($d) > 0 ? $d[0] : null;
    }
    public function getPaymentNotification($id) {
        $d = $this->db->get_where('payment_notifications', array('id' => $id))->result_array();
        return count($d) > 0 ? $d[0] : null;
    }
    public function getCategory($id) {
        $d = $this->db->get_where('categories', array('id' => $id))->result_array();
        return count($d) > 0 ? $d[0] : null;
    }
    public function getAccount($id) {
        $d = $this->db->get_where('accounts', array('id' => $id))->result_array();
        return count($d) > 0 ? $d[0] : null;
    }
    public function getBankAccount($id) {
        $d = $this->db->get_where('banks', array('id' => $id))->result_array();
        return count($d) > 0 ? $d[0] : null;
    }
    public function getPage($id) {
        $d = $this->db->get_where('pages', array('id' => $id))->result_array();
        return count($d) > 0 ? $d[0] : null;
    }
    public function getSupportTicket($id) {
        $d = $this->db->get_where('tickets', array('id' => $id))->result_array();
        return count($d) > 0 ? $d[0] : null;
    }
    public function rejectPaymentNotification($id) {
        $this->db->set('status', -1)->where('id', $id)->update('payment_notifications');
    }
    public function approvePaymentNotification($id, $user, $amount) {
        $this->db->set('status', 1)->where('id', $id)->update('payment_notifications');
        $this->db->set('balance', 'balance+'.strval($amount), FALSE)->where('id', $user)->update('users');
    }
    public function getTotalBalance() {
       return $this->db->select('SUM(balance)')->from('users')->get()->result_array()[0]['SUM(balance)'];
    }
    public function getPendingPaymentNotificationsCount() {
        return $this->db->where('status',0)->from('payment_notifications')->count_all_results();
    }
    public function getActiveSupportTicketsCount() {
        return $this->db->where('status',0)->from('tickets')->count_all_results();
    }
    public function getPaymentNotifications() {
        $data = $this->db->order_by('id', 'desc')->get('payment_notifications')->result_array();
        return count($data) > 0 ? $data : false;
    }
    public function getBankAccounts() {
        $data = $this->db->order_by('id', 'desc')->get('banks')->result_array();
        return count($data) > 0 ? $data : false;
    }
    public function getPendingPaymentNotifications() {
        $data = $this->db->query('SELECT payment_notifications.*, banks.bank_name FROM payment_notifications INNER JOIN banks ON banks.id = payment_notifications.bank WHERE payment_notifications.status = 0 ORDER BY id DESC')->result_array();
        return count($data) > 0 ? $data : false;
    }
    public function getCategories() {
        $data = $this->db->order_by('id', 'desc')->get('categories')->result_array();
        return count($data) > 0 ? $data : false;
    }
    public function getUserPaymentNotifications($uid) {
        $data = $this->db->order_by('id', 'desc')->get_where('payment_notifications', array('user' => $uid))->result_array();
        return count($data) > 0 ? $data : false;
    }
    public function getUsers() {
        $data = $this->db->order_by('id', 'desc')->get('users')->result_array();
        return count($data) > 0 ? $data : false;
    }
    public function getAccounts() {
        $data = $this->db->query('SELECT accounts.*, categories.name as category_name from accounts INNER JOIN categories ON categories.id = accounts.category WHERE accounts.user = 0 ORDER BY id DESC')->result_array();
        return count($data) > 0 ? $data : false;
    }
    public function getUserAccounts($uid) {
        $data = $this->db->query('SELECT accounts.*, categories.name as category_name from accounts INNER JOIN categories ON categories.id = accounts.category WHERE accounts.user = '.$uid.' ORDER BY id DESC')->result_array();
        return count($data) > 0 ? $data : false;
    }
    public function getTickets() {
        $data = $this->db->query('SELECT tickets.*, users.email as user_email from tickets INNER JOIN users ON users.id = tickets.user ORDER BY id DESC')->result_array();
        return count($data) > 0 ? $data : false;
    }
    public function getSupportTicketMessages($id) {
        $data = $this->db->get_where('ticket_messages', array('ticket' => $id))->result_array();
        return count($data) > 0 ? $data : false;
    }
    public function insertCategory($name) {
        $this->db->insert('categories', array(
            'name' => strip_tags($name),
            'active' => 1,
        ));
        return $this->db->insert_id();
    }
    public function insertAccount($category, $date, $days, $verified, $email, $password, $price, $details) {
        $this->db->insert('accounts', array(
            'created_date' => strtotime($date),
            'days' => $days,
            'verified' => (int)$verified < 2 ? (int)$verified : 0,
            'email' => htmlentities($email),
            'password' => htmlentities($password),
            'details' => nl2br($details),
            'category' => $category,
            'price' => $price,
            'user' => 0,
            'bought_date' => 0
        ));
        return $this->db->insert_id();
    }
    public function insertBankAccount($bank_name, $name, $number) {
        $this->db->insert('banks', array(
            'bank_name' => strip_tags($bank_name),
            'name' => strip_tags($name),
            'number' => $number
        ));
        return $this->db->insert_id();
    }
    public function updateAccount($id, $category, $date, $days, $verified, $email, $password, $price, $details) {
        $this->db->where('id', $id)->update('accounts', array(
            'created_date' => strtotime($date),
            'days' => $days,
            'verified' => (int)$verified < 2 ? (int)$verified : 0,
            'email' => htmlentities($email),
            'password' => htmlentities($password),
            'details' => nl2br($details),
            'category' => $category,
            'price' => $price,
        ));
    }
    public function updateUser($id, $name, $email, $password, $balance, $role) {
        if(!empty($password)) {
            $this->db->where('id', $id)->update('users', array(
                'name' => strip_tags($name),
                'email' => $email,
                'password' => hash('sha256', $password),
                'balance' => $balance,
                'role' => (int)$role,
            ));    
        }
        else {
            $this->db->where('id', $id)->update('users', array(
                'name' => strip_tags($name),
                'email' => $email,
                'balance' => $balance,
                'role' => (int)$role,
            ));
        }
    }
    public function updateCategory($id, $name, $active) {
        $this->db->set('name', strip_tags($name))->set('active', (int)$active)->where('id', $id)->update('categories');
    }
    public function deleteCategory($id) {
        $this->db->where('category', $id)->delete('accounts');
        $this->db->where('id', $id)->delete('categories');
    }
    public function deleteAccount($id) {
        $this->db->where('id', $id)->delete('accounts');
    }
    public function deleteUser($id) {
        $this->db->where('user', $id)->delete('tickets');
        $this->db->where('user', $id)->delete('payments');
        $this->db->where('id', $id)->delete('users');
    }
    public function deletePage($id) {
        $this->db->where('id', $id)->delete('pages');
    }
    public function deleteBankAccount($id) {
        $this->db->where('id', $id)->delete('banks');
    }
    public function getPages() {
        $data = $this->db->get_where('pages')->result_array();
        return count($data) > 0 ? $data : false;
    }
    function insertSupportTicketMessage($id, $message) {
        $this->db->insert('ticket_messages', array(
            'ticket' => $id,
            'message' => strip_tags($message),
            'user' => 0,
            'time' => time(),
        ));
        $this->db->set('status', 1)->where('id', $id)->update('tickets');
    }
    function insertPage($name, $slug, $desc, $tags, $content, $menu) {
        $i = 0;
        while($this->db->where('slug',$slug)->from('pages')->count_all_results() > 0) {
            $i++;
            $slug .= "-".$i;
        }
        $this->db->insert('pages', array(
            'name' => $name,
            'slug' => $slug,
            'description' => $desc,
            'tags' => $tags,
            'content' => $content,
            'menu' => (int)$menu < 2 ? $menu : 0
        ));
    }
    function updatePage($id, $name, $desc, $tags, $content, $menu) {
        $this->db->where('id', $id)->update('pages', array(
            'name' => $name,
            'description' => $desc,
            'tags' => $tags,
            'content' => $content,
            'menu' => (int)$menu < 2 ? $menu : 0
        ));
    }
    function updateBank($id, $bank_name, $name, $number) {
        $this->db->where('id', $id)->update('banks', array(
            'bank_name' => strip_tags($bank_name),
            'name' => strip_tags($name),
            'number' => strip_tags($number),
        ));
    }
    public function setSupportTicketStatus($id, $status) {
        if($status == -1) {
            $this->db->set('status', -1)->where('id', $id)->update('tickets');
        }
        else if($status == 1) {
            if($this->db->query('SELECT user from ticket_messages WHERE ticket = '.$id.' ORDER BY id DESC LIMIT 1')->result_array()[0]['user'] == 0) {
                $this->db->set('status', 1)->where('id', $id)->update('tickets');
            }
            else {
                $this->db->set('status', 0)->where('id', $id)->update('tickets');
            }
        }
    }
    function updateSetting($name, $value) {
        $this->db->where('name', $name)->set('value', $value)->update('configs');
    }
    public function getConfigs() {
        $configs = array();
        $d = $this->db->order_by('id', 'desc')->get('configs')->result_array();
        foreach($d as $config) {
            $configs[$config['name']] = $config['value'];
        }
        return $configs;
    }
}
?>