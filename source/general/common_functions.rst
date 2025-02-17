###############################
Funciones y constantes globales
###############################

Higgs proporciona algunas funciones y variables que están definidas globalmente y están disponibles en cualquier momento.
Estos no requieren cargar bibliotecas o ayudantes adicionales.

.. contents::
    :local:
    :depth: 2


Funciones globales
==================

Accesorios de servicio
======================

.. php:function:: cache([$key])

    :param string $key: el nombre de la caché del elemento que se recuperará de la caché (opcional)
    :returns: ya sea el objeto de la caché o el elemento recuperado de la caché
    :rtype: mixto

    Si no se proporciona ninguna clave $, devolverá la instancia del motor de caché. Si una clave $
    se proporciona, devolverá el valor de $key tal como está almacenado en el caché actualmente,
    o nulo si no se encuentra ningún valor.

    Ejemplos:

    .. literalinclude:: common_functions/001.php

.. php:function:: config(string $name[, bool $getShared = true])

    :param  string $nombre: el nombre de clase de configuración.
    :param bool $getShared: si se debe devolver una instancia compartida.
    :returns: Las instancias de configuración.
    :rtype: objeto|nulo

    Una forma más sencilla de obtener instancias de configuración de las fábricas.

    Ver :ref:`Configuración<configuration-config>`  y
    :ref:`Fábricas<factories-config>` para más detalles.

    ``config()`` usa ``Factories::config()`` internamente.
    Consulte :ref:`factories-loading-class` para obtener detalles sobre el primer parámetro ``$name``.

.. php:function:: cookie(string $name[, string $value = ''[, array $options = []]])

    :param  string $nombre: nombre de la cookie
    :param  string $valor: valor de la cookie
    :param array $options: Opciones de cookies
    :rtype: ``Cookie``
    :devuelve: instancia ``Cookie``
    :lanza: ``CookieException``

    Una forma más sencilla de crear una nueva instancia de Cookie.

.. php:function:: cookies([array $cookies = [][, bool $getGlobal = true]])

    :param array $cookies: Si ``getGlobal`` es ``false``, esto se pasa al constructor de ``CookieStore``.
    :param bool $getGlobal: Si es ``false``, crea una nueva instancia de ``CookieStore``.
    :rtype: ``Tienda de cookies``
    :returns: Instancia de ``CookieStore`` guardada en la ``Response`` actual, o una nueva instancia de ``CookieStore``.

    Recupera la instancia global ``CookieStore`` mantenida por ``Response``.

.. php:function:: env($key[, $default = null])

    :param string $key: El nombre de la variable de entorno a recuperar
    :param mixed $default: el valor predeterminado que se devolverá si no se encuentra ningún valor.
    :returns: la variable de entorno, el valor predeterminado o nulo.
    :rtype: mixto

    Se utiliza para recuperar valores que se han establecido previamente en el entorno,
    o devolver un valor predeterminado si no se encuentra. Formateará valores booleanos
    a valores booleanos reales en lugar de representaciones de cadenas.

    Especialmente útil cuando se usa junto con archivos **.env** para configurar
    valores que son específicos del entorno mismo, como la base de datos
    configuraciones, claves API, etc.

.. php:function:: esc($data[, $context = 'html'[, $encoding]])

    :param string|array $data: La información que se va a escapar.
    :param string $context: el contexto de escape. El valor predeterminado es 'html'.
    :param cadena $codificación: la codificación de caracteres de la cadena.
    :returns: Los datos escapados.
    :rtype: mixto

    Escape de datos para incluirlos en páginas web, para ayudar a prevenir ataques XSS.
    Esto utiliza la biblioteca Laminas Escaper para manejar el filtrado real de los datos.

    Si $data es una cadena, simplemente se escapa y la devuelve.
    Si $data es una matriz, entonces la recorre, escapando de cada 'valor' de los pares clave/valor.

    Valores de contexto válidos: ``html``, ``js``, ``css``, ``url``, ``attr``, ``raw``

.. php:function:: helper($filename)

    :param string|array $filename: El nombre del archivo auxiliar a cargar, o una matriz de nombres.

    Carga un archivo auxiliar.

    Para obtener detalles completos, consulte la página :doc:`helpers`.

.. php:function:: lang($line[, $args[, $locale]])

    :param string $line: La línea de texto a recuperar
    :param array $args: una matriz de datos para sustituir los marcadores de posición.
    :param string $locale: especifique una configuración regional diferente que se utilizará en lugar de la predeterminada.

    Recupera un archivo específico de la configuración regional basado en una cadena de alias.

    Para obtener más información, consulte :doc:`Localización</outgoing/localization>` página.

