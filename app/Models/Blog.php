<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BlogDetails;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\DB;


class Blog extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = ['meta_keywords' => 'array'];

    public function details()
    {
        return $this->hasOne(BlogDetails::class, 'blog_id');
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function getLanguageEditClass($id, $languageId)
    {
        return DB::table('blog_details')->where(['blog_id' => $id, 'language_id' => $languageId])->exists() ? 'bi-check2' : 'bi-pencil';
    }
}
