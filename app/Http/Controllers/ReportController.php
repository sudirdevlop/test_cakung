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

class ReportController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function byUser()
    {
        $reports = TransactionHeader::select('TransactionHeader.*','users.name','users.email')
                        ->where('UserId',Auth::user()->id)
                        ->with(['TransactionDetail' => function ($query) {
                            $query->leftJoin('Product', 'TransactionDetail.ProductId', '=', 'Product.ProductId');
                        }])
                        ->leftJoin('users', 'TransactionHeader.UserId', '=', 'users.id')
                        ->orderBy('TransactionHeaderId','asc')
                        ->get();

        return view('report.by_user', compact('reports'));
    }
        
    public function all()
    {
        $reports = TransactionHeader::select('TransactionHeader.*','users.name','users.email')
                        ->with(['TransactionDetail' => function ($query) {
                            $query->leftJoin('Product', 'TransactionDetail.ProductId', '=', 'Product.ProductId');
                        }])
                        ->leftJoin('users', 'TransactionHeader.UserId', '=', 'users.id')
                        ->orderBy('TransactionHeaderId','asc')
                        ->get();

        return view('report.by_user', compact('reports'));
    }
        
}