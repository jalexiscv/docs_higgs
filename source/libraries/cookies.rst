########
Galletas
########

Una **cookie HTTP** (cookie web, cookie de navegador) es un pequeño fragmento de datos que un servidor
envía al navegador web del usuario. El navegador puede almacenarlo y enviarlo de vuelta más tarde.
solicitudes al mismo servidor. Normalmente, se utiliza para saber si dos solicitudes provienen de
el mismo navegador, manteniendo a un usuario conectado, por ejemplo.
Recuerda información con estado para el protocolo HTTP sin estado.

Las cookies se utilizan principalmente con tres finalidades:

- **Gestión de sesiones**: inicios de sesión, carritos de compras, puntuaciones de juegos o cualquier otra cosa que el servidor deba recordar
- **Personalización**: preferencias de usuario, temas y otras configuraciones
- **Seguimiento**: Registrar y analizar el comportamiento del usuario

Para ayudarle a enviar cookies de manera eficiente a los navegadores,
Higgs proporciona la clase ``Higgs\Cookie\Cookie`` para abstraer el
interacción de cookies.

.. contents::
    :local:
    :depth: 2


Creando cookies
***************

Actualmente existen cuatro (4) formas de crear un nuevo objeto de valor ``Cookie``.

.. literalinclude:: cookies/001.php

Al construir el objeto ``Cookie``, solo se requiere el atributo ``nombre``. Todo lo demás es opcional.
Si los atributos opcionales no se modifican, sus valores se completarán con los valores predeterminados guardados en
la clase ``Cookie``.

Anulación de valores predeterminados
====================================

Para anular los valores predeterminados actualmente almacenados en la clase, puede pasar una ``Config\Cookie``
instancia o una matriz de valores predeterminados al método estático ``Cookie::setDefaults()``.

.. literalinclude:: cookies/002.php

Pasar la instancia ``Config\Cookie`` o una matriz a ``Cookie::setDefaults()`` efectivamente
sobrescribirá sus valores predeterminados y persistirá hasta que se pasen nuevos valores predeterminados.

Cambiar los valores predeterminados por un tiempo limitado
------------------------------------

Si no quieres esto
comportamiento pero solo desea cambiar los valores predeterminados por un tiempo limitado, puede aprovechar
``Cookie::setDefaults()`` devuelve la matriz de valores predeterminados anterior.

.. literalinclude:: cookies/003.php


Accediendo a los atributos de las cookies
*****************************************

Una vez creada una instancia, puede acceder fácilmente al atributo de una ``Cookie`` utilizando uno de sus métodos de obtención.

.. literalinclude:: cookies/004.php


Cookies inmutables
******************

Una nueva instancia de ``Cookie`` es una representación de objeto de valor inmutable de una cookie HTTP. siendo inmutable,
modificar cualquiera de los atributos de la instancia no afectará la instancia original. La modificación **siempre**
devuelve una nueva instancia. Debe conservar esta nueva instancia para poder utilizarla.

.. literalinclude:: cookies/005.php


Validar los atributos de una cookie
***********************************

Una cookie HTTP está regulada por varias especificaciones que deben seguirse para poder ser
aceptado por los navegadores. Así, al crear o modificar determinados atributos de la ``Cookie``,
estos se validan para comprobar si siguen las especificaciones.

Se genera una ``CookieException`` si se informan infracciones.

Validar el atributo de nombre
=============================

El nombre de una cookie puede ser cualquier carácter US-ASCII, excepto lo siguiente:

- controlar personajes;
- espacios o pestañas;
- caracteres separadores, como ``( ) < > @ , ; : \ " / [ ] ? = { }``

Si se establece el parámetro ``$raw`` en ``true``, esta validación se realizará estrictamente. Esto es porque
`setcookie() de PHP<https://www.php.net/manual/en/function.setcookie.php>` _
y `setrawcookie()<https://www.php.net/manual/en/function.setrawcookie.php>` _
rechazará las cookies con nombres no válidos. Además, galleta
Los nombres no pueden ser una cadena vacía.

Validar el atributo de prefijo
==============================

Cuando se utiliza el prefijo ``__Secure-``, las cookies deben configurarse con el indicador ``$secure`` establecido en ``true``. Si
Al utilizar el prefijo ``__Host-``, las cookies deben presentar lo siguiente:

- Bandera ``$secure`` establecida en ``true``
- ``$dominio`` está vacío
- ``$ruta`` debe ser ``/``

Validando el atributo SameSite
==============================

El atributo SameSite sólo acepta tres (3) valores:

