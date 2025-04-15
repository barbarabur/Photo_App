<?php
//se colocan en la ruta routes/api cuando hacemos un controlador para llamar al método desde la api externa o el navegador.

1️⃣ GET - Obtener Datos
📌 Se usa para consultar información sin modificar nada en la base de datos.
✅ Ejemplo en Laravel:


Route::get('/adventure/{id}', [AdventureControllerApi::class, 'show']);

✅ Uso típico:

Obtener detalles de una aventura (show())
Listar todas las aventuras (index())

2️⃣ POST - Crear un Nuevo Recurso
📌 Se usa para crear un nuevo registro en la base de datos.
✅ Ejemplo en Laravel:

Route::post('/adventure', [AdventureControllerApi::class, 'store']);
✅ Uso típico:

Crear una nueva aventura (store())
Registrar un usuario

3️⃣ PUT - Actualizar un Recurso (Reemplazo Completo)
📌 Se usa para actualizar un recurso existente en su totalidad.
✅ Ejemplo en Laravel:

Route::put('/adventure/{id}', [AdventureControllerApi::class, 'update']);
✅ Uso típico:

Modificar todos los campos de una aventura (update())

4️⃣ PATCH - Actualizar un Recurso Parcialmente
📌 Se usa para modificar parcialmente un recurso.
✅ Ejemplo en Laravel:


Route::patch('/adventure/{id}', [AdventureControllerApi::class, 'update']);
✅ Uso típico:

Cambiar solo el nombre o la descripción de una aventura
Modificar solo un estado sin tocar otros datos

📌 Diferencia entre PUT y PATCH
 
PUT reemplaza todo el recurso.
PATCH solo actualiza los campos enviados en la solicitud.

5️⃣ DELETE - Eliminar un Recurso
📌 Se usa para eliminar un registro de la base de datos.
✅ Ejemplo en Laravel:

Route::delete('/adventure/{id}', [AdventureControllerApi::class, 'destroy']);
✅ Uso típico:

Borrar una aventura (destroy())
Eliminar un usuario