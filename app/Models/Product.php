<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableTrait;

class Product extends Model
{
	public $timestamps=true;
	protected $softDelete = true;
	protected $user;
	protected $table = 'Product';
	protected $primaryKey = 'ProductId';
	protected $guarded = ['ProductId','CreatedAt','UpdatedAt'];
}