.. php:function:: model($name[, $getShared = true[, &$conn = null]])

    :param  string $nombre: el nombre de clase del modelo.
    :param boolean $getShared: si se debe devolver una instancia compartida.
    :param ConnectionInterface|null $conn: La conexión de la base de datos.
    :devuelve: Las instancias del modelo
    :rtype: objeto

    Una forma más sencilla de obtener instancias de modelo.

    El ``model()`` usa ``Factories::models()`` internamente.
    Consulte :ref:`factories-loading-class` para obtener detalles sobre el primer parámetro ``$name``.

    Véase también :ref:`Uso del modelo de Higgs<accessing-models>` .

.. php:function:: old($key[, $default = null,[, $escape = 'html']])

    :param string $key: El nombre de los datos del formulario antiguo que se verificarán.
    :param string|null $default: el valor predeterminado que se devolverá si $key no existe.
    :param false|string $escape: un contexto `escape <#esc>`_ o false para deshabilitarlo.
    :returns: el valor de la clave definida o el valor predeterminado.
    :rtype: matriz|cadena|nulo

    Proporciona una manera sencilla de acceder a "datos de entrada antiguos" al enviar un formulario.

    Ejemplo:

    .. literalinclude:: common_functions/002.php

.. note:: If you are using the :php:func:`set_value()`, :php:func:`set_select()`,
    Funciones :php:func:`set_checkbox()` y :php:func:`set_radio()` en
    :doc:`ayudante de formulario</helpers/form_helper>` , esta característica está incorporada. Solo
    Es necesario utilizar esta función cuando no se utiliza el asistente de formulario.

.. php:function:: session([$key])

    :param string $key: El nombre del elemento de sesión que se va a comprobar.
    :returns: una instancia del objeto Sesión si no hay una clave $, el valor encontrado en la sesión para la clave $ o nulo.
    :rtype: mixto

    Proporciona una manera conveniente de acceder a la clase de sesión y recuperar una
    valor almacenado. Para obtener más información, consulte :doc:`Sesiones</libraries/sessions>` página.

.. php:function:: timer([$name])

    :param  string $nombre: el nombre del punto de referencia.
    :devuelve: La instancia del temporizador
    :rtype: Higgs\Debug\Timer

    Un método conveniente que proporciona acceso rápido a la clase Timer. Puedes pasar el nombre
    de un punto de referencia como único parámetro. Esto comenzará a cronometrar desde este punto o se detendrá.
    temporización si ya se está ejecutando un temporizador con este nombre.

    Ejemplo:

    .. literalinclude:: common_functions/003.php

.. php:function:: view($name[, $data[, $options]])

    :param string $name: El nombre del archivo a cargar
    :param array $data: una matriz de pares clave/valor para estar disponibles en la vista.
    :param array $options: un conjunto de opciones que se pasarán a la clase de renderizado.
    :returns: El resultado de la vista.
    :rtype: cadena

    Toma la clase actual compatible con RendererInterface
    y le dice que muestre la vista especificada. Simplemente proporciona
    un método conveniente que se puede utilizar en controladores,
    bibliotecas y cierres enrutados.

    Actualmente, estas opciones están disponibles para su uso dentro de la matriz ``$options``:

    - ``saveData`` especifica que los datos persistirán entre múltiples llamadas a ``view()`` dentro de la misma solicitud. Si no desea que los datos se conserven, especifique false.
    - ``cache`` especifica el número de segundos para almacenar en caché la vista. Consulte :ref:`caching-views` para obtener más detalles.
    - ``debug`` se puede establecer en false para deshabilitar la adición de código de depuración para :ref:`Barra de herramientas de depuración<the-debug-toolbar>` .

    La matriz ``$option`` se proporciona principalmente para facilitar las integraciones de terceros con
    bibliotecas como Twig.

    Ejemplo:

    .. literalinclude:: common_functions/004.php

    Para obtener más detalles, consulte :doc:`Vistas <../outgoing/views>` y
    :doc:`../outgoing/view_renderer` página.

.. php:function:: view_cell($library[, $params = null[, $ttl = 0[, $cacheName = null]]])

    :param  string $biblioteca:
    :param nulo $params:
    :param entero $ttl:
    :param  string|nulo $nombrecache:
    :returns: las celdas de vista se utilizan dentro de las vistas para insertar fragmentos de HTML administrados por otras clases.
    :rtype: cadena

    Para obtener más detalles, consulte :doc:`Ver celdas</outgoing/view_cells>` página.

Funciones varias
================

.. php:function:: app_timezone()

    :returns: La zona horaria en la que se configuró la aplicación para mostrar fechas.
    :rtype: cadena

    Devuelve la zona horaria en la que se configuró la aplicación para mostrar fechas.

.. php:function:: csp_script_nonce()

    :returns: el atributo nonce de CSP para la etiqueta de secuencia de comandos.
    :rtype: cadena

    Devuelve el atributo nonce para una etiqueta de script. Por ejemplo: ``nonce="Eskdikejidojdk978Ad8jf"``.
    Ver :ref:`Política de seguridad de contenido<csp-using-functions>` .

