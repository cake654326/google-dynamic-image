<?php
namespace ContentCrackers\GoogleDynamicImage;

use Illuminate\Support\Facades\Facade;

class GoogleDynamicImageFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'googledynamicimage';
    }

}
