<?php

namespace LaravelFileViewer;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LaravelFileViewer\Skeleton\SkeletonClass
 */
class LaravelFileViewerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-file-viewer';
    }
}
