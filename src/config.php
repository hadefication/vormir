<?php

return [
    // Enable server side rendering. When disabled, the client 
    // script and the fallback html will be rendered instead.
    'enabled' => true,

    // Set to true to enable debugging, this will return all
    // errors returned by the render (js errors)
    'debug' => true,

    // Additional environment variables to be loaded
    'env' => [],

    // The path of where the server entry file sits
    'js_path' => public_path('js'),

    // Node engine specific
    'node' => [

        // Node.js bin path
        'bin_path' => env('SSR_NODE_BIN_PATH', ''),

        // The temp path where the compiled js file will be saved,
        // will be removed once the script has been executed.
        'temp_path' => storage_path('app/public')

    ],
];