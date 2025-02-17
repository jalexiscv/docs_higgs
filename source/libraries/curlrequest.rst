#######################
Clase de solicitud CURL
#######################

La clase ``CURLRequest`` es un cliente HTTP ligero basado en CURL que le permite hablar con otros
sitios web y servidores. Se puede utilizar para obtener el contenido de una búsqueda de Google, recuperar una página web o una imagen,
o comunicarse con una API, entre muchas otras cosas.

.. contents::
    :local:
    :depth: 2

Esta clase sigue el modelo del `Cliente HTTP Guzzle<http://docs.guzzlephp.org/en/latest/>` _ biblioteca desde
Es una de las bibliotecas más utilizadas. Siempre que sea posible, la sintaxis se ha mantenido igual para que, si
su aplicación necesita algo un poco más potente que lo que proporciona esta biblioteca, tendrá
cambiar muy poco para pasar a usar Guzzle.

.. note:: This class requires the `cURL Library <https://www.php.net/manual/en/book.curl.php>`_ to be installed
    en su versión de PHP. Esta es una biblioteca muy común que normalmente está disponible, pero no en todos los hosts.
    lo proporcionará, así que consulte con su proveedor de alojamiento para verificar si tiene problemas.


Configuración para CURLRequest
******************************

.. _curlrequest-sharing-options:

Opciones para compartir
=======================

.. important:: This setting exists only for backward compatibility. Do not use it
    en nuevos proyectos. Incluso si ya lo estás usando, te recomendamos que lo desactives.
    él.

.. note:: Since v7.4.0, the default value has been changed to ``false``.

Si desea compartir todas las opciones entre solicitudes, configure ``$shareOptions`` en
``true`` en **app/Config/CURLRequest.php**:

.. literalinclude:: curlrequest/001.php

Si envía más de una solicitud con una instancia de la clase, este comportamiento
puede causar una solicitud de error con encabezados y cuerpo innecesarios.

.. note:: Before v7.2.0, the request body is not reset even if ``$shareOptions`` is false due to a bug.


Cargando la biblioteca
**********************

La biblioteca se puede cargar manualmente o mediante la clase :doc:`Services</concepts/services>` .

Para cargar con la clase Servicios llame al método ``curlrequest()``:

.. literalinclude:: curlrequest/002.php

Puede pasar una serie de opciones predeterminadas como primer parámetro para modificar cómo cURL manejará la solicitud.
Las opciones se describen más adelante en este documento:

.. literalinclude:: curlrequest/003.php

.. note:: When ``$shareOptions`` is false, the default options passed to the class constructor will be used for all requests. Other options will be reset after sending a request.

Al crear la clase manualmente, debe pasar algunas dependencias. El primer parámetro es un
instancia de la clase ``Config\App``. El segundo parámetro es una instancia de URI. El tercero
El parámetro es un objeto de respuesta. El cuarto parámetro es la matriz opcional ``$options`` predeterminada:

.. literalinclude:: curlrequest/004.php


Trabajando con la biblioteca
****************************

Trabajar con solicitudes CURL es simplemente una cuestión de crear la Solicitud y obtener una
:doc:`Objeto de respuesta</outgoing/response>`  atrás. Está destinado a manejar las comunicaciones. Después
usted tiene control total sobre cómo se maneja la información.

Haciendo peticiones
===================

La mayor parte de la comunicación se realiza a través del método ``request()``, que activa la solicitud y luego devuelve
una instancia de respuesta para usted. Esto toma el método HTTP, la URL y una serie de opciones como parámetros.

.. literalinclude:: curlrequest/005.php

.. important:: By default, CURLRequest will throw ``HTTPException`` if the HTTP
    El código devuelto es mayor o igual a 400. Si desea obtener la respuesta,
    consulte la opción `http_errors`_.

.. note:: When ``$shareOptions`` is false, the options passed to the method will be used for the request. After sending the request, they will be cleared. If you want to use the options to all requests, pass the options in the constructor.

Dado que la respuesta es una instancia de ``Higgs\HTTP\Response``, tienes toda la información normal.
disponible para ti:

.. literalinclude:: curlrequest/006.php

Si bien el método ``request()`` es el más flexible, también puedes utilizar los siguientes métodos abreviados. Ellos
cada uno toma la URL como primer parámetro y una serie de opciones como segundo:

.. literalinclude:: curlrequest/007.php

URI base
--------

Se puede establecer un ``baseURI`` como una de las opciones durante la creación de instancias de la clase. Esto le permite
establezca un URI base y luego realice todas las solicitudes con ese cliente utilizando URL relativas. Esto es especialmente útil
cuando se trabaja con API:

.. literalinclude:: curlrequest/008.php

