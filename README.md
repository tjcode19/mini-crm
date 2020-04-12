# Mini CRM Project (API)

The backend part of the project developed with Laravel Lumen.

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax.

## How to set up locally


### Clone repo 
```
git clone https://github.com/tjcode19/mini-crm.git
```

### CD into your project
```
You will need to be inside that project file to enter all of the rest of the commands.
```

### Install Composer Dependencies
```
composer install
```

### Install NPM Dependencies
```
npm install
```

### Create a copy of your .env file

```
cp .env.example .env
This will create a copy of the .env.example file in your project, rename this to .env
```

### Generate an app encryption key

```
php artisan key:generate
```

### Create an empty database for our application
```
Create an empty database for your project using the database tools you prefer (I use wampserver). I named mine mini-crm-db
```
### In the .env file, add database information to allow Laravel to connect to the database
```
We will want to allow Laravel to connect to the database that you just created in the previous step. To do this, we must add the connection credentials in the .env file and Laravel will handle the connection from there.

In the .env file fill in the DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD options to match the credentials of the database you just created. This will allow us to run migrations and seed the database in the next step.
```

### Migrate the database with seed
```
php artisan migrate --seed
The seed is required to automatically load DB with 30 companies and 60 employees
```

## Login Information

### Admin User
* Username: test@test.com
* Password: password

### Company Level User
* Username: (Company email)
* Password: admin

### Employee
* Username: (Employee email)
* Password: employee


## License
The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
