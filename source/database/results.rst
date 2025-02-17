################################
Generando resultados de consulta
################################

Hay varias formas de generar resultados de consultas:

.. contents::
    :local:
    :depth: 3


Matrices de resultados
**********************

obtenerResultado()
==================

Este método devuelve el resultado de la consulta como una matriz de **objetos**, o
**una matriz vacía** en caso de error.

Obtener una matriz de stdClass
----------------------------

Normalmente usarás esto en un foreach
bucle, así:

.. literalinclude:: results/001.php

El método anterior es un alias de :php:meth:`Higgs\\Database\\BaseResult::getResultObject()`.

Obtener una matriz de matriz
-------------------------

Puede pasar la cadena 'matriz' si desea obtener sus resultados
como una matriz de matrices:

.. literalinclude:: results/002.php

El uso anterior es un alias de `getResultArray()`_.

Obtener una matriz de objetos personalizados
---------------------------------

También puedes pasar una cadena a ``getResult()`` que representa una clase para
crear una instancia para cada objeto de resultado

.. literalinclude:: results/003.php

El método anterior es un alias de `getCustomResultObject()`_.

obtenerArrayResultados()
========================

Este método devuelve el resultado de la consulta como una matriz pura o vacía.
matriz cuando no se produce ningún resultado. Normalmente usarás esto en un foreach
bucle, así:

.. literalinclude:: results/004.php


Filas de resultados
*******************

obtener fila()
==============

Este método devuelve una única fila de resultados. Si su consulta tiene más de
una fila, devuelve solo la primera fila. El resultado se devuelve como un
**objeto**. Aquí hay un ejemplo de uso:

.. literalinclude:: results/005.php

Si desea que se devuelva una fila específica, puede enviar el número de fila como un
dígito en el primer parámetro:

.. literalinclude:: results/006.php

También puedes agregar un segundo parámetro String, que es el nombre de una clase.
para crear una instancia de la fila con:

.. literalinclude:: results/007.php

getRowArray()
=============

Idéntico al método ``row()`` anterior, excepto que devuelve una matriz.
Ejemplo:

.. literalinclude:: results/008.php

Si desea que se devuelva una fila específica, puede enviar el número de fila como un
dígito en el primer parámetro:

.. literalinclude:: results/009.php

Además, puedes caminar hacia adelante/atrás/primero/último a través de tu
resultados usando estas variaciones:

    | ``$fila = $consulta->getFirstRow()``
    | ``$fila = $consulta->getLastRow()``
    | ``$fila = $consulta->getNextRow()``
    | ``$fila = $consulta->getPreviousRow()``

Por defecto devuelven un objeto a menos que pongas la palabra "matriz" en el
parámetro:

    | ``$fila = $consulta->getFirstRow('matriz')``
    | ``$fila = $consulta->getLastRow('matriz')``
    | ``$fila = $consulta->getNextRow('matriz')``
    | ``$fila = $consulta->getPreviousRow('matriz')``

.. note:: All the methods above will load the whole result into memory
    (captación previa). Utilice ``getUnbufferedRow()`` para procesar archivos grandes
    conjuntos de resultados.

getUnbufferedRow()
==================

Este método devuelve una única fila de resultados sin precargar el conjunto
resulta en la memoria como lo hace ``row()``. Si su consulta tiene más de una fila,
devuelve la fila actual y mueve el puntero de datos internos hacia adelante.

.. literalinclude:: results/010.php

Para usar con MySQLi, puede configurar el modo de resultado de MySQLi en
``MYSQLI_USE_RESULT`` para ahorrar el máximo de memoria. El uso de esto no es
Generalmente se recomienda, pero puede ser beneficioso en algunas circunstancias.
como escribir consultas grandes en csv. Si cambia el modo de resultado
ser consciente de las compensaciones asociadas con ello.

.. literalinclude:: results/011.php

.. note:: When using ``MYSQLI_USE_RESULT`` all subsequent calls on the same
    La conexión generará un error hasta que se hayan obtenido todos los registros o
    Se ha realizado una llamada ``freeResult()``. El método ``getNumRows()`` sólo
    Devuelve el número de filas según la posición actual del puntero de datos.
    Las tablas MyISAM permanecerán bloqueadas hasta que se hayan recuperado todos los registros
    o se ha realizado una llamada ``freeResult()``.

Opcionalmente, puede pasar 'objeto' (predeterminado) o 'matriz' para especificar
el tipo del valor devuelto:

.. literalinclude:: results/012.php


Objetos de resultados personalizados
************************************

