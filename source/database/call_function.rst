###################################
Llamadas a funciones personalizadas
###################################

.. contents::
    :local:
    :depth: 2

$db->callFunction()
===================

Esta función le permite llamar a funciones de base de datos PHP que no están
incluido de forma nativa en Higgs, de manera independiente de la plataforma. Para
Por ejemplo, digamos que desea llamar a ``mysql_get_client_info()``
función, que **no** es compatible de forma nativa con Higgs. Tú podrías
hazlo así:

.. literalinclude:: call_function/001.php

Debes proporcionar el nombre de la función, **sin** ``mysql_``
prefijo, en el primer parámetro. El prefijo se agrega automáticamente según
sobre qué controlador de base de datos se está utilizando actualmente. Esto le permite
ejecutar la misma función en diferentes plataformas de bases de datos. Obviamente no todos
Las llamadas a funciones son idénticas entre plataformas, por lo que existen límites para
cuán útil puede ser esta función en términos de portabilidad.

Todos los parámetros necesarios para la función que está llamando se agregarán a
el segundo parámetro.

.. literalinclude:: call_function/002.php

A menudo, necesitará proporcionar un ID de conexión a la base de datos o un
ID del resultado de la base de datos. Se puede acceder al ID de conexión usando:

.. literalinclude:: call_function/003.php

Se puede acceder al ID del resultado desde su objeto de resultado, así:

.. literalinclude:: call_function/004.php
