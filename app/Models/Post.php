<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    /** @var int  */
    const AVERAGE_READ_SPEED = 250;

    /** @var int  */
    const LIMIT_CHARACTER_CONTENT = 150;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'image',
        'body',
        'published_at',
        'featured',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'post_like')->withTimestamps();
    }

    public function scopePublished($query)
    {
        $query->where('published_at', '<=', Carbon::now());
    }

    public function scopeWithCategory($query, string $category)
    {
        $query->whereHas('categories', function ($query) use ($category) {
            $query->where('slug', $category);
        });
    }

    /**
     * Sort posts by like count
     * @param $query
     * @return void
     */
    public function scopePopular($query)
    {
        $query->withCount('likes')->orderBy('likes_count', 'desc');
    }

    /**
     * Get item by name
     * @param $query
     * @param string $search
     * @return void
     */
    public function scopeSearch($query, string $search = '')
    {
        $query->where('title', 'like', "%{$search}%");
    }

    public function scopeFeatured($query)
    {
        $query->where('featured', true);
    }

    public function getExcerpt()
    {
        return Str::limit(strip_tags($this->body), self::LIMIT_CHARACTER_CONTENT);
    }

    public function getReadingTime()
    {
        $words   = str_word_count($this->body);
        $minutes = round($words / self::AVERAGE_READ_SPEED);
        return $minutes < 1 ? 1 : $minutes;
    }

    public function getThumbnailUrl()
    {
        $isUrl = str_contains($this->image, 'http');

        return ($isUrl) ? $this->image : Storage::disk('public')->url($this->image);
    }
}
