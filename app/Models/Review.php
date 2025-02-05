<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // 商品とレビューの紐づけ
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // ユーザーとレビューの紐づけ
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
