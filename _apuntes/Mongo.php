
//Instalar mongodb

composer install
npm install
composer require mongodb/mongodb
composer require mongodb/laravel-mongodb

 
 -> archivo .env

DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=Loquesea
DB_USERNAME=root
DB_PASSWORD=

-> config/database.php
en connections =>[

'mongodb' => [
            'mongodb' => [
            'driver'   => 'mongodb',
            'dsn'      => env('DB_DSN', 'mongodb://127.0.0.1:27017'),
            'database' =>env('DB_DATABASE', 'laravelMDB')
        ],
        ],
]


