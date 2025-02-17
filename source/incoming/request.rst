###############
Solicitar clase
###############

La clase de solicitud es una representación orientada a objetos de una solicitud HTTP. Esto está destinado a
funciona tanto para solicitudes entrantes, como una solicitud a la aplicación desde un navegador, como para solicitudes salientes,
like se usaría para enviar una solicitud desde la aplicación a una aplicación de terceros.

Esta clase
proporciona la funcionalidad común que ambos necesitan, pero ambos casos tienen clases personalizadas que amplían
de la clase Solicitud para agregar una funcionalidad específica. En la práctica, necesitarás utilizar estas clases.

Consulte la documentación para :doc:`Clase IncomingRequest <./incomingrequest>` y
:doc:`CURLRequest Class <../libraries/curlrequest>` para obtener más detalles de uso.


Referencia de clase
*******************

.. php:namespace:: Higgs\HTTP

.. php:class:: Request

    .. php:method:: getIPAddress()

        :devuelve: la dirección IP del usuario, si se puede detectar. Si la dirección IP
                    no es una dirección IP válida, devolverá ``0.0.0.0``.
        :rtype: cadena

        Devuelve la dirección IP del usuario actual. Si la dirección IP no es válida, el método
        devolverá ``0.0.0.0``:

        .. literalinclude:: request/001.php

        .. important:: This method takes into account the ``Config\App::$proxyIPs`` setting and will
            devuelve la dirección IP del cliente informada mediante el encabezado HTTP para la dirección IP permitida.

    .. php:method:: isValidIP($ip[, $which = ''])

        .. deprecated:: 7.0.5
           Utilice :doc:`../libraries/validation` en su lugar.

        .. important:: This method is deprecated. It will be removed in future releases.

        :param  string $ip: dirección IP
        :param  string $cual: protocolo IP (``ipv4`` o ``ipv6``)
        :returns: verdadero si la dirección es válida, falso si no
        :rtype: booleano

        Toma una dirección IP como entrada y devuelve verdadero o falso (booleano) dependiendo
        sobre si es válido o no.

        .. note:: The $request->getIPAddress() method above automatically validates the IP address.

            .. literalinclude:: request/002.php

        Acepta un segundo parámetro de cadena opcional de ``ipv4`` o ``ipv6`` para especificar
        un formato IP. El valor predeterminado comprueba ambos formatos.

    .. php:method:: getMethod([$upper = false])

        .. important:: Use of the ``$upper`` parameter is deprecated. It will be removed in future releases.

        :param bool $upper: si se debe devolver el nombre del método de solicitud en mayúsculas o minúsculas
        :returns: método de solicitud HTTP
        :rtype: cadena

        Devuelve ``$_SERVER['REQUEST_METHOD']``, con la opción de configurarlo
        en mayúsculas o minúsculas.

        .. literalinclude:: request/003.php

    .. php:method:: setMethod($method)

        .. deprecated:: 7.0.5
           Utilice :php:meth:`Higgs\\HTTP\\Request::withMethod()` en su lugar.

        :param  string $método: establece el método de solicitud. Se utiliza al falsificar la solicitud.
        :devuelve: Esta solicitud
        :rtype: Solicitud

    .. php:method:: withMethod($method)

        .. versionadded:: 7.0.5

        :param  string $método: establece el método de solicitud.
        :vuelve: Nueva instancia de solicitud
        :rtype: Solicitud

    .. php:method:: getServer([$index = null[, $filter = null[, $flags = null]]])

        :param mixed $index: nombre del valor
        :param int $filter: El tipo de filtro a aplicar. Puede encontrar una lista de filtros en el `Manual de PHP<https://www.php.net/manual/en/filter.filters.php>` __.
        :param int|array $flags: Banderas a aplicar. Se puede encontrar una lista de banderas en el `Manual de PHP<https://www.php.net/manual/en/filter.filters.flags.php>` __.
        :returns: valor del elemento ``$_SERVER`` si se encuentra, nulo si no
        :rtype: mixto

        Este método es idéntico a los métodos ``getPost()``, ``getGet()`` y ``getCookie()`` del
        :doc:`Clase IncomingRequest <./incomingrequest>`, solo recupera datos del servidor (``$_SERVER``):

        .. literalinclude:: request/004.php

        Para devolver una matriz de múltiples valores ``$_SERVER``, pase todas las claves requeridas
        como una matriz.

        .. literalinclude:: request/005.php

    .. php:method:: getEnv([$index = null[, $filter = null[, $flags = null]]])

        .. deprecated:: 4.4.4 This method does not work from the beginning. Use
            :php:func:`env()` en su lugar.

        :param mixed $index: nombre del valor
        :param int $filter: El tipo de filtro a aplicar. Puede encontrar una lista de filtros en el `Manual de PHP<https://www.php.net/manual/en/filter.filters.php>` __.
        :param int|array $flags: Banderas a aplicar. Se puede encontrar una lista de banderas en el `Manual de PHP<https://www.php.net/manual/en/filter.filters.flags.php>` __.
        :returns: valor del elemento ``$_ENV`` si se encuentra, nulo si no
        :rtype: mixto

        Este método es idéntico a los métodos ``getPost()``, ``getGet()`` y ``getCookie()`` del
        :doc:`Clase IncomingRequest <./incomingrequest>`, solo recupera datos ambientales (``$_ENV``):

        .. literalinclude:: request/006.php

        Para devolver una matriz de múltiples valores ``$_ENV``, pase todas las claves requeridas
        como una matriz.

        .. literalinclude:: request/007.php

    .. php:method:: setGlobal($method, $value)

        :param  string $método: nombre del método
        :param mixed $valor: Datos a agregar
        :devuelve: Esta solicitud
        :rtype: Solicitud

        Permite configurar manualmente el valor de PHP global, como ``$_GET``, ``$_POST``, etc.

    .. php:method:: fetchGlobal($method [, $index = null[, $filter = null[, $flags = null]]])

        :param  string $método: constante de filtro de entrada
        :param mixed $index: nombre del valor
        :param int $filter: El tipo de filtro a aplicar. Puede encontrar una lista de filtros en el `manual de PHP<https://www.php.net/manual/en/filter.filters.php>` __.
        :param int|array $flags: Banderas a aplicar. Se puede encontrar una lista de banderas en el `Manual de PHP<https://www.php.net/manual/en/filter.filters.flags.php>` __.
        :rtype: mixto

        Obtiene uno o más elementos de un global, como cookies, get, post, etc.
        Opcionalmente, puede filtrar la entrada cuando la recupera pasando un filtro.
