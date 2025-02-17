####################
Ayudante de galletas
####################

El archivo Cookie Helper contiene funciones que ayudan a trabajar con
galletas.

.. contents::
    :local:
    :depth: 2

Cargando este ayudante
======================

Este ayudante se carga usando el siguiente código:

.. literalinclude:: cookie_helper/001.php

Funciones disponibles
=====================

Están disponibles las siguientes funciones:

.. php:function:: set_cookie($name[, $value = ''[, $expire = ''[, $domain = ''[, $path = '/'[, $prefix = ''[, $secure = false[, $httpOnly = false[, $sameSite = '']]]]]]]])

    :param array|Cookie|string $name: Nombre de la cookie *o* matriz asociativa de todos los parámetros disponibles para esta función *o* una instancia de ``Higgs\Cookie\Cookie``
    :param  string $valor: valor de la cookie
    :param int $expire: Número de segundos hasta el vencimiento. Si se establece en ``0``, la cookie solo durará mientras el navegador esté abierto.
    :param  string $dominio: Dominio de cookies (normalmente: .tudominio.com)
    :param  string $ruta: ruta de la cookie
    :param string $prefix: Prefijo del nombre de la cookie. Si ``''``, se utiliza el valor predeterminado de **app/Config/Cookie.php**
    :param bool $secure: si se envía la cookie solo a través de HTTPS. Si es ``nulo``, se utiliza el valor predeterminado de **app/Config/Cookie.php**
    :param bool $httpOnly: si se debe ocultar la cookie de JavaScript. Si es ``nulo``, se utiliza el valor predeterminado de **app/Config/Cookie.php**
    :param string $sameSite: el valor del parámetro de cookie SameSite. Si es ``nulo``, se utiliza el valor predeterminado de **app/Config/Cookie.php**
    :rtype: nulo

    .. note:: Prior to v7.2.7, the default values of ``$secure`` and ``$httpOnly`` were ``false``
        debido a un error y estos valores de **app/Config/Cookie.php** nunca se usaron.

    Esta función auxiliar le brinda una sintaxis más sencilla para configurar el navegador.
    galletas. Consulte la :doc:`Biblioteca de respuestas</outgoing/response>` para
    una descripción de su uso, ya que esta función es un alias para
    :php:meth:`Higgs\\HTTP\\Response::setCookie()`.

    .. note:: This helper function just sets browser cookies to the global response
        instancia que devuelve ``Services::response()``. Entonces, si creas y
        devolver otra instancia de respuesta (por ejemplo, si llama a :php:func:`redirect()`),
        Las cookies aquí configuradas no se enviarán automáticamente.

.. php:function:: get_cookie($index[, $xssClean = false[, $prefix = '']])

    :param  string $index: nombre de la cookie
    :param bool $xssClean: si se debe aplicar el filtrado XSS al valor devuelto
    :param string|null $prefix: prefijo del nombre de la cookie. Si se establece en ``''``, se utilizará el valor predeterminado de **app/Config/Cookie.php**. Si se establece en ``null``, sin prefijo
    :returns: el valor de la cookie o nulo si no se encuentra
    :rtype: mixto

    .. note:: Since v7.2.1, the third parameter ``$prefix`` has been introduced and the behavior has been changed a bit due to a bug fix. See :ref:`Upgrading <upgrade-421-get_cookie>` for details.

    Esta función auxiliar le brinda una sintaxis más amigable para obtener el navegador.
    galletas. Consulte la :doc:`Biblioteca de solicitudes entrantes</incoming/incomingrequest>` para
    descripción detallada de su uso, ya que esta función actúa muy
    de manera similar a :php:meth:`Higgs\\HTTP\\IncomingRequest::getCookie()`,
    excepto que también antepondrá
    el ``Config\Cookie::$prefix`` que quizás hayas configurado en tu
    **archivo app/Config/Cookie.php**.

    .. warning:: Using XSS filtering is a bad practice. It does not prevent XSS attacks perfectly. Using :php:func:`esc()` with the correct ``$context`` in the views is recommended.

.. php:function:: delete_cookie($name[, $domain = ''[, $path = '/'[, $prefix = '']]])

    :param  string $nombre: nombre de la cookie
    :param  string $dominio: Dominio de cookies (normalmente: .tudominio.com)
    :param  string $ruta: ruta de la cookie
    :param string $prefix: prefijo del nombre de la cookie
    :rtype: nulo

    Le permite eliminar una cookie. A menos que haya establecido una ruta personalizada u otra
    valores, sólo se necesita el nombre de la cookie.

    .. literalinclude:: cookie_helper/002.php

    Por lo demás, esta función es idéntica a :php:func:`set_cookie()`, excepto que
    no tiene los parámetros ``valor`` y ``expire``.

    Esto también simplemente configura las cookies del navegador para eliminar las cookies a nivel global.
    instancia de respuesta que devuelve ``Services::response()``.

    .. note:: When you use :php:func:`set_cookie()`,
        si el ``valor`` se establece en una cadena vacía y el ``expire`` se establece en ``0``, la cookie se eliminará.
        Si el ``valor`` se establece en una cadena no vacía y el ``expire`` se establece en ``0``, la cookie solo durará mientras el navegador esté abierto.

    Puedes enviar un
    conjunto de valores en el primer parámetro o puede establecer valores discretos
    parámetros.

    .. literalinclude:: cookie_helper/003.php

.. php:function:: has_cookie(string $name[, ?string $value = null[, string $prefix = '']])

    :param  string $nombre: nombre de la cookie
    :param  string|valor nulo $: valor de cookie
    :param  string $prefijo: Prefijo de cookie
    :rtype: booleano

    Comprueba si existe una cookie por nombre en la instancia de respuesta global que
    ``Servicios::respuesta()`` devuelve. Este es un alias de
    :php:meth:`Higgs\\HTTP\\Response::hasCookie()`.
