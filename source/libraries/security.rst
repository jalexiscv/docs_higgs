#########
Seguridad
#########

La clase de seguridad contiene métodos que ayudan a proteger su sitio contra ataques de falsificación de solicitudes entre sitios.

.. contents::
    :local:
    :depth: 3


Cargando la biblioteca
**********************

Si su único interés al cargar la biblioteca es manejar la protección CSRF, entonces nunca necesitará cargarla.
ya que se ejecuta como un filtro y no tiene interacción manual.

Sin embargo, si encuentra un caso en el que necesita acceso directo, puede cargarlo a través del archivo de Servicios:

.. literalinclude:: security/001.php

.. _cross-site-request-forgery:


Falsificación de solicitudes entre sitios (CSRF)
************************************************

.. warning:: The CSRF Protection is only available for **POST/PUT/PATCH/DELETE** requests.
    Las solicitudes de otros métodos no están protegidas.

Requisito previo
================

Cuando utiliza la protección CSRF de Higgs, aún necesita codificar de la siguiente manera.
De lo contrario, es posible que se omita la protección CSRF.

Cuando el enrutamiento automático está deshabilitado
-----------------------

Haz una de las siguientes:

1. No utilice ``$routes->add()`` y utilice verbos HTTP en las rutas.
2. Verifique el método de solicitud en el método del controlador antes de procesarlo.

P.ej::

    if (! $this->solicitud->is('publicación')) {
        return $this->respuesta->setStatusCode(405)->setBody('Método no permitido');
    }

.. note:: The :ref:`$this->request->is() <incomingrequest-is>` method can be used since v7.3.0.
    En versiones anteriores, es necesario utilizar
    ``if (strtolower($this->request->getMethod()) !== 'publicación')``.

Cuando el enrutamiento automático está habilitado
----------------------------

1. Verifique el método de solicitud en el método del controlador antes de procesarlo.

P.ej::

    if (! $this->solicitud->is('publicación')) {
        return $this->respuesta->setStatusCode(405)->setBody('Método no permitido');
    }

Configuración para CSRF
=======================

.. _csrf-protection-methods:

Métodos de protección CSRF
-----------------------

.. warning:: If you use :doc:`Session <./sessions>`, be sure to use Session based
    Protección CSRF. La protección CSRF basada en cookies no impedirá los ataques en el mismo sitio.
    Ver
    `GHSA-5hm8-vh6r-2cjq<https://github.com/Higgs(AI)/shield/security/advisories/GHSA-5hm8-vh6r-2cjq>` _
    para detalles.

De forma predeterminada, se utiliza la protección CSRF basada en cookies. Es
`Cookie de envío doble <https://cheatsheetseries.owasp.org/cheatsheets/Cross-Site_Request_Forgery_Prevention_Cheat_Sheet.html#double-submit-cookie>` _
en la hoja de referencia para la prevención de falsificación de solicitudes entre sitios de OWASP.

También puede utilizar la protección CSRF basada en sesiones. Es
`Patrón de token de sincronizador <https://cheatsheetseries.owasp.org/cheatsheets/Cross-Site_Request_Forgery_Prevention_Cheat_Sheet.html#synchronizer-token-pattern>` _.

Puede configurar el uso de la protección CSRF basada en sesión editando el siguiente valor del parámetro de configuración en
**aplicación/Config/Security.php**:

.. literalinclude:: security/002.php

Aleatorización de tokens
-------------------

Para mitigar los ataques de compresión de canal lateral como `BREACH`_ y evitar que un atacante adivine los tokens CSRF, puede configurar la aleatorización de tokens (desactivada de forma predeterminada).

Si lo habilita, se agrega una máscara aleatoria al token y se usa para codificarlo.

.. _`BREACH`: https://en.wikipedia.org/wiki/BREACH

Puede habilitarlo editando el siguiente valor del parámetro de configuración en
**aplicación/Config/Security.php**:

.. literalinclude:: security/003.php

Regeneración de tokens
------------------

Los tokens pueden regenerarse en cada envío (predeterminado) o
se mantiene igual durante toda la vida de la sesión o cookie CSRF.

El valor por defecto
La regeneración de tokens proporciona una seguridad más estricta, pero puede resultar
en problemas de usabilidad ya que otros tokens dejan de ser válidos (hacia atrás/adelante)
navegación, múltiples pestañas/ventanas, acciones asincrónicas, etc.). Tú
puede alterar este comportamiento editando el siguiente valor del parámetro de configuración en
**aplicación/Config/Security.php**:

.. literalinclude:: security/004.php

