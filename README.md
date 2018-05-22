# Vormir

Just another attempt to do server side rendering in Laravel using [Spatie's](https://github.com/spatie) fantastic [server-side-rendering](https://github.com/spatie/server-side-rendering) package with focus on the Node engine. This package will expose a blade directive `@ssr` that you can include to your blade files as if you are including a JavaScript file. Since this package focuses on the Node engine of [Spatie's](https://github.com/spatie) [package](https://github.com/spatie/server-side-rendering), so you need to have [Node.js](https://nodejs.org/) installed in your stack.

Also, be sure to check this [article](https://vuejsdevelopers.com/2017/11/06/vue-js-laravel-server-side-rendering/) for more details on the server side rendering workflow and this [article](https://medium.com/walmartlabs/the-benefits-of-server-side-rendering-over-client-side-rendering-5d07ff2cefe8) as to why you should do server side rendering. As to who's this package for, kindly check this [section](https://github.com/spatie/server-side-rendering#whos-this-package-for) of [Spatie's](https://github.com/spatie) [package](https://github.com/spatie/server-side-rendering) readme.

## Usage
1. Add this package to your Laravel applications by running `composer require hadefication/vormir`
2. Publish the config file by running `php artisan vendor:publish --provider="Hadefication\Vormir\VormirServiceProvider" --tag="config"` or `php artisan vendor:publish` and enter the number of this package showed in the console.
3. Locate your [Node.js](https://nodejs.org/) bin path by running `which node` and add it to your `.env` file as `SSR_NODE_BIN_PATH`.
4. Start mixing (Laravel Mix) or start building if you have your own build workflow. The build process should export two entry files, one that will be used for the client/web and one is for the server (ssr). The server entry file is the one that you will feed into the @ssr directive.
5. Add `@ssr('path/to/your/server-entry.js', $payload, $env)` to you blade and that's it!

## Config
```
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

    // The temp path where the compiled js file to be saved,
    // it will then eventually removed once the script
    // has been executed.
    'temp_path' => storage_path('app/public')

],
```

## `@ssr($entry, $payload, $env)`
The blade directive accepts three parameters where the first is required and the other two are optional.
- `$entry` - accepts a string path of the server entry file to render. Be sure to load/add/export your server entry files inside the `js_path` config. By default the `js_path` is set to `public_path('js')` or `public/js` (depending on your setup). So if you supplied the entry param like `@ssr('app/server-entry.js')` then the renderer will look for a file in the path `public/js/app/server-entry.js`.
- `$payload` - accepts a key-value array (assoc). The payload will be made available in your server entry file via `context` variable. Given that you have `@ssr('app/server-entry.js', ['foo' => 'bar'])`, the variable `foo` will now be accessible in your server entry file via `context.payload.foo`.
- `$env` - accepts a key-value array (assoc). Addition environment variables to be loaded on render (ssr).

## Vue
```
// config
...

'env' => ['VUE_ENV' => 'server']
```

```
// App.vue

<template>
    <div id="app">
        <h1>Hello cold world</h1>
    </div>
</template>
```

```
// App.js

import App from './path/to/component/App.vue';

export default new Vue({
    render: h => h(App)
});
```

```
// client-entry.js

import app from './path/to/App.js';

app.$mount('#app');
```

```
// server-entry.js

import app from './path/to/App.js';
// yarn add vue-server-renderer or npm i vue-server-renderer
import renderVueComponentToString from 'vue-server-renderer/basic';

renderVueComponentToString(app, (err, res) => console.log(res));
```

```
// Blade

<html>
    <body>
        @ssr('path/to/server-entry.js')
        <script src="/path/to/client-entry.js"></script>
    </body>
</html>
```

## React
```
// App.js

import React, { Component } from 'react';

export default class App extends Component {
    render() {
        return (
            <div className="container">
                <h1>Hello cold world</h1>
            </div>
        );
    }
}
```

```
// client-entry.js

import React from 'react';
import App from './components/App';
import { hydrate } from 'react-dom';

hydrate(<App />, document.getElementById('root'));
```

```
// server-entry.js

import React from 'react';
import App from './components/App';
import { renderToString } from 'react-dom/server';

console.log(renderToString(<App />));
```

```
// Blade
<html>
    <body>
        <div id="root">@ssr('server-entry.js')</div>
        <script src="{{ mix('js/client-entry.js') }}"></script>
    <body>
</html>
```