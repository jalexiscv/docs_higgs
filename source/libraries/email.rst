###########################
Clase de correo electrónico
###########################

La sólida clase de correo electrónico de Higgs admite las siguientes características:

- Múltiples protocolos: correo, sendmail y SMTP
- Cifrado TLS y SSL para SMTP
- Múltiples destinatarios
- CC y BCC
- Correo electrónico HTML o texto sin formato
- Archivos adjuntos
- Ajuste de palabras
- Prioridades
- Modo por lotes BCC, que permite dividir listas de correo electrónico grandes en pequeñas
   Lotes BCC.
- Herramientas de depuración de correo electrónico

.. contents::
    :local:
    :depth: 3


Usando la biblioteca de correo electrónico
******************************************

Envío de correo electrónico
===========================

Enviar correo electrónico no sólo es sencillo, sino que también puedes configurarlo sobre la marcha o
establezca sus preferencias en el archivo **app/Config/Email.php**.

A continuación se muestra un ejemplo básico que demuestra cómo se puede enviar un correo electrónico:

.. literalinclude:: email/001.php

.. _setting-email-preferences:

Configuración de preferencias de correo electrónico
===================================================

Hay 21 preferencias diferentes disponibles para personalizar la forma en que su correo electrónico
se envían mensajes. Puede configurarlos manualmente como se describe aquí,
o automáticamente a través de las preferencias almacenadas en su archivo de configuración, descritas
en `Preferencias de correo electrónico`_.

Configuración de preferencias de correo electrónico pasando una matriz
---------------------------------------

Las preferencias se establecen pasando una serie de valores de preferencia al
método de inicialización de correo electrónico. A continuación se muestra un ejemplo de cómo podría configurar algunos
preferencias:

.. literalinclude:: email/002.php

.. note:: Most of the preferences have default values that will be used
    si no los configura.

Configuración de preferencias de correo electrónico en un archivo de configuración
------------------------------------------

Si prefiere no establecer preferencias utilizando el método anterior, puede
en su lugar, colóquelos en el archivo de configuración. Simplemente abre el
**app/Config/Email.php** y establezca sus configuraciones en el
Propiedades del correo electrónico. Luego guarde el archivo y se utilizará automáticamente.
NO necesitarás usar el método ``$email->initialize()`` si
usted establece sus preferencias en el archivo de configuración.

.. _email-ssl-tls-for-smtp:

SSL versus TLS para protocolo SMTP
--------------------------------

Para proteger el nombre de usuario, la contraseña y el contenido del correo electrónico mientras se comunica con el servidor SMTP,
Se debe utilizar cifrado en el canal. Se utilizan ampliamente dos estándares diferentes y
Es importante comprender las diferencias al intentar solucionar problemas de envío de correo electrónico.
asuntos.

La mayoría de los servidores SMTP permiten conexiones en los puertos 465 o 587 al enviar correos electrónicos. (El
El puerto original 25 rara vez se usa debido a que muchos ISP tienen reglas de bloqueo implementadas y
ya que la comunicación está enteramente en texto claro).

La diferencia clave es que el puerto 465 espera que el canal de comunicación esté protegido mediante TLS.
desde el principio según `RFC 8314<https://tools.ietf.org/html/rfc8314>` _.
Una conexión al puerto 587 permite la conexión de texto sin cifrar y posteriores
actualizará el canal para usar cifrado usando el comando SMTP ``STARTTLS``.

La actualización de una conexión en el puerto 465 puede ser compatible o no con el servidor, por lo que el
El comando SMTP ``STARTTLS`` puede fallar si el servidor no lo permite. Si configura el puerto en 465,
debería intentar configurar ``SMTPCrypto`` en una cadena vacía (``''``) ya que la comunicación es
asegurado usando TLS desde el principio y el ``STARTTLS`` no es necesario.

Si su configuración requiere que se conecte al puerto 587, lo más probable es que deba configurar
``SMTPCrypto`` a ``tls`` ya que esto implementará el comando ``STARTTLS`` mientras se comunica
con el servidor SMTP para cambiar de texto sin cifrar a un canal cifrado. La comunicación inicial
se realizará en texto claro y el canal se actualizará a TLS con el comando ``STARTTLS``.

Revisar preferencias
---------------------

La configuración utilizada para el último envío exitoso está disponible en el
propiedad de instancia ``$archivo``. Esto es útil para probar y depurar.
para determinar los valores reales en el momento de la llamada ``send()``.

.. _email-preferences:

