<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
	protected $table="products";
    protected $fillable = ["invoice_id","product_no","product_desc","product_number","product_price"];

    function invoice(){
    	return $this->belongsTo("App\invoice");
    }
}
