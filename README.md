# REST: Symfony5 + Api platform

### Requirements
  * PHP 7.4 or higher;
  * MySQL-5.7 or higher;

Installation:
============
```bash
$ git clone https://github.com/SergeyTimovkin/client2.git
$ composer install
```

##### ENV:
   * Duplicate **_.env.dist_ in _.env_** and  **_.env.local_**
   * edits **_.env.local->DATABASE_URL_**

##### DB create:
```bash
$ php bin/console doctrine:database:create
$ php bin/console doctrine:migrations:migrate
$ php bin/console app:insert-dump
```

##### Generate the SSH keys:
```bash
$ openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
> 12345
$ openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
> 12345
```
##### Server run:

```bash
$ php -S 127.0.0.1:8000 -t public
```

##### Generate Test-user:
###### *email: root@root.com*
###### *pass: root*
```bash
$  php bin/console app:create-root-user
```


##### Generate token: 
```bash
curl --request POST \
  --url http://127.0.0.1:8000/authentication_token \
  --header 'Content-Type: application/json' \
  --header 'Cookie: PHPSESSID=l899f8ivr2dpgc1mibb6jlbtqhof551u' \
  --cookie PHPSESSID=c8sfj28fhap92qv5sdksd73tmlg9k9rh \
  --data '{
	"email":"root@root.com",
	"password":"root"
}'
```
### Прочее
##### Очистка кеша
```bash
 php bin/console cache:clear
```
##### Проверка phpstan
```bash
 cd vendor/bin
 phpstan.bat analyse -c ..\..\phpstan.neon
```
##### Запуск тестов
```bash
 php bin/phpunit
```
# Примеры запросов
* Получение всех адресов пользователя
```bash
curl --request GET \
  --url http://127.0.0.1:8000/api/user/address/ \
  --header 'token: *' \
  --cookie PHPSESSID=p9bt7uuath634amlfkj7iaiegqgqrrhu
```
* Удаление адреса пользователя
```bash
curl --request DELETE \
  --url http://127.0.0.1:8000/api/user/address/3 \
  --header 'Content-Type: multipart/form-data; boundary=---011000010111000001101001' \
  --header 'token: *' \
  --cookie PHPSESSID=1sfdrvfd0ol55q3t45pu73cr7j4n3ktg
```
* Добавление пользователю адреса
```bash
curl --request POST \
  --url http://127.0.0.1:8000/api/user/address/ \
  --header 'Content-Type: multipart/form-data; boundary=---011000010111000001101001' \
  --header 'token: *' \
  --cookie PHPSESSID=1sfdrvfd0ol55q3t45pu73cr7j4n3ktg \
  --form homeId=2 \
  --form porch=4
```
* Обновление адреса пользователя
```bash
curl --request PUT \
  --url 'http://127.0.0.1:8000/api/user/address/5?homeId=2&porch=777' \
  --header 'Content-Type: multipart/form-data; boundary=---011000010111000001101001' \
  --header 'token: *' \
  --cookie PHPSESSID=1sfdrvfd0ol55q3t45pu73cr7j4n3ktg
```
##### Схема БД:
 **схема_бд.mwb**
# todo:
* доку open api
* юнит тесты
