##############
Ver analizador
##############

.. contents::
    :local:
    :depth: 2

View Parser puede realizar una simple sustitución de texto para
pseudovariables contenidas en sus archivos de visualización.
Puede analizar variables simples o pares de etiquetas de variables.

Los nombres de pseudovariables o construcciones de control se escriben entre llaves, así::

    <html>
    <head>
        <title>{Titulo de Blog}</title>
    </head>
    <body>
        <h3>{blog_heading}</h3>

        {entradas de blog}
            <h5>{título}</h5>
            <p>{cuerpo}</p>
        {/entradas de blog}

    </body>
    </html>

Estas variables no son variables PHP reales, sino texto sin formato.
representaciones que te permiten eliminar PHP de tus plantillas
(archivos de vista).

.. note:: Higgs does **not** require you to use this class since
    usando PHP puro en sus páginas de visualización (por ejemplo usando el
    :doc:`Ver renderizador</outgoing/view_renderer>`  )
    les permite correr un poco más rápido.
    Sin embargo, algunos desarrolladores prefieren utilizar algún tipo de motor de plantillas si
    Trabajan con diseñadores que creen que encontrarían algunos
    confusión al trabajar con PHP.


Usando la clase de analizador de vistas
***************************************

El método más sencillo para cargar la clase de analizador es a través de su servicio:

.. literalinclude:: view_parser/001.php

Alternativamente, si no está utilizando la clase ``Parser`` como su renderizador predeterminado, puede
Puede crear una instancia directamente:

.. literalinclude:: view_parser/002.php

Luego puedes usar cualquiera de los tres métodos de renderizado estándar que proporciona:

``render()``, ``setVar()`` y
``setData()``. También podrá especificar delimitadores directamente,
a través del método ``setDelimiters()``.

.. important:: Using the ``Parser``, your view templates are processed only by the Parser
    en sí mismo, y no como un script PHP de vista convencional. Código PHP en dicho script
    El analizador lo ignora y solo se realizan sustituciones.

    Esto tiene un propósito: ver archivos sin PHP.

Que hace
========

La clase ``Parser`` procesa "scripts PHP/HTML" almacenados en la ruta de visualización de la aplicación.
Estos scripts no pueden contener PHP.

Cada parámetro de vista (al que nos referimos como pseudovariable) desencadena una sustitución,
según el tipo de valor que proporcionó. Las pseudovariables no son
extraído en variables PHP; en cambio, se accede a su valor a través de la pseudovariable
sintaxis, donde se hace referencia a su nombre entre llaves.

La clase Parser utiliza una matriz asociativa internamente para acumular pseudovariables.
configuración hasta que llame a su ``render()``. Esto significa que sus nombres de pseudovariables
debe ser único, o una configuración de parámetro posterior anulará una anterior.

Esto también afecta los valores de los parámetros de escape para diferentes contextos dentro de su
guion. Tendrá que darle a cada valor de escape un nombre de parámetro único.

Plantillas de analizador
========================

Puede utilizar el método ``render()`` para analizar (o renderizar) plantillas simples,
como esto:

.. literalinclude:: view_parser/003.php

Los parámetros de vista se pasan a ``setData()`` como asociativo
conjunto de datos que se reemplazarán en la plantilla. En el ejemplo anterior, el
la plantilla contendría dos variables: ``{blog_title}`` y ``{blog_heading}``
El primer parámetro de ``render()`` contiene el nombre de la vista :doc:`
archivo</outgoing/views>` , Donde *blog_template* es el nombre de su archivo de visualización.

.. important:: If the file extension is omitted, then the views are expected to end with the .php extension.

Opciones de configuración del analizador
========================================

Se pueden pasar varias opciones a los métodos ``render()`` o ``renderString()``.

- ``caché`` - el tiempo en segundos, para guardar los resultados de una vista; ignorado para renderString()
- ``cache_name``: la ID utilizada para guardar/recuperar el resultado de una vista en caché; por defecto es la ruta de visualización;
    ignorado para renderString()
- ``saveData``: verdadero si los parámetros de datos de la vista deben conservarse para llamadas posteriores;
    el valor predeterminado es **verdadero**
- ``cascadeData`` - verdadero si la configuración de pseudovariables debe pasarse a anidados
    sustituciones; el valor predeterminado es **verdadero**

.. literalinclude:: view_parser/004.php


Variaciones de sustitución
**************************