En su lugar, puede obtener los resultados como una instancia de una clase personalizada.
de una ``stdClass`` o matriz, como ``getResult()`` y ``getResultArray()``
los métodos lo permiten. Si la clase aún no está cargada en la memoria, el Autocargador
intentará cargarlo. El objeto tendrá todos los valores devueltos desde el
base de datos establecida como propiedades. Si estos han sido declarados y no son públicos
entonces deberías proporcionar un método ``__set()`` para permitir su configuración.

Ejemplo:

.. literalinclude:: results/013.php

Además de los dos métodos enumerados a continuación, los siguientes métodos también pueden
tome un nombre de clase para devolver los resultados como: ``getFirstRow()``, ``getLastRow()``,
``getNextRow()`` y ``getPreviousRow()``.

obtenerObjetoResultadoPersonalizado()
=====================================

Devuelve el conjunto de resultados completo como una matriz de instancias de la clase solicitada.
El único parámetro es el nombre de la clase a crear una instancia.

Ejemplo:

.. literalinclude:: results/014.php

getCustomRowObject()
====================

Devuelve una sola fila de los resultados de su consulta. El primer parámetro es la fila.
número de los resultados. El segundo parámetro es el nombre de la clase para crear una instancia.

Ejemplo:

.. literalinclude:: results/015.php

También puedes usar el método ``getRow()`` exactamente de la misma manera.

Ejemplo:

.. literalinclude:: results/016.php


Métodos auxiliares de resultados
********************************

getFieldCount()
===============

El número de CAMPOS (columnas) devueltos por la consulta. Asegúrate de llamar
el método que utiliza el objeto de resultado de su consulta:

.. literalinclude:: results/017.php

obtener nombres de campo()
==========================

Devuelve una matriz con los nombres de los CAMPOS (columnas) devueltos por la consulta.
Asegúrese de llamar al método utilizando el objeto de resultado de su consulta:

.. literalinclude:: results/018.php

obtenerNumRows()
================

El número de registros devueltos por la consulta. Asegúrate de llamar
el método que utiliza el objeto de resultado de su consulta:

.. literalinclude:: results/019.php

.. note:: Because SQLite3 lacks an efficient method returning a record count,
    Higgs buscará y almacenará en buffer los registros de resultados de la consulta internamente y
    devuelve un recuento de la matriz de registros resultante, lo que puede resultar ineficiente.

resultado libre()
=================

Libera la memoria asociada al resultado y elimina el resultado.
ID de recurso. Normalmente PHP libera su memoria automáticamente al final de
ejecución del script. Sin embargo, si está ejecutando muchas consultas en un
script particular es posible que desee liberar el resultado después de cada consulta
El resultado se ha generado para reducir el consumo de memoria.

Ejemplo:

.. literalinclude:: results/020.php

búsqueda de datos()
===================

Este método establece el puntero interno para que la siguiente fila de resultados sea
traído. Sólo es útil en combinación con ``getUnbufferedRow()``.

Acepta un valor entero positivo, que por defecto es 0 y devuelve
verdadero en caso de éxito o falso en caso de fracaso.

.. literalinclude:: results/021.php

.. note:: Not all database drivers support this feature and will return false.
    Lo más notable es que no podrás usarlo con PDO.


Referencia de clase
*******************

.. php:namespace:: Higgs\Database

