############################
Métodos de ayuda de consulta
############################

.. contents::
    :local:
    :depth: 2

Información de la ejecución de una consulta
*******************************************

$db->insertarID()
=================

El número de ID de inserción al realizar inserciones en bases de datos.

.. note:: If using the PDO driver with PostgreSQL, or using the Interbase
    controlador, esta función requiere un parámetro $name, que especifica el
    secuencia apropiada para verificar la identificación de inserción.

$db->filas afectadas()
======================

Muestra el número de filas afectadas, al realizar consultas de tipo "escritura"
(insertar, actualizar, etc.).

.. note:: In MySQL "DELETE FROM TABLE" returns 0 affected rows. The database
    La clase tiene un pequeño truco que le permite devolver el número correcto de
    filas afectadas. De forma predeterminada, este truco está habilitado pero se puede desactivar.
    en el archivo del controlador de la base de datos.

$db->getLastQuery()
===================

Devuelve un objeto Query que representa la última consulta ejecutada (la cadena de consulta, no el resultado).

Información sobre su base de datos
**********************************

$db->contarTodo()
=================

Le permite determinar el número de filas en una tabla en particular.
Envíe el nombre de la tabla en el primer parámetro. Esto es parte del Generador de consultas.
Ejemplo:

.. literalinclude:: helpers/001.php

$db->countAllResults()
======================

Le permite determinar el número de filas en un conjunto de resultados particular.
Envíe el nombre de la tabla en el primer parámetro. Esto es parte del Generador de consultas.
Ejemplo:

.. literalinclude:: helpers/002.php

$db->getPlataforma()
====================

Genera la plataforma de base de datos (DBDriver) que está ejecutando (MySQLi, SQLSRV, Postgre,
etc...):

.. literalinclude:: helpers/003.php

$db->getVersion()
=================

Genera la versión de la base de datos que está ejecutando:

.. literalinclude:: helpers/004.php
