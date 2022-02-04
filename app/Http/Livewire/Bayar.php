<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Master\Extracurricular;

class Bayar extends Component
{
    public $snapToken;
    public $belanja;

    public function mount()
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-x5lq31FWCGoPreWqj3fGEr8B';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        //ambil data belanja
        // $this->belanja = Extracurricular::find($id);

        $status = \Midtrans\Transaction::status(14);

        if($status->status_code == 404) {
            $params = array(
                'transaction_details' => array(
                    'order_id' => 14,
                    'gross_amount' => 10000,
                ),
                'customer_details' => array(
                    'first_name' => 'budi',
                    'last_name' => 'pratama',
                    'email' => 'budi.pra@example.com',
                    'phone' => '08111222333',
                ),
            );

            $this->snapToken = \Midtrans\Snap::getSnapToken($params);
        } else if($status->transaction_status == 'settlement') {
            dd($status->transaction_status);
        } else {
            dd($status->transaction_status);
        }

        
        // if(!empty($this->belanja)) {
            
        // }

        
        
    }

    public function render()
    {       
        return view('livewire.bayar');
    }
}
