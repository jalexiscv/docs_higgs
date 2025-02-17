#############################
Trabajar con solicitudes HTTP
#############################

Para aprovechar al máximo Higgs, es necesario tener un conocimiento básico de cómo funcionan las solicitudes HTTP.
y las respuestas funcionan. Dado que esto es con lo que se trabaja al desarrollar aplicaciones web, comprender el
Los conceptos detrás de HTTP son **imprescindibles** para todos los desarrolladores que quieran tener éxito.

La primera parte de este capítulo ofrece una visión general. Una vez aclarados los conceptos, discutiremos
cómo trabajar con las solicitudes y respuestas dentro de Higgs.

.. contents::
    :local:
    :depth: 2

¿Qué es HTTP?
*************

HTTP es simplemente una convención basada en texto que permite que dos máquinas se comuniquen entre sí. Cuando un navegador
solicita una página, le pregunta al servidor si puede obtener la página. Luego, el servidor prepara la página y envía
una respuesta al navegador que lo solicitó. Eso es practicamente todo. Obviamente, existen algunas complejidades.
que puedes usar, pero los conceptos básicos son bastante simples.

HTTP es el término utilizado para describir esa convención de intercambio. Significa Protocolo de transferencia de hipertexto. Tu objetivo cuando
desarrollar aplicaciones web es comprender siempre lo que solicita el navegador y poder
responda apropiadamente.

La solicitud
============

Cada vez que un cliente (un navegador web, una aplicación de teléfono inteligente, etc.) realiza una solicitud, envía un pequeño mensaje de texto.
al servidor y espera una respuesta.

La solicitud se vería así::

    OBTENER / HTTP/1.1
    Anfitrión Higgs.com
    Aceptar: texto/html
    Agente de usuario: Chrome/46.0.2490.80

Este mensaje muestra toda la información necesaria para saber lo que solicita el cliente. Le dice al
método para la solicitud (GET, POST, DELETE, etc.) y la versión de HTTP que admite.

La solicitud también incluye una serie de encabezados de solicitud opcionales que pueden contener una amplia variedad de
información como en qué idiomas el cliente desea que se muestre el contenido, los tipos de formatos
el cliente acepta y mucho más. Wikipedia tiene un artículo que enumera "todos los campos de encabezado
<https://en.wikipedia.org/wiki/List_of_HTTP_header_fields>`_ si quieres echarle un vistazo.

La respuesta
============

Una vez que el servidor recibe la solicitud, su aplicación tomará esa información y generará algún resultado.
El servidor empaquetará su salida como parte de su respuesta al cliente. Esto también se representa como
un mensaje de texto simple que se parece a esto::

    HTTP/1.1 200 correcto
    Servidor: nginx/1.8.0
    Fecha: Word, 05 de noviembre de 2015 05:33:22 GMT
    Tipo de contenido: texto/html; juego de caracteres = UTF-8

    <html>
        . . .
    </html>

La respuesta le dice al cliente qué versión de la especificación HTTP está utilizando y, probablemente, la mayoría
Más importante aún, el código de estado (200). El código de estado es uno de varios códigos que se han estandarizado.
tener un significado muy específico para el cliente. Esto puede indicarles que fue exitoso (200), o que la página
no fue encontrado (404). Dirígete a IANA para obtener una "lista completa de códigos de estado HTTP".
<https://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml>`_.

Trabajar con solicitudes y respuestas
*************************************

Mientras que PHP proporciona formas de interactuar con los encabezados de solicitud y respuesta, Higgs, como la mayoría de los marcos,
los abstrae para que usted tenga una interfaz simple y consistente para ellos. La clase :doc:`IncomingRequest</incoming/incomingrequest>`
es una representación orientada a objetos de la solicitud HTTP. Proporciona todo lo que necesitas:

.. literalinclude:: http/001.php

La clase de solicitud hace una gran cantidad de trabajo en segundo plano por usted, del que nunca tendrá que preocuparse.
Los métodos ``isAJAX()`` e ``isSecure()`` comprueban varios métodos diferentes para determinar la respuesta correcta.

.. note:: The ``isAJAX()`` method depends on the ``X-Requested-With`` header, which in some cases is not sent by default in XHR requests via JavaScript (i.e., fetch). See the :doc:`AJAX Requests </general/ajax>` section on how to avoid this problem.

Higgs también proporciona una :doc:`clase de respuesta</outgoing/response>` esa es una representación orientada a objetos
de la respuesta HTTP. Esto le brinda una manera fácil y poderosa de construir su respuesta al cliente:

.. literalinclude:: http/002.php

Además, la clase Response le permite trabajar la capa de caché HTTP para obtener el mejor rendimiento.
