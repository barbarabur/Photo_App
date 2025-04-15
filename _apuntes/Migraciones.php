<?php
// *  Revertir la última migración
php artisan migrate:rollback

// revertir todas las migraciones
php artisan migrate:reset

//revertir y volver a ejecutar:
phtp artisan migrate:refresh


/**
 * La estructura básica te viene dada cuando lo haces a partir del modelo
 * o usas php artisan make:migration create_nombreTablaEnPlural_table
 * Primero las entidades independientes, luego las que dependen de otras, y finalmente las tablas pivote (N:M) y polimórficas.
 * 
 * 
 *  Si es polimórfica
 *  Revertir la última migración
 * 
 * Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('action_zone_id')->constrained('action_zones')->onDelete('cascade');
            $table->morphs('resourceable');
            $table->integer('quantity');
            $table->boolean('available');
            $table->timestamps();
            $table->primary(['action_id', 'building_id']);
        });


    Si no es polimórfica:

            $table->id();
            $table->foreignId('invention_type_id')->constrained('invention_types')->onDelete('cascade');
            $table->foreignId('material_id')->constrained('materials')->onDelete('cascade');
            $table->foreignId('inventory_id')->constrained('inventories')->onDelete('cascade');
            $table->foreignId('action_building_id')->constrained('action_buildings')->onDelete('cascade')->nullable();
            $table->foreignId('invention_created_id')->constrained('inventions')->onDelete('cascade')->nullable();
            $table->string('name');
            $table->float('efficiency');
            $table->boolean('available');
            $table->timestamps();
            $table->softDeletes();
 */
//clave ajena en tabla pivote:  Schema::create('user_adventures', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('users_id');
    $table->unsignedBigInteger('adventures_id');
    $table->foreign('users_id')->references ('id')->on ('users');
    $table->foreign('adventures_id')->references ('id')->on ('adventures');
    $table->timestamps();
        

