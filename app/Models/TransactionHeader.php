<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableTrait;

class TransactionHeader extends Model
{
	public $timestamps=false;
	protected $softDelete = true;
	protected $user;
	protected $table = 'TransactionHeader';
	protected $primaryKey = 'TransactionHeaderId';
	protected $guarded = ['TransactionHeaderId','CreatedAt','UpdatedAt'];
	
	public function TransactionDetail()
    {
        return $this->hasMany(TransactionDetail::class, 'TransactionHeaderId', 'TransactionHeaderId');
    }
}