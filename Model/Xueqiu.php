<?php
/**
 * Created by PhpStorm.
 * User: zhudong
 * Date: 2017/2/27
 * Time: 下午6:44
 */
class Model_Xueqiu extends Model_Abstract {

    public function process_html_content($content) {
        $this->html->load($content);
        $ret = $this->html->find('.current');
        $titles = $this->html->find('h5');
        foreach ($titles as $title) {
            echo $title->innertext.PHP_EOL;
        }
        foreach ($ret as $e) {
            echo $e->innertext.PHP_EOL;
        }
    }

    public function header() {
        return array(
            'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Encoding:gzip, deflate, sdch, br',
            'Accept-Language:zh-CN,zh;q=0.8,en;q=0.6,ja;q=0.4',
            'Cache-Control:max-age=0',
            'Connection:keep-alive',
            'Cookie:aliyungf_tc=AQAAAORWqUz/6QYAhZiHPcX4rALQn2ME; u=831488190455644; u.sig=didq6Gj7merd-2cvPUChFlbLhs4; xq_a_token=280dee5696661da23161c033e7ce7facef8af94d; xq_a_token.sig=jvgfBt0IPrEBGqhhWZCXMCzIcMo; xq_r_token=184a2c0e20d72c3b3f23c2a1587bae0798adf96d; xq_r_token.sig=ptgAVJkPu7bY-y_cplgoXV79bQo; Hm_lvt_1db88642e346389874251b5a1eded6e3=1488190457; Hm_lpvt_1db88642e346389874251b5a1eded6e3=1488190457',
            'Host:xueqiu.com',
            'Referer:https://www.baidu.com/link?url=JjyLECt1OH8ysnGheRvBcqPniwFmKlRq1_L_AJGGrhS&wd=&eqid=956f7d0200010e3c0000000258b3fbf4',
            'Upgrade-Insecure-Requests:1',
            'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',
        );
    }
}