Se admiten tres tipos de sustitución: simple, en bucle y anidada.
Las sustituciones se realizan en la misma secuencia en la que se agregaron las pseudovariables.

La **sustitución simple** realizada por el analizador es uno a uno
reemplazo de pseudovariables donde el parámetro de datos correspondiente
tiene un valor escalar o de cadena, como en este ejemplo:

.. literalinclude:: view_parser/005.php

El ``Parser`` lleva la sustitución mucho más allá con "pares de variables",
utilizado para sustituciones anidadas o bucles, y con algunas funciones avanzadas
construcciones para sustitución condicional.

Cuando se ejecuta el analizador, generalmente

- manejar cualquier sustitución condicional
- Manejar cualquier sustituciones anidadas/en bucle.
- manejar las sustituciones individuales restantes

Sustituciones de bucle
======================

Una sustitución de bucle ocurre cuando el valor de una pseudovariable es
una matriz secuencial de matrices, como una matriz de configuraciones de fila.

El código de ejemplo anterior permite reemplazar variables simples. Y si
le gustaría que se repitiera un bloque completo de variables, con cada
iteración que contiene nuevos valores? Considere el ejemplo de plantilla que mostramos.
en la parte superior de la página::

    <html>
    <head>
        <title>{Titulo de Blog}</title>
    </head>
    <body>
        <h3>{blog_heading}</h3>

        {entradas de blog}
            <h5>{título}</h5>
            <p>{cuerpo}</p>
        {/entradas de blog}

    </body>
    </html>

En el código anterior notarás un par de variables: ``{blog_entries}``
datos... ``{/blog_entries}``. En un caso como este, toda la porción de datos
entre estos pares se repetiría varias veces, correspondiente a
el número de filas en el elemento "blog_entries" de la matriz de parámetros.

El análisis de pares de variables se realiza utilizando el código idéntico que se muestra arriba para
analizar variables individuales, excepto que agregará una matriz multidimensional
correspondiente a sus datos de par de variables. Considere este ejemplo:

.. literalinclude:: view_parser/006.php

El valor de la pseudovariable ``blog_entries`` es secuencial.
conjunto de conjuntos asociativos. El nivel exterior no tiene claves asociadas.
con cada una de las "filas" anidadas.

Si los datos de su "par" provienen de un resultado de base de datos, que ya es un
matriz multidimensional, simplemente puede usar la base de datos ``getResultArray()``
método:

.. literalinclude:: view_parser/007.php

Si la matriz que está intentando recorrer contiene objetos en lugar de matrices,
el analizador primero buscará un método ``asArray()`` en el objeto. Si existiera,
se llamará a ese método y la matriz resultante se recorrerá en bucle tal como
descrito arriba. Si no existe ningún método ``asArray()``, el objeto se convertirá como
una matriz y sus propiedades públicas estarán disponibles para el analizador.

Esto es especialmente útil con las clases Entity, que tienen un método ``asArray()``.
que devuelve todas las propiedades públicas y protegidas (menos la propiedad _options) y
los pone a disposición del analizador.

Sustituciones anidadas
======================

Una sustitución anidada ocurre cuando el valor de una pseudovariable es
una matriz asociativa de valores, como un registro de una base de datos:

.. literalinclude:: view_parser/008.php

El valor de la pseudovariable ``blog_entries`` es asociativo
formación. Los pares clave/valor definidos en su interior quedarán expuestos en su interior.
el bucle de par de variables para esa variable.

Un **blog_template.php** que podría funcionar para lo anterior::

    <h1>{blog_title} - {blog_heading}</h1>
    {entradas de blog}
        <div>
            <h2>{título}</h2>
            <p>{cuerpo}</p>
        </div>
    {/entradas de blog}

Si desea que se pueda acceder a las otras pseudovariables dentro de ``blog_entries``
alcance, luego asegúrese de que la opción ``cascadeData`` esté configurada en verdadero.

Comentarios
===========

