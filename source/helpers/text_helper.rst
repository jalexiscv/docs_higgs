#################
Ayudante de texto
#################

El archivo Text Helper contiene funciones que ayudan a trabajar con texto.

.. contents::
    :local:
    :depth: 2

Cargando este ayudante
======================

Este ayudante se carga usando el siguiente código:

.. literalinclude:: text_helper/001.php

Funciones disponibles
=====================

Están disponibles las siguientes funciones:

.. php:function:: random_string([$type = 'alnum'[, $len = 8]])

    :param  string $tipo: tipo de aleatorización
    :param int $len: longitud de la cadena de salida
    :devuelve: una cadena aleatoria
    :rtype: cadena

    Genera una cadena aleatoria según el tipo y la longitud que especifique.
    Útil para crear contraseñas o generar hashes aleatorios.

    .. warning:: For types: **basic**, **md5**, and **sha1**, generated strings
        no son criptográficamente seguros. Por lo tanto, estos tipos no se pueden utilizar.
        para fines criptográficos o fines que requieran valores de retorno inimaginables.
        Desde v7.3.3, estos tipos están en desuso.

    El primer parámetro especifica el tipo de cadena, el segundo parámetro
    especifica la longitud. Están disponibles las siguientes opciones:

    - **alfa**: una cadena con letras minúsculas y mayúsculas únicamente.
    - **alnum**: Cadena alfanumérica con caracteres en minúsculas y mayúsculas.
    - **básico**: [obsoleto] Un número aleatorio basado en ``mt_rand()`` (longitud ignorada).
    - **numeric**: Cadena numérica.
    - **nozero**: Cadena numérica sin ceros.
    - **md5**: [obsoleto] Un número aleatorio cifrado basado en ``md5()`` (longitud fija de 32).
    - **sha1**: [obsoleto] Un número aleatorio cifrado basado en ``sha1()`` (longitud fija de 40).
    - **crypto**: Una cadena aleatoria basada en ``random_bytes()``.

    .. note:: When you use **crypto**, you must set an even number to the second parameter.
        Desde v7.2.2, si establece un número impar, se generará ``InvalidArgumentException``.

    .. note:: Since v7.3.3, **alpha**, **alnum** and **nozero** use ``random_byte()``,
        y **numeric** usa ``random_int()``.
        En las versiones anteriores, usaba ``str_shuffle()`` que no es
        criptográficamente seguro.

    Ejemplo de uso:

    .. literalinclude:: text_helper/002.php

.. php:function:: increment_string($str[, $separator = '_'[, $first = 1]])

    :param  string $cadena: cadena de entrada
    :param string $separator: Separador al que agregar un número duplicado
    :param int $first: Número inicial
    :devuelve: una cadena incrementada
    :rtype: cadena

    Incrementa una cadena agregándole un número o aumentando el
    número. Útil para crear "copias" o un archivo o duplicar una base de datos
    contenido que tiene títulos o slugs únicos.

    Ejemplo de uso:

    .. literalinclude:: text_helper/003.php

.. php:function:: alternator($args)

    :param mixed $args: un número variable de argumentos
    :devuelve: Cadena(s) alternada(s)
    :rtype: mixto

    Permite alternar dos o más elementos al recorrerlos
    un bucle. Ejemplo:

    .. literalinclude:: text_helper/004.php

    Puede agregar tantos parámetros como desee y con cada iteración de
    su bucle se devolverá el siguiente elemento.

    .. literalinclude:: text_helper/005.php

    .. note:: To use multiple separate calls to this function simply call the
        función sin argumentos para reinicializar.

