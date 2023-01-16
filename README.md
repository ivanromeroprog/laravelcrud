# Laravel CRUD

CRUD de Usuarios y Roles creado con Laravel 9.X.

## Instalación

* Clonar repositorio.
```
git clone https://github.com/ivanromeroprog/laravelcrud laravelcrud
cd laravelcrud
```

* Copiar archivo `.env`. Configurar base de datos en este archivo.
```
cp .env.example .env
```

* Instalar dependencias y compilar js/css.
```
composer install && npm install && npm run build
```

* Generar clave de aplicación
```
php artisan key:generate
```

* Migrar base de datos
```
php artisan migrate
```

* Ejecutar servidor local
```
php artisan serve
```

* Datos de acceso:
    * E-mail: superadmin@example.com
    * Contraseña: admin