Puede colocar comentarios en sus plantillas que serán ignorados y eliminados durante el análisis ajustando el
comentarios en símbolos ``{# #}``.

::

    {# Este comentario se elimina durante el análisis. #}
    {Entrada de blog}
        <div>
            <h2>{título}</h2>
            <p>{cuerpo}</p>
        </div>
    {/Entrada de blog}

Datos en cascada
================

Tanto con una sustitución anidada como con una de bucle, tiene la opción de realizar cambios en cascada.
pares de datos en la sustitución interna.

El siguiente ejemplo no se ve afectado por la cascada:

.. literalinclude:: view_parser/009.php

Este ejemplo proporciona resultados diferentes, según la conexión en cascada:

.. literalinclude:: view_parser/010.php

Prevención del análisis
=======================

Puede especificar partes de la página que no se analizarán con el par de etiquetas ``{noparse}````{/noparse}``. Cualquier cosa en esto
La sección permanecerá exactamente como está, sin sustitución de variables, bucles, etc., que ocurran en el marcado entre corchetes.

::

    {noparse}
        <h1>Código intacto</h1>
    {/noparse}

Lógica condicional
==================

La clase Parser admite algunos condicionales básicos para manejar la sintaxis ``if``, ``else`` y ``elseif``. Todo ``si``
Los bloques deben cerrarse con una etiqueta ``endif``::

    {si $rol=='admin'}
        <h1>¡Bienvenido, administrador!</h1>
    {terminara si}

Este bloque simple se convierte en lo siguiente durante el análisis:

.. literalinclude:: view_parser/011.php

Todas las variables utilizadas dentro de las declaraciones if deben haberse configurado previamente con el mismo nombre. Aparte de eso, es
Se trata exactamente como un condicional PHP estándar, y todas las reglas PHP estándar se aplicarían aquí. Puedes usar cualquier
de los operadores de comparación que usaría normalmente, como ``==``, ``===``, ``!==``, ``<``, ``>``, etc.

::

    {si $rol=='admin'}
        <h1>Bienvenido, administrador</h1>
    {elseif $rol=='moderador'}
        <h1>Bienvenido, moderador</h1>
    {demás}
        <h1>Bienvenido, usuario</h1>
    {terminara si}

.. warning:: In the background, conditionals are parsed using an ``eval()``, so you must ensure that you take
    Tenga cuidado con los datos del usuario que se utilizan dentro de los condicionales, o podría exponer su aplicación a riesgos de seguridad.

Cambiar los delimitadores condicionales
-----------------------------------

Si tiene código JavaScript como el siguiente en sus plantillas, el analizador genera un error de sintaxis porque hay cadenas que pueden interpretarse como condicional::

    <script type="text/javascript">
        var f = función() {
            si (tiene alerta) {
                mensaje de alerta}');
            }
        }
    </script>

En ese caso, puedes cambiar los delimitadores de los condicionales con el método ``setConditionalDelimiters()`` para evitar malas interpretaciones:

.. literalinclude:: view_parser/027.php

En este caso, escribirás código en tu plantilla::

    {% si $rol=='admin' %}
        <h1>Bienvenido, administrador</h1>
    {% demás %}
        <h1>Bienvenido, usuario</h1>
    {% terminara si %}

Escapar de datos
================

De forma predeterminada, todas las sustituciones de variables se escapan para ayudar a prevenir ataques XSS en sus páginas. Método ``esc()`` de Higgs
soporta varios contextos diferentes, como ``html`` general, cuando está en un ``attr`` HTML, en ``css``, etc. Si nada
Si se especifica lo contrario, se asumirá que los datos están en un contexto HTML. Puede especificar el contexto utilizado utilizando ``esc()``
filtrar::

    { estilos_usuario | esc(css) }
    <a href="{ user_link | esc(attr) }">{ título }</a>

Habrá momentos en los que absolutamente necesitarás algo para usar y NO escapar. Puedes hacer esto agregando una exclamación.
marcas en las llaves de apertura y cierre::

    {! var_sin escapar!}

Filtros
=======

A cualquier sustitución de una sola variable se le pueden aplicar uno o más filtros para modificar la forma en que se presenta. Estos
no pretenden cambiar drásticamente la salida, sino proporcionar formas de reutilizar los mismos datos variables pero con diferentes
presentaciones. El filtro ``esc`` discutido anteriormente es un ejemplo. Las fechas son otro caso de uso común, en el que podrías
Es necesario formatear los mismos datos de forma diferente en varias secciones de la misma página.

Los filtros son comandos que vienen después del nombre de la pseudovariable y están separados por el símbolo de barra vertical, ``|``::

    // -55 se muestra como 55
    { valor|abs }

Si el parámetro toma algún argumento, debe estar separado por comas y entre paréntesis::

    {creado_en|fecha(Año) }

Se pueden aplicar varios filtros al valor uniendo varios filtros. Se procesan en orden, desde
de izquierda a derecha::

    {creado_en|fecha_modificar(+5 días)|fecha(Año) }

Filtros proporcionados
----------------

Los siguientes filtros están disponibles cuando se utiliza el analizador:
================ ================= ================== ========================================== ======== ===============================
Ejemplo de descripción de argumentos de filtro
================ ================= ================== ========================================== ======== ===============================
abs Muestra el valor absoluto de un número. {v|abdominales}

capitalizar Muestra la cadena en mayúsculas y minúsculas: todo en minúsculas {v|capitalizar}
                                   con la primera letra en mayúscula.

formato de fecha (Ymd) Una cadena de formato PHP compatible con **fecha**. {v|fecha(Fecha)}

valor date_modify para agregar Una cadena compatible **strtotime** para modificar la fecha, { v|date_modify(+1 día) }
                  / restar como ``+5 días`` o ``-1 semana``.

default valor predeterminado Muestra el valor predeterminado si la variable es `empty()`_. { v|predeterminado (por si acaso) }

esc html, attr, Especifica el contexto para escapar de los datos. {v|esc(atributo)}
                  css, js

frase de extracto, radio Devuelve el texto dentro de un radio de palabras de un { v|excerpt(gigante verde, 20) } dado
                                   frase. Igual que la función auxiliar **extracto**.

resaltar frase Resalta una frase determinada dentro del texto usando { v|highlight(view parser) }
                                   '<mark></mark> 'etiquetas.

resaltado_código Destaca ejemplos de código con HTML/CSS. {v|código_resaltado}

limit_chars limit Limita el número de caracteres a $limit. { v|limit_chars(100) }

limit_words limit Limita el número de palabras a $limit. { v|límite_palabras(20) }

moneda_moneda local, muestra una versión localizada de una moneda. "moneda" { v|moneda_local(EUR,en_US) }
                  configuración regional, valor es cualquier código de moneda ISO 4217 de 3 letras.
                  fracción

local_number tipo, precisión, Muestra una versión localizada de un número. "tipo" puede ser { v|local_number(decimal,2,en_US) }
                  configuración regional uno de: decimal, moneda, porcentaje, científico, deletreado,
                                   ordinal, duración.

lower Convierte una cadena a minúsculas. {v|inferior}

nl2br Reemplaza todos los caracteres de nueva línea (\n) a un HTML<br/> etiqueta. {v|nl2br}

number_format coloca Envuelve la función PHP **number_format** para su uso dentro de { v|number_format(3) }
                                   analizador.

prose Toma un cuerpo de texto y usa **auto_typography()** { v|prose }
                                   método para convertirla en una prosa más bonita y más fácil de leer.

redondear lugares, escriba Redondea un número a los lugares especificados. Tipos de **techo** { v|round(3) } { v|round(techo) }
                                   y se puede pasar **floor** para usar esas funciones en su lugar.

strip_tags caracteres permitidos Envuelve PHP **strip_tags**. Puede aceptar una cadena de permitidas {v|strip_tags(<br> ) }
                                   etiquetas.

título Muestra una versión "título en mayúsculas y minúsculas" de la cadena, con todo {v|título}
                                   minúsculas y cada palabra en mayúscula.

Upper Muestra la cadena en mayúsculas. {v|superior}
================ ================= ================== ========================================== ======== ===============================

.. _empty(): https://www.php.net/manual/en/function.empty.php

Consulte `NumberFormatter de PHP<https://www.php.net/manual/en/numberformatter.create.php>` _ para detalles relevantes a la
Filtro "número_local".

Filtros personalizados
--------------

Puedes crear fácilmente tus propios filtros editando **app/Config/View.php** y agregando nuevas entradas al
Matriz ``$filtros``. Cada clave es el nombre con el que se llama al filtro en la vista, y su valor es cualquier PHP válido.
invocable:

.. literalinclude:: view_parser/012.php

Complementos del analizador
===========================

Los complementos le permiten ampliar el analizador y agregar funciones personalizadas para cada proyecto. Pueden ser cualquier PHP invocable, lo que hace
son muy simples de implementar. Dentro de las plantillas, los complementos se especifican mediante etiquetas ``{+ +}``::

    {+ foo +} contenido interno {+ /foo +}

Este ejemplo muestra un complemento llamado **foo**. Puede manipular cualquier contenido entre sus etiquetas de apertura y cierre.
En este ejemplo, podría funcionar con el texto " contenido interno ". Los complementos se procesan antes que cualquier pseudovariable.
suceden los reemplazos.

Si bien los complementos a menudo constan de pares de etiquetas, como se muestra arriba, también pueden ser una sola etiqueta, sin etiqueta de cierre::

    {+foo+}

Las etiquetas de apertura también pueden contener parámetros que pueden personalizar el funcionamiento del complemento. Los parámetros se representan como
pares clave/valor::

    {+ foo bar=2 baz="xy" +}

Los parámetros también pueden ser valores únicos::

    {+ incluir algún archivo.php +}

Complementos proporcionados
----------------

Los siguientes complementos están disponibles cuando se utiliza el analizador:
================== ========================== ======= ===================================== ============= ==================================================== =
Ejemplo de descripción de argumentos de complemento
================== ========================== ======= ===================================== ============= ==================================================== =
current_url Alias de la función auxiliar current_url. {+ URL_actual +}
URL_anterior Alias de la función auxiliar URL_anterior. {+ URL_anterior +}
siteURL Alias de la función auxiliar site_url. {+ URL del sitio "iniciar sesión" +}
correo electrónico mailto, título, atributos Alias para la función auxiliar mailto. {+ mailto email=foo@example.com title="Cosas más extrañas" +}
safe_mailto correo electrónico, título, atributos Alias de la función auxiliar safe_mailto. {+ safe_mailto email=foo@example.com title="Cosas más extrañas" +}
cadena de idioma lang Alias para la función auxiliar de idioma. {+ número de idioma.terabyteAbbr +}
validation_errors nombre de campo (opcional) Devuelve una cadena de error para el campo {+ validation_errors +}, {+ validation_errors field="email" +}
                                             (si se especifica) o todos los errores de validación.
ruta nombre de ruta Alias para la función auxiliar route_to. {+ ruta "iniciar sesión" +}
csp_script_nonce Alias para el asistente csp_script_nonce {+ csp_script_nonce +}
                                             función.
csp_style_nonce Alias para el asistente csp_style_nonce {+ csp_style_nonce +}
                                             función.
================== ========================== ======= ===================================== ============= ==================================================== =

Registrar un complemento
--------------------

En su forma más simple, todo lo que necesita hacer para registrar un nuevo complemento y prepararlo para su uso es agregarlo al
**app/Config/View.php**, bajo la matriz ``$plugins``. La clave es el nombre del complemento que está
utilizado dentro del archivo de plantilla. El valor es cualquier PHP invocable válido, incluidos los métodos de clase estática:

.. literalinclude:: view_parser/014.php

También puedes usar cierres, pero estos solo se pueden definir en el constructor del archivo de configuración:

.. literalinclude:: view_parser/015.php

Si el invocable es independiente, se trata como una etiqueta única, no como una de apertura/cierre. Será reemplazado por
el valor de retorno del complemento:

.. literalinclude:: view_parser/016.php

Si el invocable está envuelto en una matriz, se trata como un par de etiquetas de apertura/cierre que puede operar en cualquiera de
el contenido entre sus etiquetas:

.. literalinclude:: view_parser/017.php


Notas de uso
************

Si incluye parámetros de sustitución a los que no se hace referencia en su
plantilla, se ignoran:

.. literalinclude:: view_parser/018.php

Si no incluye un parámetro de sustitución al que se hace referencia en su
plantilla, la pseudovariable original se muestra en el resultado:

.. literalinclude:: view_parser/019.php

Si proporciona un parámetro de sustitución de cadena cuando se espera una matriz,
es decir, para un par de variables, la sustitución se realiza por la variable de apertura
etiqueta de par, pero la etiqueta de par de la variable de cierre no se representa correctamente:

.. literalinclude:: view_parser/020.php

Ver fragmentos
==============

No es necesario utilizar pares de variables para obtener el efecto de iteración en
tus vistas. Es posible utilizar un fragmento de vista para lo que habría dentro.
un par de variables y, en su lugar, controlar la iteración en su controlador
de en la vista.

Un ejemplo con la iteración controlada en la vista::

    $plantilla = '<ul> {elementos de menú}
        <li><a href="{link}">{título}</a></li>
    {/elementos de menú}</ul> &#39;;

    $datos = [
        'elementos de menú' => [
            ['título' => 'Primer enlace', 'enlace' => '/primero'],
            ['título' => 'Segundo enlace', 'enlace' => '/segundo'],
        ]
    ];

    devolver $parser->setData($data)->renderString($template);

Resultado::

    <ul>
        <li><a href="/first">Primer enlace</a></li>
        <li><a href="/second">Segundo enlace</a></li>
    </ul>

Un ejemplo con la iteración controlada en el controlador,
usando un fragmento de vista:

.. literalinclude:: view_parser/021.php

Resultado::

    <ul>
        <li><a href="/first">Primer enlace</a></li>
        <li><a href="/second">Segundo enlace</a></li>
    </ul>


Referencia de clase
*******************

.. php:namespace:: Higgs\View

.. php:class:: Parser

    .. php:method:: render($view[, $options[, $saveData]])

        :param  string $view: nombre de archivo de la fuente de la vista
        :param array $options: conjunto de opciones, como pares clave/valor
        :param boolean $saveData: si es verdadero, guardará los datos para usarlos con otras llamadas; si es falso, limpiará los datos después de representar la vista.
        :devuelve: El texto renderizado para la vista elegida
        :rtype: cadena

        Genera la salida basándose en un nombre de archivo y cualquier dato que ya se haya configurado:

        .. literalinclude:: view_parser/022.php

        Opciones admitidas:

            - ``cache`` - el tiempo en segundos, para guardar los resultados de una vista
            - ``cache_name``: la ID utilizada para guardar/recuperar el resultado de una vista en caché; por defecto es la ruta de visualización
            - ``cascadeData``: verdadero si los pares de datos vigentes cuando se produce una sustitución anidada o en bucle deben propagarse
            - ``saveData``: verdadero si el parámetro de visualización de datos debe conservarse para llamadas posteriores

        Cualquier sustitución condicional se realiza primero y luego el resto.
        Se realizan sustituciones para cada par de datos.

    .. php:method:: renderString($template[, $options[, $saveData]])

        :param  string $plantilla: Ver fuente proporcionada como una cadena
        :param array $options: conjunto de opciones, como pares clave/valor
        :param boolean $saveData: si es verdadero, guardará los datos para usarlos con otras llamadas; si es falso, limpiará los datos después de representar la vista.
        :devuelve: El texto renderizado para la vista elegida
        :rtype: cadena

        Crea la salida basándose en una fuente de plantilla proporcionada y cualquier dato que ya se haya configurado:

        .. literalinclude:: view_parser/023.php

        Opciones admitidas y comportamiento como se indica arriba.

    .. php:method:: setData([$data[, $context = null]])

        :param array $data: conjunto de cadenas de datos de vista, como pares clave/valor
        :param string $context: el contexto que se utilizará para el escape de datos.
        :devuelve: El Renderizador, para encadenamiento de métodos
        :rtype: Higgs\\View\\RendererInterface.

        Establece varios datos de vista a la vez:

        .. literalinclude:: view_parser/024.php

        Contextos de escape admitidos: html, css, js, url, attr o raw.
        Si es "crudo", no se producirá ningún escape.

    .. php:method:: setVar($name[, $value = null[, $context = null]])

        :param  string $nombre: nombre de la variable de datos de la vista
        :param mixed $valor: El valor de los datos de esta vista
        :param string $context: el contexto que se utilizará para el escape de datos.
        :devuelve: El Renderizador, para encadenamiento de métodos
        :rtype: Higgs\\View\\RendererInterface.

        Establece una sola pieza de datos de vista:

        .. literalinclude:: view_parser/025.php

        Contextos de escape admitidos: html, css, js, url, attr o raw.
        Si es "crudo", no se producirá ningún escape.

    .. php:method:: setDelimiters($leftDelimiter = '{', $rightDelimiter = '}')

        :param string $leftDelimiter: Delimitador izquierdo para campos de sustitución
        :param string $rightDelimiter: delimitador derecho para campos de sustitución
        :devuelve: El Renderizador, para encadenamiento de métodos
        :rtype: Higgs\\View\\RendererInterface.

        Anule los delimitadores del campo de sustitución:

        .. literalinclude:: view_parser/026.php

    .. php:method:: setConditionalDelimiters($leftDelimiter = '{', $rightDelimiter = '}')

        :param string $leftDelimiter: Delimitador izquierdo para condicionales
        :param string $rightDelimiter: delimitador derecho para condicionales
        :devuelve: El Renderizador, para encadenamiento de métodos
        :rtype: Higgs\\View\\RendererInterface.

        Anule los delimitadores condicionales:

        .. literalinclude:: view_parser/027.php
