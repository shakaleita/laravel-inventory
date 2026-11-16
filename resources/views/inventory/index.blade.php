@extends('layout')
@section('subtitle','Products · movements · reorder alerts')
@section('content')
<section class="panel"><h2>Add product</h2><form class="inline" action="{{ route('products.store') }}" method="POST">@csrf
<label>SKU<input name="sku" required></label><label>Name<input name="name" required></label><label>Opening qty<input name="quantity" type="number" min="0" value="0" required></label><label>Reorder at<input name="reorder_level" type="number" min="0" value="5" required></label><label>Cost in cents<input name="unit_cost_cents" type="number" min="0" value="0" required></label><button>Add</button></form></section>
<section class="panel"><h2>Stock on hand</h2><table><thead><tr><th>SKU</th><th>Name</th><th>Quantity</th><th>Reorder level</th><th>Adjust stock</th></tr></thead><tbody>
@forelse($products as $product)<tr><td>{{ $product->sku }}</td><td>{{ $product->name }}</td><td>{{ $product->quantity }} @if($product->quantity <= $product->reorder_level)<strong class="error">Low stock</strong>@endif</td><td>{{ $product->reorder_level }}</td><td><form class="inline" method="POST" action="{{ route('products.adjust',$product) }}">@csrf<input name="change" type="number" placeholder="+5 or -2" required style="width:105px"><input name="reason" placeholder="Reason" required style="width:140px"><button>Adjust</button></form></td></tr>@empty<tr><td colspan="5">No products yet</td></tr>@endforelse</tbody></table></section>
<section class="panel"><h2>Recent movements</h2><ul>@forelse($movements as $movement)<li>{{ $movement->product?->name }}: {{ $movement->change > 0 ? '+' : '' }}{{ $movement->change }} — {{ $movement->reason }} ({{ $movement->created_at }})</li>@empty<li>No movements</li>@endforelse</ul></section>
@endsection
