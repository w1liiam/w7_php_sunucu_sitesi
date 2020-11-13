<?php
class Panel_Model extends CI_Model {
    public function getUserById($id) {
        $d = $this->db->get_where('users', array('id' => $id))->result_array();
        return count($d) > 0 ? $d[0] : null;
    }
    public function getCategory($id) {
        $d = $this->db->get_where('categories', array('id' => $id))->result_array();
        return count($d) > 0 ? $d[0] : null;
    }
    public function getActiveCategories() {
        return $this->db->get_where('categories', array('active' => 1))->result_array();
    }
    public function getAccount($id) {
        $d = $this->db->get_where('accounts', array('id' => $id))->result_array();
        return count($d) > 0 ? $d[0] : null;
    }
    public function getSupportTicket($uid, $id) {
        $d = $this->db->get_where('tickets', array('id' => $id, 'user' => $uid))->result_array();
        return count($d) > 0 ? $d[0] : null;
    }
    public function getSupportTicketMessages($uid, $id) {
        return $this->db->get_where('ticket_messages', array('ticket' => $id))->result_array();
    }
    public function updateProfile($uid, $name, $password) {
        if(!empty($password) && strlen($password) > 5) {
            $this->db->set('name', strip_tags($name))->set('password', hash('sha256', $password))->where('id', $uid)->update('users');
        }
        else {
            $this->db->set('name', strip_tags($name))->where('id', $uid)->update('users');
        }
    }
    public function buyAccount($id, $user, $amount) {
        $this->db->set('user', $user)->set('bought_date', time())->where('id', $id)->update('accounts');
        $this->db->set('balance', 'balance-'.strval($amount), FALSE)->where('id', $user)->update('users');
    }
    public function buyBulkAccounts($user, $category, $piece, $price) {
        $this->db->order_by('price', 'asc')->set('user', $user)->set('bought_date', time())->where('category', $category)->where('user',0)->limit($piece)->update('accounts');
        $this->db->set('balance', 'balance-'.$price, FALSE)->where('id', $user)->update('users');
    }
    public function getAccountsCount($id) {
        return $this->db->where("category",$id)->where("user",0)->from("accounts")->count_all_results();
    }
    public function getSupportTicketsCount($uid) {
        return $this->db->where("user",$uid)->from("tickets")->count_all_results();
    }
    public function getPaymentNotificationsCount($uid) {
        return $this->db->where("user",$uid)->from("payment_notifications")->count_all_results();
    }
    function insertPaymentNotification($uid, $bank, $name, $amount) {
        $this->db->insert('payment_notifications', array(
            'bank' => strip_tags($bank),
            'name' => strip_tags($name),
            'amount' => (float)$amount,
            'user' => $uid,
            'time' => time(),
            'status' => 0
        ));
        return $this->db->insert_id();
    }
    function insertSupportTicket($uid, $title, $message) {
        $this->db->insert('tickets', array(
            'title' => strip_tags($title),
            'user' => $uid,
            'time' => time(),
            'status' => 0
        ));
        $id = $this->db->insert_id();
        $this->db->insert('ticket_messages', array(
            'ticket' => $id,
            'message' => strip_tags($message),
            'user' => $uid,
            'time' => time(),
        ));
        return $id;
    }
    function insertSupportTicketMessage($uid, $id, $message) {
        $this->db->insert('ticket_messages', array(
            'ticket' => $id,
            'message' => strip_tags($message),
            'user' => $uid,
            'time' => time(),
        ));
        $this->db->set('status', 0)->where('id', $id)->update('tickets');
    }
    public function getUserAccountsCount($uid, $filter) {
        $today = strtotime(date('d-m-Y'));
        if($filter == "all") {
            return $this->db->where("user",$uid)->from("accounts")->count_all_results();
        }
        else if($filter == "day") {
            return $this->db->where("bought_date >=",$today)->where("user",$uid)->from("accounts")->count_all_results();
        }
        else if($filter == "week") {
            return $this->db->where("bought_date >=",$today-(7*86400))->where("user",$uid)->from("accounts")->count_all_results();
        }
        else if($filter == "month") {
            return $this->db->where("bought_date >=",$today-(30*86400))->where("user",$uid)->from("accounts")->count_all_results();
        }
    }
    public function getAccounts($id, $limit, $start) {
        $this->db->limit($limit, $start);
        $data = $this->db->order_by('id','desc')->get_where("accounts", array("category" => $id, "user" => 0))->result_array();
        return count($data) > 0 ? $data : false;
    }
    public function getBankAccounts() {
        $data = $this->db->order_by('id','desc')->get("banks")->result_array();
        return count($data) > 0 ? $data : false;
    }
    public function getSupportTickets($uid, $limit, $start) {
        $this->db->limit($limit, $start);
        $data = $this->db->order_by('id','desc')->get_where("tickets", array("user" => $uid))->result_array();
        return count($data) > 0 ? $data : false;
    }
    public function getPaymentNotifications($uid, $limit, $start) {
        $this->db->limit($limit, $start);
        $data = $this->db->order_by('id','desc')->get_where("payment_notifications", array("user" => $uid))->result_array();
        return count($data) > 0 ? $data : false;
    }
    public function getUserAccounts($uid, $limit, $start, $filter) {
        $today = strtotime(date('d-m-Y'));
        if($filter == "all") {
            $data = $this->db->query("SELECT accounts.*, categories.name as category_name FROM accounts INNER JOIN categories ON categories.id = accounts.category WHERE user = ".$uid." ORDER BY bought_date DESC LIMIT ".$start.", ".$limit)->result_array();
            return count($data) > 0 ? $data : false;    
        }
        else if($filter == "day") {
            $data = $this->db->query("SELECT accounts.*, categories.name as category_name FROM accounts INNER JOIN categories ON categories.id = accounts.category WHERE user = ".$uid." AND bought_date >= ".strval($today)." ORDER BY bought_date DESC LIMIT ".$start.", ".$limit)->result_array();
            return count($data) > 0 ? $data : false;    
        }
        else if($filter == "week") {
            $data = $this->db->query("SELECT accounts.*, categories.name as category_name FROM accounts INNER JOIN categories ON categories.id = accounts.category WHERE user = ".$uid." AND bought_date >= ".strval($today-(7*86400))." ORDER BY bought_date DESC LIMIT ".$start.", ".$limit)->result_array();
            return count($data) > 0 ? $data : false;    
        }
        else if($filter == "month") {
            $data = $this->db->query("SELECT accounts.*, categories.name as category_name FROM accounts INNER JOIN categories ON categories.id = accounts.category WHERE user = ".$uid." AND bought_date >= ".strval($today-(30*86400))." ORDER BY bought_date DESC LIMIT ".$start.", ".$limit)->result_array();
            return count($data) > 0 ? $data : false;    
        }
    }
    public function getUserAccountsCategory($uid, $cat, $filter) {
        $today = strtotime(date('d-m-Y'));
        if($filter == "all") {
            $data = $this->db->query("SELECT accounts.*, categories.name as category_name FROM accounts INNER JOIN categories ON categories.id = accounts.category WHERE user = ".$uid." AND category = ".intval($cat)." ORDER BY bought_date DESC")->result_array();
            return count($data) > 0 ? $data : false;    
        }
        else if($filter == "day") {
            $data = $this->db->query("SELECT accounts.*, categories.name as category_name FROM accounts INNER JOIN categories ON categories.id = accounts.category WHERE user = ".$uid." AND category = ".intval($cat)." AND bought_date >= ".strval($today)." ORDER BY bought_date DESC")->result_array();
            return count($data) > 0 ? $data : false;    
        }
        else if($filter == "week") {
            $data = $this->db->query("SELECT accounts.*, categories.name as category_name FROM accounts INNER JOIN categories ON categories.id = accounts.category WHERE user = ".$uid." AND category = ".intval($cat)." AND bought_date >= ".strval($today-(7*86400))." ORDER BY bought_date DESC")->result_array();
            return count($data) > 0 ? $data : false;    
        }
        else if($filter == "month") {
            $data = $this->db->query("SELECT accounts.*, categories.name as category_name FROM accounts INNER JOIN categories ON categories.id = accounts.category WHERE user = ".$uid." AND category = ".intval($cat)." AND bought_date >= ".strval($today-(30*86400))." ORDER BY bought_date DESC")->result_array();
            return count($data) > 0 ? $data : false;    
        }
    }
    public function getUserAccountCount($user_id) {
        return $this->db->where("user",$user_id)->from("accounts")->count_all_results();
    }
    public function getUserAccountSum($user_id) {
        return intval($this->db->query("SELECT SUM(price) from accounts WHERE user = ".$user_id)->result_array()[0]["SUM(price)"]);
    }
    public function getAccountsTotalPrice($category, $piece) {
        return intval($this->db->query("SELECT SUM(price) FROM (SELECT price FROM accounts WHERE category = ".$category." AND user = 0 ORDER BY price ASC LIMIT ".$piece.") AS temp")->result_array()[0]["SUM(price)"]);
    }
}
?>