.. php:function:: reduce_double_slashes($str)

    :param  string $cadena: cadena de entrada
    :devuelve: Una cadena con barras normalizadas
    :rtype: cadena

    Convierte barras dobles en una cadena en una sola barra, excepto aquellas
    se encuentra en los prefijos del protocolo URL (por ejemplo, http://).

    Ejemplo:

    .. literalinclude:: text_helper/006.php

.. php:function:: strip_slashes($data)

    :param mixed $datos: cadena de entrada o una matriz de cadenas
    :devuelve: Cadena(s) con barras eliminadas
    :rtype: mixto

    Elimina las barras diagonales de una serie de cadenas.

    Ejemplo:

    .. literalinclude:: text_helper/007.php

    Lo anterior devolverá la siguiente matriz:

    .. literalinclude:: text_helper/008.php

    .. note:: For historical reasons, this function will also accept
        y manejar entradas de cadenas. Sin embargo, esto lo convierte en sólo un
        alias de ``stripslashes()``.

.. php:function:: reduce_multiples($str[, $character = ''[, $trim = false]])

    :param string $str: Texto para buscar
    :param string $character: Carácter a reducir
    :param bool $trim: si se debe recortar también el carácter especificado
    :devuelve: cadena reducida
    :rtype: cadena

    Reduce múltiples instancias de un carácter particular que ocurre directamente
    uno tras otro. Ejemplo:

    .. literalinclude:: text_helper/009.php

    Si el tercer parámetro se establece en verdadero, eliminará las apariciones del
    carácter al principio y al final de la cadena. Ejemplo:

    .. literalinclude:: text_helper/010.php

.. php:function:: quotes_to_entities($str)

    :param  string $cadena: cadena de entrada
    :devuelve: Cadena con comillas convertidas a entidades HTML
    :rtype: cadena

    Convierte comillas simples y dobles en una cadena al HTML correspondiente
    entidades. Ejemplo:

    .. literalinclude:: text_helper/011.php

.. php:function:: strip_quotes($str)

    :param  string $cadena: cadena de entrada
    :devuelve: Cadena sin comillas
    :rtype: cadena

    Elimina comillas simples y dobles de una cadena. Ejemplo:

    .. literalinclude:: text_helper/012.php

.. php:function:: word_limiter($str[, $limit = 100[, $end_char = '&#8230;']])

    :param  string $cadena: cadena de entrada
    :param int $límite: Límite
    :param string $end_char: Carácter final (normalmente puntos suspensivos)
    :devuelve: cadena de palabras limitadas
    :rtype: cadena

    Trunca una cadena al número de *palabras* especificadas. Ejemplo:

    .. literalinclude:: text_helper/013.php

    El tercer parámetro es un sufijo opcional agregado a la cadena. Por
    De forma predeterminada, agrega puntos suspensivos.

.. php:function:: character_limiter($str[, $n = 500[, $end_char = '&#8230;']])

    :param  string $cadena: cadena de entrada
    :param int $n: Número de caracteres
    :param string $end_char: Carácter final (normalmente puntos suspensivos)
    :devuelve: cadena de caracteres limitados
    :rtype: cadena

    Trunca una cadena al número de *caracteres* especificado. Él
    mantiene la integridad de las palabras, por lo que el número de caracteres puede ser ligeramente
    más o menos de lo que especificas.

    Ejemplo:

    .. literalinclude:: text_helper/014.php

    El tercer parámetro es un sufijo opcional agregado a la cadena, si
    no declarado, este ayudante utiliza puntos suspensivos.

    .. note:: If you need to truncate to an exact number of characters, please
        consulte la función :php:func:`ellipsize()` a continuación.

.. php:function:: ascii_to_entities($str)

    :param  string $cadena: cadena de entrada
    :devuelve: Una cadena con valores ASCII convertidos en entidades
    :rtype: cadena

    Convierte valores ASCII en entidades de caracteres, incluidos ASCII alto y MS
    Caracteres de palabras que pueden causar problemas cuando se usan en una página web, por lo que
    se pueden mostrar consistentemente independientemente de la configuración del navegador o almacenarse
    confiablemente en una base de datos. Existe cierta dependencia de su servidor.
    conjuntos de caracteres admitidos, por lo que puede que no sea 100% confiable en todos los casos,
    pero en su mayor parte, debería identificar correctamente los personajes fuera
    el rango normal (como caracteres acentuados).

    Ejemplo:

    .. literalinclude:: text_helper/015.php

.. php:function:: entities_to_ascii($str[, $all = true])

    :param  string $cadena: cadena de entrada
    :param bool $all: si se deben convertir también entidades inseguras
    :devuelve: una cadena con entidades HTML convertidas a caracteres ASCII
    :rtype: cadena

    Esta función hace lo contrario de :php:func:`ascii_to_entities()`.
    Convierte las entidades de caracteres nuevamente en ASCII.

.. php:function:: convert_accented_characters($str)

    :param  string $cadena: cadena de entrada
    :devuelve: Una cadena con caracteres acentuados convertidos
    :rtype: cadena

    Translitera caracteres ASCII altos a equivalentes ASCII bajos. Útil
    cuando es necesario utilizar caracteres no ingleses donde solo se utiliza ASCII estándar
    Los caracteres se utilizan de forma segura, por ejemplo, en las URL.

    Ejemplo:

    .. literalinclude:: text_helper/016.php

    .. note:: This function uses a companion config file
        **app/Config/ForeignCharacters.php** para definir el destino y
        de matriz para transliteración.

.. php:function:: word_censor($str, $censored[, $replacement = ''])

    :param  string $cadena: cadena de entrada
    :param array $censurado: Lista de malas palabras para censurar
    :param string $replacement: Con qué reemplazar las malas palabras
    :devuelve: cadena censurada
    :rtype: cadena

    Le permite censurar palabras dentro de una cadena de texto. El primer parámetro
    contendrá la cadena original. El segundo contendrá una serie de
    palabras que no permites. El tercer parámetro (opcional) puede contener
    un valor de reemplazo para las palabras. Si no se especifica se reemplazan
    con signos de libra: ####.

    Ejemplo:

    .. literalinclude:: text_helper/017.php

.. php:function:: highlight_code($str)

    :param  string $cadena: cadena de entrada
    :devuelve: Cadena con código resaltado mediante HTML
    :rtype: cadena

    Colorea una cadena de código (PHP, HTML, etc.). Ejemplo:

    .. literalinclude:: text_helper/018.php

    La función utiliza la función ``highlight_string()`` de PHP, por lo que
    Los colores utilizados son los especificados en su archivo php.ini.

.. php:function:: highlight_phrase($str, $phrase[, $tag_open = '<mark>'[, $tag_close = '</mark>']])

    :param  string $cadena: cadena de entrada
    :param string $frase: Frase a resaltar
    :param string $tag_open: etiqueta de apertura utilizada para resaltar
    :param string $tag_close: etiqueta de cierre para el resaltado
    :devuelve: Cadena con una frase resaltada vía HTML
    :rtype: cadena

    Resaltará una frase dentro de una cadena de texto. El primer parámetro será
    contendrá la cadena original, la segunda contendrá la frase que deseas
    a más destacado. El tercer y cuarto parámetro contendrán el
    abrir/cerrar etiquetas HTML en las que desea incluir la frase.

    Ejemplo:

    .. literalinclude:: text_helper/019.php

    El código anterior imprime::

        Aquí hay una <span style="color:#990000;">bonita cadena de texto</span> sobre nada en particular.

    .. note:: This function used to use the ``<strong>`` tag by default. Older browsers
        Es posible que no admita la nueva etiqueta de marca HTML5, por lo que se recomienda que
        inserte el siguiente código CSS en su hoja de estilo si necesita soporte
        tales navegadores::

            marca {
                fondo: #ff0;
                color: #000;
            };

.. php:function:: word_wrap($str[, $charlim = 76])

    :param  string $cadena: cadena de entrada
    :param int $charlim: límite de caracteres
    :devuelve: cadena envuelta en palabras
    :rtype: cadena

    Envuelve el texto en el recuento de *caracteres* especificado manteniendo
    palabras completas.

    Ejemplo:

    .. literalinclude:: text_helper/020.php

.. php:function:: ellipsize($str, $max_length[, $position = 1[, $ellipsis = '&hellip;']])

    :param  string $cadena: cadena de entrada
    :param int $max_length: límite de longitud de cadena
    :param Mixed $position: Posición para dividir en (int o float)
    :param string $ellipsis: Qué usar como carácter de puntos suspensivos
    :devuelve: cadena elíptica
    :rtype: cadena

    Esta función eliminará las etiquetas de una cadena, la dividirá en un punto definido
    longitud máxima e inserte puntos suspensivos.

    El primer parámetro es la cadena a eliminar, el segundo es el número
    de caracteres en la cadena final. El tercer parámetro es en qué parte del
    cadena, los puntos suspensivos deben aparecer de 0 a 1, de izquierda a derecha. Para
    ejemplo. un valor de 1 colocará los puntos suspensivos a la derecha del
    cuerda, .5 en el medio y 0 a la izquierda.

    Un cuarto parámetro opcional es el tipo de puntos suspensivos. Por defecto,
    …se insertará.

    Ejemplo:

    .. literalinclude:: text_helper/021.php

    Produce::

        this_string_is_e…ak_my_design.jpg

.. php:function:: excerpt($text, $phrase = false, $radius = 100, $ellipsis = '...')

    :param string $text: Texto para extraer un extracto
    :param string $phrase: Frase o palabra para extraer el texto alrededor
    :param int $radius: Número de caracteres antes y después de $frase
    :param string $ellipsis: Qué usar como carácter de puntos suspensivos
    :returns: Extracto.
    :rtype: cadena

    Esta función extraerá $radius el número de caracteres antes y después del
    frase $ central con puntos suspensivos antes y después.

    El primer parámetro es el texto del que extraer un extracto, el segundo es el
    palabra o frase central para contar antes y después. El tercer parámetro es el
    Número de caracteres a contar antes y después de la frase central. si no hay frase
    pasado, el extracto incluirá los primeros caracteres $radius con puntos suspensivos
    al final.

    Ejemplo:

    .. literalinclude:: text_helper/022.php

    Produce::

        ... non mauris lectus. Phasellus eu sodales sem. Integer dictum purus ac
        para hendrerit embarazada Hasta un empleado grande o ahora tinciduo pero
        fanáticos de la vida Mañana, sin embargo, la curiosidad la tiene el autor, no el hablante. ...
