<?php
/**
 * @Desc     :
 * @Date     :2019/7/19-9:57 AM
 * @Author   :wangye
 * @File     :Bases.php
 * @Copyright:2015-2019 kaoyanpdf
 */

namespace App\Work\Pdf;

class Bases
{
    public function qrCodeLogic($serial, $email, $payWay)
    {
        //创建订单号
        $orderNumber = $this->getOrderNum();
        if (empty($orderNumber)) {
            return array('msg'  => '订单号生成失败',
                         'code' => 50009);
        }
        //构建订单
        $result = $this->buildOrder($orderNumber);
        if ($result['msg'] !== 'success') {
            return array('msg'  => '订单构建失败',
                         'code' => 50010,);
        }
        if ($payWay == '1') {
            $payInfo = $this->generateWxImg($orderNumber);
        } else {
            $payInfo = $this->generateAliUrl($orderNumber);
        }

        try {

        } catch (\Exception $exception) {
            print_r($exception);
        }

        return $payInfo;
    }

    public function getOrderNum()
    {
        $payService = new \App\Work\Pay\KuaiFaKa();
        $orderNumInfo = $payService->createOrderNum();

        return $orderNumInfo['data'];
    }

    public function generateWxImg($orderNumber)
    {
        $kuaifaka = new  \App\Work\Pay\KuaiFaKa();;
        $data = $kuaifaka->getWxPayImg($orderNumber);

        return $data;
    }

    public function generateAliUrl($orderNumber)
    {
        $kuaifaka = new  \App\Work\Pay\KuaiFaKa();;
        $data = $kuaifaka->getAliPayUrl($orderNumber);

        return $data;
    }

    public function buildOrder($orderNumber)
    {
        $kuaifaka = new  \App\Work\Pay\KuaiFaKa();;
        $data = $kuaifaka->buildOrder($orderNumber);

        return array(
            'data' => $data,
            'msg'  => 'success',
        );
    }

    public function getOrderStatus($orderNumber)
    {
        $kuaifaka = new  \App\Work\Pay\KuaiFaKa();;
        $res = $kuaifaka->getOrderStatus($orderNumber);

        return $res;
    }
}