# Vormir

Just another attempt to do server side rendering in Laravel using [Spatie's](https://github.com/spatie) fantastic [server-side-rendering](https://github.com/spatie/server-side-rendering) package with focus on the Node engine. This package will expose a blade directive `@ssr` that you can include to your blade files as if you are including a JavaScript file. Since this package focuses on the Node engine of [Spatie's](https://github.com/spatie) [package](https://github.com/spatie/server-side-rendering), so you need to have [Node.js](https://nodejs.org/) installed in your stack.

Also, be sure to check this [article](https://vuejsdevelopers.com/2017/11/06/vue-js-laravel-server-side-rendering/) for more details on the server side rendering workflow and this [article](https://medium.com/walmartlabs/the-benefits-of-server-side-rendering-over-client-side-rendering-5d07ff2cefe8) as to why you should do server side rendering. As to who's this package for, kindly check this [section](https://github.com/spatie/server-side-rendering#whos-this-package-for) of [Spatie's](https://github.com/spatie) [package](https://github.com/spatie/server-side-rendering) readme.

## Installation
1. Add this package to your Laravel applications by running `composer require hadefication/vormir`
2. Publish the config file by running `php artisan vendor:publish --provider="BeyondCode\Credentials\CredentialsServiceProvider" --tag="config"` or `php artisan vendor:publish` and enter the number of this package showed in the console.
3. Locate your Node.js bin path and add it to your `.env` file as `SSR_NODE_BIN_PATH`.
4. Start mixing (Laravel Mix) or start building if you have your own build workflow. Your build process should export two entry files, one that will be used for the client/web and one is for the server (ssr). The server entry file is the one that you will feed into the @ssr directive.
5. Add `@ssr('path/to/your/entry-server.js', $payload, $moreEnv)` to you blade and that's it.
