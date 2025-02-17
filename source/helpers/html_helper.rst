#############
Ayudante HTML
#############

El archivo HTML Helper contiene funciones que ayudan a trabajar con
HTML.

.. contents::
    :local:
    :depth: 2

Configuración
=============

Desde ``v7.3.0``, se anulan los elementos HTML (por ejemplo, ``<img>``) en ``html_helper`` las funciones se han cambiado para que sean compatibles con HTML5 de forma predeterminada y si necesita ser compatible con XHTML, debe configurar la propiedad ``$html5`` en **app/Config/DocTypes. php** a ``false``.

Cargando este ayudante
======================

Este ayudante se carga usando el siguiente código:

.. literalinclude:: html_helper/001.php

Funciones disponibles
=====================

Están disponibles las siguientes funciones:

.. php:function:: img([$src = ''[, $indexPage = false[, $attributes = '']]])

    :param string|array $src: URI de origen de la imagen o conjunto de atributos y valores
    :param bool $indexPage: Si se debe tratar ``$src`` como una cadena URI enrutada
    :param Mixed $attributes: atributos HTML adicionales
    :devuelve: etiqueta de imagen HTML
    :rtype: cadena

    Le permite crear HTML ``<img />`` etiquetas. El primer parámetro contiene el
    fuente de imagen. Ejemplo:

    .. literalinclude:: html_helper/002.php

    Hay un segundo parámetro opcional que es un valor verdadero/falso que
    detalles si el *src* debe tener la página especificada por
    ``$config['indexPage']`` agregado a la dirección que crea.
    Presumiblemente, esto sería si estuviera usando un controlador de medios:

    .. literalinclude:: html_helper/003.php

    Además, se puede pasar una matriz asociativa como primer parámetro,
    para un control total sobre todos los atributos y valores. Si un atributo *alt*
    no se proporciona, Higgs generará una cadena vacía.

    Ejemplo:

    .. literalinclude:: html_helper/004.php

