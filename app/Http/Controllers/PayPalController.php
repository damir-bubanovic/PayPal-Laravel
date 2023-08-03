<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePayPalRequest;
use App\Http\Requests\UpdatePayPalRequest;
use App\Models\PayPal;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('paypal.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePayPalRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PayPal $payPal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PayPal $payPal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePayPalRequest $request, PayPal $payPal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PayPal $payPal)
    {
        //
    }


    /**
     * Handle Payment
     * @return [type] [description]
     */
    public function handlePayment(Request $request) {
    		$quantity = $request->quantity;
    		$value = 2500 * $quantity;


				$provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('success.payment'),
                "cancel_url" => route('cancel.payment'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $value,
                    ]
                ]
            ]
        ]);
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()
                ->route('cancel.payment')
                ->with('message', 'Something went wrong.')
                ->with('color', 'bg-red-500');
        } else {
            return redirect()
                ->route('create.payment')
                ->with('message', $response['message'] ?? 'Something went wrong.')
                ->with('color', 'bg-red-500');
        }

    }


    /**
     * Cancle Payment
     * @return [type] [description]
     */
    public function cancelPayment() {
    		return redirect()
            ->route('create.payment')
            ->with('message', $response['message'] ?? 'You have canceled the transaction.')
            ->with('color', 'bg-red-500');
    }


    /**
     * Success Payment
     * @return [type] [description]
     */
    public function paymentSuccess(Request $request) {
    		$provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            return redirect()
                ->route('paypal.index')
                ->with('message', 'Transaction complete.')
                ->with('color', 'bg-blue-500');
        } else {
            return redirect()
                ->route('paypal.index')
                ->with('message', $response['message'] ?? 'Something went wrong.')
                ->with('color', 'bg-red-500');
        }
    }

}
