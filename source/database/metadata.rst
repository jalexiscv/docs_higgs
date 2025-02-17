#############################
Metadatos de la base de datos
#############################

.. contents::
    :local:
    :depth: 2


Metadatos de tabla
******************

Estas funciones le permiten recuperar información de la tabla.

Enumere las tablas en su base de datos
======================================

$db->listaTablas()
-----------------

Devuelve una matriz que contiene los nombres de todas las tablas de la base de datos.
al que estás conectado actualmente. Ejemplo:

.. literalinclude:: metadata/001.php

.. note:: Some drivers have additional system tables that are excluded from this return.

Determinar si existe una tabla
==============================

$db->tableExists()
------------------

A veces es útil saber si una tabla en particular existe antes
realizando una operación sobre él. Devuelve un valor booleano verdadero/falso. Ejemplo de uso:

.. literalinclude:: metadata/002.php

.. note:: Replace *table_name* with the name of the table you are looking for.


Metadatos de campo
******************

Enumerar los campos en una tabla
================================

$db->getFieldNames()
--------------------

Devuelve una matriz que contiene los nombres de los campos. Esta consulta se puede llamar
dos caminos:

1. Puede proporcionar el nombre de la tabla y llamarla desde ``$db->object``:

   .. literalinclude:: metadata/003.php

2. Puede recopilar los nombres de los campos asociados con cualquier consulta que ejecute
llamando a la función desde el objeto de resultado de su consulta:

.. literalinclude:: metadata/004.php

Determinar si un campo está presente en una tabla
=================================================

$db->fieldExists()
------------------

A veces es útil saber si un campo en particular existe antes
realizando una acción. Devuelve un valor booleano verdadero/falso. Ejemplo de uso:

.. literalinclude:: metadata/005.php

.. note:: Replace *field_name* with the name of the column you are looking
    para y reemplace *table_name* con el nombre de la tabla que está
    Buscando.

Recuperar metadatos de campo
============================

.. _db-metadata-getfielddata:

$db->getFieldData()
-------------------

Devuelve una matriz de objetos que contienen información de campo.

A veces es útil recopilar los nombres de los campos u otros metadatos, como
el tipo de columna, longitud máxima, etc.

.. note:: Not all databases provide meta-data.

Ejemplo de uso:

.. literalinclude:: metadata/006.php

Los siguientes datos están disponibles en esta función si son compatibles con su
base de datos:

- ``nombre`` - nombre de la columna
- ``tipo`` - el tipo de columna
- ``max_length`` - longitud máxima de la columna
- ``nullable`` - booleano ``true`` si la columna admite valores NULL, en caso contrario booleano ``false``
- ``default`` - el valor predeterminado
- ``primary_key`` - entero ``1`` si la columna es una clave primaria (todo entero ``1``, incluso si hay varias claves primarias), en caso contrario, entero ``0`` (este campo está actualmente sólo disponible para ``MySQLi`` y ``SQLite3``)

.. note:: Since v7.(d+).(d+), SQLSRV supported ``nullable``.

$consulta->getFieldData()
----------------------

Si ya ha ejecutado una consulta, puede utilizar el objeto de resultado en lugar de
proporcionando el nombre de la tabla:

.. literalinclude:: metadata/007.php

.. note:: The data returned is different from the data from ``$db->getFieldData()``.
    Si no puede obtener los datos que necesita, utilice ``$db->getFieldData()``.

Enumere los índices en una tabla
================================

.. _db-metadata-getindexdata:

$db->getIndexData()
-------------------

Devuelve una matriz de objetos que contienen información de índice.

Ejemplo de uso:

.. literalinclude:: metadata/008.php

Los tipos de claves pueden ser exclusivos de la base de datos que esté utilizando.
Por ejemplo, MySQL devolverá uno de los siguientes: primario, de texto completo, espacial, de índice o único.
para cada clave asociada con una tabla.

SQLite3 devuelve un pseudoíndice llamado ``PRIMARY``. Pero es un índice especial y no puede usarlo en sus comandos SQL.

.. _metadata-getforeignkeydata:

$db->getForeignKeyData()
------------------------

Devuelve una matriz de objetos que contienen información de clave externa.

Ejemplo de uso:

.. literalinclude:: metadata/009.php

Las claves externas utilizan la convención de nomenclatura ``tableprefix_table_column1_column2_foreign``. Oracle usa un sufijo ligeramente diferente de ``_fk``.
