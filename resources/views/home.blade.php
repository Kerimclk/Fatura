@extends('layouts.app')

@section('extra_css')
    <style type="text/css">
        a#delete{
            background-color: #f30000;
            padding: 5px;
            border-radius: 5px;
            color: white;
            font-size: 0.8em;
        }
    </style>
@endsection

@section('content')
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ürün Ekle</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
        {!! Form::open() !!}
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <th>No</th>
                        <th>{!! Form::text('product_name','',['class'=>'form-control']) !!}</th>
                    </tr>
                    <tr>
                        <th>Açıklama</th>
                        <th>{!! Form::textarea('product_desc','',['class'=>'form-control','rows'=>3]) !!}</th>
                    </tr>
                    <tr>
                        <th>Adet</th>
                        <th>{!! Form::text('product_number','',['class'=>'form-control']) !!}</th>
                    </tr>
                    <tr>
                        <th>Fiyat</th>
                        <th>{!! Form::text('product_price','',['class'=>'form-control']) !!}</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th style="text-align: right;font-size:20px">
                            Toplam : <i><span id="row_price">0 TL</span></i>
                        </th>
                    </tr>
                </tbody>
            </table>

        {!! Form::close() !!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
        <button type="button" class="btn btn-primary" id="btn-save">Kaydet</button>
      </div>
    </div>
  </div>
</div>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="{{ url('invoices') }}" class="btn btn-danger" style="float:right;">
                        <i class="fas fa-file-invoice"></i> 
                        <b>Faturalar</b>
                    </a>
                    <h2>Fatura Oluştur</h2>

                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {!! Form::Open() !!}
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th>{!! Form::label('','Fatura No') !!}</th>
                                <td>{!! Form::text('invoice_no','',['class'=>'form-control']) !!}</td>
                            </tr>
                            <tr>
                                <th>{!! Form::label('','Firma Ünvan') !!}</th>
                             <td>{!! Form::text('company_title','',['class'=>'form-control']) !!}</td>
                            </tr>
                            <tr>
                                <th>{!! Form::label('','Ürün(ler)') !!}</th>
                                <td>    
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal" id="btn-open-window">
                                        <i class="fas fa-plus-square"></i>
                                        <b>Ürün Ekle</b>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Açıklama</th>
                                <th>Adet</th>
                                <th>Fiyat</th>
                                <th>Toplam</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="products">
                            
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th id="product-total-price">0 TL</th>
                                <th></th>
                            </tr>
                        </tbody>
                    </table>

                    <button id="btn-print" type="button" class="btn btn-success btn-lg" style="float:right"><i class="fas fa-save"></i> <b>Kaydet</b></button>
                    <div class="result"></div>
                    {!! Form::Close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_scripts')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        var output = [];
        var products = [];

        $('input[name="product_number"], input[name="product_price"]').bind('keypress', function(e){
            var keyCode = (e.which)?e.which:event.keyCode
            return !(keyCode>31 && (keyCode<48 || keyCode>57)); 
        });

        // row price calculator
        function calculator(){
            for(var i = 0; i<2; i++){
                var product_number = parseInt($('input[name=product_number]').val());
                var product_price = parseInt($('input[name=product_price]').val());
                    var r_total = (product_number*product_price);
                    if (!isNaN(r_total)) {
                        $('span#row_price').text((r_total)+' TL');
                    }
                
            }
        }

        $(document).on('keyup','input[name="product_number"], input[name="product_price"]',function(){

            calculator();
        });


        var invoice_no = $('input[name="invoice_no"]');
        var company_title = $('input[name="company_title"]');
        var name = $('input[name="product_name"]');
        var desc = $('textarea[name="product_desc"]');
        var number = $('input[name="product_number"]');
        var price = $('input[name="product_price"]');

        // Save button click function
        $(document).on('click','button#btn-save',function(){

            var product_name = name.val();
            var product_desc = desc.val();
            var product_number = number.val();
            var product_price = price.val();

            if (product_name=="" || product_desc=="" || product_number=="" || product_price=="") {
                alert("Lütfen boş alanları doldurunuz.");
            }else{

                $("tbody#products").prepend('<tr><td>'+product_name+'</td><td>'+product_desc+'</td><td>'+product_number+' Adet</td><td>'+product_price+' TL</td><td id="row-total-price" data-total="'+(product_number*product_price)+'">'+(product_number*product_price)+' TL</td><td><a href="javascript:void(0)" id="delete" data-id="'+product_name+'"><i class="fas fa-trash"></i></a></td></tr>');

                $('#exampleModal').modal('hide');

                // this produt push array
                /*var prd = [];
                prd["name"] = product_name;
                prd["desc"] = product_desc;
                prd["number"] = product_number;
                prd["price"] = product_price;
                products.push(prd);
                */

                var prd = 
                {
                    "name" : product_name,
                    "desc" : product_desc,
                    "number": product_number,
                    "price" : product_price
                }

                products.push(prd);


                cal();

            }

        });

        // products row total price
        function cal(){

            var p_total_price = 0;

            $("td#row-total-price").each(function(){
                var i = $(this).data('total');
                p_total_price+=i;
            });

            $("th#product-total-price").html(p_total_price+" TL");
        }

        // btn-open-window
        $(document).on('click','#btn-open-window',function(){
            name.val("");
            desc.val("");
            number.val("");
            price.val("");
            $('span#row_price').text('0 TL');
        });

        // btn delete
        $(document).on('click','a#delete',function(){
            if (confirm("Silmek istediğinize eminmisiniz ?")) {

                var id = $(this).data("id");

                // array each delete
                $(products).each(function(i,v){
                    if (id == products[i]["name"]) {
                        products[i] = [];
                    }
                });

                $(this).parent().parent().remove();
            }
            cal();
        });

        // operation print
        $(document).on('click','button#btn-print',function(){

            // AJAX
            $.ajax({
                type:"post",
                url:"/insertData",
                data:
                {
                    '_token':$('input[name=_token]').val(),
                    'products':products,
                    'invoice_no':invoice_no.val(),
                    'company_title':company_title.val()
                },
                success:function(res)
                {
                   if(res == 200)
                   {
                        window.location.href = "{{ url('/invoices') }}";  
                   }
                   else
                   {
                        alert("Bir problem var!");
                   }
                }
            });

        }); 
    });
</script>
@endsection