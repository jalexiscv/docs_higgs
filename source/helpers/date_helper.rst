#################
Ayudante de citas
#################

El archivo Date Helper contiene funciones que ayudan a trabajar con
fechas.

.. contents::
    :local:
    :depth: 2

.. note:: Many functions previously found in the Higgs 3 ``date_helper`` have been moved to the :doc:`Time <../libraries/time>` class in Higgs.

Cargando este ayudante
======================

Este ayudante se carga usando el siguiente código:

.. literalinclude:: date_helper/001.php

Funciones disponibles
=====================

Están disponibles las siguientes funciones:

.. php:function:: now([$timezone = null])

    :param  string $zona horaria: zona horaria
    :devuelve: marca de tiempo UNIX
    :rtype: int

    .. note:: It is recommended to use the :doc:`Time <../libraries/time>` class instead. Use ``Time::now()->getTimestamp()`` to get the current UNIX timestamp.

    Si no se proporciona una zona horaria, devolverá la marca de tiempo actual de UNIX mediante ``time()``.

    .. literalinclude:: date_helper/002.php

    Si se proporciona alguna zona horaria compatible con PHP, devolverá una marca de tiempo compensada por la diferencia horaria. No es lo mismo que la marca de tiempo actual de UNIX.

    Si no tiene intención de establecer su referencia de tiempo maestro en
    cualquier otra zona horaria compatible con PHP (lo que normalmente hará si ejecuta un sitio
    que permite a cada usuario establecer su propia configuración de zona horaria) no hay ningún beneficio en usar
    esta función sobre la función ``time()`` de PHP.

.. php:function:: timezone_select([$class = '', $default = '', $what = \DateTimeZone::ALL, $country = null])

    :param string $class: clase opcional para aplicar al campo de selección
    :param string $default: valor predeterminado para la selección inicial
    :param int $what: Constantes de clase DateTimeZone (ver `listIdentifiers<https://www.php.net/manual/en/datetimezone.listidentifiers.php>` _)
    :param  string $país: un código de país de dos letras compatible con ISO 3166-1 (consulte `listIdentifiers<https://www.php.net/manual/en/datetimezone.listidentifiers.php>` _)
    :returns: campo de selección HTML preformateado
    :rtype: cadena

    Genera un campo de formulario ``select` de zonas horarias disponibles (opcionalmente filtrado por ``$what`` y ``$country``).
    Puede proporcionar una clase de opción para aplicar al campo para facilitar el formato, así como un valor predeterminado
    valor seleccionado.

    .. literalinclude:: date_helper/003.php
