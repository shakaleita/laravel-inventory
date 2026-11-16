<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Product extends Model {
 protected $fillable=['sku','name','quantity','reorder_level','unit_cost_cents'];
 public function movements(){return $this->hasMany(StockMovement::class);}
}
