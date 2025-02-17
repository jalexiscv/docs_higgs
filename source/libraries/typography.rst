##########
Tipografía
##########

La biblioteca de tipografía contiene métodos que le ayudan a dar formato al texto.
de maneras semánticamente relevantes.

.. contents::
    :local:
    :depth: 2


Cargando la biblioteca
**********************

Como todos los servicios en Higgs, se puede cargar a través de ``Config\Services``, aunque normalmente no será necesario
para cargarlo manualmente:

.. literalinclude:: typography/001.php


Funciones estáticas disponibles
*******************************

Están disponibles las siguientes funciones:

.. php:function:: autoTypography($str[, $reduce_linebreaks = false])

    :param  string $cadena: cadena de entrada
    :param bool $reduce_linebreaks: si se deben reducir múltiples instancias de nuevas líneas dobles a dos
    :devuelve: cadena con formato HTML segura para tipografía
    :rtype: cadena

    Da formato al texto para que sea semántica y tipográficamente correcto.
    HTML.

    Ejemplo de uso:

    .. literalinclude:: typography/002.php

    .. note:: Typographic formatting can be processor intensive, particularly if
        tienes mucho contenido formateado. Si eliges usar este
        función que quizás quieras considerar :doc:`caching <../general/caching>` tu
        páginas.

.. php:function:: formatCharacters($str)

    :param  string $cadena: cadena de entrada
    :devuelve: Cadena con caracteres formateados.
    :rtype: cadena

    Esta función convierte principalmente comillas dobles y simples.
    a entidades rizadas, pero también convierte guiones largos,
    espacios dobles y ampersand.

    Ejemplo de uso:

    .. literalinclude:: typography/003.php

.. php:function:: nl2brExceptPre($str)

    :param  string $cadena: cadena de entrada
    :devuelve: Cadena con saltos de línea con formato HTML
    :rtype: cadena

    Convierte nuevas líneas a ``<br />`` etiquetas a menos que aparezcan dentro de ``<pre>`` etiquetas.
    Esta función es idéntica a la función nativa PHP ``nl2br()``,
    excepto que ignora ``<pre>`` etiquetas.

    Ejemplo de uso:

    .. literalinclude:: typography/004.php
