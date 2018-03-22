<?php

namespace App\Models\Core;

use HalcyonLaravel\Base\Models\Model;
use Spatie\Sluggable\SlugOptions;
use HalcyonLaravel\Base\Models\Traits\ModelDefaultTraits;

class DummyClass extends Model
{
    use ModelDefaultTraits;

    /**
     * Declared Fillables
     */
    protected $fillable = [
        'name',
        'content',
        'description',
        'image',
    ];


    public const moduleName         = 'dummyClass';
    public const viewBackendPath    = 'backend.core.dummyClass';
    public const viewFrontendPath   = 'frontend.core.dummyClass';
    public const routeAdminPath     = 'admin.dummyClass';
    public const routeFrontendPath  = 'frontend.dummyClass';

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Return the baseable source for this model.
     *
     * @return array
     */
    public function baseable() : array
    {
        return [
            'source' => 'title'
        ];
    }


    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
}
