<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
class InventoryController {
 public function index(){return view('inventory.index',['products'=>Product::orderBy('name')->get(),'movements'=>StockMovement::with('product')->latest()->limit(12)->get()]);}
 public function store(Request $request){
  $data=$request->validate(['sku'=>'required|string|max:100|unique:products,sku','name'=>'required|string|max:255','quantity'=>'required|integer|min:0','reorder_level'=>'required|integer|min:0','unit_cost_cents'=>'required|integer|min:0']);
  DB::transaction(function()use($data){$product=Product::create($data);if($product->quantity>0)$product->movements()->create(['change'=>$product->quantity,'reason'=>'Opening balance']);});
  return back()->with('success','Product added');
 }
 public function adjust(Request $request,Product $product){
  $data=$request->validate(['change'=>'required|integer|not_in:0','reason'=>'required|string|max:255']);
  DB::transaction(function()use($product,$data){
   $locked=Product::whereKey($product->id)->lockForUpdate()->firstOrFail();
   if($locked->quantity+$data['change']<0)throw ValidationException::withMessages(['change'=>'Insufficient stock']);
   $locked->quantity+=$data['change'];$locked->save();
   $locked->movements()->create(['change'=>$data['change'],'reason'=>$data['reason']]);
  });
  return back()->with('success','Stock adjusted');
 }
 /**
  * Replenishment proposals based on current stock and reorder thresholds.
  * Target inventory is twice the reorder level; never proposes negative units.
  */
 public function reorderReport(){
  $items=Product::whereColumn('quantity','<=','reorder_level')->orderBy('sku')->get();
  return response()->json($items->map(function($item){
   $target=max($item->reorder_level*2,1);
   return [
    'product_id'=>$item->id,'sku'=>$item->sku,'name'=>$item->name,
    'current_quantity'=>$item->quantity,'reorder_level'=>$item->reorder_level,
    'suggested_quantity'=>max(0,$target-$item->quantity),
    'estimated_cost_cents'=>max(0,$target-$item->quantity)*$item->unit_cost_cents,
   ];
  })->values());
 }
 public function insights(){return response()->json(['products'=>Product::count(),'low_stock'=>Product::whereColumn('quantity','<=','reorder_level')->count(),'inventory_value_cents'=>Product::selectRaw('COALESCE(SUM(quantity * unit_cost_cents),0) total')->value('total'),'stock_movements'=>StockMovement::count()]);}

 /**
  * Stream a deterministic read-only CSV snapshot of the local demo dataset.
  * Spreadsheet formula prefixes are escaped to prevent formula interpretation.
  */
 public function export(){
  return response()->streamDownload(function(){
   $handle=fopen('php://output','w');
   fputcsv($handle, ['id','sku','name','quantity','reorder_level','unit_cost_cents'], ',', '"', '');
   foreach(Product::orderBy('id')->cursor() as $record){
    $row=[];
    foreach(['id','sku','name','quantity','reorder_level','unit_cost_cents'] as $column){
     $value=(string)($record->{$column}??'');
     if(preg_match('/^\s*[=+\-@\t\r]/u',$value))$value="'".$value;
     $row[]=$value;
    }
    fputcsv($handle,$row,',','"','');
   }
   fclose($handle);
  }, 'inventory-products.csv', ['Content-Type'=>'text/csv; charset=UTF-8','Cache-Control'=>'no-store']);
 }
}
