@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
<div class="col-md-8">
	<div class="card">
		<div class="card-header">
			<a href="{{ url('/home') }}" class="btn btn-primary" style="float:right;">
				<i class="fas fa-plus-square"></i> 
				<b>Yeni Fatura</b>
			</a>
            <h2>Faturalar</h2>
        </div>
        <div class="card-body">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Fatura No</th>
					<th>Firma Adı</th>
					<th>Ürün Kalemleri</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($data as $item)
					<tr>
						<td>{{ $item->invoice_no }}</td>
						<td>{{ $item->company_name }}</td>
						<td>{{ $item->products->count() }} Adet</td>
						<td><a href="{{ url('invoices') }}/{{ $item->id }}" class="btn btn-success btn-block"><i class="fas fa-download"></i> <b>İndir</b> </a></td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	</div>
</div>
</div>
@endsection