################
Ver renderizador
################

.. contents::
    :local:
    :depth: 2


Usando el renderizador de vistas
********************************

La función :php:func:`view()` es una función conveniente que toma una instancia del
servicio ``renderer``, establece los datos y representa la vista. Si bien esto es a menudo
exactamente lo que desea, es posible que en ocasiones desee trabajar con ello de manera más directa.
En ese caso podrás acceder al servicio Ver directamente:

.. literalinclude:: view_renderer/001.php
   :lines: 2-

Alternativamente, si no estás usando la clase ``Ver`` como tu renderizador predeterminado, puedes
Puede crear una instancia directamente:

.. literalinclude:: view_renderer/002.php
   :lines: 2-

.. important:: You should create services only within controllers. If you need
    acceso a la clase Ver desde una biblioteca, debe configurarlo como una dependencia
    en el constructor de su biblioteca.

Luego puede utilizar cualquiera de los tres métodos estándar que proporciona:

:php:meth:`render()<Higgs\\View\\View::render()>` ,
:php:meth:`setVar()<Higgs\\View\\View::setVar()>`  y
:php:meth:`setData()<Higgs\\View\\View::setData()>` .

Que hace
========

La clase ``View`` procesa scripts HTML/PHP convencionales almacenados en la ruta de visualización de la aplicación,
después de extraer los parámetros de vista en variables PHP, accesibles dentro de los scripts.
Esto significa que los nombres de los parámetros de su vista deben ser nombres de variables PHP legales.

La clase Ver utiliza una matriz asociativa internamente para acumular parámetros de vista.
hasta que llames a su ``render()``. Esto significa que los nombres de sus parámetros (o variables)
debe ser único, o una configuración de variable posterior anulará una anterior.

Esto también afecta los valores de los parámetros de escape para diferentes contextos dentro de su
guion. Tendrá que darle a cada valor de escape un nombre de parámetro único.

No se atribuye ningún significado especial a los parámetros cuyo valor es una matriz. Le corresponde
a usted para procesar la matriz apropiadamente en su código PHP.

Configuración de parámetros de vista
====================================

El :php:meth:`setVar()<Higgs\\View\\View::setVar()>` El método establece un parámetro de vista.

.. literalinclude:: view_renderer/008.php
   :lines: 2-

El :php:meth:`setData()<Higgs\\View\\View::setData()>` el método establece vistas múltiples
parámetros a la vez.

.. literalinclude:: view_renderer/007.php
   :lines: 2-

Encadenamiento de métodos
=========================

Los métodos ``setVar()`` y ``setData()`` se pueden encadenar, lo que le permite combinar un
número de llamadas diferentes juntas en una cadena:

.. literalinclude:: view_renderer/003.php
   :lines: 2-

Escapar de datos
================

Cuando pasas datos a las funciones ``setVar()`` y ``setData()`` tienes la opción de escapar de los datos a proteger.
contra ataques de scripts entre sitios. Como último parámetro en cualquiera de los métodos, puede pasar el contexto deseado a
escapar de los datos para. Consulte a continuación las descripciones del contexto.

Si no desea que se escapen los datos, puede pasar ``null`` o ``'raw'`` como parámetro final para cada función:

.. literalinclude:: view_renderer/004.php
   :lines: 2-

Si elige no escapar de los datos, o está pasando una instancia de objeto, puede escapar manualmente los datos dentro
la vista con la función :php:func:`esc()`. El primer parámetro es la cadena a escapar. El segundo parámetro es el
contexto para escapar de los datos (ver más abajo)::

    <?= esc($object->obtenerEstadística()) ?>

Escapar de contextos
-----------------

Por defecto, las funciones ``esc()`` y, a su vez, las funciones ``setVar()`` y ``setData()`` asumen que los datos que desea
escape está diseñado para usarse dentro de HTML estándar. Sin embargo, si los datos están destinados a ser utilizados en Javascript, CSS,
o en un atributo href, necesitaría diferentes reglas de escape para que sea efectivo. Puedes pasar el nombre del
contexto como segundo parámetro. Los contextos válidos son ``'html'``, ``'js'``, ``'css'``, ``'url'`` y ``'attr'``::

    <a href="<?= esc($url, 'url') ?>" data-foo="<?= esc($bar, 'attr') ?>">Algún enlace</a>

    <script>
        var nombre del sitio = '<?= esc($siteName, 'js') ?> &#39;;
    </script>

    <style>
        cuerpo {
            color de fondo:<?= esc('bgColor', 'css') ?>
        }
    </style>

