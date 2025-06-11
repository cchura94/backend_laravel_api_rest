## Migraciones y Models

```
php artisan make:migration create_personas_table
php artisan make:model Persona
```

```
php artisan make:Role -m
php artisan make:migration create_role_user_table
```

```
php artisan make:Permiso -m
php artisan make:migration create_permiso_role_table
```

````
php artisan make:model Sucursal -m
php artisan make:migration create_sucursal_user_table
```

```
php artisan make:model Almacen -m
```
```
php artisan make:model Categoria -m
php artisan make:model Producto -m
php artisan make:migration create_almacen_producto_table
```

```
php artisan make:model EntidadComercial -m

php artisan make:model Nota -m
```
```
php artisan make:migration create_movimiento_table
```