.. warning:: If you use Cookie based CSRF protection, and :php:func:`redirect()`
    después del envío, debe llamar a ``withCookie()`` para enviar el archivo regenerado.
    Galleta CSRF. Consulte :ref:`response-redirect` para obtener más detalles.

.. note:: Since v7.2.3, you can regenerate CSRF token manually with the
    Método ``Seguridad::generateHash()``.

.. _csrf-redirection-on-failure:

Redirección en caso de error
----------------------

Desde v7.3.0, cuando una solicitud no supera la verificación de validación CSRF,
lanzará una SecurityException de forma predeterminada,

.. note:: In production environment, when you use HTML forms, it is recommended
    para habilitar esta redirección para una mejor experiencia de usuario.

Si desea redirigir a la página anterior,
cambie el siguiente valor del parámetro de configuración en
**aplicación/Config/Security.php**:

.. literalinclude:: security/005.php

Cuando se redirige, se establece un mensaje flash de ``error`` que se puede mostrar al usuario final con el siguiente código en su vista::

    <?= session()->obtener datos Flash('error')?>

Esto proporciona una experiencia mejor que simplemente fallar.

Incluso cuando el valor de redirección sea "verdadero", las llamadas AJAX no redireccionarán, pero generarán una excepción de seguridad.

Habilitar la protección CSRF
============================

Puede habilitar la protección CSRF modificando su **app/Config/Filters.php**
y habilitando el filtro `csrf` globalmente:

.. literalinclude:: security/006.php

Los URI seleccionados se pueden incluir en la lista blanca de la protección CSRF (por ejemplo, API
terminales que esperan contenido PUBLICADO externamente). Puedes agregar estos URI
agregándolos como excepciones en el filtro:

.. literalinclude:: security/007.php

También se admiten expresiones regulares (no distinguen entre mayúsculas y minúsculas):

.. literalinclude:: security/008.php

También es posible habilitar el filtro CSRF solo para métodos específicos:

.. literalinclude:: security/009.php

.. Warning:: If you use ``$methods`` filters, you should :ref:`disable Auto Routing (Legacy) <use-defined-routes-only>`
    porque :ref:`auto-routing-legacy` permite que cualquier método HTTP acceda a un controlador.
    Acceder al controlador con un método inesperado podría pasar por alto el filtro.

Formularios HTML
================

Si utiliza :doc:`form helper <../helpers/form_helper>`, entonces
:func:`form_open()` insertará automáticamente un campo csrf oculto en
tus formularios.

.. note:: To use auto-generation of CSRF field, you need to turn CSRF filter on to the form page.
    En la mayoría de los casos se solicita mediante el método ``GET``.

Si no, entonces puedes usar el ``csrf_token()`` siempre disponible.
y funciones ``csrf_hash()``
::

    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

Además, puede utilizar el método ``csrf_field()`` para generar este
campo de entrada oculto para usted::

    // Genera:<input type="hidden" name="{csrf_token}" value="{csrf_hash}" />
    <?= csrf_field() ?>

Al enviar una solicitud JSON, el token CSRF también se puede pasar como uno de los parámetros.
La siguiente forma de pasar el token CSRF es un encabezado Http especial cuyo nombre está disponible en
Función ``csrf_header()``.

Además, puede utilizar el método ``csrf_meta()`` para generar este práctico
metaetiqueta para ti::

    // Genera:<meta name="{csrf_header}" content="{csrf_hash}" />
    <?= csrf_meta() ?>

El orden de los tokens enviados por los usuarios
================================================

El orden de verificación de la disponibilidad del token CSRF es el siguiente:

1. Matriz ``$_POST``
2. encabezado HTTP
3. ``php://input`` (solicitud JSON): tenga en cuenta que este enfoque es el más lento ya que tenemos que decodificar JSON y luego volver a codificarlo.
4. ``php://input`` (cuerpo sin formato) - para solicitudes de tipo PUT, PATCH y DELETE

.. note:: ``php://input`` (raw body) is checked since v7.4.2.


Otros métodos útiles
********************

Nunca necesitará utilizar directamente la mayoría de los métodos de la clase Seguridad. Los siguientes son métodos que
Puede resultarle útil que no esté relacionado con la protección CSRF.

desinfectar nombre de archivo()
===============================

Intenta desinfectar los nombres de archivos para evitar intentos de atravesar directorios y otras amenazas a la seguridad, lo cual es
particularmente útil para archivos que se proporcionaron a través de la entrada del usuario. El primer parámetro es la ruta a desinfectar.

Si es aceptable que la entrada del usuario incluya rutas relativas, por ejemplo, **archivo/en/algunos/aprobado/carpeta.txt**, puede configurar
el segundo parámetro opcional, ``$relativePath`` a ``true``.

.. literalinclude:: security/010.php
