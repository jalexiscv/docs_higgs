################
Asistente de URL
################

El archivo URL Helper contiene funciones que ayudan a trabajar con URL.

.. contents::
    :local:
    :depth: 2

Cargando este ayudante
======================

El marco carga automáticamente este asistente en cada solicitud.

Funciones disponibles
=====================

Están disponibles las siguientes funciones:

.. php:function:: site_url([$uri = ''[, $protocol = null[, $altConfig = null]]])

    :param array|string $uri: cadena de URI o matriz de segmentos de URI.
    :param string $protocol: Protocolo, por ejemplo, 'http' o 'https'. Si se establece una cadena vacía '', se devuelve un enlace relativo al protocolo.
    :param \\Config\\App $altConfig: Configuración alternativa a utilizar.
    :devuelve: URL del sitio
    :rtype: cadena

    .. note:: Since v7.3.0, if you set ``Config\App::$allowedHostnames``,
        esto devuelve la URL con el nombre de host establecido si la URL actual coincide.

    Devuelve la URL de su sitio, como se especifica en su archivo de configuración. El **index.php**
    archivo (o lo que haya configurado como su sitio ``Config\App::$indexPage`` en su configuración
    archivo) se agregará a la URL, al igual que cualquier segmento de URI que pase al
    función.

    Le recomendamos que utilice esta función cada vez que necesite generar un
    URL local para que sus páginas sean más portátiles en caso de que su URL
    cambios.

    Opcionalmente, los segmentos se pueden pasar a la función como una cadena o un
    formación. Aquí hay un ejemplo de cadena:

    .. literalinclude:: url_helper/001.php

    El ejemplo anterior devolvería algo como:

    **http://example.com/index.php/news/local/123**

    A continuación se muestra un ejemplo de segmentos pasados como una matriz:

    .. literalinclude:: url_helper/002.php

    Puede que la configuración alternativa le resulte útil si genera URL para un
    sitio diferente al suyo, que contiene diferentes preferencias de configuración.
    Usamos esto para pruebas unitarias del marco en sí.

.. php:function:: base_url([$uri = ''[, $protocol = null]])

    :param array|string $uri: cadena de URI o matriz de segmentos de URI.
    :param string $protocol: Protocolo, por ejemplo, 'http' o 'https'. Si se establece una cadena vacía '', se devuelve un enlace relativo al protocolo.
    :devuelve: URL base
    :rtype: cadena

    .. note:: Since v7.3.0, if you set ``Config\App::$allowedHostnames``,
        esto devuelve la URL con el nombre de host establecido si la URL actual coincide.

    .. note:: In previous versions, this returned the base URL without a trailing
        barra diagonal (``/``) cuando se llama sin argumento. El error fue solucionado y
        desde v7.3.2 devuelve la URL base con una barra diagonal.

    Devuelve la URL base de su sitio, como se especifica en su archivo de configuración. Ejemplo:

    .. literalinclude:: url_helper/003.php

    Esta función devuelve lo mismo que :php:func:`site_url()`, sin
    se agrega ``Config\App::$indexPage``.

    También como :php:func:`site_url()`, puedes proporcionar segmentos como una cadena o
    una matriz. Aquí hay un ejemplo de cadena:

    .. literalinclude:: url_helper/004.php

    El ejemplo anterior devolvería algo como:

    **http://ejemplo.com/blog/post/123**

    Si pasa una cadena vacía ``''`` como segundo parámetro, devuelve
    el enlace relativo al protocolo:

    .. literalinclude:: url_helper/026.php

    Esto es útil porque a diferencia de :php:func:`site_url()`, puedes proporcionar un
    cadena a un archivo, como una imagen o una hoja de estilo. Por ejemplo:

    .. literalinclude:: url_helper/005.php

    Esto te daría algo como:

    **http://example.com/images/icons/edit.png**

