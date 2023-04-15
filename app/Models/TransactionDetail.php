<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableTrait;

class TransactionDetail extends Model
{
	public $timestamps=false;
	protected $softDelete = true;
	protected $user;
	protected $table = 'TransactionDetail';
	protected $primaryKey = 'TransactionDetailId';
	protected $guarded = ['TransactionDetailId','CreatedAt','UpdatedAt'];
	
	public function product()
    {
        return $this->belongsTo(Product::class, 'ProductId', 'ProductId');
    }
}