Ver opciones de renderizado
===========================

Se pueden pasar varias opciones a los métodos ``render()`` o ``renderString()``:

- ``$opciones``

    - ``caché`` - el tiempo en segundos, para guardar los resultados de una vista; ignorado por
      ``renderString()``.
    - ``cache_name``: la ID utilizada para guardar/recuperar el resultado de una vista en caché; valores predeterminados
      al ``$viewPath``; ignorado para ``renderString()``.
    - ``debug``: se puede configurar en falso para deshabilitar la adición de código de depuración para
      :ref:`Barra de herramientas de depuración<the-debug-toolbar>` .
- ``$saveData`` - verdadero si los parámetros de datos de la vista deben conservarse durante
  convocatorias posteriores.

.. note:: ``$saveData`` as defined by the interface must be a boolean, but implementing
    las clases (como ``Ver`` a continuación) pueden ampliar esto para incluir valores ``nulos``.


Referencia de clase
*******************

.. php:namespace:: Higgs\View

.. php:class:: View

    .. php:method:: render($view[, $options[, $saveData = false]])

        :param  string $view: nombre de archivo de la fuente de la vista
        :param array $options: conjunto de opciones, como pares clave/valor
        :param boolean|null $saveData: si es verdadero, guardará los datos para usarlos con otras llamadas. Si es falso, limpiará los datos después de representar la vista. Si es nulo, utiliza la configuración de configuración.
        :devuelve: El texto renderizado para la vista elegida
        :rtype: cadena

        Genera la salida basándose en un nombre de archivo y cualquier dato que ya se haya configurado:

        .. literalinclude:: view_renderer/005.php
           :lines: 2-

    .. php:method:: renderString($view[, $options[, $saveData = false]])

        :param string $view: Contenido de la vista a representar, por ejemplo, contenido recuperado de una base de datos
        :param array $options: conjunto de opciones, como pares clave/valor
        :param boolean|null $saveData: si es verdadero, guardará los datos para usarlos con otras llamadas. Si es falso, limpiará los datos después de representar la vista. Si es nulo, utiliza la configuración de configuración.
        :devuelve: El texto renderizado para la vista elegida
        :rtype: cadena

        Crea la salida basándose en un fragmento de vista y cualquier dato que ya se haya configurado:

        .. literalinclude:: view_renderer/006.php
           :lines: 2-

    .. warning:: This could be used for displaying content that might have been stored in a database,
        pero debe tener en cuenta que se trata de una posible vulnerabilidad de seguridad,
        y que **debes** validar dichos datos y probablemente escapar de ellos
        ¡adecuadamente!

    .. php:method:: setData([$data[, $context = null]])

        :param array $data: conjunto de cadenas de datos de vista, como pares clave/valor
        :param string $context: el contexto que se utilizará para el escape de datos.
        :devuelve: El Renderizador, para encadenamiento de métodos
        :rtype: Higgs\\View\\RendererInterface.

        Establece varios datos de vista a la vez:

        .. literalinclude:: view_renderer/007.php
           :lines: 2-

        Contextos de escape admitidos: ``html``, ``css``, ``js``, ``url`` o ``attr`` o ``raw``.
        Si es ``'crudo'``, no se producirá ningún escape.

        Cada llamada se suma a la matriz de datos que el objeto está acumulando,
        hasta que se renderice la vista.

    .. php:method:: setVar($name[, $value = null[, $context = null]])

        :param  string $nombre: nombre de la variable de datos de la vista
        :param mixed $valor: El valor de los datos de esta vista
        :param string $context: el contexto que se utilizará para el escape de datos.
        :devuelve: El Renderizador, para encadenamiento de métodos
        :rtype: Higgs\\View\\RendererInterface.

        Establece una sola pieza de datos de vista:

        .. literalinclude:: view_renderer/008.php
           :lines: 2-

        Contextos de escape admitidos: ``html``, ``css``, ``js``, ``url``, ``attr`` o ``raw``.
        Si es ``'crudo'``, no se producirá ningún escape.

        Si utiliza la variable de datos de vista que ha utilizado anteriormente
        para este objeto, el nuevo valor reemplazará al existente.
