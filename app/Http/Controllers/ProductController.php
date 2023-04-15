<?php

namespace App\Http\Controllers;

use App\Company;
use App\Models\Product;
use App\Events\NewCustomerHasRegisteredEvent;
use App\Mail\WelcomeNewUserMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = Product::orderBy('ProductId','asc')->get();

        return view('products.index', compact('products'));
    }
    
    public function byId($id)
    {
        $product = Product::where('ProductId',$id)->first();

        return view('products.detail', compact('product'));
    }
}