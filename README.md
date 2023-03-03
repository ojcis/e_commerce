# e-commerce

### in this aplication you can:
* Update, remove, create new products as admin.
* Add products to cart, remove and check out as user.

## Examples:
### User:
![user](https://user-images.githubusercontent.com/112757458/222597504-9df49197-6393-428c-93f3-5205643f8721.gif)
### Admin:
![admin](https://user-images.githubusercontent.com/112757458/222597536-cf0b577b-5827-41bd-85f7-3952a30764cf.gif)

## Technologies used:
* PHP 8.1.16
* Laravel Framework 10.1.5
* Composer 2.4.4 
* mySQL 8.0
* Node.js npm 9.3.1
* Vue.js
* Tailwind CSS

## Instructions:
* Clone this repository
* In terminal navigate to back-end folder, Install the required packages using the command:<br><code>composer install</code>
* In new terminal navigate to front-end folder, Install the required packages using the command:<br><code>npm i</code>
* Create mySQL schema.
* Make a copy of the <code>.env.example</code> and rename the copy to <code>.env</code> in back-end folder.
* Enter the mySQL credentials in the <code>.env</code> file. (DB_DATABASE, DB_USERNAME, DB_PASSWOR)
* Run migrations and seed the database by using the command in back-end folder:<br><code>php artisan migrate:fresh --seed</code>
* Start the back-end server by using the command in back-end directory:<br><comand>php -S localhost:8000</comand>
* Start the front-end server in another terminal by using the command in front-end directory:<br><comand>npm run dev</comand>
* Test the website (admin email: <code>admin@example.com</code> password: <code>password</code>)
