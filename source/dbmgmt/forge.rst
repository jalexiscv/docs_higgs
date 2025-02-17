###############################
Clase de forja de base de datos
###############################

La clase Database Forge contiene métodos que le ayudarán a gestionar su
base de datos.

.. contents::
    :local:
    :depth: 2


Inicializando la clase Forge
****************************

.. important:: In order to initialize the Forge class, your database
    El controlador ya debe estar ejecutándose, ya que la clase Forge depende de él.

Cargue la clase Forge de la siguiente manera:

.. literalinclude:: forge/001.php

También puede pasar otro nombre de grupo de base de datos al cargador DB Forge, en caso de que
la base de datos que desea administrar no es la predeterminada:

.. literalinclude:: forge/002.php

En el ejemplo anterior, pasamos el nombre de un grupo de base de datos diferente.
al que conectarse como primer parámetro.


Crear y eliminar bases de datos
*******************************

$forge->createDatabase('db_name')
=================================

Le permite crear la base de datos especificada en el primer parámetro.
Devuelve verdadero/falso según el éxito o el fracaso:

.. literalinclude:: forge/003.php

Un segundo parámetro opcional establecido en verdadero agregará la declaración ``SI EXISTE``
o comprobará si existe una base de datos antes de crearla (dependiendo del DBMS).

.. literalinclude:: forge/004.php

$forge->dropDatabase('db_name')
===============================

Le permite eliminar la base de datos especificada en el primer parámetro.
Devuelve verdadero/falso según el éxito o el fracaso:

.. literalinclude:: forge/005.php

Crear bases de datos en la línea de comando
===========================================

Higgs admite la creación de bases de datos directamente desde su terminal favorito utilizando el ``db:create`` dedicado.
dominio. Al utilizar este comando se supone que la base de datos aún no existe. De lo contrario, Higgs
se quejará de que la creación de la base de datos ha fallado.

Para comenzar, simplemente escriba el comando y el nombre de la base de datos (por ejemplo, ``foo``):

.. code-block:: console

    php spark db: crear foo

Si todo salió bien, deberías esperar que se muestre el mensaje ``Base de datos "foo" creada exitosamente''.

Si está en un entorno de prueba o está utilizando el controlador SQLite3, puede pasar la extensión del archivo
para el archivo donde se creará la base de datos usando la opción ``--ext``. Los valores válidos son ``db`` y
``sqlite`` y por defecto es ``db``. Recuerde que estos no deben ir precedidos de un punto.
:

.. code-block:: console

    php spark db: crear foo --ext sqlite

El comando anterior creará el archivo db en **WRITEPATH/foo.sqlite**.

.. note:: When using the special SQLite3 database name ``:memory:``, expect that the command will still
    produce un mensaje de éxito pero no se crea ningún archivo de base de datos. Esto se debe a que SQLite3 simplemente usará
    una base de datos en memoria.


Crear tablas
************

Hay varias cosas que quizás desee hacer al crear tablas. Agregar
campos, agregar claves a la tabla, modificar columnas. Higgs proporciona una
mecanismo para ello.

.. _adding-fields:

Agregar campos
==============

$forjar->addField()
------------------

Los campos normalmente se crean mediante una matriz asociativa. Dentro de la matriz, debes
incluya una clave ``tipo`` que se relacione con el tipo de datos del campo.

Por ejemplo, ``INT``, ``VARCHAR``, ``TEXT``, etc.
Muchos tipos de datos (por ejemplo, ``VARCHAR``) también requieren una clave ``constraint``.

.. literalinclude:: forge/006.php

Además, se pueden utilizar las siguientes claves/valores:

- ``unsigned``/true: para generar ``UNSIGNED`` en la definición del campo.
- ``default``/value: para generar la restricción ``DEFAULT`` en la definición del campo.
- ``null``/true: para generar ``NULL`` en la definición del campo. Sin esto,
   el campo por defecto será ``NO NULO``.
- ``auto_increment``/true: genera un indicador de auto_increment en el
   campo. Tenga en cuenta que el tipo de campo debe ser un tipo que admita esto,
   como por ejemplo ``INTEGER``.
