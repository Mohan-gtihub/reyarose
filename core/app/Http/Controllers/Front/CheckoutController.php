<?php

namespace App\Http\Controllers\Front;

use App\{
    Models\Order,
    Models\PaymentSetting,
    Traits\StripeCheckout,
    Traits\MollieCheckout,
    Traits\PaypalCheckout,
    Traits\PaystackCheckout,
    Http\Controllers\Controller,
    Http\Requests\PaymentRequest,
    Traits\CashOnDeliveryCheckout,
    Traits\BankCheckout,
};
use App\Helpers\PriceHelper;
use App\Helpers\SmsHelper;
use App\Models\Currency;
use App\Models\Item;
use App\Models\Setting;
use App\Models\ShippingService;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Mollie\Laravel\Facades\Mollie;
use Seshac\Shiprocket\Shiprocket;

class CheckoutController extends Controller
{

    use StripeCheckout {
        StripeCheckout::__construct as private __stripeConstruct;
    }
    use PaypalCheckout {
        PaypalCheckout::__construct as private __paypalConstruct;
    }
    use MollieCheckout {
        MollieCheckout::__construct as private __MollieConstruct;
    }

    use BankCheckout;
    use PaystackCheckout;
    use CashOnDeliveryCheckout;

    public function __construct()
    {
        $setting = Setting::first();
        if ($setting->is_guest_checkout != 1) {
            $this->middleware('auth');
        }
        $this->middleware('localize');
        $this->__stripeConstruct();
        $this->__paypalConstruct();
    }

