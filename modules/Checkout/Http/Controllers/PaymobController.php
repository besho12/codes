<?php

namespace Modules\Checkout\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Modules\Order\Entities\Order;
use Illuminate\Routing\Controller;
use Modules\Payment\Facades\Gateway;
use Modules\Checkout\Events\OrderPlaced;
use Modules\Transaction\Entities\Transaction;
use Modules\Cart\Facades\Cart;

class PaymobController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param int $orderId
     * @param OrderService $orderService
     *
     * @return Response
     */

    public $config_values; 

    public function __construct()
    {

        $this->config_values = [
            'api_key' => setting('paymob_api_key'),
            'iframe_id' => setting('paymob_iframe_id'),
            'integration_id' => setting('paymob_integration_id'),
            'hmac' => setting('paymob_hmac'),
            'channel' => 'WEB',
            'industry_type' => 'Retail',
        ];
        
    }
    

    public function paymob_create_order(Request $request){

        $order_id = $request->order_id;
        $order = Order::where('id', $order_id)->first();
        $token = $this->getToken();
        $paymob = $this->createOrder($token, $order);
        $this->update_portal_order_with_paymob_order($order->id, $paymob->id);
        $paymentToken = $this->getPaymentToken($paymob, $token, $order);        
        $url = 'https://accept.paymobsolutions.com/api/acceptance/iframes/' . $this->config_values['iframe_id'] . '?payment_token=' . $paymentToken;
        echo json_encode($url);
    }

    function update_portal_order_with_paymob_order($portal_order_id, $paymob_order_id){
        Order::where('id', $portal_order_id)->update([
            'payment_order_id'=>$paymob_order_id
        ]);
    }
    


    public function createOrder($token, $order)
    {
        
        $total = ($order->total->amount());
        $items[] = [
            'name' => 'Test',
            'amount_cents' => round($total * 100),
            'description' => 'payment ID :' . $order['id'],
            'quantity' => 1
        ];

        $data = [
            "auth_token" => $token,
            "delivery_needed" => "false",
            "amount_cents" => round($total * 100),
            "currency" => "EGP",
            "items" => $items,
            'order_id' => $order->id,
            'portal_order_id' => $order['id'],

        ];
        $response = $this->cURL(
            'https://accept.paymob.com/api/ecommerce/orders',
            $data
        );

        return $response;
    }

    
    public function getPaymentToken($order, $token, $portal_order)
    {

        $value = 500;
        $billingData = [
            "apartment" => "N/A",
            "email" => 'test@gmail.com',
            "floor" => "N/A",
            "first_name" => 'beshoy',
            "street" => "N/A",
            "building" => "N/A",
            "phone_number" => "N/A",
            "shipping_method" => "PKG",
            "postal_code" => "N/A",
            "city" => "N/A",
            "country" => "N/A",
            "last_name" => 'ecladuos',
            "state" => "N/A",
        ];

        $data = [
            "auth_token" => $token,
            'amount_cents' => round($portal_order->total->amount() * 100),
            "expiration" => 3600,
            "order_id" => $order->id,
            "billing_data" => $billingData,
            "currency" => 'EGP',
            "integration_id" => $this->config_values['integration_id']
        ];

        $response = $this->cURL(
            'https://accept.paymob.com/api/acceptance/payment_keys',
            $data
        );

        return $response->token;
    }

    public function getToken()
    {
        $response = $this->cURL(
            'https://accept.paymob.com/api/auth/tokens',
            ['api_key' => $this->config_values['api_key']]
        );

        
        return $response->token;
    }

    protected function cURL($url, $json)
    {
        $ch = curl_init($url);

        $headers = array();
        $headers[] = 'Content-Type: application/json';

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $output = curl_exec($ch);

        // Check if there was a cURL error
        if (curl_errno($ch)) {
            dd('cURL error: ' . curl_error($ch));
        }

        curl_close($ch);
        return json_decode($output);
    }

    protected function GETcURL($url)
    {
        // Create curl resource
        $ch = curl_init($url);

        // Request headers
        $headers = array();
        $headers[] = 'Content-Type: application/json';

        // Return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // $output contains the output string
        $output = curl_exec($ch);

        // Close curl resource to free up system resources
        curl_close($ch);
        return json_decode($output);
    }

    public function paymobcallbackresponseview(Request $request){
        $data = $request;
        return view('storefront::public.checkout.complete.paid', compact('data'));
    }

    public function callback(Request $request)
    {

        $data = $request->all();

        

       
        ksort($data);
        $hmac = $data['hmac'];

        $array = [
            'amount_cents',
            'created_at',
            'currency',
            'error_occured',
            'has_parent_transaction',
            'id',
            'integration_id',
            'is_3d_secure',
            'is_auth',
            'is_capture',
            'is_refunded',
            'is_standalone_payment',
            'is_voided',
            'order',
            'owner',
            'pending',
            'source_data_pan',
            'source_data_sub_type',
            'source_data_type',
            'success',
        ];

        $secret = $this->config_values['hmac'];

        $connectedString = '';
        foreach ($data as $key => $element) {
            if (in_array($key, $array)) {
                $connectedString .= $element;
            }
        }

        
        $hased = hash_hmac('sha512', $connectedString, $secret);


        $callbackData = [
            'hased' => $hased,
            'hmac' => $hmac
        ];
        
        $portal_id = $data['obj']['order']['id'];

        $order = Order::where('payment_order_id',$portal_id)->firstOrFail();

        


        if (/*$hased == $hmac && */ $data['obj']['success'] == "true") {
    
            // $gateway = Gateway::get('paymob');
    
            try {
                // $response = $gateway->complete($order);
                Transaction::create([
                    'order_id' => $order['id'],
                    'transaction_id' => $data['obj']['id'],
                    'payment_method' => 'paymob',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);

                Cart::clearCartConditions();
                
                event(new OrderPlaced($order));

            } catch (Exception $e) {    
                return response()->json([
                    'message' => $e->getMessage(),
                ], 403);
            }
    
    
            if (!request()->ajax()) {
                return redirect()->route('checkout.complete.show');
            }


        }
        

    }


}
