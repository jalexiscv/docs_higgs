######################
Rasgo de respuesta API
######################

Gran parte del desarrollo PHP moderno requiere la creación de API, ya sea simplemente para proporcionar datos para un entorno con mucho javascript.
aplicación de una sola página o como un producto independiente. Higgs proporciona un rasgo de respuesta API que puede ser
Se utiliza con cualquier controlador para simplificar los tipos de respuesta comunes, sin necesidad de recordar qué código de estado HTTP.
se debe devolver para qué tipos de respuesta.

.. contents::
    :local:
    :depth: 2


Uso de ejemplo
**************

El siguiente ejemplo muestra un patrón de uso común dentro de sus controladores.

.. literalinclude:: api_responses/001.php

En este ejemplo, se devuelve un código de estado HTTP de 201, con el mensaje de estado genérico "Creado". Métodos
existen para los casos de uso más comunes:

.. literalinclude:: api_responses/002.php


Manejo de tipos de respuesta
****************************

Cuando pasa sus datos en cualquiera de estos métodos, ellos determinarán el tipo de datos para formatear los resultados según
los siguientes criterios:

* Si los datos son una cadena, se tratarán como HTML para enviarlos al cliente.
* Si los datos son una matriz, se formatearán de acuerdo con el valor ``$this->format`` del controlador. Si eso está vacío,
  Intentará negociar el tipo de contenido con lo que el cliente solicitó, por defecto en JSON.
  si no se ha especificado nada más dentro de **Config/Format.php**, la propiedad ``$supportedResponseFormats``.

Para definir el formateador que se utiliza, edite **Config/Format.php**. ``$supportedResponseFormats`` contiene una lista de
tipos de mime para los que su aplicación puede formatear automáticamente la respuesta. Por defecto, el sistema sabe cómo
formatee las respuestas XML y JSON:

.. literalinclude:: api_responses/003.php

Esta es la matriz que se utiliza durante :doc:`Negociación de contenido</incoming/content_negotiation>` para determinar cuál
tipo de respuesta a devolver. Si no se encuentran coincidencias entre lo que el cliente solicitó y lo que usted apoya, la primera
El formato en esta matriz es lo que se devolverá.

A continuación, debe definir la clase que se utiliza para formatear la matriz de datos. Esta debe ser una clase totalmente calificada.
nombre, y la clase debe implementar ``Higgs\Format\FormatterInterface``. Los formateadores salen de la caja que
admite JSON y XML:

.. literalinclude:: api_responses/004.php

Por lo tanto, si su solicitud solicita datos con formato JSON en un encabezado **Aceptar**, la matriz de datos que pasa cualquiera de los
Los métodos ``respond*`` o ``fail*`` serán formateados por la clase ``Higgs\Format\JSONFormatter``. La resultante
Los datos JSON se enviarán de vuelta al cliente.


Referencia de clase
*******************

.. php:method:: setResponseFormat($format)

    :param string $format: El tipo de respuesta a devolver, ya sea ``json`` o ``xml``

    Esto define el formato que se utilizará al formatear matrices en las respuestas. Si proporciona un valor "nulo" para
    ``$formato``, se determinará automáticamente mediante la negociación de contenido.

.. literalinclude:: api_responses/005.php

.. php:method:: respond($data[, $statusCode = 200[, $message = '']])

    :param mixed $data: Los datos a devolver al cliente. Ya sea cadena o matriz.
    :param int $statusCode: el código de estado HTTP que se devolverá. El valor predeterminado es 200
    :param string $message: un mensaje personalizado de "motivo" para devolver.

    Este es el método utilizado por todos los demás métodos de este rasgo para devolver una respuesta al cliente.

    El elemento ``$data`` puede ser una cadena o una matriz. De forma predeterminada, se devolverá una cadena como HTML,
    mientras que una matriz se ejecutará a través de json_encode y se devolverá como JSON, a menos que :doc:`Negociación de contenido</incoming/content_negotiation>`
    determina que debe devolverse en un formato diferente.

    Si se pasa una cadena ``$message``, se usará en lugar de los códigos de motivo estándar de la IANA para el
    estado de respuesta. Sin embargo, no todos los clientes respetarán los códigos personalizados y utilizarán los estándares de la IANA.
    que coincidan con el código de estado.

    .. note:: Since it sets the status code and body on the active Response instance, this should always
        ser el método final en la ejecución del script.