    public function ship_address()
    {

        if (!Session::has('cart')) {
            return redirect(route('front.cart'));
        }
        $data['user'] = Auth::user() ? Auth::user() : null;
        $cart = Session::get('cart');
        $total_tax = 0;
        $cart_total = 0;
        $total = 0;

        foreach ($cart as $key => $item) {
            $total += ($item['main_price'] + $item['attribute_price']) * $item['qty'];
            $cart_total = $total;
            $item = Item::findOrFail($key);
            if ($item->tax) {
                $total_tax += $item::taxCalculate($item);
            }
        }


        $shipping = [];
        if (ShippingService::whereStatus(1)->whereId(1)->whereIsCondition(1)->exists()) {
            $shipping = ShippingService::whereStatus(1)->whereId(1)->whereIsCondition(1)->first();
            if ($cart_total >= $shipping->minimum_price) {
                $shipping = $shipping;
            } else {
                $shipping = [];
            }
        }

        if (!$shipping) {
            $shipping = ShippingService::whereStatus(1)->where('id', '!=', 1)->first();
        }
        $discount = [];
        if (Session::has('coupon')) {
            $discount = Session::get('coupon');
        }

        if (!PriceHelper::Digital()) {
            $shipping = null;
        }

        $grand_total = ($cart_total + ($shipping ? $shipping->price : 0)) + $total_tax;
        $grand_total = $grand_total - ($discount ? $discount['discount'] : 0);
        $state_tax = Auth::check() && Auth::user()->state_id ? Auth::user()->state->price : 0;
        $total_amount = $grand_total + $state_tax;

        $data['cart'] = $cart;
        $data['cart_total'] = $cart_total;
        $data['grand_total'] = $total_amount;
        $data['discount'] = $discount;
        $data['shipping'] = $shipping;
        $data['tax'] = $total_tax;
        $data['payments'] = PaymentSetting::whereStatus(1)->get();
        return view('front.checkout.billing', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function billingStore(Request $request)
     {
         // Define validation rules
         $rules = [
             'bill_first_name' => 'required|string|max:255',
             'bill_last_name' => 'required|string|max:255',
             'bill_email' => 'required|email|max:255',
             'bill_phone' => 'required|string|max:10|regex:/^[6-9]\d{9}$/',
             'bill_company' => 'nullable|string|max:255',
             'gst' => 'required|string|size:15|regex:/^[a-zA-Z0-9]+$/',
             'bill_address1' => 'required|string|max:255',
             'bill_address2' => 'nullable|string|max:255',
             'bill_zip' => 'required|numeric|digits:6',
             'bill_city' => 'required|string|max:255',
             'bill_country' => 'required|string|max:255',
         ];
     
         // Define custom error messages
         $messages = [
             'bill_first_name.required' => 'Please enter your first name.',
             'bill_last_name.required' => 'Please enter your last name.',
             'bill_email.required' => 'Please enter a valid email address.',
             'bill_email.email' => 'The email address must be a valid email format.',
             'bill_phone.required' => 'Please enter a valid phone number.',
             'bill_phone.regex' => 'The phone number must be a valid Indian number starting with 6-9 and containing 10 digits.',
             'bill_address1.required' => 'Please enter your address.',
             'bill_zip.required' => 'Please enter your ZIP code.',
             'bill_city.required' => 'Please enter your city.',
             'bill_country.required' => 'Please enter your country.',
         ];
     
         // Validate the request data
         $validatedData = $request->validate($rules, $messages);
         Session::put('billing_address', $request->all());
         // Process the validated data as needed
         if ($request->same_ship_address) {
             $shipping = [
                 "ship_first_name" => $validatedData['bill_first_name'],
                 "ship_last_name" => $validatedData['bill_last_name'],
                 "ship_email" => $validatedData['bill_email'],
                 "ship_phone" => $validatedData['bill_phone'],
                 "ship_company" => $validatedData['bill_company'] ?? '',
                 "gst" => $validatedData['gst'] ?? '',
                 "ship_address1" => $validatedData['bill_address1'],
                 "ship_address2" => $validatedData['bill_address2'] ?? '',
                 "ship_zip" => $validatedData['bill_zip'],
                 "ship_city" => $validatedData['bill_city'],
                 "ship_country" => $validatedData['bill_country'],
             ];
             Session::put('shipping_address', $shipping);
         } else {
             
             Session::put('billing_address', $request->all());
            Session::forget('shipping_address');
         }
     
         // Redirect to the appropriate route
         return Session::has('shipping_address')
             ? redirect()->route('front.checkout.payment')
             : redirect()->route('front.checkout.shipping');
     }


    public function shipping()
    {

        if (Session::has('shipping_address')) {
            return redirect(route('front.checkout.payment'));
        }

        if (!Session::has('cart')) {
            return redirect(route('front.cart'));
        }
        $data['user'] = Auth::user();
        $cart = Session::get('cart');

        $total_tax = 0;
        $cart_total = 0;
        $total = 0;

        foreach ($cart as $key => $item) {

            $total += ($item['main_price'] + $item['attribute_price']) * $item['qty'];
            $cart_total = $total;
            $item = Item::findOrFail($key);
            if ($item->tax) {
                $total_tax += $item::taxCalculate($item);
            }
        }
        $shipping = [];
        if (ShippingService::whereStatus(1)->whereId(1)->whereIsCondition(1)->exists()) {
            $shipping = ShippingService::whereStatus(1)->whereId(1)->whereIsCondition(1)->first();
            if ($cart_total >= $shipping->minimum_price) {
                $shipping = $shipping;
            } else {
                $shipping = [];
            }
        }

        if (!$shipping) {
            $shipping = ShippingService::whereStatus(1)->where('id', '!=', 1)->first();
        }
        $discount = [];
        if (Session::has('coupon')) {
            $discount = Session::get('coupon');
        }

        if (!PriceHelper::Digital()) {
            $shipping = null;
        }

        $grand_total = ($cart_total + ($shipping ? $shipping->price : 0)) + $total_tax;
        $grand_total = $grand_total - ($discount ? $discount['discount'] : 0);
        $state_tax = Auth::check() && Auth::user()->state_id ? ($cart_total * Auth::user()->state->price) / 100 : 0;
        $grand_total = $grand_total + $state_tax;

        $total_amount = $grand_total;
        $data['cart'] = $cart;
        $data['cart_total'] = $cart_total;
        $data['grand_total'] = $total_amount;
        $data['discount'] = $discount;
        $data['shipping'] = $shipping;
        $data['tax'] = $total_tax;
        $data['payments'] = PaymentSetting::whereStatus(1)->get();
        return view('front.checkout.shipping', $data);
    }

    public function shippingStore(Request $request)
    {

        Session::put('shipping_address', $request->all());
        return redirect(route('front.checkout.payment'));
    }



    public function payment()
    {
        if (!Session::has('billing_address')) {
            return redirect(route('front.checkout.billing'));
        }

        if (!Session::has('shipping_address')) {
            return redirect(route('front.checkout.shipping'));
        }


        if (!Session::has('cart')) {
            return redirect(route('front.cart'));
        }
        $data['user'] = Auth::user();
        $cart = Session::get('cart');

        $total_tax = 0;
        $cart_total = 0;
        $total = 0;

        foreach ($cart as $key => $item) {

            $total += ($item['main_price'] + $item['attribute_price']) * $item['qty'];
            $cart_total = $total;
            $item = Item::findOrFail($key);
            if ($item->tax) {
                $total_tax += $item::taxCalculate($item);
            }
        }
        $shipping = [];
        if (ShippingService::whereStatus(1)->whereId(1)->whereIsCondition(1)->exists()) {
            $shipping = ShippingService::whereStatus(1)->whereId(1)->whereIsCondition(1)->first();
            if ($cart_total >= $shipping->minimum_price) {
                $shipping = $shipping;
            } else {
                $shipping = [];
            }
        }

        if (!$shipping) {
            $shipping = ShippingService::whereStatus(1)->where('id', '!=', 1)->first();
        }
        $discount = [];
        if (Session::has('coupon')) {
            $discount = Session::get('coupon');
        }

        if (!PriceHelper::Digital()) {
            $shipping = null;
        }

        $grand_total = ($cart_total + ($shipping ? $shipping->price : 0)) + $total_tax;
        $grand_total = $grand_total - ($discount ? $discount['discount'] : 0);
        $state_tax = Auth::check() && Auth::user()->state_id ? ($cart_total * Auth::user()->state->price) / 100 : 0;
        $grand_total = $grand_total + $state_tax;


        $total_amount = $grand_total;

        $data['cart'] = $cart;
        $data['cart_total'] = $cart_total;
        $data['grand_total'] = $total_amount;
        $data['discount'] = $discount;
        $data['shipping'] = $shipping;
        $data['tax'] = $total_tax;
        $data['payments'] = PaymentSetting::whereStatus(1)->get();
        return view('front.checkout.payment', $data);
    }

    public function checkout(PaymentRequest $request)
    {


        $input = $request->all();

        $checkout = false;
        $payment_redirect = false;
        $payment = null;

        if (Session::has('currency')) {
            $currency = Currency::findOrFail(Session::get('currency'));
        } else {
            $currency = Currency::where('is_default', 1)->first();
        }


        $usd_supported = array(
            "USD", "AED", "AFN", "ALL", "AMD", "ANG", "AOA", "ARS", "AUD", "AWG",
            "AZN", "BAM", "BBD", "BDT", "BGN", "BIF", "BMD", "BND", "BOB", "BRL",
            "BSD", "BWP", "BYN", "BZD", "CAD", "CDF", "CHF", "CLP", "CNY", "COP",
            "CRC", "CVE", "CZK", "DJF", "DKK", "DOP", "DZD", "EGP", "ETB", "EUR",
            "FJD", "FKP", "GBP", "GEL", "GIP", "GMD", "GNF", "GTQ", "GYD", "HKD",
            "HNL", "HTG", "HUF", "IDR", "ILS", "INR", "ISK", "JMD", "JPY", "KES",
            "KGS", "KHR", "KMF", "KRW", "KYD", "KZT", "LAK", "LBP", "LKR", "LRD",
            "LSL", "MAD", "MDL", "MGA", "MKD", "MMK", "MNT", "MOP", "MUR", "MVR",
            "MWK", "MXN", "MYR", "MZN", "NAD", "NGN", "NIO", "NOK", "NPR", "NZD",
            "PAB", "PEN", "PGK", "PHP", "PKR", "PLN", "PYG", "QAR", "RON", "RSD",
            "RUB", "RWF", "SAR", "SBD", "SCR", "SEK", "SGD", "SHP", "SLE", "SOS",
            "SRD", "STD", "SZL", "THB", "TJS", "TOP", "TRY", "TTD", "TWD", "TZS",
            "UAH", "UGX", "UYU", "UZS", "VND", "VUV", "WST", "XAF", "XCD", "XOF",
            "XPF", "YER", "ZAR", "ZMW"
        );


        $paypal_supported = ['USD', 'EUR', 'AUD', 'BRL', 'CAD', 'HKD', 'JPY', 'MXN', 'NZD', 'PHP', 'GBP', 'RUB'];
        $paystack_supported = ['NGN', "GHS"];
        switch ($input['payment_method']) {

            case 'Stripe':
                if (!in_array($currency->name, $usd_supported)) {
                    Session::flash('error', __('Currency Not Supported'));
                    return redirect()->back();
                }
                $checkout = true;
                $payment_redirect = true;
                $payment = $this->stripeSubmit($input);
                break;

            case 'Paypal':
                if (!in_array($currency->name, $paypal_supported)) {
                    Session::flash('error', __('Currency Not Supported'));
                    return redirect()->back();
                }
                $checkout = true;
                $payment_redirect = true;
                $payment = $this->paypalSubmit($input);
                break;


            case 'Mollie':
                if (!in_array($currency->name, $usd_supported)) {
                    Session::flash('error', __('Currency Not Supported'));
                    return redirect()->back();
                }
                $checkout = true;
                $payment_redirect = true;
                $payment = $this->MollieSubmit($input);
                break;

            case 'Paystack':
                if (!in_array($currency->name, $paystack_supported)) {
                    Session::flash('error', __('Currency Not Supported'));
                    return redirect()->back();
                }
                $checkout = true;
                $payment = $this->PaystackSubmit($input);

                break;

            case 'Bank':
                $checkout = true;
                $payment = $this->BankSubmit($input);
                break;

            case 'Cash On Delivery':
                $checkout = true;
                $payment = $this->cashOnDeliverySubmit($input);
                break;
        }



        if ($checkout) {
            if ($payment_redirect) {
                if ($payment['status']) {
                    return redirect()->away($payment['link']);
                } else {
                    Session::put('message', $payment['message']);
                    return redirect()->route('front.checkout.cancle');
                }
            } else {
                if ($payment['status']) {
                    return redirect()->route('front.checkout.success');
                } else {
                    Session::put('message', $payment['message']);
                    return redirect()->route('front.checkout.cancle');
                }
            }
        } else {
            return redirect()->route('front.checkout.cancle');
        }
    }

    public function paymentRedirect(Request $request)
    {
        $responseData = $request->all();

        if (isset($responseData['session_id'])) {
            $payment = $this->stripeNotify($responseData);
            if ($payment['status']) {
                return redirect()->route('front.checkout.success');
            } else {
                Session::put('message', $payment['message']);
                return redirect()->route('front.checkout.cancle');
            }
        } elseif (Session::has('order_payment_id')) {
            $payment = $this->paypalNotify($responseData);
            if ($payment['status']) {
                return redirect()->route('front.checkout.success');
            } else {
                Session::put('message', $payment['message']);
                return redirect()->route('front.checkout.cancle');
            }
        } else {
            return redirect()->route('front.checkout.cancle');
        }
    }

    public function mollieRedirect(Request $request)
    {

        $responseData = $request->all();

        $payment = Mollie::api()->payments()->get(Session::get('payment_id'));
        $responseData['payment_id'] = $payment->id;
        if ($payment->status == 'paid') {
            $payment = $this->mollieNotify($responseData);
            if ($payment['status']) {
                return redirect()->route('front.checkout.success');
            } else {
                Session::put('message', $payment['message']);
                return redirect()->route('front.checkout.cancle');
            }
        } else {
            return redirect()->route('front.checkout.cancle');
        }
    }

    public function paymentSuccess()
{
    if (Session::has('order_id')) {
        $order_id = Session::get('order_id');
        $order = Order::find($order_id);

        if ($order) {
         $billingAddress = json_decode($order->billing_info, true);
                $shippingAddress = json_decode($order->shipping_info, true);
                $cart = json_decode($order->cart, true);

                $orderDetails = [
                    'order_id' => $order->transaction_number,
                    'order_date' => $order->created_at->format('Y-m-d H:i'),
                    'billing_customer_name' => $billingAddress['bill_first_name'] . ' ' . $billingAddress['bill_last_name'],
                    'billing_last_name' => $billingAddress['bill_last_name'],
                    'billing_address' => $billingAddress['bill_address1'],
                    'billing_address_2' => $billingAddress['bill_address2'],
                    'billing_city' => $billingAddress['bill_city'],
                    'billing_state' => 'Delhi',
                    'billing_pincode' => '100002',
                    'billing_country' => $billingAddress['bill_country'],
                    'billing_email' => $billingAddress['bill_email'],
                    'billing_phone' => $billingAddress['bill_phone'],
                    'shipping_is_billing' => true,
                    'shipping_customer_name' => '',
                    'shipping_last_name' => '',
                    'shipping_address' => '',
                    'shipping_address_2' => '',
                    'shipping_city' => '',
                    'shipping_pincode' => '',
                    'shipping_country' => '',
                    'shipping_state' => '', // Assuming 'ship_state' exists in your data
                    'shipping_email' => '',
                    'shipping_phone' => '',
                    'order_items' => [],
                    'payment_method' => ($order->payment_method=='Cash On Delivery') ? 'COD' : 'Prepaid',
                    'sub_total' => $order->grand_total, 
                    'order_type' => '',
                    'length'=> ($order->length > 0.5) ? $order->length : '0.5' ,
                    'breadth'=> ($order->breadth > 0.5) ? $order->breadth : '0.5',
                    'height'=> ($order->height > 0.5) ? $order->height : '0.5',
                    'weight'=> ($order->weight>0) ? $order->weight : 1,
                ];

                // Dynamically populate order items
                foreach ($cart as $item) {
                    $orderDetails['order_items'][] = [
                        'name' => $item['name'],
                        'sku' => $item['sku'],
                        'units' => $item['qty'],
                        'selling_price' => $item['price'],
                        'discount' => '',
                        'tax' => '',
                        'hsn' => '',
                    ];
                }

                // Assuming you have a method to get the Shiprocket token
                // $token = Shiprocket::getToken();
                
                // // // Assuming Shiprocket::order() accepts an array of orders
                // $response = Shiprocket::order($token)->create($orderDetails);
            //   dd($response);
        }

        $cart = json_decode($order->cart, true);
        $setting = Setting::first();
        if ($setting->is_twilio == 1) {
            // message
            $sms = new SmsHelper();
            $user_number = $order->user->phone;
            if ($user_number) {
                $sms->SendSms($user_number, "'purchase'");
            }
        }
        return view('front.checkout.success', compact('order', 'cart'));
        
    }

    return redirect()->route('front.index');
     //return view('front.checkout.success');
}

    public function paymentCancle()
    {
        $message = '';
        if (Session::has('message')) {
            $message = Session::get('message');
            Session::forget('message');
        } else {
            $message = __('Payment Failed!');
        }
        Session::flash('error', $message);
        return redirect()->route('front.checkout.billing');
    }

    public function stateSetUp($state_id)
    {

        if (!Session::has('cart')) {
            return redirect(route('front.cart'));
        }

        $cart = Session::get('cart');
        $total_tax = 0;
        $cart_total = 0;
        $total = 0;
        foreach ($cart as $key => $item) {

            $total += ($item['main_price'] + $item['attribute_price']) * $item['qty'];
            $cart_total = $total;
            $item = Item::findOrFail($key);
            if ($item->tax) {
                $total_tax += $item::taxCalculate($item);
            }
        }

        $shipping = [];
        if (ShippingService::whereStatus(1)->whereId(1)->whereIsCondition(1)->exists()) {
            $shipping = ShippingService::whereStatus(1)->whereId(1)->whereIsCondition(1)->first();
            if ($cart_total >= $shipping->minimum_price) {
                $shipping = $shipping;
            } else {
                $shipping = [];
            }
        }

        if (!$shipping) {
            $shipping = ShippingService::whereStatus(1)->where('id', '!=', 1)->first();
        }
        $discount = [];
        if (Session::has('coupon')) {
            $discount = Session::get('coupon');
        }

        $grand_total = ($cart_total + ($shipping ? $shipping->price : 0)) + $total_tax;
        $grand_total = $grand_total - ($discount ? $discount['discount'] : 0);

        $state_price = 0;
        if ($state_id) {
            $state = State::findOrFail($state_id);
            if ($state->type == 'fixed') {
                $state_price = $state->price;
            } else {
                $state_price = ($cart_total * $state->price) / 100;
            }
        } else {
            if (Auth::check() && Auth::user()->state_id) {
                $state = Auth::user()->state;
                if ($state->type == 'fixed') {
                    $state_price = $state->price;
                } else {
                    $state_price = ($cart_total * $state->price) / 100;
                }
            } else {
                $state_price = 0;
            }
        }

        $total_amount = $grand_total + $state_price;

        $data['state_price'] = PriceHelper::setCurrencyPrice($state_price);
        $data['grand_total'] = PriceHelper::setCurrencyPrice($total_amount);

        return response()->json($data);
    }
}