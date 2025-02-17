###############################
Conectándose a su base de datos
###############################

.. contents::
    :local:
    :depth: 2

Conexión a una base de datos
============================

Conexión al grupo predeterminado
--------------------------------

Puede conectarse a su base de datos agregando esta línea de código en cualquier
función donde sea necesario, o en el constructor de su clase para hacer el
base de datos disponible globalmente en esa clase.

.. literalinclude:: connecting/001.php
    :lines: 2-

Si la función anterior **no** contiene ninguna información en el primer
parámetro, se conectará al grupo predeterminado especificado en la configuración de su base de datos
archivo. Para la mayoría de las personas, este es el método de uso preferido.

Existe un método de conveniencia que es puramente un resumen de la línea anterior.
y se proporciona para su comodidad:

.. literalinclude:: connecting/002.php
    :lines: 2-

Parámetros disponibles
----------------------

**\\Config\\Database::connect($group = null, bool $getShared = true): BaseConnection**

#. ``$group``: El nombre del grupo de la base de datos, una cadena que debe coincidir con el nombre de la propiedad de la clase de configuración. El valor predeterminado es ``Config\Database::$defaultGroup``.
#. ``$getShared``: verdadero/falso (booleano). Si se debe devolver la conexión compartida (consulte
   Conexión a múltiples bases de datos a continuación).

Conexión con un grupo específico
--------------------------------

El primer parámetro de esta función se puede utilizar **opcionalmente** para
especifique un grupo de base de datos particular desde su archivo de configuración. Ejemplos:

Para elegir un grupo específico de su archivo de configuración, puede hacer esto:

.. literalinclude:: connecting/003.php
    :lines: 2-

Donde ``group_name`` es el nombre del grupo de conexión de su configuración
archivo.

Múltiples conexiones a la misma Base de datos
---------------------------------------------

De forma predeterminada, el método ``connect()`` devolverá la misma instancia del
conexión de base de datos cada vez. Si necesita tener una conexión separada
a la misma base de datos, envíe ``false`` como segundo parámetro:

.. literalinclude:: connecting/004.php
    :lines: 2-

Conexión a múltiples bases de datos
===================================

Si necesita conectarse a más de una base de datos simultáneamente, puede
hazlo de la siguiente manera:

.. literalinclude:: connecting/005.php
    :lines: 2-

Nota: Cambie las palabras ``group_one`` y ``group_two`` a las específicas
nombres de grupos a los que se está conectando.

.. note:: You don't need to create separate database configurations if you
    Sólo es necesario utilizar una base de datos diferente en la misma conexión. Tú
    Puede cambiar a una base de datos diferente cuando lo necesite, así:

    ``$db->setDatabase($database2_name);``

Conexión con configuraciones personalizadas
===========================================

Puede pasar una serie de configuraciones de base de datos en lugar de un nombre de grupo para obtener
una conexión que utiliza su configuración personalizada. La matriz pasada debe ser
El mismo formato que los grupos están definidos en el archivo de configuración:

.. literalinclude:: connecting/006.php
    :lines: 2-

Reconectar / Mantener viva la conexión
======================================

Si se excede el tiempo de espera de inactividad del servidor de base de datos mientras realiza
algo de trabajo pesado de PHP (procesar una imagen, por ejemplo), deberías
considere hacer ping al servidor usando el método ``reconnect()`` antes
enviar más consultas, lo que puede mantener viva la conexión con gracia
o restablecerlo.

.. important:: If you are using MySQLi database driver, the ``reconnect()`` method
    no hace ping al servidor pero cierra la conexión y luego se conecta nuevamente.

.. literalinclude:: connecting/007.php
    :lines: 2-

Cerrar manualmente la conexión
==============================

Mientras Higgs se encarga inteligentemente de cerrar tu base de datos
conexiones, puede cerrar explícitamente la conexión.

.. literalinclude:: connecting/008.php
    :lines: 2-