.. php:method:: fail($messages[, int $status = 400[, string $code = null[, string $message = '']]])

    :param mixed $messages: una cadena o conjunto de cadenas que contienen mensajes de error encontrados.
    :param int $status: el código de estado HTTP que se devolverá. El valor predeterminado es 400.
    :param string $code: un código de error personalizado, específico de API.
    :param string $message: un mensaje personalizado de "motivo" para devolver.
    :returns: una respuesta de varias partes en el formato preferido del cliente.

    Es el método genérico utilizado para representar una respuesta fallida y lo utilizan todos los demás métodos "fallidos".

    El elemento ``$messages`` puede ser una cadena o una matriz de cadenas.

    El parámetro ``$status`` es el código de estado HTTP que debe devolverse.

    Dado que muchas API funcionan mejor utilizando códigos de error personalizados, se puede pasar un código de error personalizado en el tercer
    parámetro. Si no hay ningún valor presente, será lo mismo que ``$status``.

    Si se pasa una cadena ``$message``, se usará en lugar de los códigos de motivo estándar de la IANA para el
    estado de respuesta. Sin embargo, no todos los clientes respetarán los códigos personalizados y utilizarán los estándares de la IANA.
    que coincidan con el código de estado.

    La respuesta es una matriz con dos elementos: ``error`` y ``mensajes``. El elemento ``error`` contiene el estado
    código del error. El elemento ``messages`` contiene una serie de mensajes de error. Se vería algo como:

    .. literalinclude:: api_responses/006.php

.. php:method:: respondCreated($data = null[, string $message = ''])

    :param mixed $data: Los datos a devolver al cliente. Ya sea cadena o matriz.
    :param string $message: un mensaje personalizado de "motivo" para devolver.
    :returns: El valor del método send() del objeto Respuesta.

    Establece el código de estado apropiado que se usará cuando se crea un nuevo recurso, generalmente 201:

    .. literalinclude:: api_responses/007.php

.. php:method:: respondDeleted($data = null[, string $message = ''])

    :param mixed $data: Los datos a devolver al cliente. Ya sea cadena o matriz.
    :param string $message: un mensaje personalizado de "motivo" para devolver.
    :returns: El valor del método send() del objeto Respuesta.

    Establece el código de estado apropiado que se usará cuando se eliminó un nuevo recurso como resultado de esta llamada API, generalmente 200.

    .. literalinclude:: api_responses/008.php

.. php:method:: respondNoContent(string $message = 'No Content')

    :param string $message: un mensaje personalizado de "motivo" para devolver.
    :returns: El valor del método send() del objeto Respuesta.

    Establece el código de estado apropiado para usar cuando el servidor ejecutó exitosamente un comando pero no hay ningún
    respuesta significativa para enviar al cliente, normalmente 204.

    .. literalinclude:: api_responses/009.php

.. php:method:: failUnauthorized(string $description = 'Unauthorized'[, string $code = null[, string $message = '']])

    :param  string $descripción: el mensaje de error que se mostrará al usuario.
    :param string $code: un código de error personalizado, específico de API.
    :param string $message: un mensaje personalizado de "motivo" para devolver.
    :returns: El valor del método send() del objeto Respuesta.

    Establece el código de estado apropiado para usar cuando el usuario no ha sido autorizado,
    o tiene autorización incorrecta. El código de estado es 401.

    .. literalinclude:: api_responses/010.php

