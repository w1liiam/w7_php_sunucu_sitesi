<?php
class Payment_Model extends CI_Model {
    function insertPayment($uid, $amount) {
        $this->db->insert('payments', array(
            'amount' => (float)$amount,
            'user' => $uid,
            'time' => time(),
            'status' => 0
        ));
        return $this->db->insert_id();
    }
    public function getPendingPayment($id) {
        $d = $this->db->get_where('payments', array('id' => $id, 'status' => 0))->result_array();
        return count($d) > 0 ? $d[0] : null;
    }
    public function confirmPayment($id, $uid, $name, $amount) {
        $this->db->set('status', 1)->where('id', $id)->update('payments');
        $this->db->set('balance', 'balance+'.strval($amount), FALSE)->where('id', $uid)->update('users');
        $this->db->insert('payment_notifications', array(
            'bank' => 0,
            'name' => $name,
            'amount' => (float)$amount,
            'user' => $uid,
            'time' => time(),
            'status' => 1
        ));
    }
}
?>