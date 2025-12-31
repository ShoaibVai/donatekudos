<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'slug',
        'bio',
        'custom_html',
        'custom_css',
        'custom_js',
        'theme',
        'template_id',
    ];

    protected $casts = [
        'template_id' => 'integer',
    ];

    /**
     * Boot method to add model events
     */
    protected static function boot()
    {
        parent::boot();
        
        // Ensure slug is URL-safe
        static::saving(function ($profile) {
            if ($profile->isDirty('slug')) {
                $profile->slug = Str::slug($profile->slug);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function galleryImages()
    {
        return $this->hasMany(GalleryImage::class)->orderBy('order');
    }

    /**
     * Sanitize custom HTML to remove dangerous tags and scripts
     */
    public function getSafeCustomHtmlAttribute()
    {
        if (empty($this->custom_html)) {
            return '';
        }
        // Basic sanitization - remove script tags and dangerous attributes
        $html = $this->custom_html;
        $html = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi', '', $html);
        $html = preg_replace('/on\w+\s*=\s*["\'][^"\'\']*["\']/', '', $html);
        return $html;
    }

    /**
     * Sanitize custom CSS to remove dangerous content
     */
    public function getSafeCustomCssAttribute()
    {
        if (empty($this->custom_css)) {
            return '';
        }
        // Remove javascript: and data: URLs from CSS
        $css = $this->custom_css;
        $css = preg_replace('/javascript\s*:/i', '', $css);
        $css = preg_replace('/data\s*:/i', '', $css);
        return $css;
    }

    /**
     * Get safe custom JS (completely disabled for security)
     */
    public function getSafeCustomJsAttribute()
    {
        // For security, we should not allow custom JS
        // Return empty string or commented out code
        return '// Custom JavaScript is disabled for security reasons';
    }
}