.. php:method:: failForbidden(string $description = 'Forbidden'[, string $code=null[, string $message = '']])

    :param  string $descripción: el mensaje de error que se mostrará al usuario.
    :param string $code: un código de error personalizado, específico de API.
    :param string $message: un mensaje personalizado de "motivo" para devolver.
    :returns: El valor del método send() del objeto Respuesta.

    A diferencia de ``failUnauthorized()``, este método debe usarse cuando el punto final de API solicitado nunca está permitido.
    No autorizado implica que se anima al cliente a intentarlo nuevamente con credenciales diferentes. Medios prohibidos
    el cliente no debe volver a intentarlo porque no ayudará. El código de estado es 403.

    .. literalinclude:: api_responses/011.php

.. php:method:: failNotFound(string $description = 'Not Found'[, string $code=null[, string $message = '']])

    :param  string $descripción: el mensaje de error que se mostrará al usuario.
    :param string $code: un código de error personalizado, específico de API.
    :param string $message: un mensaje personalizado de "motivo" para devolver.
    :returns: El valor del método send() del objeto Respuesta.

    Establece el código de estado apropiado para usar cuando no se puede encontrar el recurso solicitado. El código de estado es 404.

    .. literalinclude:: api_responses/012.php

.. php:method:: failValidationErrors($errors[, string $code=null[, string $message = '']])

    :param Mixed $errors: el mensaje de error o conjunto de mensajes que se mostrarán al usuario.
    :param string $code: un código de error personalizado, específico de API.
    :param string $message: un mensaje personalizado de "motivo" para devolver.
    :returns: El valor del método send() del objeto Respuesta.

    Establece el código de estado apropiado para usar cuando los datos que envió el cliente no pasaron las reglas de validación. El código de estado suele ser 400.

    .. literalinclude:: api_responses/013.php

.. php:method:: failResourceExists(string $description = 'Conflict'[, string $code=null[, string $message = '']])

    :param  string $descripción: el mensaje de error que se mostrará al usuario.
    :param string $code: un código de error personalizado, específico de API.
    :param string $message: un mensaje personalizado de "motivo" para devolver.
    :returns: El valor del método send() del objeto Respuesta.

    Establece el código de estado apropiado para usar cuando el recurso que el cliente intenta crear ya existe.
    El código de estado suele ser 409.

    .. literalinclude:: api_responses/014.php

.. php:method:: failResourceGone(string $description = 'Gone'[, string $code=null[, string $message = '']])

    :param  string $descripción: el mensaje de error que se mostrará al usuario.
    :param string $code: un código de error personalizado, específico de API.
    :param string $message: un mensaje personalizado de "motivo" para devolver.
    :returns: El valor del método send() del objeto Respuesta.

    Establece el código de estado apropiado para usar cuando el recurso solicitado se eliminó previamente y
    ya no está disponible. El código de estado suele ser 410.

    .. literalinclude:: api_responses/015.php

.. php:method:: failTooManyRequests(string $description = 'Too Many Requests'[, string $code=null[, string $message = '']])

    :param  string $descripción: el mensaje de error que se mostrará al usuario.
    :param string $code: un código de error personalizado, específico de API.
    :param string $message: un mensaje personalizado de "motivo" para devolver.
    :returns: El valor del método send() del objeto Respuesta.

    Establece el código de estado apropiado para usar cuando el cliente ha llamado a un punto final de API demasiadas veces.
    Esto podría deberse a algún tipo de limitación o limitación de velocidad. El código de estado suele ser 400.

    .. literalinclude:: api_responses/016.php

.. php:method:: failServerError(string $description = 'Internal Server Error'[, string $code = null[, string $message = '']])

    :param  string $descripción: el mensaje de error que se mostrará al usuario.
    :param string $code: un código de error personalizado, específico de API.
    :param string $message: un mensaje personalizado de "motivo" para devolver.
    :returns: El valor del método send() del objeto Respuesta.

    Establece el código de estado apropiado para usar cuando hay un error del servidor.

    .. literalinclude:: api_responses/017.php
