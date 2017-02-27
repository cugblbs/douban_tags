<?php
/**
 * Created by PhpStorm.
 * User: zhudong
 * Date: 2017/2/27
 * Time: 下午6:52
 */
class Model_Douban extends Model_Abstract {

    public function process_html_content($content) {
        $this->html->load($content);
        $ret = $this->html->find("ul li");
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
    }

    public function header() {
        return array(
            'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Encoding:gzip, deflate, sdch, br',
            'Accept-Language:zh-CN,zh;q=0.8,en;q=0.6,ja;q=0.4',
            'Cache-Control:max-age=0',
            'Connection:keep-alive',
            'Cookie:ll="108288"; bid=C0osylWoiEY; gr_user_id=308422a4-05ab-47ec-8735-d9e0ac5389e7; _vwo_uuid_v2=E19FBEF6BCF422F7713629DE878D2DA8|ad904f5d89230cd6da0e6bb05499e170; ps=y; _pk_ref.100001.3ac3=%5B%22%22%2C%22%22%2C1488175872%2C%22https%3A%2F%2Fwww.douban.com%2F%22%5D; _pk_id.100001.3ac3=513dfe40ffd97eb2.1488173277.2.1488175895.1488173309.; _pk_ses.100001.3ac3=*',
            'Host:www.douban.com',
            'Upgrade-Insecure-Requests:1',
            'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',
        );
    }
}