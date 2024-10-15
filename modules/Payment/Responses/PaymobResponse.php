<?php

namespace Modules\Payment\Responses;

use Modules\Order\Entities\Order;
use Modules\Payment\GatewayResponse;
use Modules\Payment\HasTransactionReference;

class PaymobResponse extends GatewayResponse implements HasTransactionReference
{
    private $order;


    public function __construct(Order $order)
    {
        $this->order = $order;
    }


    public function getOrderId()
    {
        return $this->order->id;
    }


    public function getTransactionReference()
    {
        return 'id';
    }


    public function toArray()
    {
        return [
            'api_key' => setting('paymob_api_key'),
            'email' => $this->order->customer_email,
            'amount' => $this->order->total->convertToCurrentCurrency()->subunit(),
            'ref' => 'ref' . time(),
            'currency' => currency(),
            'order_id' => $this->order->id,
        ];
    }
}