- ``unique``/true: para generar una clave única para la definición del campo.

.. literalinclude:: forge/007.php

Una vez definidos los campos, se pueden agregar usando
``$forge->addField($fields)`` seguido de una llamada al
:ref:`crearTabla()<creating-a-table>` método.

Notas sobre tipos de datos
-------------------

Tipos de punto flotante
^^^^^^^^^^^^^^^^^^^^^^^

Los tipos de punto flotante como ``FLOAT`` y ``DOUBLE`` representan valores aproximados.
Por lo tanto, no deben usarse cuando se necesitan valores exactos.

::

    mysql> CREAR TABLA t (f FLOAT, d DOBLE);
    mysql> INSERTAR EN t VALORES (99.9, 99.9);

    mysql> SELECCIONAR * DESDE t DONDE f=99.9;
    Conjunto vacío (0,00 seg)

    mysql> SELECCIONE * DESDE t DONDE f > 99.89 Y f < 99.91;
    +------+------+
    | f | re |
    +------+------+
    | 99,9 | 99,9 |
    +------+------+
    1 fila en conjunto (0,01 seg)

Cuando es importante preservar la precisión exacta, por ejemplo con datos monetarios,
Se debe utilizar ``DECIMAL`` o ``NUMERIC``.

TEXTO
^^^^^

``TEXT`` no debe usarse en SQLSRV. Está en desuso.
Consulte `ntext, texto e imagen (Transact-SQL) - SQL Server | Microsoft aprende <https://learn.microsoft.com/en-us/sql/t-sql/data-types/ntext-text-and-image-transact-sql?view=sql-server-ver16>` _.

.. _forge-addfield-default-value-rawsql:

Cadenas SQL sin formato como valores predeterminados
---------------------------------

.. versionadded:: 4.2.0

Desde v7.2.0, ``$forge->addField()`` acepta una instancia ``Higgs\Database\RawSql``, que expresa cadenas SQL sin formato.

.. literalinclude:: forge/027.php

.. warning:: When you use ``RawSql``, you MUST escape the data manually. Failure to do so could result in SQL injections.

Pasar cadenas como campos
-------------------------

Si sabe exactamente cómo desea que se cree un campo, puede pasar el
cadena en las definiciones de campo con ``addField()``:

.. literalinclude:: forge/008.php

.. note:: Passing raw strings as fields cannot be followed by ``addKey()`` calls on those fields.

.. note:: Multiple calls to ``addField()`` are cumulative.

Creando un campo de identificación
--------------------

Existe una excepción especial para la creación de campos de identificación. Un campo con tipo
La identificación se asignará automáticamente como INT(9) auto_incrementing
Clave primaria.

.. literalinclude:: forge/009.php

.. _adding-keys:

Agregar claves
==============

$forjar->addKey()
----------------

En términos generales, querrás que tu mesa tenga claves. Esto es
logrado con ``$forge->addKey('field')``. El segundo opcional
El parámetro establecido en verdadero lo convertirá en una clave principal y la tercera.
El parámetro establecido en verdadero lo convertirá en una clave única. Puedes especificar un nombre
con el cuarto parámetro. Tenga en cuenta que ``addKey()`` debe ir seguido de un
llamada a ``createTable()`` o ``processIndexes()`` cuando la tabla ya
existe.

Se deben enviar claves no principales de varias columnas como una matriz. Salida de muestra
a continuación es para MySQL.

.. literalinclude:: forge/010.php

$forjar->addPrimaryKey()
-----------------------

$forjar->addUniqueKey()
----------------------

Para hacer que la lectura del código sea más objetiva, también es posible agregar elementos primarios.
y claves únicas con métodos específicos:

.. literalinclude:: forge/011.php

.. note:: When you add a primary key, MySQL and SQLite will assume the name ``PRIMARY`` even if a name is provided.

.. _adding-foreign-keys:

Agregar claves externas
=======================

Las claves externas ayudan a imponer relaciones y acciones en sus tablas. Para tablas que admiten claves externas,
puedes agregarlos directamente en Forge:

.. literalinclude:: forge/012.php

Puede especificar la acción deseada para las propiedades "al actualizar" y "al eliminar" de la restricción, así como el nombre:

.. literalinclude:: forge/013.php

.. note:: SQLite3 does not support the naming of foreign keys. Higgs will refer to them by ``prefix_table_column_foreign``.

.. _creating-a-table:

Creando una tabla
=================

Una vez declarados los campos y las claves, puede crear una nueva tabla
con

.. literalinclude:: forge/014.php

Un segundo parámetro opcional establecido en verdadero creará la tabla solo si aún no existe.

.. literalinclude:: forge/015.php

También puedes pasar atributos de tabla opcionales, como ``ENGINE`` de MySQL:

.. literalinclude:: forge/016.php

.. note:: Unless you specify the ``CHARACTER SET`` and/or ``COLLATE`` attributes,
    ``createTable()`` siempre los agregará con su *juego de caracteres* configurado
    y valores *DBCollat*, siempre y cuando no estén vacíos (sólo MySQL).


Mesas de caída
**************

Dejar caer una mesa
===================

Ejecute una instrucción ``DROP TABLE`` y opcionalmente agregue una cláusula ``IF EXISTS``.

.. literalinclude:: forge/017.php

Se puede pasar un tercer parámetro para agregar una opción ``CASCADE``, que podría ser necesaria para algunos
controladores para manejar la eliminación de tablas con claves externas.

.. literalinclude:: forge/018.php


Modificar tablas
****************

Agregar un campo a una tabla
============================

$forjar->addColumn()
-------------------

El método ``addColumn()`` se utiliza para modificar una tabla existente. Él
acepta la misma matriz de campos que :ref:`Creando tablas<adding-fields>` , y puede
utilizarse para agregar campos adicionales.

.. note:: Unlike when creating a table, if ``null`` is not specified, the column
    será ``NULL``, no ``NOT NULL``.

.. literalinclude:: forge/022.php

Si está utilizando MySQL o CUBIRD, puede aprovechar sus
Cláusulas ``AFTER`` y ``FIRST`` para posicionar la nueva columna.

Ejemplos:

.. literalinclude:: forge/023.php

Eliminar campos de una tabla
============================

.. _db-forge-dropColumn:

$forjar->dropColumn()
--------------------

Se utiliza para eliminar una columna de una tabla.

.. literalinclude:: forge/024.php

Se utiliza para eliminar varias columnas de una tabla.

.. literalinclude:: forge/025.php

Modificar un campo en una tabla
===============================

.. _db-forge-modifyColumn:

$forjar->modificarColumna()
----------------------

El uso de este método es idéntico a ``addColumn()``, excepto que
modifica una columna existente en lugar de agregar una nueva. Con el fin de
cambiar el nombre, puede agregar una clave de "nombre" en la matriz que define el campo.

.. literalinclude:: forge/026.php

.. note:: The ``modifyColumn()`` may unexpectedly change ``NULL``/``NOT NULL``.
    Por lo tanto, se recomienda especificar siempre el valor de la clave "nula". A diferencia de cuando se crea
    una tabla, si no se especifica ``null``, la columna será ``NULL``, no
    ``NO NULO``.

.. note:: Due to a bug, prior v7.3.4, SQLite3 may not set ``NOT NULL`` even if you
    especifique ``'nulo' => falso``.

.. note:: Due to a bug, prior v7.3.4, Postgres and SQLSRV set ``NOT NULL`` even
    si especifica ``'null' => true``.

.. _db-forge-adding-keys-to-a-table:

Agregar claves a una tabla
==========================

.. versionadded:: 7.0.0

Puede agregar claves a una tabla existente usando ``addKey()``, ``addPrimaryKey()``,
``addUniqueKey()`` o ``addForeignKey()`` y ``processIndexes()``:

.. literalinclude:: forge/029.php

.. _dropping-a-primary-key:

Dejar caer una clave principal
==============================

.. versionadded:: 7.0.0

Ejecute DROP PRIMARY KEY.