.. php:function:: current_url([$returnObject = false[, $request = null]])

    :param boolean $returnObject: True si desea que se devuelva una instancia de URI, en lugar de una cadena.
    :param IncomingRequest|null $request: una solicitud alternativa para usar en la detección de ruta; útil para realizar pruebas.
    :devuelve: La URL actual
    :rtype: cadena|\\Higgs\\HTTP\\URI

    Devuelve la URL completa de la página que se está viendo actualmente.
    Al devolver una cadena, se eliminan las partes de consulta y fragmento de la URL.
    Al devolver el URI, se conservan las partes de la consulta y del fragmento.

    Sin embargo, por razones de seguridad, se crea en función de la configuración de ``Config\App``,
    y no pretende coincidir con la URL del navegador.

    Desde v7.3.0, si configura ``Config\App::$allowedHostnames``,
    esto devuelve la URL con el nombre de host establecido si la URL actual coincide.

    .. note:: Calling ``current_url()`` is the same as doing this:

        .. literalinclude:: url_helper/006.php
           :lines: 2-

    .. important:: Prior to v7.1.2, this function had a bug causing it to ignore the configuration on ``Config\App::$indexPage``.

.. php:function:: previous_url([$returnObject = false])

    :param boolean $returnObject: True si desea que se devuelva una instancia de URI en lugar de una cadena.
    :returns: la URL en la que se encontraba anteriormente el usuario
    :rtype: cadena|mixto|\\Higgs\\HTTP\\URI

    Devuelve la URL completa (incluidos los segmentos) de la página en la que se encontraba anteriormente el usuario.

    .. note:: Due to security issues of blindly trusting the ``HTTP_REFERER`` system variable, Higgs will
        almacenar páginas visitadas anteriormente en la sesión si está disponible. Esto asegura que siempre
        Utilice una fuente conocida y confiable. Si la sesión no se ha cargado o no está disponible de otro modo,
        luego se utilizará una versión desinfectada de ``HTTP_REFERER``.

.. php:function:: uri_string()

    :devuelve: una cadena URI
    :rtype: cadena

    Devuelve la parte de la ruta de la URL actual relativa a baseURL.

    Por ejemplo, cuando su URL base es **http://some-site.com/** y la URL actual es::

        http://some-site.com/blog/comments/123

    La función devolvería::

        blog/comentarios/123

    Cuando su URL base es **http://some-site.com/subfolder/** y la URL actual es::

        http://some-site.com/subfolder/blog/comments/123

    La función devolvería::

        blog/comentarios/123

    .. note:: In previous versions, the parameter ``$relative = false`` was defined.
        Sin embargo, debido a un error, esta función siempre devolvía una ruta relativa a baseURL.
        Desde v7.3.2, el parámetro se eliminó.

    .. note:: In previous versions, when you navigate to the baseURL, this function
        devolvió ``/``. Desde v7.3.2, el error se ha solucionado y devuelve un
        cadena vacía(``''``).

.. php:function:: index_page([$altConfig = null])

    :param \\Config\\App $altConfig: Configuración alternativa para usar
    :devuelve: El valor ``indexPage``
    :rtype: cadena

    Devuelve su sitio **indexPage**, como se especifica en su archivo de configuración.
    Ejemplo:

    .. literalinclude:: url_helper/007.php

    Al igual que con :php:func:`site_url()`, puede especificar una configuración alternativa.
    Puede que la configuración alternativa le resulte útil si genera URL para un
    sitio diferente al suyo, que contiene diferentes preferencias de configuración.
    Usamos esto para pruebas unitarias del marco en sí.

