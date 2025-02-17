#####################
Ayudante de seguridad
#####################

El archivo Security Helper contiene funciones relacionadas con la seguridad.

.. contents::
    :local:
    :depth: 2

Cargando este ayudante
======================

Este ayudante se carga usando el siguiente código:

.. literalinclude:: security_helper/001.php

Funciones disponibles
=====================

Están disponibles las siguientes funciones:

.. php:function:: sanitize_filename($filename)

    :param  string $nombre de archivo: nombre de archivo
    :devuelve: nombre de archivo desinfectado
    :rtype: cadena

    Proporciona protección contra el cruce de directorios.

    Esta función es un alias para ``\Higgs\Security::sanitizeFilename()``.
    Para obtener más información, consulte la :doc:`Biblioteca de seguridad <../libraries/security>`
    documentación.

.. php:function:: strip_image_tags($str)

    :param  string $cadena: cadena de entrada
    :devuelve: la cadena de entrada sin etiquetas de imagen
    :rtype: cadena

    Esta es una función de seguridad que eliminará las etiquetas de imágenes de una cadena.
    Deja la URL de la imagen como texto sin formato.

    Ejemplo:

    .. literalinclude:: security_helper/002.php

.. php:function:: encode_php_tags($str)

    :param  string $cadena: cadena de entrada
    :devuelve: cadena formateada de forma segura
    :rtype: cadena

    Esta es una función de seguridad que convierte etiquetas PHP en entidades.

    Ejemplo:

    .. literalinclude:: security_helper/003.php