.. php:function:: img_data([$src = ''[, $indexPage = false[, $attributes = '']]])

    :param string $path: Ruta al archivo de imagen
    :param string|null $mime: tipo MIME a usar, o nulo para adivinar
    :devuelve: cadena de imagen binaria codificada en base64
    :rtype: cadena

    Genera una cadena lista para src a partir de una imagen utilizando el protocolo "datos:".
    Ejemplo:

    .. literalinclude:: html_helper/005.php

    Hay un segundo parámetro opcional para especificar el tipo MIME; de lo contrario, el
    La función utilizará su configuración de Mimes para adivinar:

    .. literalinclude:: html_helper/006.php

    Tenga en cuenta que ``$path`` debe existir y ser un formato de imagen legible compatible con el protocolo ``data:``.
    Esta función no se recomienda para archivos muy grandes, pero proporciona una manera conveniente
    de servir imágenes desde su aplicación a las que no se puede acceder desde la web (por ejemplo, en **public/**).

.. php:function:: link_tag([$href = ''[, $rel = 'stylesheet'[, $type = 'text/css'[, $title = ''[, $media = ''[, $indexPage = false[, $hreflang = '']]]]]]])

    :param  string $href: la fuente del archivo de enlace
    :param  string $rel: tipo de relación
    :param string $type: Tipo del documento relacionado
    :param  string $título: Título del enlace
    :param  string $media: tipo de medio
    :param bool $indexPage: Si se debe tratar ``$src`` como una cadena URI enrutada
    :param  strings $hreflang: tipo Hreflang
    :devuelve: etiqueta de enlace HTML
    :rtype: cadena

    Le permite crear HTML ``<link />`` etiquetas. Esto es útil para enlaces de hojas de estilo,
    así como otros enlaces. Los parámetros son *href*, con *rel* opcional,
    *tipo*, *título*, *medios* y *página de índice*.

    *indexPage* es un valor booleano que especifica si *href* debería tener
    la página especificada por ``$config['indexPage']`` agregada a la dirección que crea.

    Ejemplo:

    .. literalinclude:: html_helper/007.php

    Más ejemplos:

    .. literalinclude:: html_helper/008.php

    Alternativamente, se puede pasar una matriz asociativa a la función ``link_tag()``
    para un control total sobre todos los atributos y valores:

    .. literalinclude:: html_helper/009.php

.. php:function:: script_tag([$src = ''[, $indexPage = false]])

    :param array|string $src: El nombre de origen o URL de un archivo JavaScript, o una matriz asociativa que especifica los atributos
    :param bool $indexPage: Si se debe tratar ``$src`` como una cadena URI enrutada
    :devuelve: etiqueta de secuencia de comandos HTML
    :rtype: cadena

    Le permite crear HTML ``<script></script>`` etiquetas. El parámetro es *src*, con *indexPage* opcional.

    *indexPage* es un valor booleano que especifica si *src* debería tener
    la página especificada por ``$config['indexPage']`` agregada a la dirección que crea.

    Ejemplo:

    .. literalinclude:: html_helper/010.php

    Alternativamente, se puede pasar una matriz asociativa a la función ``script_tag()``
    para un control total sobre todos los atributos y valores:

    .. literalinclude:: html_helper/011.php

.. php:function:: ul($list[, $attributes = ''])

    :param array $list: Listar entradas
    :param array $atributos: atributos HTML
    :devuelve: lista desordenada con formato HTML
    :rtype: cadena

    Le permite generar listas HTML desordenadas a partir de archivos simples o
    matrices multidimensionales. Ejemplo:

    .. literalinclude:: html_helper/012.php

    El código anterior producirá esto:

    .. code-block:: html

        <ul class="boldlist" id="mylist">
            <li>rojo</li>
            <li>azul</li>
            <li>verde</li>
            <li>amarillo</li>
        </ul>

    Aquí hay un ejemplo más complejo, usando una matriz multidimensional:

    .. literalinclude:: html_helper/013.php

    El código anterior producirá esto:

    .. code-block:: html

        <ul class="boldlist" id="mylist">
            <li>colores
                <ul>
                    <li>rojo</li>
                    <li>azul</li>
                    <li>verde</li>
                </ul>
            </li>
            <li>formas
                <ul>
                    <li>redondo</li>
                    <li>cuadrado</li>
                    <li>círculos
                        <ul>
                            <li>elipse</li>
                            <li>oval</li>
                            <li>esfera</li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>estados de ánimo
                <ul>
                    <li>feliz</li>
                    <li>decepcionado
                        <ul>
                            <li>derrotado
                                <ul>
                                    <li>abatido</li>
                                    <li>descorazonado</li>
                                    <li>deprimido</li>
                                </ul>
                            </li>
                            <li>enojado</li>
                            <li>cruz</li>
                            <li>enojado</li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>

.. php:function:: ol($list, $attributes = '')

    :param array $list: Listar entradas
    :param array $atributos: atributos HTML
    :devuelve: lista ordenada con formato HTML
    :rtype: cadena

    Idéntico a :php:func:`ul()`, solo que produce el ``<ol>``etiqueta para
    listas ordenadas en lugar de ``<ul>``.

.. php:function:: video($src[, $unsupportedMessage = ''[, $attributes = ''[, $tracks = [][, $indexPage = false]]]])

    :param mixed $src: ya sea una cadena de origen o una matriz de fuentes. Ver función :php:func:`source()`
    :param string $unsupportedMessage: el mensaje que se mostrará si la etiqueta multimedia no es compatible con el navegador
    :param  string $atributos: atributos HTML
    :param array $tracks: utiliza la función track dentro de una matriz. Ver función :php:func:`track()`
    :param bool $páginaíndice:
    :devuelve: elemento de vídeo con formato HTML
    :rtype: cadena

    Le permite generar elementos de video HTML desde simples o
    matrices de origen. Ejemplo:

    .. literalinclude:: html_helper/014.php

    El código anterior producirá esto:

    .. code-block:: html

        <video src="test.mp4" controls>
          Su navegador no soporta la etiqueta de vídeo.
        </video>

        <video src="http://www.Higgs.com/test.mp4" controls>
          <track src="subtitles_no.vtt" kind="subtitles" srclang="no" label="Norwegian No" />
          <track src="subtitles_yes.vtt" kind="subtitles" srclang="yes" label="Norwegian Yes" />
          Su navegador no soporta la etiqueta de vídeo.
        </video>

        <video class="test" controls>
          <source src="movie.mp4" type="video/mp4" class="test" />
          <source src="movie.ogg" type="video/ogg" />
          <source src="movie.mov" type="video/quicktime" />
          <source src="movie.ogv" type="video/ogv; codecs=dirac, speex" />
          <track src="subtitles_no.vtt" kind="subtitles" srclang="no" label="Norwegian No" />
          <track src="subtitles_yes.vtt" kind="subtitles" srclang="yes" label="Norwegian Yes" />
          Su navegador no soporta la etiqueta de vídeo.
        </video>

.. php:function:: audio($src[, $unsupportedMessage = ''[, $attributes = ''[, $tracks = [][, $indexPage = false]]]])

    :param mixed $src: ya sea una cadena de origen o una matriz de fuentes. Ver función :php:func:`source()`
    :param string $unsupportedMessage: el mensaje que se mostrará si la etiqueta multimedia no es compatible con el navegador
    :param  strings $atributos:
    :param array $tracks: utiliza la función track dentro de una matriz. Ver función :php:func:`track()`
    :param bool $páginaíndice:
    :devuelve: elemento de audio con formato HTML
    :rtype: cadena

    Idéntico a :php:func:`video()`, solo que produce el ``<audio>`` etiqueta en lugar de ``<video>``.

.. php:function:: source($src = ''[, $type = false[, $attributes = '']])

    :param string $src: La ruta del recurso multimedia
    :param bool $type: el tipo MIME del recurso con parámetros de códecs opcionales
    :param array $atributos: atributos HTML
    :devuelve: etiqueta fuente HTML
    :rtype: cadena

    Le permite crear HTML ``<source />`` etiquetas. El primer parámetro contiene el
    fuente fuente. Ejemplo:

    .. literalinclude:: html_helper/015.php

.. php:function:: embed($src = ''[, $type = false[, $attributes = ''[, $indexPage = false]]])

    :param string $src: La ruta del recurso a incrustar
    :param bool $tipo: tipo MIME
    :param array $atributos: atributos HTML
    :param bool $páginaíndice:
    :devuelve: etiqueta HTML incrustada
    :rtype: cadena

    Le permite crear HTML ``<embed />`` etiquetas. El primer parámetro contiene el
    insertar fuente. Ejemplo:

    .. literalinclude:: html_helper/016.php

.. php:function:: object($data = ''[, $type = false[, $attributes = '']])

    :param  string $data: una URL de recurso
    :param bool $type: tipo de contenido del recurso
    :param array $atributos: atributos HTML
    :param array $params: utiliza la función param dentro de una matriz. Ver función :php:func:`param()`
    :devuelve: etiqueta de objeto HTML
    :rtype: cadena

    Le permite crear HTML ``<object />`` etiquetas. El primer parámetro contiene el
    datos del objeto. Ejemplo:

    .. literalinclude:: html_helper/017.php

    El código anterior producirá esto:

    .. code-block:: html

        <object data="movie.swf" class="test"></object>

        <object data="movie.swf" class="test">
          <param name="foo" type="ref" value="bar" class="test" />
          <param name="hello" type="ref" value="world" class="test" />
        </object>

.. php:function:: param($name = ''[, $type = false[, $attributes = '']])

    :param  string $nombre: el nombre del parámetro
    :param  string $valor: el valor del parámetro
    :param array $atributos: atributos HTML
    :devuelve: etiqueta de parámetro HTML
    :rtype: cadena

    Le permite crear HTML ``<param />`` etiquetas. El primer parámetro contiene el
    fuente del parámetro. Ejemplo:

    .. literalinclude:: html_helper/018.php

.. php:function:: track($name = ''[, $type = false[, $attributes = '']])

    :param  string $nombre: el nombre del parámetro
    :param  string $valor: el valor del parámetro
    :param array $atributos: atributos HTML
    :devuelve: etiqueta de seguimiento HTML
    :rtype: cadena

    Genera un elemento de pista para especificar pistas cronometradas. Las pistas son
    formateado en formato WebVTT. Ejemplo:

    .. literalinclude:: html_helper/019.php

.. php:function:: doctype([$type = 'html5'])

    :param  string $tipo: nombre de tipo de documento
    :devuelve: etiqueta HTML DocType
    :rtype: cadena

    Le ayuda a generar declaraciones de tipo de documento o DTD. HTML5
    se utiliza de forma predeterminada, pero hay muchos tipos de documentos disponibles.

    Ejemplo:

    .. literalinclude:: html_helper/020.php

    La siguiente es una lista de las opciones de tipo de documento predefinidas. Estos son configurables,
    extraídos de **app/Config/DocTypes.php**, o podrían anularse en su configuración **.env**.

    =============================== ==================== ==================================================== ==================================================== =================================================
    Tipo de documento Opción Resultado
    =============================== ==================== ==================================================== ==================================================== =================================================
    XHTML 1.1 xhtml11<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
    XHTML 1.0 estricto xhtml1-estricto <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    XHTML 1.0 Transicional xhtml1-trans <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    Conjunto de marcos XHTML 1.0 xhtml1-frame <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
    XHTML Básico 1.1 xhtml-basic11 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.1//EN" "http://www.w3.org/TR/xhtml-basic/xhtml-basic11.dtd">
    HTML5 HTML5<!DOCTYPE html>
    HTML 4 estricto html4-estricto<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
    HTML 4 Transicional html4-trans <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    Conjunto de marcos HTML 4 marco html4 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
    MathML 1.01 matemático1<!DOCTYPE math SYSTEM "http://www.w3.org/Math/DTD/mathml1/mathml.dtd">
    MathML 2.0 mathml2<!DOCTYPE math PUBLIC "-//W3C//DTD MathML 2.0//EN" "http://www.w3.org/Math/DTD/mathml2/mathml2.dtd">
    SVG 1.0 svg10 <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.0//EN" "http://www.w3.org/TR/2001/REC-SVG-20010904/DTD/svg10.dtd">
    SVG 1.1 completo svg11<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
    SVG 1.1 Básico svg11-básico <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1 Basic//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11-basic.dtd">
    SVG 1.1 Pequeño svg11-tiny <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1 Tiny//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11-tiny.dtd">
    XHTML+MathML+SVG (host XHTML) xhtml-math-svg-xh <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1 plus MathML 2.0 plus SVG 1.1//EN" "http://www.w3.org/2002/04/xhtml-math-svg/xhtml-math-svg.dtd">
    XHTML+MathML+SVG (host SVG) xhtml-math-svg-sh <!DOCTYPE svg:svg PUBLIC "-//W3C//DTD XHTML 1.1 plus MathML 2.0 plus SVG 1.1//EN" "http://www.w3.org/2002/04/xhtml-math-svg/xhtml-math-svg.dtd">
    XHTML+RDFa 1.0 xhtml-rdfa-1 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
    XHTML+RDFa 1.1 xhtml-rdfa-2 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.1//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-2.dtd">
    =============================== ==================== ==================================================== ==================================================== =================================================