- **Lax**: las cookies no se envían en subsolicitudes normales entre sitios (por ejemplo, para cargar imágenes o marcos en un sitio de terceros), pero se envían cuando un usuario navega al sitio de origen (*es decir* cuando sigue un enlace).
- **Estricto**: las cookies solo se enviarán en un contexto propio y no junto con solicitudes iniciadas por sitios web de terceros.
- **Ninguno**: Las cookies se enviarán en todos los contextos, *es decir* en respuestas a solicitudes tanto propias como de origen cruzado.

Higgs, sin embargo, le permite establecer el atributo SameSite en una cadena vacía. Cuando una cadena vacía es
proporcionada, se utiliza la configuración predeterminada de SameSite guardada en la clase ``Cookie``. Puedes cambiar el SameSite predeterminado
utilizando ``Cookie::setDefaults()`` como se explicó anteriormente.

Las especificaciones de cookies recientes han cambiado de modo que los navegadores modernos deben proporcionar un SameSite predeterminado
si no se proporcionó nada. Este valor predeterminado es ``Lax``. Si ha configurado SameSite para que sea una cadena vacía y su
El SameSite predeterminado también es una cadena vacía, su cookie recibirá el valor ``Lax``.

Si SameSite está configurado en ``Ninguno``, debe asegurarse de que ``Secure`` también esté configurado en ``true``.

Al escribir el atributo SameSite, la clase ``Cookie`` acepta cualquiera de los valores sin distinguir entre mayúsculas y minúsculas. Puede
También aproveche las constantes de la clase para que no sea una molestia.

.. literalinclude:: cookies/006.php



Envío de cookies
****************

Establezca los objetos ``Cookie`` en el ``CookieStore`` del objeto Response, y
el marco enviará automáticamente las cookies.

Utilice :php:meth:`Higgs\\HTTP\\Response::setCookie()` para configurar:

.. literalinclude:: cookies/017.php

También puedes usar la función auxiliar :php:func:`set_cookie()`:

.. literalinclude:: cookies/018.php



Usando la tienda de cookies
***************************

.. note:: Normally, there is no need to use CookieStore directly.

La clase ``CookieStore`` representa una colección inmutable de objetos ``Cookie``.

Obtener la tienda a partir de la respuesta
==========================================

La ``Tienda de cookies``
Se puede acceder a la instancia desde el objeto ``Respuesta`` actual.

.. literalinclude:: cookies/007.php

Creando tienda de cookies
=========================

Higgs proporciona otras tres (3) formas de crear una nueva instancia de ``CookieStore``.

.. literalinclude:: cookies/008.php

.. note:: When using the global :php:func:`cookies()` function, the passed ``Cookie`` array will only be considered
    si el segundo argumento, ``$getGlobal``, está establecido en ``false``.

Comprobación de cookies en la tienda
====================================

Para comprobar si existe un objeto ``Cookie`` en la instancia ``CookieStore``, puede utilizar varias formas:

.. literalinclude:: cookies/009.php

Obtener cookies en la tienda
============================

Recuperar una instancia de ``Cookie`` en una colección de cookies es muy fácil:

.. literalinclude:: cookies/010.php

Al obtener una instancia de ``Cookie`` directamente de ``CookieStore``, aparece un nombre no válido
arrojará una ``CookieException``.

.. literalinclude:: cookies/011.php

Al obtener una instancia de ``Cookie`` de la colección de cookies de la ``Respuesta`` actual,
un nombre no válido simplemente devolverá "nulo".

.. literalinclude:: cookies/012.php

Si no se proporcionan argumentos al obtener cookies de ``Respuesta``, todos los objetos ``Cookie``
en la tienda se mostrará.

.. literalinclude:: cookies/013.php

.. note:: The helper function :php:func:`get_cookie()` gets the cookie from the current ``Request`` object, not
    de ``Respuesta``. Esta función verifica la matriz ``$_COOKIE`` si esa cookie está configurada y la recupera
    de inmediato.

Agregar/eliminar cookies en la tienda
=====================================

Como se mencionó anteriormente, los objetos ``CookieStore`` son inmutables. Necesitas guardar la instancia modificada.
para poder trabajar en ello. La instancia original no se modifica.

.. literalinclude:: cookies/014.php

.. note:: Removing a cookie from the store **DOES NOT** delete it from the browser.
    Si pretendes eliminar una cookie *del navegador*, debes poner un valor vacío
    cookie con el mismo nombre a la tienda.

Al interactuar con las cookies almacenadas en el objeto ``Respuesta`` actual, puede agregar o eliminar de forma segura
cookies sin preocuparse por la naturaleza inmutable de la colección de cookies. El objeto ``Respuesta`` reemplazará
la instancia con la instancia modificada.

.. literalinclude:: cookies/015.php

Envío de cookies en la tienda
=============================

.. deprecated:: 4.1.6

.. important:: This method is deprecated. It will be removed in future releases.

