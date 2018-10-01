<h1>{{ $row->invoice_no }}</h1>
<p><i>{{ $row->company_name }}</i></p>

<table cellpadding="5" cellspacing="5" width="100%">
	<thead>
		<tr>
			<th>No</th>
			<th>Açiklama</th>
			<th>Adet</th>
			<th>Fiyat</th>
			<th>Toplam</th>
		</tr>
	</thead>
	<tbody>
		@foreach($row->products as $item)
			<tr>
				<td>{{ $item->product_no }}</td>
				<td>{{ $item->product_desc }}</td>
				<td>{{ $item->product_number }} Adet</td>
				<td>{{ $item->product_price }} TL</td>
				<td>{{ $item->product_number * $item->product_price }}</td>
			</tr>
		@endforeach
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td><b>{{ $toplam }} TL</b></td>
		</tr>
	</tbody>
</table>