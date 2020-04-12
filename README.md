# Mini CRM Project (API)


Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## How to set up locally

* Clone repo: 
<code>git clone https://github.com/tjcode19/mini-crm.git</code>

* CD into your project
<p>You will need to be inside that project file to enter all of the rest of the commands.</p>

* Install Composer Dependencies
<code>composer install</code>

*Install NPM Dependencies
<code>npm install</code>

*Create a copy of your .env file
<code>cp .env.example .env</code>
<p>This will create a copy of the .env.example file in your project and name the copy simply .env</p>

*Generate an app encryption key
<code>php artisan key:generate</code>

*Create an empty database for our application
<p>Create an empty database for your project using the database tools you prefer (I use wampserver)</p>

*In the .env file, add database information to allow Laravel to connect to the database
<p>We will want to allow Laravel to connect to the database that you just created in the previous step. To do this, we must add the connection credentials in the .env file and Laravel will handle the connection from there.</p>

<p>In the .env file fill in the DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD options to match the credentials of the database you just created. This will allow us to run migrations and seed the database in the next step.
</p>

*Migrate the database
<code>php artisan migrate --seed</code>

## Contributing

Thank you for considering contributing to Lumen! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