La mayoría de las veces, no necesita preocuparse por enviar cookies manualmente. Higgs hará esto
para ti. Sin embargo, si realmente necesita enviar cookies manualmente, puede utilizar el método ``dispatch``. Al igual que
Al enviar otros encabezados, debe asegurarse de que los encabezados aún no se hayan enviado verificando el valor.
de ``headers_sent()``.

.. literalinclude:: cookies/016.php


Personalización de cookies
**************************

Ya existen valores predeterminados sensatos dentro de la clase ``Cookie`` para garantizar la creación fluida de cookies.
objetos. Sin embargo, es posible que desee definir sus propios ajustes cambiando los siguientes ajustes en el
Clase ``Config\Cookie`` en el archivo **app/Config/Cookie.php**.

==================== =============================== ======= ========= =================================== ====================
Opciones/tipos de configuración Descripción predeterminada
==================== =============================== ======= ========= =================================== ====================
**$prefix** ``string````''`` Prefijo para anteponer al nombre de la cookie.
**$expires** ``DateTimeInterface|string|int````0`` La marca de tiempo de caducidad.
**$ruta** ``cadena````/`` La propiedad de ruta de la cookie.
**$dominio** ``cadena````''`` La propiedad de dominio de la cookie.con barra diagonal.
**$secure** ``true/false````false`` Si se envía a través de HTTPS seguro.
**$httponly** ``true/false````true`` Si no es accesible para JavaScript.
**$samesite** ``Lax|Ninguno|Estricto|lax|none|strict''````Lax`` El atributo SameSite.
**$raw** ``true/false````false`` Si se enviará usando ``setrawcookie()``.
==================== =============================== ======= ========= =================================== ====================

En tiempo de ejecución, puede proporcionar manualmente un nuevo valor predeterminado utilizando el método ``Cookie::setDefaults()``.


Referencia de clase
*******************

.. php:namespace:: Higgs\Cookie

.. php:class:: Cookie

    .. php:staticmethod:: setDefaults([$config = []])

        :param \\Config\\Cookie|array $config: La matriz o instancia de configuración
        :rtype: matriz<string, mixed>
        :returns: Los antiguos valores predeterminados

        Establezca los atributos predeterminados para una instancia de Cookie inyectando los valores de la configuración ``Config\Cookie`` o una matriz.

    .. php:staticmethod:: fromHeaderString(string $header[, bool $raw = false])

        :param string $header: La cadena de encabezado ``Set-Cookie``
        :param bool $raw: Si esta cookie no debe codificarse en URL y enviarse mediante ``setrawcookie()``
        :rtype: ``Cookie``
        :devuelve: instancia ``Cookie``
        :lanza: ``CookieException``

        Cree una nueva instancia de Cookie a partir de un encabezado ``Set-Cookie``.

    .. php:method:: __construct(string $name[, string $value = ''[, array $options = []]])

        :param  string $nombre: el nombre de la cookie
        :param  string $valor: el valor de la cookie
        :param array $options: Las opciones de cookies
        :rtype: ``Cookie``
        :devuelve: instancia ``Cookie``
        :lanza: ``CookieException``

        Construya una nueva instancia de Cookie.

    .. php:method:: getId()

        :rtype: cadena
        :returns: el ID utilizado en la indexación en la colección de cookies.

    .. php:method:: getPrefix(): string
    .. php:method:: getName(): string
    .. php:method:: getPrefixedName(): string
    .. php:method:: getValue(): string
    .. php:method:: getExpiresTimestamp(): int
    .. php:method:: getExpiresString(): string
    .. php:method:: isExpired(): bool
    .. php:method:: getMaxAge(): int
    .. php:method:: getDomain(): string
    .. php:method:: getPath(): string
    .. php:method:: isSecure(): bool
    .. php:method:: isHTTPOnly(): bool
    .. php:method:: getSameSite(): string
    .. php:method:: isRaw(): bool
    .. php:method:: getOptions(): array

    .. php:method:: withRaw([bool $raw = true])

        :param bool $sin procesar:

        :rtype: ``Cookie``
        :devuelve: nueva instancia de ``Cookie``

        Crea una nueva cookie con la opción de codificación de URL actualizada.

    .. php:method:: withPrefix([string $prefix = ''])

        :param  string $prefijo:

        :rtype: ``Cookie``
        :devuelve: nueva instancia de ``Cookie``

        Crea una nueva Cookie con un nuevo prefijo.

    .. php:method:: withName(string $name)

        :param  string $nombre:

        :rtype: ``Cookie``
        :devuelve: nueva instancia de ``Cookie``

        Crea una nueva cookie con un nuevo nombre.

    .. php:method:: withValue(string $value)

        :param  string $valor:

        :rtype: ``Cookie``
        :devuelve: nueva instancia de ``Cookie``

        Crea una nueva cookie con un nuevo valor.

    .. php:method:: withExpires($expires)

        :param DateTimeInterface|cadena|int $expires:

        :rtype: ``Cookie``
        :devuelve: nueva instancia de ``Cookie``

        Crea una nueva cookie y la nueva cookie caduca en el tiempo.

    .. php:method:: withExpired()

        :rtype: ``Cookie``
        :devuelve: nueva instancia de ``Cookie``

        Crea una nueva Cookie que caducará en el navegador.

    .. php:method:: withNeverExpiring()

        .. deprecated:: 4.2.6

        .. important:: This method is deprecated. It will be removed in future releases.

        :param  string $nombre:

        :rtype: ``Cookie``
        :devuelve: nueva instancia de ``Cookie``

        Crea una nueva cookie que prácticamente nunca caducará.

    .. php:method:: withDomain(?string $domain)

        :param  string|dominio $nulo:

        :rtype: ``Cookie``
        :devuelve: nueva instancia de ``Cookie``

        Crea una nueva Cookie con un nuevo dominio.

    .. php:method:: withPath(?string $path)

        :param  string|nulo $ruta:

        :rtype: ``Cookie``
        :devuelve: nueva instancia de ``Cookie``

        Crea una nueva cookie con una nueva ruta.

    .. php:method:: withSecure([bool $secure = true])

        :param bool $seguro:

        :rtype: ``Cookie``
        :devuelve: nueva instancia de ``Cookie``

        Crea una nueva cookie con un nuevo atributo "Seguro".

    .. php:method:: withHTTPOnly([bool $httponly = true])

        :param bool $httpsolo:

        :rtype: ``Cookie``
        :devuelve: nueva instancia de ``Cookie``

        Crea una nueva cookie con el nuevo atributo "HttpOnly".

    .. php:method:: withSameSite(string $samesite)

        :param  string $samesite:

        :rtype: ``Cookie``
        :devuelve: nueva instancia de ``Cookie``

        Crea una nueva cookie con el nuevo atributo "SameSite".

    .. php:method:: toHeaderString()

        :rtype: cadena
        :returns: Devuelve la representación de cadena que se puede pasar como cadena de encabezado.

    .. php:method:: toArray()

        :rtype: matriz
        :returns: Devuelve la representación de matriz de la instancia de Cookie.

