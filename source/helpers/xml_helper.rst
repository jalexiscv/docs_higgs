############
Ayudante XML
############

El archivo XML Helper contiene funciones que ayudan a trabajar con XML.
datos.

.. contents::
    :local:
    :depth: 2

Cargando este ayudante
======================

Este ayudante se carga usando el siguiente código

.. literalinclude:: xml_helper/001.php

Funciones disponibles
=====================

Están disponibles las siguientes funciones:

.. php:function:: xml_convert($str[, $protect_all = false])

    :param string $str: la cadena de texto a convertir
    :param bool $protect_all: si se debe proteger todo el contenido que parece una entidad potencial en lugar de solo entidades numeradas, por ejemplo, &amp;foo;
    :devuelve: cadena convertida a XML
    :rtype: cadena

    Toma una cadena como entrada y convierte el siguiente XML reservado
    caracteres a entidades:

      - Signos de unión: &amp;
      - Caracteres menores y mayores que: < >
      - Comillas simples y dobles: ' "
      - Guiones: -

    Esta función ignora los símbolos si son parte de números existentes.
    entidades de caracteres, por ejemplo, {. Ejemplo:

    .. literalinclude:: xml_helper/002.php

    salidas:

    .. code-block:: html

        <p>Aquí hay un párrafo y una entidad ({).</p>
