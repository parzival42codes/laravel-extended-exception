<?php

use parzival42codes\LaravelExtendedException\App\Services\ExtendedExceptionService;

if (! function_exists('extendedException')) {
    function extendedException(
        string $message
    ): ExtendedExceptionService {
        return new ExtendedExceptionService($message);
    }
}