.. php:class:: BaseResult

    .. php:method:: getResult([$type = 'object'])

        :param string $type: tipo de resultados solicitados: matriz, objeto o nombre de clase
        :returns: matriz que contiene las filas recuperadas
        :rtype: matriz

        Un contenedor para ``getResultArray()``, ``getResultObject()``
        y métodos ``getCustomResultObject()``.

        Uso: consulte `Matrices de resultados`_.

    .. php:method:: getResultArray()

        :returns: matriz que contiene las filas recuperadas
        :rtype: matriz

        Devuelve los resultados de la consulta como una matriz de filas, donde cada
        La fila es en sí misma una matriz asociativa.

        Uso: consulte `Matrices de resultados`_.

    .. php:method:: getResultObject()

        :returns: matriz que contiene las filas recuperadas
        :rtype: matriz

        Devuelve los resultados de la consulta como una matriz de filas, donde cada
        fila es un objeto de tipo ``stdClass``.

        Uso: consulte `Obtener una matriz de stdClass`_.

    .. php:method:: getCustomResultObject($class_name)

        :param string $class_name: nombre de clase para las filas resultantes
        :returns: matriz que contiene las filas recuperadas
        :rtype: matriz

        Devuelve los resultados de la consulta como una matriz de filas, donde cada
        fila es una instancia de la clase especificada.

    .. php:method:: getRow([$n = 0[, $type = 'object']])

        :param int $n: índice de la fila de resultados de la consulta que se devolverá
        :param string $type: tipo de resultado solicitado: matriz, objeto o nombre de clase
        :returns: la fila solicitada o nula si no existe
        :rtype: mixto

        Un contenedor para ``getRowArray()``, ``getRowObject()`` y
        Métodos ``getCustomRowObject()``.

        Uso: consulte `Filas de resultados`_.

    .. php:method:: getUnbufferedRow([$type = 'object'])

        :param string $type: tipo de resultado solicitado: matriz, objeto o nombre de clase
        :returns: siguiente fila del conjunto de resultados o nula si no existe
        :rtype: mixto

        Obtiene la siguiente fila de resultados y la devuelve en el
        formulario solicitado.

        Uso: consulte `Filas de resultados`_.

    .. php:method:: getRowArray([$n = 0])

        :param int $n: índice de la fila de resultados de la consulta que se devolverá
        :returns: la fila solicitada o nula si no existe
        :rtype: matriz

        Devuelve la fila del resultado solicitado como una matriz asociativa.

        Uso: consulte `Filas de resultados`_.

    .. php:method:: getRowObject([$n = 0])

        :param int $n: índice de la fila de resultados de la consulta que se devolverá
                :returns: la fila solicitada o nula si no existe
        :rtype: clase estándar

        Devuelve la fila de resultados solicitada como un objeto de tipo
        ``clase estándar``.

        Uso: consulte `Filas de resultados`_.

    .. php:method:: getCustomRowObject($n, $type)

        :param int $n: Índice de la fila de resultados a devolver
        :param string $class_name: nombre de clase para la fila resultante
        :returns: la fila solicitada o nula si no existe
        :rtype: $tipo

        Devuelve la fila del resultado solicitado como una instancia del
        clase solicitada.

    .. php:method:: dataSeek([$n = 0])

        :param int $n: índice de la fila de resultados que se devolverá a continuación
        :returns: verdadero en caso de éxito, falso en caso de error
        :rtype: booleano

        Mueve el puntero de la fila de resultados internos al desplazamiento deseado.

        Uso: consulte `Métodos auxiliares de resultados`_.

    .. php:method:: setRow($key[, $value = null])

        :param mixed $key: nombre de columna o matriz de pares clave/valor
        :param mixed $valor: valor para asignar a la columna, $key es un nombre de campo único
        :rtype: nulo

        Asigna un valor a una columna en particular.

    .. php:method:: getNextRow([$type = 'object'])

        :param string $type: tipo de resultado solicitado: matriz, objeto o nombre de clase
        :returns: siguiente fila del conjunto de resultados, o nula si no existe
        :rtype: mixto

        Devuelve la siguiente fila del conjunto de resultados.

    .. php:method:: getPreviousRow([$type = 'object'])

        :param string $type: tipo de resultado solicitado: matriz, objeto o nombre de clase
        :returns: fila anterior del conjunto de resultados, o nula si no existe
        :rtype: mixto

        Devuelve la fila anterior del conjunto de resultados.

    .. php:method:: getFirstRow([$type = 'object'])

        :param string $type: tipo de resultado solicitado: matriz, objeto o nombre de clase
        :returns: Primera fila del conjunto de resultados, o nulo si no existe
        :rtype: mixto

        Devuelve la primera fila del conjunto de resultados.

    .. php:method:: getLastRow([$type = 'object'])

        :param string $type: tipo de resultado solicitado: matriz, objeto o nombre de clase
        :returns: última fila del conjunto de resultados, o nula si no existe
        :rtype: mixto

        Devuelve la última fila del conjunto de resultados.

    .. php:method:: getFieldCount()

        :returns: Número de campos en el conjunto de resultados
        :rtype: int

        Devuelve el número de campos del conjunto de resultados.

        Uso: consulte `Métodos auxiliares de resultados`_.

    .. php:method:: getFieldNames()

        :devuelve: Matriz de nombres de columnas
        :rtype: matriz

        Devuelve una matriz que contiene los nombres de los campos en el
        conjunto resultante.

    .. php:method:: getFieldData()

        :returns: matriz que contiene metadatos de campo
        :rtype: matriz

        Genera una matriz de objetos ``stdClass`` que contienen
        metadatos de campo.

    .. php:method:: getNumRows()

        :returns: Número de filas en el conjunto de resultados
        :rtype: int

        Devuelve el número de filas devueltas por la consulta.

    .. php:method:: freeResult()

        :rtype: nulo

        Libera un conjunto de resultados.

        Uso: consulte `Métodos auxiliares de resultados`_.
