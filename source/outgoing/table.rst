###################
Clase de tabla HTML
###################

La clase Table proporciona métodos que le permiten generar automáticamente HTML
tablas de matrices o conjuntos de resultados de bases de datos.

.. contents::
    :local:
    :depth: 2


Usando la clase de tabla
************************

Inicializando la clase
======================

La clase Tabla no se proporciona como un servicio y se debe crear una instancia de ella.
"normalmente", por ejemplo:

.. literalinclude:: table/001.php

Ejemplos
========

A continuación se muestra un ejemplo que muestra cómo se puede crear una tabla a partir de un
matriz multidimensional. Tenga en cuenta que el primer índice de la matriz se convertirá en el
encabezado de la tabla (o puede configurar sus propios encabezados usando ``setHeading()``
método descrito en la referencia de funciones a continuación).

.. literalinclude:: table/002.php

A continuación se muestra un ejemplo de una tabla creada a partir del resultado de una consulta de base de datos. El
La clase de tabla generará automáticamente los encabezados basados en la tabla.
nombres (o puede establecer sus propios encabezados usando ``setHeading()``
método descrito en la referencia de clase a continuación).

.. literalinclude:: table/003.php

A continuación se muestra un ejemplo que muestra cómo se puede crear una tabla usando datos discretos.
parámetros:

.. literalinclude:: table/004.php

Aquí está el mismo ejemplo, excepto que en lugar de parámetros individuales,
Se utilizan matrices:

.. literalinclude:: table/005.php

Cambiando el aspecto de tu mesa
===============================

La clase de tabla le permite configurar una plantilla de tabla con la que puede
especifique el diseño de su diseño. Aquí está el prototipo de plantilla:

.. literalinclude:: table/006.php

.. note:: You'll notice there are two sets of "row" blocks in the
    plantilla. Estos le permiten crear colores o diseños de filas alternas.
    elementos que se alternan con cada iteración de los datos de la fila.

NO es necesario que envíe una plantilla completa. Si solo necesitas
Para cambiar partes del diseño, simplemente puede enviar esos elementos. En esto
Por ejemplo, solo se cambia la etiqueta de apertura de la tabla:

.. literalinclude:: table/007.php

También puede establecer valores predeterminados para estos pasando una serie de configuraciones de plantilla
al constructor de tablas:

.. literalinclude:: table/008.php

.. _table-sync-rows-with-headings:

Sincronizar filas con encabezados
=================================

.. versionadded:: 4.4.0

El método ``setSyncRowsWithHeading(true)`` permite que cada valor de datos
se coloca en la misma columna definida en ``setHeading()`` si un
Se utilizó una matriz asociativa como parámetro. Esto es especialmente útil
cuando se trata de datos cargados a través de REST API donde el pedido no es
su gusto, o si la API devolvió demasiados datos.

Si una fila de datos contiene una clave que no está presente en el encabezado, su valor es
filtrado. Por el contrario, si una fila de datos no tiene una clave en el encabezado,
en su lugar se colocará una celda vacía.

.. literalinclude:: table/019.php

.. important:: You must call ``setSyncRowsWithHeading(true)`` and
    ``setHeading([...])`` antes de agregar filas mediante ``addRow([...])`` donde
    Se produce la reordenación de las columnas.

Usar una matriz como entrada para ``generar()`` produce el mismo resultado:

.. literalinclude:: table/020.php



Referencia de clase
*******************

.. php:namespace:: Higgs\View

