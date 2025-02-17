#####################
Ayudante de inflector
#####################

El archivo Inflector Helper contiene funciones que le permiten cambiar
**Palabras en inglés** a plural, singular, caso camello, etc.

.. contents::
    :local:
    :depth: 2

Cargando este ayudante
======================

Este ayudante se carga usando el siguiente código:

.. literalinclude:: inflector_helper/001.php

Funciones disponibles
=====================

Están disponibles las siguientes funciones:

.. php:function:: singular($string)

    :param  string $cadena: cadena de entrada
    :devuelve: Una palabra singular
    :rtype: cadena

    Cambia una palabra plural a singular. Ejemplo:

    .. literalinclude:: inflector_helper/002.php

.. php:function:: plural($string)

    :param  string $cadena: cadena de entrada
    :devuelve: una palabra en plural
    :rtype: cadena

    Cambia una palabra singular a plural. Ejemplo:

    .. literalinclude:: inflector_helper/003.php

.. php:function:: counted($count, $string)

    :param int $count: Número de elementos
    :param  string $cadena: cadena de entrada
    :devuelve: una frase en singular o plural
    :rtype: cadena

    Cambia una palabra y su recuento a una frase. Ejemplo:

    .. literalinclude:: inflector_helper/004.php

.. php:function:: camelize($string)

    :param  string $cadena: cadena de entrada
    :devuelve: cadena de caso Camel
    :rtype: cadena

    Cambia una cadena de palabras separadas por espacios o guiones bajos a camello
    caso. Ejemplo:

    .. literalinclude:: inflector_helper/005.php

.. php:function:: pascalize($string)

    :param  string $cadena: cadena de entrada
    :devuelve: cadena Pascal en mayúsculas y minúsculas
    :rtype: cadena

    Cambia una cadena de palabras separadas por espacios o guiones bajos a Pascal
    case, que es camel case con la primera letra en mayúscula. Ejemplo:

    .. literalinclude:: inflector_helper/006.php

.. php:function:: underscore($string)

    :param  string $cadena: cadena de entrada
    :devuelve: Cadena que contiene guiones bajos en lugar de espacios
    :rtype: cadena

    Toma varias palabras separadas por espacios y las subraya.
    Ejemplo:

    .. literalinclude:: inflector_helper/007.php

.. php:function:: decamelize($string)

    :param  string $cadena: cadena de entrada
    :devuelve: Cadena que contiene guiones bajos entre palabras
    :rtype: cadena

    Toma varias palabras en camelCase o PascalCase y las convierte a Snake_case.
    Ejemplo:

    .. literalinclude:: inflector_helper/014.php

.. php:function:: humanize($string[, $separator = '_'])

    :param  string $cadena: cadena de entrada
    :param  string $separador: separador de entrada
    :devuelve: cadena humanizada
    :rtype: cadena

    Toma varias palabras separadas por guiones bajos y agrega espacios entre ellas.
    a ellos. Cada palabra está en mayúscula.

    Ejemplo:

    .. literalinclude:: inflector_helper/008.php

    Para utilizar guiones en lugar de guiones bajos:

    .. literalinclude:: inflector_helper/009.php

.. php:function:: is_pluralizable($word)

    :param  string $palabra: cadena de entrada
    :devuelve: verdadero si la palabra es contable o falso si no
    :rtype: booleano

    Comprueba si la palabra dada tiene una versión plural. Ejemplo:

    .. literalinclude:: inflector_helper/010.php

.. php:function:: dasherize($string)

    :param  string $cadena: cadena de entrada
    :devuelve: cadena Dasherizada
    :rtype: cadena

    Reemplaza los guiones bajos con guiones en la cadena. Ejemplo:

    .. literalinclude:: inflector_helper/011.php

.. php:function:: ordinal($integer)

    :param int $integer: El número entero para determinar el sufijo
    :devuelve: sufijo ordinal
    :rtype: cadena

    Devuelve el sufijo que se debe agregar a un
    número para indicar la posición, como por ejemplo
    1º, 2º, 3º, 4º. Ejemplo:

    .. literalinclude:: inflector_helper/012.php

.. php:function:: ordinalize($integer)

    :param int $integer: El entero a ordenar
    :devuelve: entero ordinalizado
    :rtype: cadena

    Convierte un número en una cadena ordinal usada
    para indicar la posición, como 1.º, 2.º, 3.º, 4.º.
    Ejemplo:

    .. literalinclude:: inflector_helper/013.php
