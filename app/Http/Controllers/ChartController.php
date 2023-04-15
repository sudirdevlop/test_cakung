<?php

namespace App\Http\Controllers;

use App\Company;
use App\Models\Product;
use App\Models\Chart;
use App\Events\NewCustomerHasRegisteredEvent;
use App\Mail\WelcomeNewUserMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use DB;
use Auth;
use Response;

class ChartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $charts = Chart::where('CreatedBy',Auth::user()->id)
                        ->with('product')
                        ->orderBy('ChartId','asc')
                        ->get();

        return view('charts.index', compact('charts'));
    }
    
    public function store(request $request)
    {
        DB::beginTransaction();
        try {
            
            $cek = Chart::where('CreatedBy',Auth::user()->id)
                        ->where('ProductId',$request->ProductId)
                        ->first();

            $Product = Product::where('ProductId',$request->ProductId)->first();

            $harga_diskon = $Product->Price*$Product->Discount/100;
            $harga_diskon = $Product->Price-$harga_diskon;

            
            if(empty($cek)){
                $Chart = new Chart;
                $Chart->ProductId = $request->ProductId;
                $Chart->Quantity = 1;
                $Chart->Price = $harga_diskon;
                $Chart->Subtotal = $harga_diskon;
                $Chart->CreatedAt = date('Y-m-d H:i:s');
                $Chart->CreatedBy = Auth::user()->id;
                $Chart->save();
            }else{

                DB::table('Chart')
                ->where('ProductId', $request->ProductId)
                ->where('CreatedBy', Auth::user()->id)
                ->update([
                    'Quantity' => $cek->Quantity+1,
                    'Price' => $harga_diskon,
                    'Subtotal' => $cek->Subtotal+$harga_diskon
                ]);

            }


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
                    'message'   => $e
                ), 400);
        }
    }

    public function change_qty(request $request)
    {
        DB::beginTransaction();
        try {
            
            $cek = Chart::where('CreatedBy',Auth::user()->id)
                        ->where('ProductId',$request->ProductId)
                        ->first();

            $Product = Product::where('ProductId',$request->ProductId)->first();

            $harga_diskon = $Product->Price*$Product->Discount/100;
            $harga_diskon = $Product->Price-$harga_diskon;

            $subtotal = $harga_diskon*$request->Qty;

            DB::table('Chart')
            ->where('ProductId', $request->ProductId)
            ->where('CreatedBy', Auth::user()->id)
            ->update([
                'Quantity' => $request->Qty,
                'Subtotal' => $subtotal
            ]);


            $response = [
                'status' => 'success',
                'message' => 'Berhasil dirubah.'
            ];
            DB::commit();
            return response()->json($response, 200);

        }catch (\Exception $e) {
            DB::rollback();
            return Response::json(array(
                    'status' => 'error',
                    'message'   => $e
                ), 400);
        }
    }

    public function delete($id){
        DB::beginTransaction();
        try{
            $cek = Chart::where('CreatedBy',Auth::user()->id)
                        ->where('ProductId',$id)
                        ->delete();

            $response = [
                'status' => 'success',
                'message' => 'Berhasil dirubah.'
            ];
            DB::commit();
            return response()->json($response, 200);

        }catch (\Exception $e) {
            DB::rollback();
            return Response::json(array(
                    'status' => 'error',
                    'message'   => $e
                ), 400);
        }
    }
}