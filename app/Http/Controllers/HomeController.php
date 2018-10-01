<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\invoice;
use App\product;
use PDF;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$invoice = invoice::with("products")->get();
        $product = product::where('invoice_id', 1)->first();*/
        return view('home');
    }

    public function Ajax(Request $request)
    {
    	//Invoice Bilgileri
    	$invoice = new invoice();
    	$invoice->invoice_no = $request["invoice_no"];;
    	$invoice->company_name = $request['company_title'];;
    	$invoice->save();

    	$products = $request['products'];

		foreach ($products as $item) 
		{
			$product = new product();
			$product->invoice_id = $invoice->id;
			$product->product_no = $item["name"];
			$product->product_desc = $item["desc"];
			$product->product_number = $item["number"];
			$product->product_price = $item["price"];
			$product->save();
		}

		return response(200);
    }

    public function invoices(){

    	$data = invoice::orderBy("created_at","desc")->get();
    	return view("invoice",compact("data"));
    }

    public function convert($id){

    	$row = invoice::find($id);

    	$toplam = 0;
    	foreach ($row->products as $item) {
    		$toplam += ( $item->product_number * $item->product_price );
    	}

    	$pdf = PDF::loadView('fatura',compact('row','toplam'));
    	return $pdf->download(rand(1,99999999).".pdf");
    }
}