.. php:function:: anchor([$uri = ''[, $title = ''[, $attributes = ''[, $altConfig = null]]]])

    :param mixed $uri: cadena URI o matriz de segmentos URI
    :param  string $título: título ancla
    :param mixed $atributos: atributos HTML
    :param \\Config\\App $altConfig: Configuración alternativa para usar
    :devuelve: hipervínculo HTML (etiqueta de anclaje)
    :rtype: cadena

    Crea un enlace de anclaje HTML estándar basado en la URL de su sitio local.

    El primer parámetro puede contener cualquier segmento que desee agregar al
    URL. Al igual que con la función :php:func:`site_url()` anterior, los segmentos pueden
    ser una cadena o una matriz.

    .. note:: If you are building links that are internal to your application
        no incluya la URL base (``http://...``). Esto se agregará
        automáticamente a partir de la información especificada en su archivo de configuración.
        Incluya solo los segmentos de URI que desee agregar a la URL.

    El segundo segmento es el texto que le gustaría que dijera el enlace. Si usted
    déjelo en blanco, se utilizará la URL.

    El tercer parámetro puede contener una lista de atributos que le gustaría
    añadido al enlace. Los atributos pueden ser una cadena simple o una
    matriz asociativa.

    Aquí hay unos ejemplos:

    .. literalinclude:: url_helper/008.php

    Como se indicó anteriormente, puede especificar una configuración alternativa.
    Puede que la configuración alternativa le resulte útil si genera enlaces para un
    sitio diferente al suyo, que contiene diferentes preferencias de configuración.
    Usamos esto para pruebas unitarias del marco en sí.

    .. note:: Attributes passed into the anchor function are automatically escaped to protected against XSS attacks.

.. php:function:: anchor_popup([$uri = ''[, $title = ''[, $attributes = false[, $altConfig = null]]]])

    :param  string $uri: cadena URI
    :param  string $título: título ancla
    :param mixed $atributos: atributos HTML
    :param \\Config\\App $altConfig: Configuración alternativa para usar
    :devuelve: hipervínculo emergente
    :rtype: cadena

    Casi idéntica a la función :php:func:`anchor()` excepto que
    abre la URL en una nueva ventana. Puede especificar la ventana de JavaScript
    atributos en el tercer parámetro para controlar cómo se abre la ventana.
    Si el tercer parámetro no está configurado, simplemente se abrirá una nueva ventana con
    la configuración de su propio navegador.

    Aquí hay un ejemplo con atributos:

    .. literalinclude:: url_helper/009.php

    Como se indicó anteriormente, puede especificar una configuración alternativa.
    Puede que la configuración alternativa le resulte útil si genera enlaces para un
    sitio diferente al suyo, que contiene diferentes preferencias de configuración.
    Usamos esto para pruebas unitarias del marco en sí.

    .. note:: The above attributes are the function defaults so you only need to
        configure los que sean diferentes a lo que necesita. Si quieres el
        función para usar todos sus valores predeterminados simplemente pase una matriz vacía en el
        tercer parámetro:

        .. literalinclude:: url_helper/010.php

    .. note:: The **window_name** is not really an attribute, but an argument to
        la `ventana.open() de JavaScript<https://www.w3schools.com/jsref/met_win_open.asp>` _
        método, que acepta un nombre de ventana o un destino de ventana.

    .. note:: Any other attribute than the listed above will be parsed as an
        Atributo HTML a la etiqueta de anclaje.

    .. note:: Attributes passed into the anchor_popup function are automatically escaped to protected against XSS attacks.

.. php:function:: mailto($email[, $title = ''[, $attributes = '']])

    :param  string $correo electrónico: dirección de correo electrónico
    :param  string $título: título ancla
    :param mixed $atributos: atributos HTML
    :devuelve: Un hipervínculo "enviar a"
    :rtype: cadena

    Crea un enlace de correo electrónico HTML estándar. Ejemplo de uso:

    .. literalinclude:: url_helper/011.php

    Al igual que con la pestaña :php:func:`anchor()` anterior, puedes establecer atributos usando el
    tercer parámetro:

    .. literalinclude:: url_helper/012.php

    .. note:: Attributes passed into the mailto function are automatically escaped to protected against XSS attacks.

.. php:function:: safe_mailto($email[, $title = ''[, $attributes = '']])

    :param  string $correo electrónico: dirección de correo electrónico
    :param  string $título: título ancla
    :param mixed $atributos: atributos HTML
    :devuelve: Un hipervínculo "enviar a" seguro contra spam
    :rtype: cadena

    Idéntico a la función :php:func:`mailto()` excepto que escribe un mensaje ofuscado
    versión de la etiqueta *mailto* usando números ordinales escritos con JavaScript para
    ayudar a evitar que los robots de spam recopilen la dirección de correo electrónico.

.. php:function:: auto_link($str[, $type = 'both'[, $popup = false]])

    :param  string $cadena: cadena de entrada
    :param string $type: tipo de enlace ('correo electrónico', 'url' o 'ambos')
    :param bool $popup: si se deben crear enlaces emergentes
    :devuelve: cadena enlazada
    :rtype: cadena

    Convierte automáticamente las URL y direcciones de correo electrónico contenidas en una cadena en
    Enlaces. Ejemplo:

    .. literalinclude:: url_helper/013.php

    El segundo parámetro determina si las URL y los correos electrónicos se convierten o
    solo uno o el otro. El comportamiento predeterminado es ambos si el parámetro no es
    especificado. Los enlaces de correo electrónico están codificados como :php:func:`safe_mailto()` como se muestra
    arriba.

    Convierte solo URL:

    .. literalinclude:: url_helper/014.php

    Convierte sólo direcciones de correo electrónico:

    .. literalinclude:: url_helper/015.php

    El tercer parámetro determina si los enlaces se muestran en una nueva ventana.
    El valor puede ser verdadero o falso (booleano):

    .. literalinclude:: url_helper/016.php

    .. note:: The only URLs recognized are those that start with ``www.`` or with ``://``.

.. php:function:: url_title($str[, $separator = '-'[, $lowercase = false]])

    :param  string $cadena: cadena de entrada
    :param string $separator: Separador de palabras (normalmente ``'-'`` o ``'_'``)
    :param bool $minúsculas: si se debe transformar la cadena de salida a minúsculas
    :devuelve: cadena con formato URL
    :rtype: cadena

    Toma una cadena como entrada y crea una cadena URL amigable para los humanos. Esto es
    útil si, por ejemplo, tienes un blog en el que te gustaría utilizar el
    título de sus entradas en la URL. Ejemplo:

    .. literalinclude:: url_helper/017.php

    El segundo parámetro determina el delimitador de palabras. Por defecto guiones
    son usados. Las opciones preferidas son: ``-`` (guión) o ``_`` (guión bajo).

    Ejemplo:

    .. literalinclude:: url_helper/018.php

    El tercer parámetro determina si se admiten caracteres en minúsculas.
    forzado. Por defecto no lo son. Las opciones son booleanas verdadero/falso.

    Ejemplo:

    .. literalinclude:: url_helper/019.php

.. php:function:: mb_url_title($str[, $separator = '-'[, $lowercase = false]])

    :param  string $cadena: cadena de entrada
    :param string $separator: Separador de palabras (normalmente ``'-'`` o ``'_'``)
    :param bool $minúsculas: si se debe transformar la cadena de salida a minúsculas
    :devuelve: cadena con formato URL
    :rtype: cadena

    Esta función funciona igual que :php:func:`url_title()` pero convierte todos
    caracteres acentuados automáticamente.

.. php:function:: prep_url([$str = ''[, $secure = false]])

    :param  string $cadena: cadena de URL
    :param boolean $secure: verdadero para ``https://``
    :devuelve: cadena URL con prefijo de protocolo
    :rtype: cadena

    Esta función agregará ``http://`` o ``https://`` en el caso de que un prefijo de protocolo
    falta en una URL.

    Pase la cadena URL a la función de esta manera:

    .. literalinclude:: url_helper/020.php

.. php:function:: url_to($controller[, ...$args])

    :param  string $controlador: nombre de ruta o Controlador::método
    :param mixed...$args: Uno o más parámetros que se pasarán a la ruta. El último parámetro le permite configurar la configuración regional.
    :devuelve: URL absoluta
    :rtype: cadena

    .. note:: This function requires the controller/method to have a route defined in **app/Config/Routes.php**.

    Crea una URL absoluta para un método de controlador en su aplicación. Ejemplo:

    .. literalinclude:: url_helper/021.php

    También puedes agregar argumentos a la ruta.
    Aquí hay un ejemplo:

    .. literalinclude:: url_helper/022.php

    Esto es útil porque aún puedes cambiar tus rutas después de poner enlaces.
    en tus puntos de vista.

    Desde v7.3.0, cuando usa ``{locale}`` en su ruta, puede especificar opcionalmente el valor local como último parámetro.

    .. literalinclude:: url_helper/025.php

    Para obtener detalles completos, consulte :ref:`reverse-routing` y :ref:`using-named-routes`.

.. php:function:: url_is($path)

    :param string $path: La ruta URL relativa a baseURL para verificar la ruta URI actual.
    :rtype: booleano

    Compara la ruta de la URL actual con la ruta proporcionada para ver si coinciden. Ejemplo:

    .. literalinclude:: url_helper/023.php

    Esto coincidiría con **http://example.com/admin**. Coincidiría con **http://example.com/subdir/admin**
    si su URL base es ``http://example.com/subdir/``.

    Puede utilizar el comodín ``*`` para hacer coincidir
    cualquier otro carácter aplicable en la URL:

    .. literalinclude:: url_helper/024.php

    Esto coincidiría con cualquiera de los siguientes:

    - /administrador
    - /administrador/
    - /admin/usuarios
    - /admin/usuarios/escuelas/compañeros/...
