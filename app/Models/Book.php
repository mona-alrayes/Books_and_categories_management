<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Book extends Model
{
    use HasFactory , SoftDeletes;

    protected  $fillable = [
        'id',
        'title',
        'author',
        'published_at',
        'is_active',
        'category_id',
    ];

    protected $casts =[
      'published_at'=>'datetime',
    ];


    public function setPublishedAtAttribute($published_at): void
    {
        $this->attributes['published_at'] = Carbon::parse($published_at)->format('Y-m-d');
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

}
