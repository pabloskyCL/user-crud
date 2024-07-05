### Instrucciones para levantar el proyecto

* pre-requisito tener instalado docker y docker compose

copiar archivo .env.example  en la carpeta raiz y cambiar el nombre a .env

* luego modificar para que quede de esta manera	

```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:W5tFk7d5Nq9MIdOLvDmuMr+Uh745T9ITMTGHz27W0LQ=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
```

clonar repositorio front end https://github.com/pabloskyCL/user-crud-front/tree/pablo-quiroz en la raiz

* una vez clonado cambiar el nombre de la carpeta resultante a "frontend"

levantar los contenedores con docker compose up -d 

una vez levantado los contenedores ingresar al contenedor user-crud-api

* docker exec -it user-crud-api bash

instalar dependencias con composer install

luego ingresar a la carpeta frontend y lanzar npm install y npm run build



