<?php return array (
  'socialiteproviders/manager' => 
  array (
    'providers' => 
    array (
      0 => 'SocialiteProviders\\Manager\\ServiceProvider',
    ),
  ),
  'laravel/scout' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Scout\\ScoutServiceProvider',
    ),
  ),
  'fideloper/proxy' => 
  array (
    'providers' => 
    array (
      0 => 'Fideloper\\Proxy\\TrustedProxyServiceProvider',
    ),
  ),
  'artesaos/seotools' => 
  array (
    'providers' => 
    array (
      0 => 'Artesaos\\SEOTools\\Providers\\SEOToolsServiceProvider',
    ),
    'aliases' => 
    array (
      'SEOMeta' => 'Artesaos\\SEOTools\\Facades\\SEOMeta',
      'OpenGraph' => 'Artesaos\\SEOTools\\Facades\\OpenGraph',
      'Twitter' => 'Artesaos\\SEOTools\\Facades\\TwitterCard',
      'SEO' => 'Artesaos\\SEOTools\\Facades\\SEOTools',
    ),
  ),
  'babenkoivan/scout-elasticsearch-driver' => 
  array (
    'providers' => 
    array (
      0 => 'ScoutElastic\\ScoutElasticServiceProvider',
    ),
  ),
  'cybercog/laravel-love' => 
  array (
    'providers' => 
    array (
      0 => 'Cog\\Laravel\\Love\\Providers\\LoveServiceProvider',
    ),
  ),
  'davejamesmiller/laravel-breadcrumbs' => 
  array (
    'providers' => 
    array (
      0 => 'DaveJamesMiller\\Breadcrumbs\\BreadcrumbsServiceProvider',
    ),
    'aliases' => 
    array (
      'Breadcrumbs' => 'DaveJamesMiller\\Breadcrumbs\\Facades\\Breadcrumbs',
    ),
  ),
  'kalnoy/nestedset' => 
  array (
    'providers' => 
    array (
      0 => 'Kalnoy\\Nestedset\\NestedSetServiceProvider',
    ),
  ),
  'laravel/socialite' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Socialite\\SocialiteServiceProvider',
    ),
    'aliases' => 
    array (
      'Socialite' => 'Laravel\\Socialite\\Facades\\Socialite',
    ),
  ),
  'laravel/tinker' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ),
  ),
  'torann/geoip' => 
  array (
    'providers' => 
    array (
      0 => 'Torann\\GeoIP\\GeoIPServiceProvider',
    ),
    'aliases' => 
    array (
      'GeoIP' => 'Torann\\GeoIP\\Facades\\GeoIP',
    ),
  ),
  'barryvdh/laravel-debugbar' => 
  array (
    'providers' => 
    array (
      0 => 'Barryvdh\\Debugbar\\ServiceProvider',
    ),
    'aliases' => 
    array (
      'Debugbar' => 'Barryvdh\\Debugbar\\Facade',
    ),
  ),
  'barryvdh/laravel-ide-helper' => 
  array (
    'providers' => 
    array (
      0 => 'Barryvdh\\LaravelIdeHelper\\IdeHelperServiceProvider',
    ),
  ),
  'nunomaduro/collision' => 
  array (
    'providers' => 
    array (
      0 => 'NunoMaduro\\Collision\\Adapters\\Laravel\\CollisionServiceProvider',
    ),
  ),
  'mossebo-cm/mossebo-shop-core' => 
  array (
    'providers' => 
    array (
      0 => 'MosseboShopCore\\MosseboShopCoreServiceProvider',
    ),
  ),
);