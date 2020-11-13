<?php
class ConfigLoader {
    protected $CI;
    public function __construct() {    
        $this->CI =& get_instance();
    }
    public function load() {
        $configs = $this->CI->db->get("configs")->result_array();
        foreach($configs as $config) {
            $this->CI->config->set_item($config["name"], $config["value"]);
        }
        date_default_timezone_set($this->CI->config->item("site_timezone"));
    }
}