.. php:class:: CookieStore

    .. php:staticmethod:: fromCookieHeaders(array $headers[, bool $raw = false])

        :param array $header: Matriz de encabezados ``Set-Cookie``
        :param bool $raw: si no se debe utilizar codificación URL
        :rtype: ``Tienda de cookies``
        :devuelve: instancia ``CookieStore``
        :lanza: ``CookieException``

        Crea un CookieStore a partir de una serie de encabezados ``Set-Cookie``.

    .. php:method:: __construct(array $cookies)

        :param array $cookies: Matriz de objetos ``Cookie``
        :rtype: ``Tienda de cookies``
        :devuelve: instancia ``CookieStore``
        :lanza: ``CookieException``

    .. php:method:: has(string $name[, string $prefix = ''[, ?string $value = null]]): bool

        :param  string $nombre: nombre de la cookie
        :param  string $prefijo: Prefijo de cookie
        :param  string|valor nulo $: valor de cookie
        :rtype: booleano
        :returns: Comprueba si un objeto ``Cookie`` identificado por nombre y prefijo está presente en la colección.

    .. php:method:: get(string $name[, string $prefix = '']): Cookie

        :param  string $nombre: nombre de la cookie
        :param  string $prefijo: Prefijo de cookie
        :rtype: ``Cookie``
        :returns: Recupera una instancia de Cookie identificada por un nombre y prefijo.
        :lanza: ``CookieException``

    .. php:method:: put(Cookie $cookie): CookieStore

        :param Cookie $cookie: Un objeto Cookie
        :rtype: ``Tienda de cookies``
        :devuelve: nueva instancia ``CookieStore``

        Almacene una nueva cookie y devuelva una nueva colección. La colección original se mantiene sin cambios.

    .. php:method:: remove(string $name[, string $prefix = '']): CookieStore

        :param  string $nombre: nombre de la cookie
        :param  string $prefijo: Prefijo de cookie
        :rtype: ``Tienda de cookies``
        :devuelve: nueva instancia ``CookieStore``

        Elimina una cookie de una colección y devuelve una colección actualizada.
        La colección original se mantiene sin cambios.

    .. php:method:: dispatch(): void

        :rtype: nulo

        Envía todas las cookies en la tienda.

    .. php:method:: display(): array

        :rtype: matriz
        :returns: Devuelve todas las instancias de cookies en la tienda.

    .. php:method:: clear(): void

        :rtype: nulo

        Borra la colección de cookies.
