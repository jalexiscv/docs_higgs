#############
Mensajes HTTP
#############

La clase Mensaje proporciona una interfaz para las partes de un mensaje HTTP que son comunes a ambos.
solicitudes y respuestas, incluido el cuerpo del mensaje, la versión del protocolo, las utilidades para trabajar con
los encabezados y los métodos para manejar la negociación de contenido.

Esta clase es la clase principal que tanto la :doc:`Request Class <../incoming/request>` como la
:doc:`Clase de respuesta <../outgoing/response>` se extiende desde.


Referencia de clase
*******************

.. php:namespace:: Higgs\HTTP

.. php:class:: Message

    .. php:method:: getBody()

        :devuelve: El cuerpo del mensaje actual
        :rtype: mixto

        Devuelve el cuerpo del mensaje actual, si se ha configurado alguno. Si no existe el cuerpo, devuelve nulo:

        .. literalinclude:: message/001.php

    .. php:method:: setBody($data)

        :param mixed $data: El cuerpo del mensaje.
        :devuelve: la instancia de Mensaje|Respuesta para permitir que los métodos se encadenen.
        :rtype: Higgs\\HTTP\\Mensaje|Higgs\\HTTP\\Respuesta

        Establece el cuerpo de la solicitud actual.

    .. php:method:: appendBody($data)

        :param mixed $data: El cuerpo del mensaje.
        :devuelve: la instancia de Mensaje|Respuesta para permitir que los métodos se encadenen.
        :rtype: Higgs\\HTTP\\Mensaje|Higgs\\HTTP\\Respuesta

        Agrega datos al cuerpo de la solicitud actual.

    .. php:method:: populateHeaders()

        :returns: nulo

        Escanea y analiza los encabezados que se encuentran en los datos del SERVIDOR y los almacena para acceder a ellos posteriormente.
        Esto lo utiliza :doc:`Clase IncomingRequest <../incoming/incomingrequest>` para realizar
        los encabezados de la solicitud actual disponibles.

        Los encabezados son cualquier dato del SERVIDOR que comience con ``HTTP_``, como ``HTTP_HOST``. cada mensaje
        se convierte de su formato estándar de mayúsculas y guiones bajos a un formato de ucwords y guiones.
        El ``HTTP_`` anterior se elimina de la cadena. Entonces ``HTTP_ACCEPT_LANGUAGE`` se convierte en
        ``Aceptar-Idioma``.

    .. php:method:: headers()

        :returns: una matriz de todos los encabezados encontrados.
        :rtype: matriz

        Devuelve una matriz de todos los encabezados encontrados o configurados previamente.

    .. php:method:: header($name)

        :param string $name: el nombre del encabezado cuyo valor desea recuperar.
        :returns: Devuelve un único objeto de encabezado. Si existen varios encabezados con el mismo nombre, devolverá una matriz de objetos de encabezado.
        :rtype: \Higgs\\HTTP\\Encabezado|matriz

        Le permite recuperar el valor actual de un único encabezado de mensaje. ``$name`` es el nombre del encabezado que no distingue entre mayúsculas y minúsculas.
        Si bien el encabezado se convierte internamente como se describe anteriormente, puede acceder al encabezado con cualquier tipo de mayúsculas y minúsculas:

        .. literalinclude:: message/002.php

        Si el encabezado tiene múltiples valores, ``getValue()`` regresará como una matriz de valores. Puedes usar ``getValueLine()``
        método para recuperar los valores como una cadena:

        .. literalinclude:: message/003.php

        Puede filtrar el encabezado pasando un valor de filtro como segundo parámetro:

        .. literalinclude:: message/004.php

    .. php:method:: hasHeader($name)

        :param string $name: el nombre del encabezado que desea ver si existe.
        :returns: Devuelve verdadero si existe, falso en caso contrario.
        :rtype: booleano

    .. php:method:: getHeaderLine($name)

        :param cadena $nombre: El nombre del encabezado a recuperar.
        :returns: una cadena que representa el valor del encabezado.
        :rtype: cadena

        Devuelve los valores del encabezado como una cadena. Este método le permite obtener fácilmente una representación de cadena.
        de los valores del encabezado cuando el encabezado tiene múltiples valores. Los valores están apropiadamente unidos:

        .. literalinclude:: message/005.php

    .. php:method:: setHeader($name, $value)

        :param string $name: el nombre del encabezado para establecer el valor.
        :param mixed $valor: el valor para establecer el encabezado.
        :devuelve: La instancia actual de Mensaje|Respuesta
        :rtype: Higgs\\HTTP\\Mensaje|Higgs\\HTTP\\Respuesta

        Establece el valor de un único encabezado. ``$name`` es el nombre del encabezado que no distingue entre mayúsculas y minúsculas. si el encabezado
        aún no existe en la colección, se creará. El ``$value`` puede ser una cadena
        o una serie de cadenas:

        .. literalinclude:: message/006.php

    .. php:method:: removeHeader($name)

        :param cadena $nombre: El nombre del encabezado a eliminar.
        :devuelve: La instancia del mensaje actual
        :rtype: Higgs\\HTTP\\Mensaje

        Elimina el encabezado del mensaje. ``$name`` es el nombre del encabezado que no distingue entre mayúsculas y minúsculas:

        .. literalinclude:: message/007.php

    .. php:method:: appendHeader($name, $value)

        :param string $name: El nombre del encabezado a modificar
        :param  string $valor: el valor que se agregará al encabezado.
        :devuelve: La instancia del mensaje actual
        :rtype: Higgs\\HTTP\\Mensaje

        Agrega un valor a un encabezado existente. El encabezado ya debe ser una matriz de valores en lugar de una sola cadena.
        Si es una cadena, se generará una LogicException.

        .. literalinclude:: message/008.php

    .. php:method:: prependHeader($name, $value)

        :param string $name: El nombre del encabezado a modificar
        :param  string $valor: el valor que se antepondrá al encabezado.
        :devuelve: La instancia del mensaje actual
        :rtype: Higgs\\HTTP\\Mensaje

        Antepone un valor a un encabezado existente. El encabezado ya debe ser una matriz de valores en lugar de una sola cadena.
        Si es una cadena, se generará una LogicException.

        .. literalinclude:: message/009.php

    .. php:method:: getProtocolVersion()

        :devuelve: La versión actual del protocolo HTTP
        :rtype: cadena

        Devuelve el protocolo HTTP actual del mensaje. Si no se ha configurado ninguno,
        devolver ``1.1``.

    .. php:method:: setProtocolVersion($version)

        :param string $version: La versión del protocolo HTTP
        :devuelve: La instancia del mensaje actual
        :rtype: Higgs\\HTTP\\Mensaje

        Establece la versión del protocolo HTTP que utiliza este mensaje. Los valores válidos son
        ``1.0``, ``1.1``, ``2.0`` y ``3.0``:

        .. literalinclude:: message/010.php
