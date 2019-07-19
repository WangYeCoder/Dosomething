<?php

namespace Home\Controller;

use Think\Controller;

class PdfController extends Controller
{
    /**
     * 获取支付验证码
     */
    public function getqrcode()
    {
        $pdfService = new \App\Work\Pdf\Bases();
        $email = I('email');
        $userName = I('username');
        $payWay = I('payway');
        if (empty($payWay) || empty($userName) || empty($email)) {
            $this->ajaxReturn(array(
                'code' => 40001,
                'msg'  => '一定是有什么是空',
            ));
        }
        $payInfo = $pdfService->qrCodeLogic($email, $userName, $payWay);

        $this->ajaxReturn($payInfo);
    }

    /**
     * 查询支付状态
     */
    public function getorderstatus()
    {
        $orderNumber = I('ordernum');
        if (empty($orderNumber)) {
            $this->ajaxReturn(array(
                'code' => 40002,
                'msg'  => '订单号不可为空',
            ));
        }
        $pdfService = new \App\Work\Pdf\Bases();
        $result = $pdfService->getOrderStatus($orderNumber);

        $this->ajaxReturn($result);
    }
}
