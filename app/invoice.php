<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    //
    protected $table="invoice";
    protected $fillable = ["invoice_no","company_name"];

    function products(){
    	return $this->hasMany("App\product");
    }
}