.. php:function:: csp_style_nonce()

    :returns: el atributo nonce de CSP para la etiqueta de estilo.
    :rtype: cadena

    Devuelve el atributo nonce para una etiqueta de estilo. Por ejemplo: ``nonce="Eskdikejidojdk978Ad8jf"``.
    Ver :ref:`Política de seguridad de contenido<csp-using-functions>` .

.. php:function:: csrf_token()

    :returns: el nombre del token CSRF actual.
    :rtype: cadena

    Devuelve el nombre del token CSRF actual.

.. php:function:: csrf_header()

    :returns: el nombre del encabezado del token CSRF actual.
    :rtype: cadena

    El nombre del encabezado del token CSRF actual.

.. php:function:: csrf_hash()

    :returns: El valor actual del hash CSRF.
    :rtype: cadena

    Devuelve el valor hash CSRF actual.

.. php:function:: csrf_field()

    :returns: una cadena con el HTML para entrada oculta con toda la información CSRF requerida.
    :rtype: cadena

    Devuelve una entrada oculta con la información CSRF ya insertada::

        <input type="hidden" name="{csrf_token}" value="{csrf_hash}">

.. php:function:: csrf_meta()

    :returns: una cadena con el HTML para la metaetiqueta con toda la información CSRF requerida.
    :rtype: cadena

    Devuelve una metaetiqueta con la información CSRF ya insertada::

        <meta name="{csrf_header}" content="{csrf_hash}">

.. php:function:: force_https($duration = 31536000[, $request = null[, $response = null]])

    :param int $duration: la cantidad de segundos que los navegadores deben convertir los enlaces a este recurso a HTTPS.
    :param RequestInterface $request: una instancia del objeto Request actual.
    :param ResponseInterface $respuesta: una instancia del objeto Respuesta actual.

    Comprueba si actualmente se accede a la página a través de HTTPS. Si es así, entonces
    no pasa nada. Si no es así, el usuario es redirigido nuevamente al URI actual.
    sino a través de HTTPS. Establecerá el encabezado HTTP Strict Transport Security (HTST), que indica
    navegadores modernos para modificar automáticamente cualquier solicitud HTTP a solicitud HTTPS durante la ``$duración``.

    .. note:: This function is also used when you set
        ``Config\App:$forceGlobalSecureRequests`` en verdadero.

.. php:function:: function_usable($function_name)

    :param string $function_name: Función a verificar
    :returns: verdadero si la función existe y es seguro llamarla, falso en caso contrario.
    :rtype: booleano

.. php:function:: is_cli()

    :returns: verdadero si el script se ejecuta desde la línea de comando o falso en caso contrario.
    :rtype: booleano

.. php:function:: is_really_writable($file)

    :param string $file: El nombre del archivo que se está verificando.
    :returns: verdadero si puede escribir en el archivo, falso en caso contrario.
    :rtype: booleano

.. php:function:: is_windows([$mock = null])

    :param bool|null $mock: si se proporciona y es booleano, se utilizará como valor de retorno.
    :rtype: booleano

    Detecta si la plataforma se está ejecutando en Windows.

    .. note:: The boolean value provided to $mock will persist in subsequent calls. To reset this
        valor simulado, el usuario debe pasar un "nulo" explícito a la llamada de función. Esta voluntad
        actualice la función para utilizar la detección automática.

    .. literalinclude:: common_functions/012.php

.. php:function:: log_message($level, $message [, $context])

    :param  string $nivel: el nivel de gravedad
    :param string $message: El mensaje que se va a registrar.
    :param array $context: una matriz asociativa de etiquetas y sus valores que deben reemplazarse en $message
    :returns: verdadero si se registró correctamente o falso si hubo un problema al registrarlo
    :rtype: booleano

    Registra un mensaje utilizando los controladores de registro definidos en **app/Config/Logger.php**.

    El nivel puede ser uno de los siguientes valores: **emergencia**, **alerta**, **crítico**, **error**, **advertencia**,
    **aviso**, **información** o **depuración**.

    El contexto se puede utilizar para sustituir valores en la cadena del mensaje. Para obtener detalles completos, consulte la
    :doc:`Información de registro<logging>` página.

.. php:function:: redirect(string $route)

    :param cadena $ruta: El nombre de la ruta o Controlador::método al que redirigir al usuario.
    :rtype: Respuesta de redireccionamiento

    Devuelve una instancia de RedirectResponse que le permite crear redirecciones fácilmente.
    Consulte :ref:`response-redirect` para obtener más detalles.

