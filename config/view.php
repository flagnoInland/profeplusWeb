<?php

	use Jenssegers\Agent\Agent;

	$agent = new Agent();

	if ($agent->isMobile()) {
        $paths = array(resource_path('views/mobile'), resource_path('views/emails'), resource_path('views'));
    } else {
        $paths = array(resource_path('views/mobile'), resource_path('views/emails'), resource_path('views'));
    }

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

	/*
    'paths' => [
        resource_path('views'),
    ],
	*/
	'paths' => $paths,

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => realpath(storage_path('framework/views')),

];
