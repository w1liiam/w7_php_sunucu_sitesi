<?php
class OutputCompress {
    protected $CI;
    public function __construct() {    
        $this->CI =& get_instance();
    }
    public function compress() {
        $buffer = $this->CI->output->get_output();
        $search = array(
            '/\n/',
            '/\>[^\S ]+/s',
            '/[^\S ]+\</s',
            '/(\s)+/s'
        );
        $replace = array(
            ' ',
            '>',
            '<',
            '\\1'
        );
        $buffer = preg_replace($search, $replace, $buffer);
        $this->CI->output->set_output($buffer);
        $this->CI->output->_display();
    }
}