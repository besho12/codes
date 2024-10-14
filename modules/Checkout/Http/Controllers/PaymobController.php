<?php

namespace Modules\Checkout\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Modules\Order\Entities\Order;
use Illuminate\Routing\Controller;
use Modules\Payment\Facades\Gateway;
use Modules\Checkout\Events\OrderPlaced;

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
        // $this->update_portal_order_with_();
        $paymentToken = $this->getPaymentToken($paymob, $token, $order);        
        $url = 'https://accept.paymobsolutions.com/api/acceptance/iframes/' . $this->config_values['iframe_id'] . '?payment_token=' . $paymentToken;
        echo json_encode($url);
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
            "order_id" => $portal_order['id'],
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

        Order::where('id',1)->update([
            'test_callback'=>json_encode($request->all())
        ]);
        // dd($request);
        // id=226078119&pending=false&amount_cents=20000&success=true&is_auth=false&is_capture=false&is_standalone_payment=true&is_voided=false&is_refunded=false&is_3d_secure=true&integration_id=4853193&profile_id=1000304&has_parent_transaction=false&order=254435924&created_at=2024-10-13T18%3A59%3A49.559861&currency=EGP&merchant_commission=0&discount_details=%5B%5D&is_void=false&is_refund=false&error_occured=false&refunded_amount_cents=0&captured_amount=0&updated_at=2024-10-13T19%3A00%3A08.297606&is_settled=false&bill_balanced=false&is_bill=false&owner=1853067&data.message=Approved&source_data.type=card&source_data.pan=2346&source_data.sub_type=MasterCard&acq_response_code=00&txn_response_code=APPROVED&hmac=b7b2a065c62a0075dec1e293fe1000b9615d7e69d91f4513272d8f05c1c380673600f8f9a42e0fde291b0b6abd93848a89ab7c19744f4b20e73064c8cbb5a054
        // $data = $request->all();
        // ksort($data);
        // $hmac = $data['hmac'];

        // $array = [
        //     'amount_cents',
        //     'created_at',
        //     'currency',
        //     'error_occured',
        //     'has_parent_transaction',
        //     'id',
        //     'integration_id',
        //     'is_3d_secure',
        //     'is_auth',
        //     'is_capture',
        //     'is_refunded',
        //     'is_standalone_payment',
        //     'is_voided',
        //     'order',
        //     'owner',
        //     'pending',
        //     'source_data_pan',
        //     'source_data_sub_type',
        //     'source_data_type',
        //     'success',
        // ];

        // $secret = $this->config_values['hmac'];

        // $connectedString = '';
        // foreach ($data as $key => $element) {
        //     if (in_array($key, $array)) {
        //         $connectedString .= $element;
        //     }
        // }

        // $hased = hash_hmac('sha512', $connectedString, $secret);

        // if ($hased == $hmac && $data['success'] === "true") {

        //     $order = Order::findOrFail($data['order_id']);
    
        //     $gateway = Gateway::get(request('paymentMethod'));
    
        //     try {
        //         $response = $gateway->complete($order);
        //     } catch (Exception $e) {
        //         $orderService->delete($order);
    
        //         return response()->json([
        //             'message' => $e->getMessage(),
        //         ], 403);
        //     }
    
        //     $order->storeTransaction($response);
    
        //     event(new OrderPlaced($order));
    
        //     if (!request()->ajax()) {
        //         return redirect()->route('checkout.complete.show');
        //     }


        // }
        

    }


}
