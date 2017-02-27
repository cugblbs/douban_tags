<?php
/**
 * Created by PhpStorm.
 * User: zhudong
 * Date: 2017/2/27
 * Time: 下午6:28
 */
abstract class Model_Abstract {

    protected $html  = null;
    protected $content = null;

    public function __construct() {
        $this->html = new simple_html_dom();
    }

    public function process_html_content($content) {}

    public function header() {}
}