.. php:class:: Table

    .. attribute:: $function = null

        Le permite especificar una función PHP nativa o un objeto de matriz de función válido para aplicar a todos los datos de la celda.

        .. literalinclude:: table/009.php

        En el ejemplo anterior, todos los datos de la celda se ejecutarían a través de la función :php:func:`htmlspecialchars()` de PHP, lo que daría como resultado::

            <td>fred</td><td> <strong>Azul</strong></td><td> Pequeño</td>

    .. php:method:: generate([$tableData = null])

        :param mixed $tableData: datos con los que rellenar las filas de la tabla
        :devuelve: tabla HTML
        :rtype: cadena

        Devuelve una cadena que contiene la tabla generada. Acepta un parámetro opcional que puede ser una matriz o un objeto de resultado de base de datos.

    .. php:method:: setCaption($caption)

        :param  string $caption: título de la tabla
        :devuelve: Instancia de tabla (encadenamiento de métodos)
        :rtype: Tabla

        Le permite agregar un título a la tabla.

        .. literalinclude:: table/010.php

    .. php:method:: setHeading([$args = [] [, ...]])

        :param Mixed $args: una matriz o varias cadenas que contienen los títulos de las columnas de la tabla
        :devuelve: Instancia de tabla (encadenamiento de métodos)
        :rtype: Tabla

        Le permite configurar el encabezado de la tabla. Puede enviar una matriz o parámetros discretos:

        .. literalinclude:: table/011.php

    .. php:method:: setFooting([$args = [] [, ...]])

        :param Mixed $args: una matriz o varias cadenas que contienen los valores del pie de la tabla
        :devuelve: Instancia de tabla (encadenamiento de métodos)
        :rtype: Tabla

        Le permite configurar el pie de la mesa. Puede enviar una matriz o parámetros discretos:

        .. literalinclude:: table/012.php

    .. php:method:: addRow([$args = [] [, ...]])

        :param Mixed $args: una matriz o varias cadenas que contienen los valores de la fila
        :devuelve: Instancia de tabla (encadenamiento de métodos)
        :rtype: Tabla

        Le permite agregar una fila a su tabla. Puede enviar una matriz o parámetros discretos:

        .. literalinclude:: table/013.php

        Si desea establecer los atributos de etiqueta de una celda individual, puede utilizar una matriz asociativa para esa celda.
        La clave asociativa **datos** define los datos de la celda. Cualquier otro par clave => val se agrega como atributo clave='val' a la etiqueta:

        .. literalinclude:: table/014.php

    .. php:method:: makeColumns([$array = [] [, $columnLimit = 0]])

        :param array $array: una matriz que contiene datos de varias filas
        :param int $columnLimit: Recuento de columnas en la tabla
        :returns: una matriz de columnas de tabla HTML
        :rtype: matriz

        Este método toma una matriz unidimensional como entrada y crea una matriz multidimensional con una profundidad igual al número de columnas deseadas.
        Esto permite mostrar una única matriz con muchos elementos en una tabla que tiene un recuento de columnas fijo. Considere este ejemplo:

        .. literalinclude:: table/015.php

    .. php:method:: setTemplate($template)

        :param array $template: una matriz asociativa que contiene valores de plantilla
        :returns: verdadero en caso de éxito, falso en caso de error
        :rtype: booleano

        Le permite configurar su plantilla. Puede enviar una plantilla completa o parcial.

        .. literalinclude:: table/016.php

    .. php:method:: setEmpty($value)

        :param mixed $valor: Valor para poner en celdas vacías
        :devuelve: Instancia de tabla (encadenamiento de métodos)
        :rtype: Tabla

        Le permite establecer un valor predeterminado para usar en cualquier celda de la tabla que esté vacía.
        Podrías, por ejemplo, establecer un espacio que no se rompa:

        .. literalinclude:: table/017.php

    .. php:method:: clear()

        :devuelve: Instancia de tabla (encadenamiento de métodos)
        :rtype: Tabla

        Le permite borrar el encabezado de la tabla, los datos de la fila y el título. Si
        necesita mostrar varias tablas con diferentes datos que
        debería llamar a este método después de que cada tabla haya sido
        generado para borrar la información de la tabla anterior.

        Ejemplo

        .. literalinclude:: table/018.php
    
    .. php:method:: setSyncRowsWithHeading(bool $orderByKey)

        :devuelve: Instancia de tabla (encadenamiento de métodos)
        :rtype: Tabla

        Permite ordenar cada clave de datos de fila por claves de encabezado. Esto da
        mayor control de los datos que se desplazan en la columna correcta. Hacer
        asegúrese de establecer este valor antes de llamar al primer método ``addRow()``.
