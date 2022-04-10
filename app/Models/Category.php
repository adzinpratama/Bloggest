<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'description', 'sort', 'parent_id'];

    public function scopeOnlyParent($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeSearch($query, $title)
    {
        return $query->where('title', 'LIKE', "%{$title}%");
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function node()
    {
        return $this->children()->orderBy('sort')->with('node');
    }
}
