# REST: Symfony5 + Api platform
* Бизнес-суть проекта: пользователь и его адреса. 
* Проект расширяемый. Можно использовать как основу. 

Installation:
============
```bash
git clone https://github.com/SergeyTimovkin/client2.git
```

```bash
cp .env.example .env
```

```bash
docker-compose build 
```

```bash
docker-compose up -d
```

```bash
docker exec -it php /bin/sh
```

```bash
composer install
```

```bash
cp .env.dist .env
```

##### DB init:
```bash
php bin/console doctrine:migrations:migrate
php bin/console app:insert-dump
```
##### Generate the SSH keys:
```bash
mkdir config/jwt
openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096 -pass pass:12345
openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
# Enter: 12345
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
  --url http://127.0.0.1:8080/authentication_token \
  --header 'Content-Type: application/json' \
  --data '{
	"email":"root@root.com",
	"password":"root"
}'
```

##### Проверка phpstan
```bash
 cd vendor/bin
 phpstan.bat analyse -c ..\..\phpstan.neon
```
##### Проверка phpunit
Дополнительно необходимо указать токен(TOKEN) тестового пользователя и тестируемый хост(host) в tests/BaseTest
```bash
 cd vendor/bin
 phpunit ..\..\tests
```

# Примеры запросов
* Получение всех адресов пользователя
```bash
curl --request GET \
  --url http://127.0.0.1:8080/api/user/address/ \
  --header 'token: *'
```
* Удаление адреса пользователя
```bash
curl --request DELETE \
  --url http://127.0.0.1:8000/api/user/address/3 \
  --header 'Content-Type: multipart/form-data; boundary=---011000010111000001101001' \
  --header 'token: *'
```
* Добавление пользователю адреса
```bash
curl --request POST \
  --url http://127.0.0.1:8080/api/user/address/ \
  --header 'Content-Type: multipart/form-data; boundary=---011000010111000001101001' \
  --header 'token: *' \
  --form homeId=2 \
  --form porch=4
```
* Обновление адреса пользователя
```bash
curl --request PUT \
  --url 'http://127.0.0.1:8080/api/user/address/5?homeId=2&porch=777' \
  --header 'Content-Type: multipart/form-data; boundary=---011000010111000001101001' \
  --header 'token: *'
```



