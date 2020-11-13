<?php
class Home_Model extends CI_Model {
    public function getActiveCategories() {
        $d = $this->db->order_by('id','desc')->get_where('categories', array('active' => 1))->result_array();
        for($i = 0; $i < count($d); $i++) {
            $r = $this->db->query('SELECT COUNT(*) as accounts_count, COUNT(IF(accounts.user = 0, 1, null)) as unused_accounts_count FROM accounts WHERE category = '.$d[$i]['id'])->result_array();
            $d[$i]['accounts_count'] = $r[0]['accounts_count'];
            $d[$i]['unused_accounts_count'] = $r[0]['unused_accounts_count'];
        }
        return $d;
    }
    public function getPages() {
        return $this->db->order_by('name', 'asc')->get_where('pages', array('menu' => 1))->result_array();
    }
    public function getPage($slug) {
        $d = $this->db->get_where('pages', array('slug' => $slug))->result_array();
        return count($d) > 0 ? $d[0] : null;
    }
}
?>