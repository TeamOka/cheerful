<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = ['title', 'description', 'tag', 'user_id', 'image'];

    // ユーザーのモデルファイル設定追加
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