Preferencias de correo electrónico
==================================

La siguiente es una lista de todas las preferencias que se pueden configurar cuando
enviando correo electrónico.

=================== =================== ============ ================ =================================== =======================================
Preferencia Valor predeterminado Opciones Descripción
=================== =================== ============ ================ =================================== =======================================
**userAgent** Higgs Ninguno El "agente de usuario".
**protocol** mail ``mail``, ``sendmail``, El protocolo de envío de correo.
                                        o ``smtp``
**mailPath** /usr/sbin/sendmail Ninguno La ruta del servidor a Sendmail.
**SMTPHost** No Predeterminado Ninguno Nombre de host del servidor SMTP.
**SMTPUser** No Predeterminado Ninguno Nombre de usuario SMTP.
**SMTPPass** No Predeterminado Ninguno Contraseña SMTP.
**Puerto SMTP** 25 Ninguno Puerto SMTP. (Si se establece en ``465``, se utilizará TLS para la conexión
                                                                     independientemente de la configuración de ``SMTPCrypto``.)
**SMTPTimeout** 5 Ninguno Tiempo de espera SMTP (en segundos).
**SMTPKeepAlive** false ``true``/``false`` (booleano) Habilita conexiones SMTP persistentes.
**SMTPCrypto** tls ``tls``, ``ssl`` o cifrado SMTP. Establecer esto en ``ssl`` creará una conexión segura
                                        canal de cadena vacía (``''``) al servidor usando SSL, y ``tls`` emitirá un
                                                                     Comando ``STARTTLS`` al servidor. La conexión en el puerto ``465`` debe
                                                                     establezca esto en una cadena vacía (``''``). Ver también
                                                                     :ref:`correo electrónico-ssl-tls-para-smtp`.
**wordWrap** true ``true``/``false`` (booleano) Habilita el ajuste de palabras.
**wrapChars** 76 Recuento de caracteres para ajustar.
**mailType** texto ``text`` o ``html`` Tipo de correo. Si envías un correo electrónico HTML debes enviarlo como una web completa
                                                                     página. Asegúrate de no tener ningún enlace relativo o imagen relativa.
                                                                     caminos de lo contrario no funcionarán.
**charset** utf-8 Conjunto de caracteres (``utf-8``, ``iso-8859-1``, etc.).
**validar** verdadero ``true``/``false`` (booleano) Si se valida la dirección de correo electrónico.
**prioridad** 3 1, 2, 3, 4, 5 Prioridad de correo electrónico. ``1`` = más alto. ``5`` = más bajo. ``3`` = normal.
**CRLF** \\n ``\r\n`` o ``\n`` o ``\r`` Carácter de nueva línea. (Utilice ``\r\n`` para cumplir con RFC 822).
**nueva línea** \\n ``\r\n`` o ``\n`` o ``\r`` Carácter de nueva línea. (Utilice ``\r\n`` para cumplir con RFC 822).
**BCCBatchMode** false ``true``/``false`` (booleano) Habilita el modo por lotes BCC.
**BCCBatchSize** 200 Ninguno Número de correos electrónicos en cada lote de CCO.
**DSN** false ``true``/``false`` (booleano) Habilitar mensaje de notificación desde el servidor.
=================== =================== ============ ================ =================================== =======================================

Anular el ajuste de palabras
============================

Si tiene habilitado el ajuste de palabras (recomendado para cumplir con RFC 822)
y tienes un enlace muy largo en tu correo electrónico que también puede incluirse,
haciendo que la persona que lo recibe no pueda hacer clic en él.
Higgs le permite anular manualmente el ajuste de palabras dentro de parte de su
mensaje como este::

    El texto de su correo electrónico que
    se envuelve normalmente.

    {desenvolver}http://example.com/a_long_link_that_should_not_be_wrapped.html{/unwrap}

    Más texto que será
    Envuelto normalmente.

Coloque el elemento entre el que no desea ajustar palabras: {unwrap} {/unwrap}


Referencia de clase
*******************

.. php:namespace:: Higgs\Email

