<?php

namespace App\Controllers;
use App\Models\OrderModel;
use App\Models\PaymentModel;
use CodeIgniter\Controller;

class OrderController extends Controller
{
    public function create()
    {
        $orderModel = new OrderModel();

        $products = $this->request->getPost('products');
        $totalAmount = 0;

        // Calculate total amount
        foreach ($products as $product) {
            $totalAmount += $product['quantity'] * $product['price'];
        }
        $data = [
            'customer_name' => $this->request->getPost('name'),
            'customer_email' => $this->request->getPost('email'),
            'total_amount' => $totalAmount,
            'status' => 'initiated'
        ];

        $orderId = $orderModel->insert($data);


        // print_r($orderId);
        // die();
        return redirect()->to('/checkout/' . $orderId);
    }

    public function checkout($orderId)
    {
        $orderModel = new OrderModel();
        $order = $orderModel->find($orderId);

        // Convert total_amount to float using array access
        $totalAmount = floatval($order['total_amount']);

        if (!$order || $totalAmount <= 0) {
            return $this->response->setJSON([
                'error' => 'Invalid order data or total amount.',
                'order_data' => $order
            ]);
        }

        // Prepare the data for PayTabs API
        $data = [
            'profile_id' => 132344,
            'tran_type' => "sale",
            'tran_class' => "ecom",
            'cart_id' => (string)$order['id'],
            'cart_amount' => $totalAmount,  
            'cart_currency' => "EGP",
            'cart_description' => "Purchase Order #" . $order['id'],
            'framed' => true,
            'framed_return_top' => true,
            'framed_return_parent' => true,
            'hide_shipping'=>true,
            'customer_details' => [
                'name' => $order['customer_name'],
                'email' => $order['customer_email'],
                'phone' => "0522222222",
                'street1' => "address street",
                'city' => "cc",
                'state' => "AZ",
                'country' => "AE",
                'zip' => "12345"
            ]
        ];

        // Call the PayTabs API
        $response = $this->callPayTabsAPI($data);

        // print_r($response);
        // die();
        // Check if the response is valid
        if ($response && isset($response->redirect_url)) {

       
            $paymentModel = new PaymentModel();
            $paymentData = [
                'order_id' => $orderId,
                'transaction_id' => $response->tran_ref,
                'amount' => $response->cart_amount,  
                'status' => 'initiated',  
                'request'=> json_encode($data),
                'response' => json_encode($response),  // Store the full response for reference
            ];
    
            $paymentModel->insert($paymentData);
    
            return $this->response->setJSON(['iframe_url' => $response->redirect_url]);
        } else {
            return $this->response->setJSON([
                'error' => 'Failed to get a valid response from PayTabs API.',
                'response' => $response
            ]);
        }
    }

    private function callPayTabsAPI($data)
    {
        $apiKey = getenv('PAYTABS_API_KEY');
        
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://secure-egypt.paytabs.com/payment/request",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => [
                "authorization: " . $apiKey,
                "Content-Type: application/json"
            ],
            CURLOPT_POSTFIELDS => json_encode($data)
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function myOrders()
    {
        $orderModel = new OrderModel();
        $orders = $orderModel->findAll();  // Fetch all orders
        
        return view('orders/my_orders', ['orders' => $orders]);
    }


    public function orderDetails($orderId)
    {
        $orderModel = new OrderModel();
        $paymentModel = new PaymentModel();

        $order = $orderModel->find($orderId);
        if (!$order) {
            return $this->response->setJSON(['error' => 'Order not found.']);
        }

        $payment = $paymentModel->where('order_id', $orderId)->first();

        $data = [
            'order' => $order,
            'payment' => $payment,
        ];

        return view('orders/order_details', $data);
    }
}