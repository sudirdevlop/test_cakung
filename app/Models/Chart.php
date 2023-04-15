<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableTrait;

class Chart extends Model
{
	public $timestamps=false;
	protected $softDelete = true;
	protected $user;
	protected $table = 'Chart';
	protected $primaryKey = 'ChartId';
	protected $guarded = ['ChartId','CreatedAt','UpdatedAt'];
	
	public function product()
    {
        return $this->belongsTo(Product::class, 'ProductId', 'ProductId');
    }
}