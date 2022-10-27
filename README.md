
# Terminal Scan Project

This Readme is taking into account that whomever clones the repo will already have a Linux server and MySQL database engine.

- Clone this project
- Go to the folder application using `cd` command on your cmd or terminal
- Run `composer install` on your cmd or terminal
- Copy .env.example file to .env on the root folder; `cp .env.example .env`
- Open your .env file and change the database name (DB_DATABASE) to whatever you have, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration.
- Run `php artisan key:generate`
- Run `php artisan migrate`
- Run `php artisan db:seed`
- Run `php artisan serve`

## How to run the application

This is fairly simple to run, using the product "SKUs" of A,B,C,D,E , you can pass any combinations of those SKUs into the command line with the `scanorder` option.  Below is some examples:

`php artisan terminal:pos --scanorder=BCDABEAAA`
- should yield a total of: $32.34

`php artisan terminal:pos --scanorder=CCCCCC`
- Should yield a total of: $6.60

`php artisan terminal:pos --scanorder=ABCD` 
- Should yield a total of: $14.74

`php artisan terminal:pos --scanorder=ABECDE`
- Should yield a total of: $16.94

## Example return

| SKU   | QTY   | SUBTOTAL  |
| ----  | ----  | ----      |
| A     | 1     | $2.00     |
| B     | 1     | $10.00    |
| E     | 2     | $2.00     |
| C     | 1     | $1.25     |
| D     | 1     | $0.15     |

| |
| ---- |
| Subtotal: $15.40 |
| Tax: $1.54 |
| Total: $16.94 |