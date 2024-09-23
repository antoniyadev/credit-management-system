<h1 align="center">Welcome to Credits Management Project 👋</h1>
<p>
</p>

> This is a small project for managing credits. Users can view, create, and add payments to their credits.
![Screenshot from 2024-09-23 09-16-38](https://github.com/user-attachments/assets/38c1e1c1-04ad-4176-900e-ab5087b4fa68)
>
![Screenshot from 2024-09-23 21-02-57](https://github.com/user-attachments/assets/eab3ebae-cab9-4743-bc36-6f91353fa783)




## Install

- Clone this repository locally: ```git clone git@github.com:antoniyadev/credits-management-project.git```
- Copy the .env.example file to .env
- Install the PHP dependencies: ```composer install```
- Generate a new app key: ```php artisan key:generate```
- Prepare the database: ```php artisan migrate --seed```
- Install and compile the front-end dependencies: ```npm install && npm run build```
- Set a valid APP_URL, DB_DATABASE, DB_USERNAME, DB_PASSWORD value in your .env file
- Serve the website locally: ```php artisan serve```

## Run tests

For Unit and Feature tests set your .env.testing file and run:
```sh
php artisan test
```

For browser tests set .env.dusk.testing file and run:
```sh
php artisan dusk
```

## Author

👤 **Antoniya**

* Website: https://antoniyadev.github.io
* Github: [@antoniyadev](https://github.com/antoniyadev)

## Show your support

Give a ⭐️ if this project helped you!

***
_This README was generated with ❤️ by [readme-md-generator](https://github.com/kefranabg/readme-md-generator)_
