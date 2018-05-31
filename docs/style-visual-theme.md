# Style & Visual Theme

### Injecting Assets

You may globally inject custom CSS files after the Sharp assets by defining their paths in the `config/sharp.php` config file.

```php
// config/sharp.php

"assets" => [
    "strategy" => "raw",
    "head"     => [
        "/css/inject.css", // Outputs <link rel="stylesheet" href="/css/inject.css"> after sharp assets
    ],
],

// ...
```

The comment next to the item within the `head` position show how the output would appear in the HTML.

### Strategy

The `strategy` defines how the asset path will be rendered

- `raw` to output the path in the form it appears in your array
- `asset` to pass the path to the laravel [`asset()`](https://laravel.com/docs/5.6/helpers#method-asset) function
- `mix` to pass the path to the laravel [`mix()`](https://laravel.com/docs/5.6/helpers#method-mix) function

## Customizing Sharp theme
Install the npm package `sharp-theme`:
```
npm install sharp-theme
```

### Build sharp css
*sharp.scss*
```scss
import 'variables.scss';
import '~sharp-theme/sharp.scss';
```

*variables.scss*
```scss
$brand-03: #f00;
```

Sharp use Carbon Design System, you can refer to its documentation if you want an advanced variables usage:
[Carbon themes](http://carbondesignsystem.com/style/colors/usage)

### Blade binding