.. php:class:: Email

    .. php:method:: setFrom($from[, $name = ''[, $returnPath = null]])

        :param  string $from: dirección de correo electrónico "De"
        :param  string $nombre: nombre para mostrar "De"
        :param string $returnPath: Dirección de correo electrónico opcional para redirigir el correo electrónico no entregado
        :devuelve: Higgs\\Email\\Email instancia (encadenamiento de métodos)
        :rtype: Higgs\\Correo electrónico\\Correo electrónico

        Establece la dirección de correo electrónico y el nombre de la persona que envía el correo electrónico:

        .. literalinclude:: email/003.php

        También puede establecer una ruta de retorno para ayudar a redirigir el correo no entregado:

        .. literalinclude:: email/004.php

        .. note:: Return-Path can't be used if you've configured 'smtp' as
            su protocolo.

    .. php:method:: setReplyTo($replyto[, $name = ''])

        :param  string $replyto: dirección de correo electrónico para respuestas
        :param  string $nombre: nombre para mostrar de la dirección de correo electrónico de respuesta
        :devuelve: Higgs\\Email\\Email instancia (encadenamiento de métodos)
        :rtype: Higgs\\Correo electrónico\\Correo electrónico

        Establece la dirección de respuesta. Si no se proporciona la información,
        Se utiliza la información del método `setFrom <#setFrom>`_. Ejemplo:

        .. literalinclude:: email/005.php

    .. php:method:: setTo($to)

        :param mixed $to: cadena delimitada por comas o una matriz de direcciones de correo electrónico
        :devuelve: Higgs\\Email\\Email instancia (encadenamiento de métodos)
        :rtype: Higgs\\Correo electrónico\\Correo electrónico

        Establece las direcciones de correo electrónico de los destinatarios. Puede ser un solo correo electrónico,
        una lista delimitada por comas o una matriz:

        .. literalinclude:: email/006.php

        .. literalinclude:: email/007.php

        .. literalinclude:: email/008.php

    .. php:method:: setCC($cc)

        :param mixed $cc: cadena delimitada por comas o una matriz de direcciones de correo electrónico
        :devuelve: Higgs\\Email\\Email instancia (encadenamiento de métodos)
        :rtype: Higgs\\Correo electrónico\\Correo electrónico

        Establece las direcciones de correo electrónico CC. Al igual que el "para", puede ser un solo correo electrónico,
        una lista delimitada por comas o una matriz.

    .. php:method:: setBCC($bcc[, $limit = ''])

        :param mixed $bcc: cadena delimitada por comas o una matriz de direcciones de correo electrónico
        :param int $limit: Número máximo de correos electrónicos para enviar por lote
        :devuelve: Higgs\\Email\\Email instancia (encadenamiento de métodos)
        :rtype: Higgs\\Correo electrónico\\Correo electrónico

        Establece las direcciones de correo electrónico CCO. Al igual que el método ``setTo()``, puede ser un único
        correo electrónico, una lista delimitada por comas o una matriz.

        Si se establece ``$limit``, se habilitará el "modo por lotes", que enviará
        los correos electrónicos en lotes, y cada lote no exceda el especificado
        ``$límite``.

    .. php:method:: setSubject($subject)

        :param  string $asunto: línea de asunto del correo electrónico
        :devuelve: Higgs\\Email\\Email instancia (encadenamiento de métodos)
        :rtype: Higgs\\Correo electrónico\\Correo electrónico

        Establece el asunto del correo electrónico:

        .. literalinclude:: email/009.php

    .. php:method:: setMessage($body)

        :param string $body: cuerpo del mensaje de correo electrónico
        :devuelve: Higgs\\Email\\Email instancia (encadenamiento de métodos)
        :rtype: Higgs\\Correo electrónico\\Correo electrónico

        Establece el cuerpo del mensaje de correo electrónico:

        .. literalinclude:: email/010.php

    .. php:method:: setAltMessage($str)

        :param string $str: cuerpo del mensaje de correo electrónico alternativo
        :devuelve: Higgs\\Email\\Email instancia (encadenamiento de métodos)
        :rtype: Higgs\\Correo electrónico\\Correo electrónico

        Establece el cuerpo del mensaje de correo electrónico alternativo:

        .. literalinclude:: email/011.php

        Esta es una cadena de mensaje opcional que se puede utilizar si envía
        Correo electrónico con formato HTML. Te permite especificar un mensaje alternativo.
        sin formato HTML que se agrega a la cadena de encabezado para
        personas que no aceptan correo electrónico HTML. Si no estableces el tuyo
        mensaje Higgs extraerá el mensaje de su correo electrónico HTML
        y quitar las etiquetas.

    .. php:method:: setHeader($header, $value)

        :param  string $encabezado: nombre del encabezado
        :param  string $valor: valor del encabezado
        :devuelve: Higgs\\Email\\Email instancia (encadenamiento de métodos)
        :rtype: Higgs\\Correo electrónico\\Correo electrónico

        Agrega encabezados adicionales al correo electrónico:

        .. literalinclude:: email/012.php

    .. php:method:: clear($clearAttachments = false)

        :param bool $clearAttachments: si se borran o no los archivos adjuntos
        :devuelve: Higgs\\Email\\Email instancia (encadenamiento de métodos)
        :rtype: Higgs\\Correo electrónico\\Correo electrónico

        Inicializa todas las variables de correo electrónico a un estado vacío. Este método
        está diseñado para usarse si ejecuta el método de envío de correo electrónico en un bucle,
        permitiendo que los datos se restablezcan entre ciclos.

        .. literalinclude:: email/013.php

        Si establece el parámetro en verdadero, todos los archivos adjuntos se borrarán como
        Bueno:

        .. literalinclude:: email/014.php

    .. php:method:: send($autoClear = true)

        :param bool $autoClear: si se borran los datos del mensaje automáticamente
        :returns: verdadero en caso de éxito, falso en caso de error
        :rtype: booleano

        El método de envío de correo electrónico. Devuelve un valor booleano verdadero o falso según
        éxito o fracaso, lo que permite su uso condicional:

        .. literalinclude:: email/015.php

        Este método borrará automáticamente todos los parámetros si la solicitud fue
        exitoso. Para detener este comportamiento, pase falso:

        .. literalinclude:: email/016.php

        .. note:: In order to use the ``printDebugger()`` method, you need
            para evitar borrar los parámetros del correo electrónico.

        .. note:: If ``BCCBatchMode`` is enabled, and there are more than
            destinatarios ``BCCBatchSize``, este método siempre devolverá
            booleano ``true``.

    .. php:method:: attach($filename[, $disposition = ''[, $newname = null[, $mime = '']]])

        :param  string $nombre de archivo: nombre de archivo
        :param cadena $disposición: 'disposición' del archivo adjunto. Mayoría
            Los clientes de correo electrónico toman su propia decisión independientemente del MIME.
            especificación utilizada aquí. https://www.iana.org/assignments/cont-disp/cont-disp.xhtml
        :param string $newname: nombre de archivo personalizado para usar en el correo electrónico
        :param string $mime: tipo MIME a usar (útil para datos almacenados en buffer)
        :devuelve: Higgs\\Email\\Email instancia (encadenamiento de métodos)
        :rtype: Higgs\\Correo electrónico\\Correo electrónico

        Le permite enviar un archivo adjunto. Coloque la ruta/nombre del archivo en el primero
        parámetro. Para varios archivos adjuntos, utilice el método varias veces.
        Por ejemplo:

        .. literalinclude:: email/017.php

        Para utilizar la disposición predeterminada (adjunto), deje el segundo parámetro en blanco,
        de lo contrario, utilice una disposición personalizada:

        .. literalinclude:: email/018.php

        También puedes usar una URL:

        .. literalinclude:: email/019.php

        Si desea utilizar un nombre de archivo personalizado, puede utilizar el tercer parámetro:

        .. literalinclude:: email/020.php

        Si necesita utilizar una cadena de búfer en lugar de un archivo físico real, puede
        use el primer parámetro como búfer, el tercer parámetro como nombre de archivo y el cuarto
        parámetro como tipo mime:

        .. literalinclude:: email/021.php

    .. php:method:: setAttachmentCID($filename)

        :param string $filename: nombre de archivo adjunto existente
        :returns: ID de contenido del archivo adjunto o falso si no se encuentra
        :rtype: cadena

        Establece y devuelve el ID de contenido de un archivo adjunto, lo que le permite insertar un archivo en línea
        (imagen) adjunto en HTML. El primer parámetro debe ser el nombre del archivo ya adjunto.

        .. literalinclude:: email/022.php

        .. note:: Content-ID for each e-mail must be re-created for it to be unique.

    .. php:method:: printDebugger($include = ['headers', 'subject', 'body'])

        :param array $include: qué partes del mensaje imprimir
        :returns: datos de depuración formateados
        :rtype: cadena

        Devuelve una cadena que contiene los mensajes del servidor, los encabezados de correo electrónico y
        el mensaje de correo electrónico. Útil para depurar.

        Opcionalmente, puede especificar qué partes del mensaje deben imprimirse.
        Las opciones válidas son: **encabezados**, **asunto**, **cuerpo**.

        Ejemplo:

        .. literalinclude:: email/023.php

        .. note:: By default, all of the raw data will be printed.
