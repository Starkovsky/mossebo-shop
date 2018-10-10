<?php return array (
  'app' => 
  array (
    'name' => 'Mossebo.Market',
    'env' => 'local',
    'debug' => true,
    'url' => 'http://mossebo-shop.test',
    'timezone' => 'UTC',
    'locale' => 'ru',
    'fallback_locale' => 'ru',
    'key' => 'base64:uvdrE5fv9Rk91+OBrdvDixBOrli6vHzxYn0C1B5MwXw=',
    'cipher' => 'AES-256-CBC',
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Cookie\\CookieServiceProvider',
      6 => 'Illuminate\\Database\\DatabaseServiceProvider',
      7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      10 => 'Illuminate\\Hashing\\HashServiceProvider',
      11 => 'Illuminate\\Mail\\MailServiceProvider',
      12 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      13 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      14 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      15 => 'Illuminate\\Queue\\QueueServiceProvider',
      16 => 'Illuminate\\Redis\\RedisServiceProvider',
      17 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      18 => 'Illuminate\\Session\\SessionServiceProvider',
      19 => 'Illuminate\\Translation\\TranslationServiceProvider',
      20 => 'Illuminate\\Validation\\ValidationServiceProvider',
      21 => 'Illuminate\\View\\ViewServiceProvider',
      22 => 'App\\Providers\\AppServiceProvider',
      23 => 'App\\Providers\\AuthServiceProvider',
      24 => 'App\\Providers\\CartServiceProvider',
      25 => 'App\\Providers\\EventServiceProvider',
      26 => 'App\\Providers\\RouteServiceProvider',
      27 => 'App\\Providers\\MorphServiceProvider',
      28 => 'App\\Providers\\RepoServiceProvider',
      29 => 'App\\Providers\\HelpersServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Redis' => 'Illuminate\\Support\\Facades\\Redis',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'SeoProxy' => 'App\\Seo\\SeoProxy',
      'Shoppingcart' => 'Gloudemans\\Shoppingcart\\Facades\\Cart',
    ),
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'api' => 
      array (
        'driver' => 'token',
        'provider' => 'users',
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\User',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_resets',
        'expire' => 60,
      ),
    ),
  ),
  'breadcrumbs' => 
  array (
    'view' => 'chunks.breadcrumbs',
    'files' => '/Users/Urij/code/mossebo-shop/routes/breadcrumbs.php',
    'unnamed-route-exception' => true,
    'missing-route-bound-breadcrumb-exception' => true,
    'invalid-named-breadcrumb-exception' => true,
    'manager-class' => 'DaveJamesMiller\\Breadcrumbs\\BreadcrumbsManager',
    'generator-class' => 'DaveJamesMiller\\Breadcrumbs\\BreadcrumbsGenerator',
  ),
  'broadcasting' => 
  array (
    'default' => 'log',
    'connections' => 
    array (
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => '',
        'secret' => '',
        'app_id' => '',
        'options' => 
        array (
          'cluster' => 'mt1',
          'encrypted' => true,
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'cache' => 
  array (
    'default' => 'redis',
    'stores' => 
    array (
      'apc' => 
      array (
        'driver' => 'apc',
      ),
      'array' => 
      array (
        'driver' => 'array',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => '/Users/Urij/code/mossebo-shop/storage/framework/cache/data',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
    ),
    'prefix' => 'mossebomarket_cache',
  ),
  'database' => 
  array (
    'default' => 'pgsql',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'database' => 'mossebo',
        'prefix' => '',
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'host' => '178.128.45.10',
        'port' => '5432',
        'database' => 'mossebo',
        'username' => 'forge',
        'password' => 'Qtz6eWmJ33seIlHIVA8h',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'strict' => true,
        'engine' => NULL,
      ),
      'pgsql-production' => 
      array (
        'driver' => 'pgsql',
        'host' => '127.0.0.1',
        'port' => '5432',
        'database' => 'forge',
        'username' => 'forge',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
        'schema' => 'public',
        'sslmode' => 'prefer',
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'host' => '178.128.45.10',
        'port' => '5432',
        'database' => 'mossebo',
        'username' => 'forge',
        'password' => 'Qtz6eWmJ33seIlHIVA8h',
        'charset' => 'utf8',
        'prefix' => '',
        'schema' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'host' => '178.128.45.10',
        'port' => '5432',
        'database' => 'mossebo',
        'username' => 'forge',
        'password' => 'Qtz6eWmJ33seIlHIVA8h',
        'charset' => 'utf8',
        'prefix' => '',
      ),
    ),
    'migrations' => 'migrations',
    'redis' => 
    array (
      'client' => 'predis',
      'default' => 
      array (
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => 0,
      ),
      'session' => 
      array (
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => 1,
      ),
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'local',
    'cloud' => 's3',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => '/Users/Urij/code/mossebo-shop/storage/app',
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => '/Users/Urij/code/mossebo-shop/storage/app/public',
        'url' => 'http://mossebo-shop.test/storage',
        'visibility' => 'public',
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => NULL,
        'secret' => NULL,
        'region' => NULL,
        'bucket' => NULL,
        'url' => NULL,
      ),
    ),
  ),
  'geoip' => 
  array (
    'log_failures' => true,
    'include_currency' => true,
    'service' => 'maxmind_database',
    'services' => 
    array (
      'maxmind_database' => 
      array (
        'class' => 'Torann\\GeoIP\\Services\\MaxMindDatabase',
        'database_path' => '/Users/Urij/code/mossebo-shop/storage/app/geoip.mmdb',
        'update_url' => 'https://geolite.maxmind.com/download/geoip/database/GeoLite2-City.mmdb.gz',
        'locales' => 
        array (
          0 => 'en',
        ),
      ),
      'maxmind_api' => 
      array (
        'class' => 'Torann\\GeoIP\\Services\\MaxMindWebService',
        'user_id' => NULL,
        'license_key' => NULL,
        'locales' => 
        array (
          0 => 'en',
        ),
      ),
      'ipapi' => 
      array (
        'class' => 'Torann\\GeoIP\\Services\\IPApi',
        'secure' => true,
        'key' => NULL,
        'continent_path' => '/Users/Urij/code/mossebo-shop/storage/app/continents.json',
        'lang' => 'en',
      ),
    ),
    'cache' => 'none',
    'cache_tags' => 
    array (
      0 => 'torann-geoip-location',
    ),
    'cache_expires' => 30,
    'default_location' => 
    array (
      'ip' => '127.0.0.0',
      'iso_code' => 'RU',
      'country' => 'Russia',
      'city' => 'St Petersburg',
      'state' => 'SPE',
      'state_name' => 'St.-Petersburg',
      'postal_code' => '190000',
      'lat' => 59.9321,
      'lon' => -30.1968,
      'timezone' => 'Europe/Moscow',
      'continent' => 'Unknown',
      'default' => true,
      'currency' => 'RUB',
    ),
  ),
  'hashing' => 
  array (
    'driver' => 'bcrypt',
  ),
  'languages' => 
  array (
    'default' => 1,
  ),
  'location' => 
  array (
    'default_city_id' => 279393,
  ),
  'logging' => 
  array (
    'default' => 'stack',
    'channels' => 
    array (
      'stack' => 
      array (
        'driver' => 'stack',
        'channels' => 
        array (
          0 => 'single',
        ),
      ),
      'single' => 
      array (
        'driver' => 'single',
        'path' => '/Users/Urij/code/mossebo-shop/storage/logs/laravel.log',
        'level' => 'debug',
      ),
      'daily' => 
      array (
        'driver' => 'daily',
        'path' => '/Users/Urij/code/mossebo-shop/storage/logs/laravel.log',
        'level' => 'debug',
        'days' => 7,
      ),
      'slack' => 
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'critical',
      ),
      'syslog' => 
      array (
        'driver' => 'syslog',
        'level' => 'debug',
      ),
      'errorlog' => 
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
      ),
    ),
  ),
  'mail' => 
  array (
    'driver' => 'smtp',
    'host' => 'smtp.yandex.com',
    'port' => '465',
    'from' => 
    array (
      'address' => 'shop@mossebo.market',
      'name' => 'Mossebo.Market',
    ),
    'to' => 
    array (
      'address' => 'trigur@yandex.ru',
      'name' => '>Юрий',
    ),
    'encryption' => 'ssl',
    'username' => 'shop@mossebo.market',
    'password' => '4HN09a3ih0Pc',
    'sendmail' => '/usr/sbin/sendmail -bs',
    'markdown' => 
    array (
      'theme' => 'default',
      'paths' => 
      array (
        0 => '/Users/Urij/code/mossebo-shop/resources/views/vendor/mail',
      ),
    ),
  ),
  'queue' => 
  array (
    'default' => 'sync',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => 'your-public-key',
        'secret' => 'your-secret-key',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'your-queue-name',
        'region' => 'us-east-1',
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
      ),
    ),
    'failed' => 
    array (
      'database' => 'pgsql',
      'table' => 'failed_jobs',
    ),
  ),
  'repositories' => 
  array (
    'cache' => 
    array (
      'minutes' => 30,
    ),
  ),
  'scout' => 
  array (
    'driver' => 'elastic',
    'prefix' => '',
    'queue' => true,
    'chunk' => 
    array (
      'searchable' => 500,
      'unsearchable' => 500,
    ),
    'soft_delete' => false,
    'algolia' => 
    array (
      'id' => '',
      'secret' => '',
    ),
  ),
  'scout_elastic' => 
  array (
    'client' => 
    array (
      'hosts' => 
      array (
        0 => '209.97.182.177:9235',
      ),
    ),
    'update_mapping' => true,
    'indexer' => 'single',
    'document_refresh' => NULL,
  ),
  'seotools' => 
  array (
    'meta' => 
    array (
      'defaults' => 
      array (
        'title' => 'Mossebo.Market',
        'description' => 'Mossebo.Market',
        'separator' => ' - ',
        'keywords' => 
        array (
        ),
        'canonical' => false,
      ),
      'webmaster_tags' => 
      array (
        'google' => NULL,
        'bing' => NULL,
        'alexa' => NULL,
        'pinterest' => NULL,
        'yandex' => NULL,
      ),
    ),
    'opengraph' => 
    array (
      'defaults' => 
      array (
        'title' => 'Mossebo.Market',
        'description' => 'Mossebo.Market',
        'url' => false,
        'type' => false,
        'site_name' => false,
        'images' => 
        array (
        ),
      ),
    ),
    'twitter' => 
    array (
      'defaults' => 
      array (
      ),
    ),
  ),
  'services' => 
  array (
    'mailgun' => 
    array (
      'domain' => NULL,
      'secret' => NULL,
    ),
    'ses' => 
    array (
      'key' => NULL,
      'secret' => NULL,
      'region' => 'us-east-1',
    ),
    'sparkpost' => 
    array (
      'secret' => NULL,
    ),
    'stripe' => 
    array (
      'model' => 'App\\Models\\User',
      'key' => NULL,
      'secret' => NULL,
    ),
    'vkontakte' => 
    array (
      'client_id' => '6481933',
      'client_secret' => 'YRkRAW9ia9mkmyHychNr',
      'redirect' => 'https://mossebo-shop.test/login/vkontakte/callback',
    ),
    'odnoklassniki' => 
    array (
      'client_id' => '1266698240',
      'client_secret' => 'E59CE039A750B4F17EA1E8B5',
      'client_public' => 'CBAJEBIMEBABABABA',
      'redirect' => 'https://mossebo-shop.test/login/odnoklassniki/callback',
    ),
    'facebook' => 
    array (
      'client_id' => '2082740105281448',
      'client_secret' => '6a4287ccbe5a70170ca4a34137c16c75',
      'redirect' => 'https://mossebo-shop.test/login/facebook/callback',
    ),
    'google' => 
    array (
      'client_id' => '527585669004-kdb1jlkk692kktj2qc7haih780prhpt7.apps.googleusercontent.com',
      'client_secret' => '-0OGogkOdx5oVfZ3Fq5YoBct',
      'redirect' => 'https://localhost:3000/login/google/callback',
    ),
  ),
  'session' => 
  array (
    'driver' => 'redis',
    'lifetime' => '43200',
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => '/Users/Urij/code/mossebo-shop/storage/framework/sessions',
    'connection' => 'session',
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'mossebomarket_session',
    'path' => '/',
    'domain' => 'mossebo-shop.test',
    'secure' => false,
    'http_only' => false,
    'same_site' => NULL,
  ),
  'shop' => 
  array (
    'badges' => 
    array (
      'icons' => 
      array (
        0 => 'symbol-fire',
        1 => 'symbol-star',
        2 => 'symbol-moon',
        3 => 'symbol-thumbs-up',
        4 => 'symbol-plus-one',
        5 => 'symbol-leaf',
        6 => 'symbol-giftbox',
      ),
    ),
    'price' => 
    array (
      'types' => 
      array (
        'default' => 2,
        'franchisee' => 3,
      ),
    ),
    'promo' => 
    array (
      'default' => '21',
      'discount' => 
      array (
        'percent' => 
        array (
          'max_percent' => 100,
        ),
        'amount' => 
        array (
          'max_percent' => 100,
        ),
      ),
      'conditions' => 
      array (
        'types' => 
        array (
          0 => 'min_summ',
          1 => 'product_expensive',
          2 => 'products_quantity',
          3 => 'first_order',
        ),
      ),
    ),
    'repositories' => 
    array (
      'cache' => 
      array (
        'minutes' => 30,
      ),
    ),
  ),
  'tables' => 
  array (
    'Admins' => 'admins',
    'AdminLogs' => 'admin_logs',
    'AdminRoles' => 'admin_roles',
    'AdminRoleRelations' => 'admin_role_relations',
    'AdminRolePermissions' => 'admin_role_permissions',
    'AdminRolePermissionGroups' => 'admin_role_permission_groups',
    'AdminRolePermissionRelations' => 'admin_role_permission_relations',
    'Users' => 'users',
    'PasswordResets' => 'password_resets',
    'SocialProviders' => 'social_providers',
    'Settings' => 'settings',
    'Countries' => 'countries',
    'CountriesI18n' => 'countries_i18n',
    'Cities' => 'cities',
    'CitiesI18n' => 'cities_i18n',
    'PostalCodes' => 'postal_codes',
    'Regions' => 'regions',
    'Languages' => 'languages',
    'Currencies' => 'shop_currencies',
    'Images' => 'images',
    'Prices' => 'shop_prices',
    'PriceTypes' => 'shop_price_types',
    'PriceTypesI18n' => 'shop_price_types_i18n',
    'Categories' => 'shop_categories',
    'CategoriesI18n' => 'shop_categories_i18n',
    'CategoryProducts' => 'shop_category_products',
    'Rooms' => 'shop_rooms',
    'RoomsI18n' => 'shop_rooms_i18n',
    'RoomProducts' => 'shop_room_products',
    'Styles' => 'shop_styles',
    'StylesI18n' => 'shop_styles_i18n',
    'StyleProducts' => 'shop_style_products',
    'Products' => 'shop_products',
    'ProductsI18n' => 'shop_products_i18n',
    'ProductCounts' => 'shop_product_counts',
    'RelatedProducts' => 'shop_related_products',
    'Suppliers' => 'shop_suppliers',
    'SuppliersI18n' => 'shop_suppliers_i18n',
    'SupplierProducts' => 'shop_supplier_products',
    'DeliveryTypes' => 'shop_delivery_types',
    'DeliveryTypesI18n' => 'shop_delivery_types_i18n',
    'PayTypes' => 'shop_pay_types',
    'PayTypesI18n' => 'shop_pay_types_i18n',
    'Orders' => 'shop_orders',
    'OrderProducts' => 'shop_order_products',
    'OrderProductAttributeOptions' => 'shop_order_product_attribute_options',
    'OrderStatuses' => 'shop_order_statuses',
    'OrderStatusesI18n' => 'shop_order_statuses_i18n',
    'OrdersTemp' => 'shop_orders_temp',
    'Attributes' => 'shop_attributes',
    'AttributesI18n' => 'shop_attributes_i18n',
    'AttributeOptions' => 'shop_attribute_options',
    'AttributeOptionsI18n' => 'shop_attribute_options_i18n',
    'ProductAttributes' => 'shop_product_attributes',
    'ProductAttributeOptions' => 'shop_product_attribute_options',
    'Cart' => 'shop_cart',
    'Media' => 'media',
    'Reviews' => 'reviews',
    'MsbTransactions' => 'msb_transactions',
    'PromoCodes' => 'shop_promo_codes',
    'PromoCodesI18n' => 'shop_promo_codes_i18n',
    'PromoConditions' => 'shop_promo_conditions',
    'PromoUses' => 'shop_promo_uses',
    'BadgeTypes' => 'shop_badge_types',
    'BadgeTypesI18n' => 'shop_badge_types_i18n',
    'Badges' => 'shop_badges',
    'Banners' => 'shop_banners',
    'BannersI18n' => 'shop_banners_i18n',
    'BannerPlaces' => 'shop_banner_places',
    'BannerPlaceRelations' => 'shop_banner_place_relations',
    'Sales' => 'shop_sales',
    'Interiors' => 'shop_interiors',
    'InteriorsI18n' => 'shop_interiors_i18n',
    'InteriorPoints' => 'shop_interior_points',
    'InteriorStyles' => 'shop_interior_styles',
    'InteriorRooms' => 'shop_interior_rooms',
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => '/Users/Urij/code/mossebo-shop/resources/views',
    ),
    'compiled' => '/Users/Urij/code/mossebo-shop/storage/framework/views',
  ),
  'debugbar' => 
  array (
    'enabled' => NULL,
    'except' => 
    array (
    ),
    'storage' => 
    array (
      'enabled' => true,
      'driver' => 'file',
      'path' => '/Users/Urij/code/mossebo-shop/storage/debugbar',
      'connection' => NULL,
      'provider' => '',
    ),
    'include_vendors' => true,
    'capture_ajax' => true,
    'add_ajax_timing' => false,
    'error_handler' => false,
    'clockwork' => false,
    'collectors' => 
    array (
      'phpinfo' => true,
      'messages' => true,
      'time' => true,
      'memory' => true,
      'exceptions' => true,
      'log' => true,
      'db' => true,
      'views' => true,
      'route' => true,
      'auth' => true,
      'gate' => true,
      'session' => true,
      'symfony_request' => true,
      'mail' => true,
      'laravel' => false,
      'events' => false,
      'default_request' => false,
      'logs' => false,
      'files' => false,
      'config' => false,
      'cache' => false,
    ),
    'options' => 
    array (
      'auth' => 
      array (
        'show_name' => true,
      ),
      'db' => 
      array (
        'with_params' => true,
        'backtrace' => true,
        'timeline' => false,
        'explain' => 
        array (
          'enabled' => false,
          'types' => 
          array (
            0 => 'SELECT',
          ),
        ),
        'hints' => true,
      ),
      'mail' => 
      array (
        'full_log' => false,
      ),
      'views' => 
      array (
        'data' => false,
      ),
      'route' => 
      array (
        'label' => true,
      ),
      'logs' => 
      array (
        'file' => NULL,
      ),
      'cache' => 
      array (
        'values' => true,
      ),
    ),
    'inject' => true,
    'route_prefix' => '_debugbar',
    'route_domain' => NULL,
  ),
  'shop/promo' => 
  array (
    'default' => '21',
    'discount' => 
    array (
      'percent' => 
      array (
        'max_percent' => 100,
      ),
      'amount' => 
      array (
        'max_percent' => 100,
      ),
    ),
    'conditions' => 
    array (
      'types' => 
      array (
        0 => 'min_summ',
        1 => 'product_expensive',
        2 => 'products_quantity',
        3 => 'first_order',
      ),
    ),
  ),
  'shop/badges' => 
  array (
    'icons' => 
    array (
      0 => 'symbol-fire',
      1 => 'symbol-star',
      2 => 'symbol-moon',
      3 => 'symbol-thumbs-up',
      4 => 'symbol-plus-one',
      5 => 'symbol-leaf',
      6 => 'symbol-giftbox',
    ),
  ),
  'shop/price' => 
  array (
    'types' => 
    array (
      'default' => 2,
      'franchisee' => 3,
    ),
  ),
  'trustedproxy' => 
  array (
    'proxies' => NULL,
    'headers' => 30,
  ),
  'ide-helper' => 
  array (
    'filename' => '_ide_helper',
    'format' => 'php',
    'meta_filename' => '.phpstorm.meta.php',
    'include_fluent' => false,
    'write_model_magic_where' => true,
    'include_helpers' => false,
    'helper_files' => 
    array (
      0 => '/Users/Urij/code/mossebo-shop/vendor/laravel/framework/src/Illuminate/Support/helpers.php',
    ),
    'model_locations' => 
    array (
      0 => 'app',
    ),
    'extra' => 
    array (
      'Eloquent' => 
      array (
        0 => 'Illuminate\\Database\\Eloquent\\Builder',
        1 => 'Illuminate\\Database\\Query\\Builder',
      ),
      'Session' => 
      array (
        0 => 'Illuminate\\Session\\Store',
      ),
    ),
    'magic' => 
    array (
      'Log' => 
      array (
        'debug' => 'Monolog\\Logger::addDebug',
        'info' => 'Monolog\\Logger::addInfo',
        'notice' => 'Monolog\\Logger::addNotice',
        'warning' => 'Monolog\\Logger::addWarning',
        'error' => 'Monolog\\Logger::addError',
        'critical' => 'Monolog\\Logger::addCritical',
        'alert' => 'Monolog\\Logger::addAlert',
        'emergency' => 'Monolog\\Logger::addEmergency',
      ),
    ),
    'interfaces' => 
    array (
    ),
    'custom_db_types' => 
    array (
    ),
    'model_camel_case_properties' => false,
    'type_overrides' => 
    array (
      'integer' => 'int',
      'boolean' => 'bool',
    ),
  ),
  'tinker' => 
  array (
    'dont_alias' => 
    array (
    ),
  ),
);
