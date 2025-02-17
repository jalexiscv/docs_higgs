.. _content-security-policy:


Política de seguridad de contenidos
###################################

.. contents::
    :local:
    :depth: 2


¿Qué es la política de seguridad de contenidos?
***********************************************

Una de las mejores protecciones que tienes contra los ataques XSS es implementar un Content
Política de seguridad (CSP) en el sitio. Esto requiere que usted especifique y autorice cada
fuente de contenido que se incluye en el HTML de su sitio, incluidas imágenes,
hojas de estilo, archivos JavaScript, etc. El navegador rechazará el contenido de
fuentes que no están explícitamente aprobadas. Esta autorización se define dentro
encabezado ``Content-Security-Policy`` de la respuesta y ofrece varias configuraciones
opciones.

Esto suena complejo y, en algunos sitios, definitivamente puede resultar un desafío. Sin embargo, en el caso de muchos sitios sencillos, donde todo el contenido
es atendido por el mismo dominio (por ejemplo, **http://example.com**), es muy sencillo de integrar.

Como se trata de un tema complejo, esta guía del usuario no abordará todos los detalles. Para obtener más información, debe
visite los siguientes sitios:

* `Sitio principal de la Política de seguridad de contenido<https://content-security-policy.com/>` _
* `Especificación W3C<https://www.w3.org/TR/CSP>` _
* `Introducción en HTML5Rocks<https://www.html5rocks.com/en/tutorials/security/content-security-policy/>` _
* `Artículo en SitePoint<https://www.sitepoint.com/improving-web-security-with-the-content-security-policy/>` _


Activar CSP
***********

.. important:: The :ref:`Debug Toolbar <the-debug-toolbar>` may use Kint, which
    genera scripts en línea. Por lo tanto, cuando CSP está activado, CSP nonce es
    salida automática para la barra de herramientas de depuración. Sin embargo, si no estás usando
    CSP nonce, esto cambiará el encabezado de CSP a algo que no desea,
    y se comportará diferente que en producción; si desea verificar CSP
    comportamiento, apague la barra de herramientas de depuración.

De forma predeterminada, la compatibilidad con esto está desactivada. Para habilitar el soporte en su aplicación, edite el valor ``CSPEnabled`` en
**aplicación/Config/App.php**:

.. literalinclude:: csp/011.php

Cuando está habilitado, el objeto de respuesta contendrá una instancia de ``Higgs\HTTP\ContentSecurityPolicy``. El
Los valores establecidos en **app/Config/ContentSecurityPolicy.php** se aplican a esa instancia y, si no se realizan cambios,
necesario durante el tiempo de ejecución, luego se envía el encabezado con el formato correcto y listo.

Con CSP habilitado, se agregan dos líneas de encabezado a la respuesta HTTP: un encabezado **Content-Security-Policy**, con
políticas que identifican tipos de contenido u orígenes que están explícitamente permitidos para diferentes
contextos y un encabezado **Content-Security-Policy-Report-Only**, que identifica los tipos de contenido
u orígenes que estarán permitidos pero que también serán reportados al destino
de su elección.

Nuestra implementación proporciona un tratamiento predeterminado, modificable mediante el método ``reportOnly()``.
Cuando se agrega una entrada adicional a una directiva CSP, como se muestra a continuación, se agregará
al encabezado CSP apropiado para bloquear o prevenir. Eso se puede anular por cada
base de llamada, proporcionando un segundo parámetro opcional a la llamada al método de adición.


Configuración de tiempo de ejecución
************************************

Si su aplicación necesita realizar cambios en tiempo de ejecución, puede acceder a la instancia en ``$this->response->getCSP()`` en sus controladores. El
La clase contiene una serie de métodos que se asignan con bastante claridad al valor de encabezado apropiado que necesita configurar.
A continuación se muestran ejemplos, con diferentes combinaciones de parámetros, aunque todos aceptan una directiva
nombre o una serie de ellos:

.. literalinclude:: csp/012.php

El primer parámetro de cada uno de los métodos "agregar" es un valor de cadena apropiado,
o una serie de ellos.

El método ``reportOnly()`` le permite especificar el tratamiento de informes predeterminado
para fuentes posteriores, a menos que se anule. Por ejemplo, podría especificar
que youtube.com estaba permitido y luego proporciona varias fuentes permitidas pero reportadas:

.. literalinclude:: csp/013.php


Contenido en línea
******************

Es posible configurar un sitio web para que no proteja ni siquiera los scripts y estilos en línea en sus propias páginas, ya que esto podría tener
sido el resultado del contenido generado por el usuario. Para protegerse contra esto, CSP le permite especificar un nonce dentro del
`` <style>`` and ``<script>`` tags, and to add those values to the response's header.

Usar marcadores de posición
===========================

Esto es un dolor de manejar en realidad.
vida, y es más seguro cuando se genera sobre la marcha. Para simplificar esto, puede incluir un ``{csp-style-nonce}`` o
``{csp-script-nonce}`` marcador de posición en la etiqueta y será manejado automáticamente::

    // Original
    <script {csp-script-nonce}>
        console.log("El script no se ejecutará porque no contiene un atributo nonce");
    </script>

    // se convierte
    <script nonce="Eskdikejidojdk978Ad8jf">
        console.log("El script no se ejecutará porque no contiene un atributo nonce");
    </script>

    // O
    <style {csp-style-nonce}>
        . . .
    </style>

.. warning:: If an attacker injects a string like ``<script {csp-script-nonce}>``, it might become the real nonce attribute with this functionality. You can customize the placeholder string with the ``$scriptNonceTag`` and ``$styleNonceTag`` properties in **app/Config/ContentSecurityPolicy.php**.

.. _csp-using-functions:

Usando funciones
================

Si no te gusta la función de reemplazo automático anterior, puedes desactivarla
con la configuración ``$autoNonce = false`` en **app/Config/ContentSecurityPolicy.php**.

En este caso, puede utilizar las funciones :php:func:`csp_script_nonce()` y :php:func:`csp_style_nonce()`::

    // Original
    <script <?= csp_script_nonce() ?>>
        console.log("El script no se ejecutará porque no contiene un atributo nonce");
    </script>

    // se convierte
    <script nonce="Eskdikejidojdk978Ad8jf">
        console.log("El script no se ejecutará porque no contiene un atributo nonce");
    </script>

    // O
    <style <?= csp_style_nonce() ?>>
        . . .
    </style>
