#########################
Probando su base de datos
#########################

.. contents::
    :local:
    :depth: 2

La clase de prueba
******************

Para aprovechar las herramientas de base de datos integradas que Higgs proporciona para las pruebas, su
las pruebas deben extender ``CIUnitTestCase`` y usar ``DatabaseTestTrait``:

.. literalinclude:: database/001.php

Debido a que la funcionalidad especial se ejecuta durante las fases ``setUp()`` y ``tearDown()``, debe asegurarse
que llames a los métodos de los padres si necesitas usarlos, de lo contrario perderás mucho
de la funcionalidad aquí descrita:

.. literalinclude:: database/002.php

Configurar una base de datos de prueba
**************************************

Al ejecutar pruebas de bases de datos, debe proporcionar una base de datos que pueda usarse durante las pruebas. En lugar de
Al utilizar las funciones de base de datos integradas de PHPUnit, el marco proporciona herramientas específicas para Higgs. La primera
El siguiente paso es asegurarse de haber configurado un grupo de base de datos ``pruebas`` en **app/Config/Database.php**.
Esto especifica una conexión de base de datos que solo se usa mientras se ejecutan pruebas, para mantener seguros el resto de sus datos.

Si tiene varios desarrolladores en su equipo, es probable que desee mantener sus credenciales almacenadas en
el archivo **.env**. Para hacerlo, edite el archivo para asegurarse de que las siguientes líneas estén presentes y tengan el
Información correcta::

    base de datos.pruebas.nombre de host = host local
    base de datos.pruebas.base de datos = ci4_test
    base de datos.pruebas.nombre de usuario = raíz
    base de datos.pruebas.contraseña = raíz
    base de datos.pruebas.DBDriver = MySQLi
    base de datos.pruebas.DBPrefix =
    base de datos.pruebas.puerto = 3306

Migraciones y Semillas
======================

Al ejecutar pruebas, debe asegurarse de que su base de datos tenga configurado el esquema correcto y que
está en un estado conocido para cada prueba. Puede utilizar migraciones y semillas para configurar su base de datos,
agregando un par de propiedades de clase a su prueba.

.. literalinclude:: database/003.php

Migraciones
-----------

$migrar
^^^^^^^

Este valor booleano determina si la migración de la base de datos se ejecuta antes de la prueba.
De forma predeterminada, la base de datos siempre se migra al último estado disponible según lo definido en ``$namespace``.
Si es "falso", la migración nunca se ejecuta. Si desea deshabilitar la migración, establezca ``false``.

$migrarOnce
^^^^^^^^^^^

Este valor booleano determina si la migración de la base de datos se ejecuta solo una vez. Si quieres
para ejecutar la migración una vez antes de la primera prueba, establezca "verdadero". Si no está presente o es "falso", la migración
se ejecuta antes de cada prueba.

$actualizar
^^^^^^^^^^^

Este valor booleano determina si la base de datos se actualiza por completo antes de la prueba. Si es "verdadero",
todas las migraciones se revierten a la versión 0.

$ espacio de nombres
^^^^^^^^^^^^^^^^^^^^

De forma predeterminada, Higgs buscará en **tests/_support/Database/Migrations** para localizar las migraciones.
que debería ejecutarse durante la prueba. Puede cambiar esta ubicación especificando un nuevo espacio de nombres en las propiedades ``$namespace``.
Esto no debe incluir el subespacio de nombres **Base de datos\\Migraciones** sino solo el espacio de nombres base.

.. important:: If you set this property to ``null``, it runs migrations from all available namespaces like ``php spark migrate --all``.

Semillas
--------

$semilla
^^^^^^^^

Si está presente y no está vacío, especifica el nombre de un archivo semilla que se utiliza para llenar la base de datos con
datos de prueba antes de ejecutar la prueba.

$ semilla una vez
^^^^^^^^^^^^^^^^^

Este valor booleano determina si la inicialización de la base de datos se ejecuta solo una vez. Si quieres
para ejecutar la inicialización de la base de datos una vez antes de la primera prueba, establezca "true". Si no está presente o es "falso", inicialización de la base de datos
se ejecuta antes de cada prueba.

$rutabase
^^^^^^^^^

De forma predeterminada, Higgs buscará en **tests/_support/Database/Seeds** para localizar las semillas que debe ejecutar durante la prueba.
Puede cambiar este directorio especificando la propiedad ``$basePath``. Esto no debe incluir el directorio **Seeds**,
sino la ruta al directorio único que contiene el subdirectorio.

Métodos auxiliares
******************

La clase **DatabaseTestTrait** proporciona varios métodos auxiliares para ayudar a probar su base de datos.

Cambiar el estado de la base de datos
=====================================

base de datos de regresión ()
-----------------------------

Este método, llamado durante ``$refresh`` descrito anteriormente, está disponible si necesita restablecer la base de datos manualmente.

migrarBase de datos()
---------------------

Llamado durante ``setUp()``, este método está disponible si necesita ejecutar migraciones manualmente.

semilla($nombre)
----------------

Le permite cargar manualmente una semilla en la base de datos. El único parámetro es el nombre de la semilla a ejecutar. La semilla
debe estar presente dentro de la ruta especificada en ``$basePath``.

hasInDatabase($tabla, $datos)
------------------------------

Inserta una nueva fila en la base de datos. Esta fila se elimina después de que se ejecute la prueba actual. ``$data`` es un asociativo
Matriz con los datos a insertar en la tabla.

.. literalinclude:: database/007.php

Obtener datos de la base de datos
=================================

grabFromDatabase($tabla, $columna, $criterios)
----------------------------------------------

Devuelve el valor de ``$columna`` de la tabla especificada donde la fila coincide con ``$criterios``. Si más de uno
Si se encuentra una fila, solo devolverá la primera.

.. literalinclude:: database/006.php

Afirmaciones
============

dontSeeInDatabase($tabla, $criterios)
-------------------------------------

Afirma que una fila con criterios que coinciden con los pares clave/valor en ``$criteria`` NO existe en la base de datos.

.. literalinclude:: database/004.php

ver en la base de datos ($ tabla, $ criterios)
----------------------------------------------

Afirma que una fila con criterios que coinciden con los pares clave/valor en ``$criteria`` SÍ existe en la base de datos.

.. literalinclude:: database/005.php

verNumRecords($esperado, $tabla, $criterios)
--------------------------------------------

Afirma que se encuentran varias filas coincidentes en la base de datos que coinciden con ``$criteria``.

.. literalinclude:: database/008.php