.. literalinclude:: forge/028.php

Dejando caer una llave
======================

Ejecute una TECLA SOLTAR.

.. literalinclude:: forge/020.php

Dejar caer una clave externa
============================

Ejecute una SOLTAR LLAVE EXTRANJERA.

.. literalinclude:: forge/019.php

Cambiar el nombre de una tabla
==============================

Ejecuta un cambio de nombre de TABLA

.. literalinclude:: forge/021.php


Referencia de clase
*******************

.. php:namespace:: Higgs\Database

.. php:class:: Forge

    .. php:method:: addColumn($table[, $field = []])

        :param  string $table: nombre de la tabla a la que agregar la columna
        :param array $campo: Definición(es) de columna
        :returns: verdadero en caso de éxito, falso en caso de error
        :rtype: booleano

        Agrega una columna a una tabla existente. Uso: consulte `Agregar un campo a una tabla`_.

    .. php:method:: addField($field)

        :param array $campo: definición de campo para agregar
        :devuelve: instancia ``\Higgs\Database\Forge`` (encadenamiento de métodos)
        :rtype: ``\Higgs\Database\Forge``

        Agrega un campo al conjunto que se utilizará para crear una tabla. Uso: Consulte `Agregar campos`_.

    .. php:method:: addForeignKey($fieldName, $tableName, $tableField[, $onUpdate = '', $onDelete = '', $fkName = ''])

        :param string|string[] $fieldName: Nombre de un campo clave o una matriz de campos
        :param string $tableName: Nombre de una tabla principal
        :param string|string[] $tableField: Nombre de un campo de la tabla principal o una matriz de campos
        :param  string $onUpdate: acción deseada para "al actualizar"
        :param string $onDelete: acción deseada para "al eliminar"
        :param string $fkName: Nombre de la clave externa. Esto no funciona con SQLite3
        :devuelve: instancia ``\Higgs\Database\Forge`` (encadenamiento de métodos)
        :rtype: ``\Higgs\Database\Forge``

        Agrega una clave externa al conjunto que se utilizará para crear una tabla. Uso: Consulte `Agregar claves externas`_.

        .. note:: ``$fkName`` can be used since v7.3.0.

    .. php:method:: addKey($key[, $primary = false[, $unique = false[, $keyName = '']]])

        :param mixed $key: Nombre de un campo clave o una matriz de campos
        :param bool $primary: se establece en verdadero si debe ser una clave principal o una normal
        :param bool $unique: se establece en verdadero si debe ser una clave única o normal
        :param string $keyName: nombre de la clave que se agregará
        :devuelve: instancia ``\Higgs\Database\Forge`` (encadenamiento de métodos)
        :rtype: ``\Higgs\Database\Forge``

        Agrega una clave al conjunto que se utilizará para crear una tabla. Uso: Consulte `Agregar claves`_.

        .. note:: ``$keyName`` can be used since v7.3.0.

    .. php:method:: addPrimaryKey($key[, $keyName = ''])

        :param mixed $key: Nombre de un campo clave o una matriz de campos
        :param string $keyName: nombre de la clave que se agregará
        :devuelve: instancia ``\Higgs\Database\Forge`` (encadenamiento de métodos)
        :rtype: ``\Higgs\Database\Forge``

        Agrega una clave principal al conjunto que se utilizará para crear una tabla. Uso: Consulte `Agregar claves`_.

        .. note:: ``$keyName`` can be used since v7.3.0.

    .. php:method:: addUniqueKey($key[, $keyName = ''])

        :param mixed $key: Nombre de un campo clave o una matriz de campos
        :param string $keyName: nombre de la clave que se agregará
        :devuelve: instancia ``\Higgs\Database\Forge`` (encadenamiento de métodos)
        :rtype: ``\Higgs\Database\Forge``

        Agrega una clave única al conjunto que se utilizará para crear una tabla. Uso: Consulte `Agregar claves`_.

        .. note:: ``$keyName`` can be used since v7.3.0.

    .. php:method:: createDatabase($dbName[, $ifNotExists = false])

        :param string $db_name: Nombre de la base de datos a crear
        :param  string $ifNotExists: establezca en verdadero para agregar una cláusula ``SI NO EXISTE`` o verificar si la base de datos existe
        :returns: verdadero en caso de éxito, falso en caso de error
        :rtype: booleano

        Crea una nueva base de datos. Uso: Consulte `Creación y eliminación de bases de datos`_.

    .. php:method:: createTable($table[, $if_not_exists = false[, array $attributes = []]])

        :param string $table: Nombre de la tabla a crear
        :param  string $if_not_exists: configúrelo en verdadero para agregar una cláusula ``SI NO EXISTE``
        :param string $attributes: una matriz asociativa de atributos de tabla
        :returns: objeto de consulta en caso de éxito, falso en caso de error
        :rtype: mixto

        Crea una nueva tabla. Uso: Consulte `Creación de una tabla`_.

    .. php:method:: dropColumn($table, $column_name)

        :param  string $table: nombre de la tabla
        :param mixed $column_names: cadena delimitada por comas o una matriz de nombres de columnas
        :returns: verdadero en caso de éxito, falso en caso de error
        :rtype: booleano

        Elimina una o varias columnas de una tabla. Uso: Consulte `Eliminar campos de una tabla`_.

    .. php:method:: dropDatabase($dbName)

        :param string $dbName: nombre de la base de datos que se eliminará
        :returns: verdadero en caso de éxito, falso en caso de error
        :rtype: booleano

        Elimina una base de datos. Uso: Consulte `Creación y eliminación de bases de datos`_.

    .. php:method:: dropKey($table, $keyName[, $prefixKeyName = true])

        :param string $table: Nombre de la tabla que tiene clave
        :param string $keyName: nombre de la clave que se eliminará
        :param string $prefixKeyName: si el prefijo de la base de datos debe agregarse a ``$keyName``
        :returns: verdadero en caso de éxito, falso en caso de error
        :rtype: booleano

        Elimina un índice o índice único.

        .. note:: ``$keyName`` and ``$prefixKeyName`` can be used since v7.3.0.

    .. php:method:: dropPrimaryKey($table[, $keyName = ''])

        :param  string $table: nombre de la tabla para eliminar la clave principal
        :param  string $keyName: nombre de la clave principal que se eliminará
        :returns: verdadero en caso de éxito, falso en caso de error
        :rtype: booleano

        Elimina una clave principal de una tabla.

        .. note:: ``$keyName`` can be used since v7.3.0.

    .. php:method:: dropTable($table_name[, $if_exists = false])

        :param string $table: Nombre de la tabla a eliminar
        :param  string $if_exists: Establecer en verdadero para agregar una cláusula ``SI EXISTE``
        :returns: verdadero en caso de éxito, falso en caso de error
        :rtype: booleano

        Deja caer una mesa. Uso: Consulte `Dejar caer una mesa`_.

    .. php:method:: processIndexes($table)

        .. versionadded:: 7.0.0

        :param string $table: Nombre de la tabla a la que agregar índices
        :returns: verdadero en caso de éxito, falso en caso de error
        :rtype: booleano

        Se utiliza después de ``addKey()``, ``addPrimaryKey()``, ``addUniqueKey()``,
        y ``addForeignKey()`` para agregar índices a una tabla existente.
        Consulte `Agregar claves a una tabla`_.

    .. php:method:: modifyColumn($table, $field)

        :param  string $table: nombre de la tabla
        :param array $campo: Definición(es) de columna
        :returns: verdadero en caso de éxito, falso en caso de error
        :rtype: booleano

        Modifica una columna de la tabla. Uso: Consulte `Modificación de un campo en una tabla`_.

    .. php:method:: renameTable($table_name, $new_table_name)

        :param  strings $table: Actual de la tabla
        :param string $new_table_name: Nuevo nombre de la tabla
        :returns: objeto de consulta en caso de éxito, falso en caso de error
        :rtype: mixto

        Cambia el nombre de una tabla. Uso: Consulte `Cambiar el nombre de una tabla`_.