Cuando se proporciona un URI relativo al método ``request()`` o cualquiera de los métodos abreviados, se combinará
con el baseURI de acuerdo con las reglas descritas por
`RFC 2986, sección 2<https://tools.ietf.org/html/rfc3986#section-5.2>` _. Para ahorrarte algo de tiempo, aquí tienes algunos
Ejemplos de cómo se resuelven las combinaciones.

    ===================== ================ ============= ============
    baseURI URI Resultado
    ===================== ================ ============= ============
    \http://foo.com/bar\http://foo.com/bar
    \http://foo.com/foo /bar \http://foo.com/bar
    \http://foo.com/foo bar \http://foo.com/bar
    \http://foo.com/foo/bar \http://foo.com/foo/bar
    \http://foo.com \http://baz.com \http://baz.com
    \http://foo.com/?barra \http://foo.com/bar
    ===================== ================ ============= ============

Usando respuestas
=================

Cada llamada ``request()`` devuelve un objeto Respuesta que contiene mucha información útil y algunos datos útiles.
métodos. Los métodos más utilizados le permiten determinar la respuesta en sí.

Puede obtener el código de estado y la frase de motivo de la respuesta:

.. literalinclude:: curlrequest/009.php

Puede recuperar encabezados de la respuesta:

.. literalinclude:: curlrequest/010.php

El cuerpo se puede recuperar usando el método ``getBody()``:

.. literalinclude:: curlrequest/011.php

El cuerpo es el cuerpo sin formato proporcionado por el servidor remoto. Si el tipo de contenido requiere formato, necesitará
para asegurarse de que su secuencia de comandos maneje eso:

.. literalinclude:: curlrequest/012.php


Opciones de solicitud
*********************

Esta sección describe todas las opciones disponibles que puede pasar al constructor, el método ``request()``,
o cualquiera de los métodos abreviados.

permitir_redirecciones
======================

De forma predeterminada, cURL seguirá todos los encabezados "Ubicación:" que los servidores remotos envían. La opción ``allow_redirects``
le permite modificar cómo funciona.

Si establece el valor en ``false``, no seguirá ninguna redirección:

.. literalinclude:: curlrequest/013.php

Establecerlo en "verdadero" aplicará la configuración predeterminada a la solicitud:

.. literalinclude:: curlrequest/014.php

Puede pasar una matriz como valor de la opción ``allow_redirects`` para especificar nuevas configuraciones en lugar de las predeterminadas:

.. literalinclude:: curlrequest/015.php

.. note:: Following redirects does not work when PHP is in safe_mode or open_basedir is enabled.

autenticación
=============

Le permite proporcionar detalles de autenticación para `HTTP Básico<https://www.ietf.org/rfc/rfc2069.txt>` _ y
`Resumen<https://www.ietf.org/rfc/rfc2069.txt>` _ y autenticación. Es posible que su script tenga que hacer más para soportar
Autenticación implícita: esto simplemente le pasa el nombre de usuario y la contraseña. El valor debe ser un
Matriz donde el primer elemento es el nombre de usuario y el segundo es la contraseña. El tercer parámetro debe ser
el tipo de autenticación a utilizar, ya sea ``básica`` o ``digest``:

.. literalinclude:: curlrequest/016.php

cuerpo
======

Hay dos formas de configurar el cuerpo de la solicitud para los tipos de solicitud que los admitan, como PUT o POST.
La primera forma es utilizar el método ``setBody()``:

.. literalinclude:: curlrequest/017.php

El segundo método consiste en pasar una opción ``body``. Esto se proporciona para mantener la compatibilidad con la API de Guzzle.
y funciona exactamente de la misma manera que el ejemplo anterior. El valor debe ser una cadena:

.. literalinclude:: curlrequest/018.php

certificado
===========

Para especificar la ubicación de un certificado del lado del cliente con formato PEM, pase una cadena con la ruta completa al
archivo como la opción ``cert``. Si se requiere una contraseña, establezca el valor en una matriz con el primer elemento
como ruta al certificado y el segundo como contraseña:

.. literalinclude:: curlrequest/019.php

tiempo de espera de conexión
============================

De forma predeterminada, Higgs no impone un límite para que cURL intente conectarse a un sitio web. Si lo necesitas
modificar este valor, puedes hacerlo pasando la cantidad de tiempo en segundos con la opción ``connect_timeout``.
Puedes pasar 0 para esperar indefinidamente:

.. literalinclude:: curlrequest/020.php

Galleta
=======

Esto especifica el nombre de archivo que CURL debe usar para leer los valores de las cookies y
para guardar los valores de las cookies. Esto se hace usando las opciones ``CURL_COOKIEJAR`` y ``CURL_COOKIEFILE``.
Un ejemplo:

.. literalinclude:: curlrequest/021.php

depurar
=======

Cuando se pasa ``debug`` y se establece en ``true``, esto permitirá que la depuración adicional se haga eco en STDERR durante el
ejecución del script.

Esto se hace pasando ``CURLOPT_VERBOSE`` y haciendo eco de la salida. Entonces, cuando estás ejecutando un integrado
server a través de ``sparkserve``, verá el resultado en la consola. De lo contrario, la salida se escribirá en
el registro de errores del servidor.

.. literalinclude:: curlrequest/034.php

Puede pasar un nombre de archivo como valor de depuración para que el resultado se escriba en un archivo:

.. literalinclude:: curlrequest/022.php

demora
======

Le permite pausar una cantidad de milisegundos antes de enviar la solicitud:

.. literalinclude:: curlrequest/023.php

parámetros_formulario
=====================

Puede enviar datos de formulario en una solicitud POST application/x-www-form-urlencoded pasando una matriz asociativa en
la opción ``form_params``. Esto establecerá el encabezado ``Content-Type`` en ``application/x-www-form-urlencoded``
si aún no está configurado:

.. literalinclude:: curlrequest/024.php

.. note:: ``form_params`` cannot be used with the ``multipart`` option. You will need to use one or the other.
        Utilice ``form_params`` para la solicitud ``application/x-www-form-urlencoded`` y ``multipart`` para ``multipart/form-data``
        peticiones.

.. _curlrequest-request-options-headers:

encabezados
===========

Si bien puedes configurar cualquier encabezado que esta solicitud necesite usando el método ``setHeader()``, también puedes pasar un encabezado asociativo.
conjunto de encabezados como opción. Cada clave es el nombre de un encabezado y cada valor es una cadena o una matriz de cadenas.
que representa los valores del campo del encabezado:

.. literalinclude:: curlrequest/025.php

Si los encabezados se pasan al constructor, se tratan como valores predeterminados que serán anulados más adelante por cualquier
más matrices de encabezados o llamadas a ``setHeader()``.

http_errores
============

De forma predeterminada, CURLRequest generará ``HTTPException`` si el código HTTP devuelto es
mayor o igual a 400.

Si desea ver el cuerpo de la respuesta, puede configurar ``http_errors`` en ``false`` para
devolver el contenido en su lugar:

.. literalinclude:: curlrequest/026.php

json
====

La opción ``json`` se utiliza para cargar fácilmente datos codificados en JSON como el cuerpo de una solicitud. Un encabezado de tipo de contenido
de ``application/json`` se agrega, sobrescribiendo cualquier tipo de contenido que ya esté configurado. Los datos proporcionados a
esta opción puede ser cualquier valor que acepte ``json_encode()``:

.. literalinclude:: curlrequest/027.php

.. note:: This option does not allow for any customization of the ``json_encode()`` function, or the Content-Type
        encabezamiento. Si necesita esa capacidad, necesitará codificar los datos manualmente, pasándolos a través de ``setBody()``.
        método de CURLRequest y establezca el encabezado Content-Type con el método ``setHeader()``.

multiparte
==========

Cuando necesite enviar archivos y otros datos a través de una solicitud POST, puede usar la opción ``multipart``, junto con
la clase `CURLFile<https://www.php.net/manual/en/class.curlfile.php>` _. Los valores deben ser una matriz asociativa.
de datos POST para enviar. Para un uso más seguro, el método heredado de cargar archivos anteponiendo su nombre con una `@`
ha sido deshabilitado. Todos los archivos que desee enviar deben pasarse como instancias de CURLFile:

.. literalinclude:: curlrequest/028.php

.. note:: ``multipart`` cannot be used with the ``form_params`` option. You can only use one or the other. Use
        ``form_params`` para solicitudes ``application/x-www-form-urlencoded`` y ``multipart`` para ``multipart/form-data``
        peticiones.

.. _curlrequest-request-options-proxy:

apoderado
=========

.. versionadded:: 4.4.0

Puedes configurar un proxy pasando una matriz asociativa como la opción ``proxy``:

.. literalinclude:: curlrequest/035.php

consulta
========

Puede pasar datos para enviarlos como variables de cadena de consulta pasando una matriz asociativa como la opción ``consulta``:

.. literalinclude:: curlrequest/029.php

se acabó el tiempo
==================

De forma predeterminada, las funciones cURL pueden ejecutarse todo el tiempo que sea necesario, sin límite de tiempo. Puedes modificar esto con el ``timeout``
opción. El valor debe ser la cantidad de segundos durante los cuales desea que se ejecuten las funciones. Utilice 0 para esperar indefinidamente:

.. literalinclude:: curlrequest/030.php

agente de usuario
=================

Permite especificar el Agente de Usuario para solicitudes:

.. literalinclude:: curlrequest/031.php

verificar
=========

Esta opción describe el comportamiento de verificación del certificado SSL. Si la opción ``verificar`` es ``verdadera``, habilita la
Verificación del certificado SSL y utiliza el paquete de CA predeterminado proporcionado por el sistema operativo. Si se establece en "falso"
deshabilitará la verificación del certificado (¡esto es inseguro y permite ataques de intermediario!). Puedes configurarlo
a una cadena que contiene la ruta a un paquete de CA para habilitar la verificación con un certificado personalizado. El valor predeterminado
es verdad:

.. literalinclude:: curlrequest/032.php

.. _curlrequest-version:

versión
=======

Para configurar el protocolo HTTP a utilizar, puede pasar una cadena o flotante con el número de versión (normalmente ``1.0``
o ``1.1``, ``2.0`` es compatible desde v7.3.0.):

.. literalinclude:: curlrequest/033.php
