<?php
/**
 * Created by PhpStorm.
 * User: zhudong
 * Date: 2017/2/27
 * Time: 下午12:08
 * 爬虫程序
 */
include "Http.php";
include "Header.php";
include "simple_html_dom/simple_html_dom.php";

class Crawer {

    /**
     * 从给定的url获取html内容
     *
     * @param string $url
     * @return string
     */
    function _getUrlContent($url){
        if($url) {
            $content = Helper_Http::get($url, Helper_Header::get());
            $html = new simple_html_dom();
            $html->load($content);
            $ret = $html->find("ul li");
            foreach ($ret as $index => $item) {
                $text = $item->innertext;
                if(strpos($text, '?tag=')) {
                    $arr = explode('"', $text);
                    $text = explode('=', $arr[1])[1];
                    echo $text. PHP_EOL;
                }
                if(strpos($text, '/tag/')) {
                    $text = explode('?', $text)[0];
                    $arr = explode('"', urldecode($text));
                    $text = explode('/', $arr[1])[4];
                    if(empty($text)) continue;
                    echo $text. PHP_EOL;
                }
            }
            return $content;
        }else{
            return false;
        }
    }
    /**
     * 从html内容中筛选链接
     *
     * @param string $web_content
     * @return array
     */
    function _filterUrl($web_content){
        $reg_tag_a = '/<[a|A].*?href=[\'\"]{0,1}([^>\'\"\ ]*).*?>/';
        $result = preg_match_all($reg_tag_a,$web_content,$match_result);
        if($result){
            return $match_result[1];
        }
    }
    /**
     * 修正相对路径
     *
     * @param string $base_url
     * @param array $url_list
     * @return array
     */
    function _reviseUrl($base_url,$url_list){
        $url_info = parse_url($base_url);
        $base_url = $url_info["scheme"].'://';
        if( isset($url_info["user"]) && isset($url_info["pass"])) {
            $base_url .= $url_info["user"].":".$url_info["pass"]."@";
        }
        $base_url .= $url_info["host"];
        if( isset($url_info["port"])) {
            $base_url .= ":".$url_info["port"];
        }
        isset($url_info["path"]) && $base_url .= $url_info["path"];
        if(is_array($url_list)){
            foreach ($url_list as $url_item) {
                if(preg_match('/^http/',$url_item)){
                    //已经是完整的url
                    $result[] = $url_item;
                }else {
                    //不完整的url
                    $real_url = $base_url.'/'.$url_item;
                    $result[] = $real_url;
                }
            }
            return $result;
        }else {
            return;
        }
    }
    /**
     * 爬虫
     *
     * @param string $url
     * @return array
     */
    public function crawler($url){
        $content = $this->_getUrlContent($url);
        if($content){
            $url_list = $this->_reviseUrl($url, $this->_filterUrl($content));
            if($url_list){
                return $url_list;
            }else {
                return ;
            }
        }else{
            return ;
        }
    }

    /**
     * 爬虫开始
     *
     */
    public function start(){
        $current_url = "https://www.douban.com/tag/";
        $fp_puts = fopen("url.txt","ab");
        $fp_gets = fopen("url.txt","r");
        do {
            $current_url = trim($current_url);
            $result_url_arr = $this->crawler($current_url);
            if($result_url_arr){
                foreach ($result_url_arr as $url) {
                    fputs($fp_puts, $url.PHP_EOL);
                }
            }
        } while ($current_url = fgets($fp_gets, 1024));//不断获得url
    }
}

$crawer = new Crawer();
$crawer->start();
