<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// ソート機能追加
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    // Kyslik/column-sortableライブラリー追加して Sortble追加
    use HasFactory, Sortable;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'image',
        'recommend_flag',
        'carriage_flag',
    ];

    // 商品とカテゴリの紐づけ
    public function category()
    {

        return $this->belongsTo(Category::class);
    }

    // 商品とレビューの紐づけ
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // 多対多のリーレーションシップ設定
    public function favorited_users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
