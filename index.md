## How to install IMRepo

* clone this repo 
```bash
git clone https://github.com/imokhles/imrepo
```
* change direction to IMRepo folder
```bash
cd imrepo
```
* copy .env.example to .env
```bash
cp .env.example .env
```
* update .env with your database info
```bash
DB_DATABASE=DB_NAME
DB_USERNAME=USERNAME
DB_PASSWORD=PASSWORD
```
* generate laravel key
```bash
php artisan key:generate
```
* install composer packages
```bash
composer update
```
* setup Backpack Base package
```bash
php artisan backpack:base:install
```
* setup Backpack Crud package ( NOTE: reply NO to don't install elfinder file manager (we don't need it) )
```bash
php artisan backpack:crud:install
```
* refresh your migrations 
```bash
php artisan migrate:refresh --force --seed
```
