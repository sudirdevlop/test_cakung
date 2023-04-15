<?php

namespace App\Http\Controllers;

use App\Company;
use App\Models\Product;
use App\Models\TransactionHeader;
use App\Models\TransactionDetail;
use App\Models\Chart;
use App\Events\NewCustomerHasRegisteredEvent;
use App\Mail\WelcomeNewUserMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use DB;
use Auth;
use Response;

class TransactionController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $charts = Transaction::where('CreatedBy',Auth::user()->id)
                        ->with('product')
                        ->orderBy('TransactionId','asc')
                        ->get();

        return view('charts.index', compact('charts'));
    }
    
    public function store(request $request)
    {
        DB::beginTransaction();
        try {
            

            $subtotal = Chart::where('CreatedBy',Auth::user()->id)
                        ->sum('Subtotal');
                    
            $lastTransactionDetail = TransactionHeader::count();

            if ($lastTransactionDetail) {
                $transactionNumber = intval($lastTransactionDetail) + 1;
            } else {
                $transactionNumber = 1;
            }
            
            $fullTransactionNumber = 'TRX-' . str_pad($transactionNumber, 5, '0', STR_PAD_LEFT);

            $TransactionHeader = new TransactionHeader;
            $TransactionHeader->UserId = Auth::user()->id;
            $TransactionHeader->TransactionNumber = $fullTransactionNumber;
            $TransactionHeader->Total = $subtotal;
            $TransactionHeader->CreatedAt = date('Y-m-d H:i:s');
            $TransactionHeader->CreatedBy = Auth::user()->id;
            $TransactionHeader->save();
            
            
            $chart = Chart::where('CreatedBy',Auth::user()->id)
                                ->get();
            
            foreach($chart as $value) {
            
                $TransactionDetail = new TransactionDetail;
                $TransactionDetail->TransactionHeaderId = $TransactionHeader->TransactionHeaderId;
                $TransactionDetail->ProductId = $value->ProductId;
                $TransactionDetail->Price = $value->Price;
                $TransactionDetail->Subtotal = $value->Subtotal;
                $TransactionDetail->Quantity = $value->Quantity;
                $TransactionDetail->CreatedAt = date('Y-m-d H:i:s');
                $TransactionDetail->CreatedBy = Auth::user()->id;
                $TransactionDetail->save();

            }

            $chart = Chart::where('CreatedBy',Auth::user()->id)
                                ->delete();
            
        
            $response = [
                'status' => 'success',
                'message' => 'Berhasil tersimpan.'
            ];
            DB::commit();
            return response()->json($response, 200);

        }catch (\Exception $e) {
            DB::rollback();
            return Response::json(array(
                'status' => 'error',
                'message'   => $e->getMessage()." - ".$e->getLine()
            ), 400);
        }
    }

    
}