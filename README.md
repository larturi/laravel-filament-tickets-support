# Tickets Support System | Laravel & Filament

## Local Mode

#### Crear el .env basado en .env.template y configuarar las variables de la base de datos MySql

```bash
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

#### Levantar los Contenedores con Docker Sail

```bash
./vendor/bin/sail up -d
```

#### Ejecutar Migraciones

```bash
./vendor/bin/sail artisan migrate:fresh --seed     

# Admin: admin@admin.com::password
# Agent: agent@agent.com::password
```

#### Generar un usuario con Filament

```bash
./vendor/bin/sail artisan make:filament-user
```

#### Entrar a <http://localhost/admin>

## Limpiar cache

``` bash
./vendor/bin/sail artisan config:cache
./vendor/bin/sail artisan route:cache
./vendor/bin/sail artisan view:cache
```

## Crear nuevos models

#### Crear model y migration

```bash
./vendor/bin/sail artisan make:model Ticket -m
```

#### Editar en el archivo de migration los campos

```bash
database/migrations/2025_03_01_140051_create_categories_table.php
```

#### Editar el Model con las relaciones y habilitar los campos para el formulario

```bash
app/models/Ticket.php

protected $fillable = ['name'];
```

#### Impactar en la BD

```bash
./vendor/bin/sail artisan migrate
```

#### Crear CRUD en Fillament

```bash
./vendor/bin/sail artisan make:filament-resource TicketResource
```

#### Crear Relation Manager en Fillament

```bash
 ./vendor/bin/sail artisan make:migration "create category_ticket table"
 
 ./vendor/bin/sail artisan migrate
 
 ./vendor/bin/sail artisan make:filament-relation-manager TicketResource categories name

 # Editar los dos models agregando la relacion

 # Category.php
public function tickets()
{
    return $this->belongsToMany(Ticket::class);
}

# Ticket.php
 public function categories()
{
    return $this->belongsToMany(Category::class);
}
 ```
