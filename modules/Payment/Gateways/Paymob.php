<?php

namespace Modules\Payment\Gateways;

use Exception;
use Illuminate\Http\Request;
use Modules\Order\Entities\Order;
use Modules\Payment\GatewayInterface;
use Modules\Payment\Responses\PaymobResponse;
use Paytm\JsCheckout\Facades\Paytm as PaytmAlias;
use Illuminate\Support\Facades\Redirect;

class Paymob implements GatewayInterface
{
    public $label;
    public $description;
    public $config_values;    



    public function __construct()
    {
        $this->label = setting('paymob_label');
        $this->description = setting('paymob_description');
    }

    /**
     * @throws Exception
     */
    public function purchase(Order $order, Request $request)
    {
        return new PaymobResponse($order);
    }



   

    public function complete(Order $order)
    {
        return new PaymobResponse($order, request()->all());
    }


    private function getRedirectUrl($order)
    {
        return route('checkout.complete.store', ['orderId' => $order->id, 'paymentMethod' => 'paymob']);
    }
}
