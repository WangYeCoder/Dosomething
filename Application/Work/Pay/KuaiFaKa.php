<?php
/**
 * @Desc     :
 * @Date     :2019/4/2-3:35 PM
 * @Author   :wangye
 * @File     :KuaiFaKa.php
 * @Copyright:2015-2019 unversity
 */

namespace App\Work\Pay;


class KuaiFaKa
{
    //快发卡平台对接支付 -- 创建订单号,与邮箱ID绑定,然后查询支付状态,进行异步查询
    /**
     * 创建订单号
     * @return array|mixed
     */
    public function createOrderNum()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL            => "https://api.kuaifaka.com/purch/create_order_num",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => "undefined=",
            CURLOPT_HTTPHEADER     => array(
                "Content-Type: application/x-www-form-urlencoded",
                "Origin: http://m.kuaifaka.com",
                "Postman-Token: b2e5bc5e-f61b-4106-9a08-95cca132943b",
                "Referer: http://m.kuaifaka.com/purchasing?link=oxebv2",
                "User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Mobile Safari/537.36",
                "authtype: h5",
                "cache-control: no-cache",
                "link: oxebv2",
                "pwd: null",
                "token: null",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $res = json_decode($response, true);
        if ($err) {
            return array('msg'  => '订单号生成失败',
                         'code' => '500031');
        } else {
            return $res;
        }
    }

    /**
     * 构建订单,订单号 87351为测试商品号,正式为 87338
     * @param     $orderNum
     * @param int $goodsNum
     * @return array|mixed
     */
    public function buildOrder($orderNum, $goodsNum = 87351)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL            => "https://api.kuaifaka.com/purch/build_order",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => "pr_id={$goodsNum}&num=1&order_push=0&push_value=&pay_type=9&order_num={$orderNum}&coupon=&get_card_pwd=&contact=w258765%40gmail.com&machine_no=&pay_bank=&open_page_time=&undefined=",
            CURLOPT_HTTPHEADER     => array(
                "Content-Type: application/x-www-form-urlencoded",
                "Origin: http://m.kuaifaka.com",
                "Postman-Token: 0ad4b9b5-95d9-4522-8bc0-fe68c2ed4c1b",
                "Referer: http://m.kuaifaka.com/purchasing?link=oxebv2",
                "User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Mobile Safari/537.36",
                "authtype: h5",
                "cache-control: no-cache",
                "link: oxebv2",
                "pwd: null",
                "token: null",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $res = json_decode($response, true);
        if ($err) {
            return array('msg'  => '订单构建失败',
                         'code' => '500032',);
        } else {
            return $res;
        }
    }

    /**
     * 生成支付二维码(微信)
     * @param $orderNum
     * @return array|mixed
     */
    public function getWxPayImg($orderNum)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL            => "https://api.kuaifaka.com/purch/get_pay_info",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"order_num\"\r\n\r\n{$orderNum}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
            CURLOPT_HTTPHEADER     => array(
                "Postman-Token: a4494f7b-7263-41fb-b1df-4c4948c99d94",
                "cache-control: no-cache",
                "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $res = json_decode($response, true);
        if ($err) {
            return array('msg'  => '生成微信支付二维码失败',
                         'code' => '500033',);
        } else {
            return $res;
        }
    }

    /**
     * 获取阿里支付URL
     * @param $orderNumber
     * @return array|mixed
     */

    public function getAliPayUrl($orderNumber)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL            => "https://api.kuaifaka.com/purch/get_pay_info",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"order_num\"\r\n\r\n{$orderNumber}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"\"\r\n\r\n\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
            CURLOPT_HTTPHEADER     => array(
                "Postman-Token: 6b7e50ad-6a84-4af6-b0b4-fb8e173eb3f7",
                "Referer: http://m.kuaifaka.com/buy_pay?order_number=kfk1904021ca4ec5b",
                "cache-control: no-cache",
                "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $res = json_decode($response, true);
        if ($err) {
            return array('msg'  => '生成Ali支付URL失败',
                         'code' => '500034',);
        } else {
            return $res;
        }
    }


    /**
     * 获取订单状态  2 等待付款 0 支付成功
     * @param $orderNum
     * @return array|mixed
     */
    public function getOrderStatus($orderNum)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL            => "https://api.kuaifaka.com/purch/get_order_state?=",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"order_num\"\r\n\r\n{$orderNum}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
            CURLOPT_HTTPHEADER     => array(
                "Postman-Token: 656ec29b-f35c-43c2-aed0-de77b4a24948",
                "cache-control: no-cache",
                "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $res = json_decode($response, true);
        if ($err) {
            return array('msg'  => '生成微信支付二维码失败',
                         'code' => '500031',);
        } else {
            return $res['data'];
        }
    }
}