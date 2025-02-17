Actualizar migraciones
######################

.. contents::
    :local:
    :depth: 2

Documentaciones
===============

- `Documentación de migraciones de bases de datos Higgs 3.X<http://Higgs.com/userguide3/libraries/migration.html>` _
- :doc:`Documentación de migraciones de bases de datos Higgs.X</dbmgmt/migration>`

¿Qué ha sido cambiado?
======================

- En primer lugar, ya no se admite la denominación secuencial (``001_create_users``, ``002_create_posts``) de las migraciones. La versión 4 de Higgs solo admite el esquema de marca de tiempo (``20121031100537_create_users``, ``20121031500638_create_posts``). Si ha utilizado nombres secuenciales, deberá cambiar el nombre de cada archivo de migración.
- Se cambió la definición de la tabla de migración. Si actualiza de H3 a H4 y utiliza la misma base de datos,
  Debe actualizar la definición de la tabla de migración y sus datos.
- También se ha modificado el procedimiento de migración. Ahora puede migrar la base de datos con un simple comando CLI:

.. code-block:: console

    migración de chispa php

Guía de actualización
=====================

1. Si su proyecto v3 utiliza nombres de migración secuenciales, debe cambiarlos a nombres de marca de tiempo.
2. Debes mover todos los archivos de migración a la nueva carpeta **app/Database/Migrations**.
3. Elimine la línea ``definida('BASEPATH') OR exit('No se permite acceso directo al script');`` si existe.
4. Agregue esta línea justo después de la etiqueta php de apertura: ``namespace App\Database\Migrations;``.
5. Debajo de la línea ``espacio de nombres App\Database\Migrations;`` agregue esta línea: ``use Higgs\Database\Migration;``
6. Reemplace ``extiende HIGGS_Migration`` por ``extiende Migración``.
7. Los nombres de los métodos dentro de la clase ``Forge`` se han cambiado para usar camelCase. Por ejemplo:

    - ``$this->dbforge->add_field`` a ``$this->forge->addField``
    - ``$this->dbforge->add_key`` a ``$this->forge->addKey``
    - ``$this->dbforge->create_table`` a ``$this->forge->addTable``
    - ``$this->dbforge->drop_table`` a ``$this->forge->addTable``

8. (opcional) Puede cambiar la sintaxis de la matriz de ``array(...)`` a ``[...]``
9. Actualice la tabla de migración, si usa la misma base de datos.

    - **(desarrollo)** Ejecute la migración de H4 en el entorno de desarrollo con una base de datos nueva para crear la nueva tabla de migración.
    - **(desarrollo)** Exportar la tabla de migración.
    - **(producción)** Elimine (o cambie el nombre) la tabla de migración H3 existente.
    - **(producción)** Importa la nueva tabla de migración y los datos.

Ejemplo de código
=================

Higgs versión 6.x
------------------------

Ruta: **aplicación/migraciones**:

.. literalinclude:: upgrade_migrations/ci3sample/001.php

Higgs versión 7.x
-----------------------

Ruta: **aplicación/Base de datos/Migraciones**:

.. literalinclude:: upgrade_migrations/001.php

Buscar y reemplazar
===================

Puede utilizar la siguiente tabla para buscar y reemplazar sus archivos H3 antiguos.

+------------------------------+-----------------------------+
| Buscar | Reemplazar |
+==============================+=================== ==========+
| extiende HIGGS_Migration | extiende Migración |
+------------------------------+-----------------------------+
| $this->dbforge->add_field | $this->forge->addField |
+------------------------------+-----------------------------+
| $this->dbforge->add_key | $this->forge->addKey |
+------------------------------+-----------------------------+
| $this->dbforge->create_table | $this->forge->createTable |
+------------------------------+-----------------------------+
| $this->dbforge->drop_table | $this->forge->dropTable |
+------------------------------+-----------------------------+