.. php:function:: remove_invisible_characters($str[, $urlEncoded = true])

    :param  string $cadena: cadena de entrada
    :param bool $urlEncoded: si se deben eliminar también los caracteres codificados en URL
    :devuelve: cadena desinfectada
    :rtype: cadena

    Esta función evita la inserción de caracteres nulos entre ASCII
    caracteres, como Java\\0script.

    Ejemplo:

    .. literalinclude:: common_functions/007.php

.. php:function:: request()

    .. versionadded:: 7.0.0

    :returns: el objeto Solicitud compartido.
    :rtype: Solicitud entrante|Solicitud CLI

    Esta función es un contenedor para ``Services::request()``.

.. php:function:: response()

    .. versionadded:: 7.0.0

    :returns: el objeto Respuesta compartido.
    :rtype: Respuesta

    Esta función es un contenedor para ``Services::response()``.

.. php:function:: route_to($method[, ...$params])

    :param  string $método: Nombre de ruta o Controlador::método
    :param int|string ...$params: Uno o más parámetros que se pasarán a la ruta. El último parámetro le permite configurar la configuración regional.
    :returns: una ruta de ruta (ruta URI relativa a baseURL)
    :rtype: cadena

    .. note:: This function requires the controller/method to have a route defined in **app/Config/Routes.php**.

    .. important:: ``route_to()`` returns a *route* path, not a full URI path for your site.
        Si su **baseURL** contiene subcarpetas, el valor de retorno no es el mismo
        como el URI para vincular. En ese caso, simplemente use :php:func:`url_to()` en su lugar.
        Véase también :ref:`urls-url-structure`.

    Genera una ruta para usted basada en una combinación de controlador::método. Tomará en vigor los parámetros, si se proporcionan.

    .. literalinclude:: common_functions/009.php

    Genera una ruta para usted basada en el nombre de una ruta.

    .. literalinclude:: common_functions/010.php

    Desde v7.3.0, cuando usa ``{locale}`` en su ruta, puede especificar opcionalmente el valor local como último parámetro.

    .. literalinclude:: common_functions/011.php

.. php:function:: service($name[, ...$params])

    :param string $name: El nombre del servicio a cargar
    :param mixed $params: Uno o más parámetros para pasar al método de servicio.
    :returns: una instancia de la clase de servicio especificada.
    :rtype: mixto

    Proporciona fácil acceso a cualquiera de los :doc:`Servicios <../concepts/services>` definidos en el sistema.
    Esto siempre devolverá una instancia compartida de la clase, por lo que no importa cuántas veces se llame
    durante una sola solicitud, solo se creará una instancia de clase.

    Ejemplo:

    .. literalinclude:: common_functions/008.php

.. php:function:: single_service($name [, ...$params])

    :param string $name: El nombre del servicio a cargar
    :param mixed $params: Uno o más parámetros para pasar al método de servicio.
    :returns: una instancia de la clase de servicio especificada.
    :rtype: mixto

    Idéntica a la función **service()** descrita anteriormente, excepto que todas las llamadas a esta
    La función devolverá una nueva instancia de la clase, donde **servicio** devuelve lo mismo
    instancia cada vez.

.. php:function:: slash_item ( $item )

    :param  string $item: nombre del elemento de configuración
    :returns: el elemento de configuración o nulo si el elemento no existe
    :rtype: cadena|nulo

    Obtener un elemento del archivo de configuración con una barra diagonal adjunta (si no está vacía)

.. php:function:: stringify_attributes($attributes [, $js])

    :param mixed $atributos: cadena, matriz de pares clave-valor u objeto
    :param boolean $js: verdadero si los valores no necesitan comillas (estilo Javascript)
    :devuelve: Cadena que contiene los pares clave/valor del atributo, separados por comas
    :rtype: cadena

    Función auxiliar utilizada para convertir una cadena, matriz u objeto de atributos en una cadena.


Constantes globales
===================

Las siguientes constantes siempre están disponibles en cualquier lugar dentro de su aplicación.

Constantes centrales
====================

.. php:const:: APPPATH

    La ruta al directorio **aplicación**.

.. php:const:: ROOTPATH

    La ruta al directorio raíz del proyecto. Justo encima de ``APPPATH``.

.. php:const:: SYSTEMPATH

    La ruta al directorio **sistema**.

.. php:const:: FCPATH

    La ruta al directorio que contiene el controlador frontal.

.. php:const:: WRITEPATH

    La ruta al directorio **escribible**.

Constantes de tiempo
====================

.. php:const:: SECOND

    Es igual a 1.

.. php:const:: MINUTE

    Es igual a 60.

.. php:const:: HOUR

    Es igual a 3600.

.. php:const:: DAY

    Es igual a 86400.

.. php:const:: WEEK

    Equivale a 604800.

.. php:const:: MONTH

    Es igual a 2592000.

.. php:const:: YEAR

    Equivale a 31536000.

.. php:const:: DECADE

    Es igual a 315360000.
