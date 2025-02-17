################
Solicitudes AJAX
################

El método ``IncomingRequest::isAJAX()`` usa el encabezado ``X-Requested-With`` para definir si la solicitud es XHR o normal. Sin embargo, las implementaciones de JavaScript más recientes (es decir, fetch) ya no envían este encabezado junto con la solicitud, por lo que el uso de ``IncomingRequest::isAJAX()`` se vuelve menos confiable, porque sin este encabezado no es posible definir si la solicitud es o no XHR.

Para solucionar este problema, la solución más eficiente (hasta ahora) es definir manualmente el encabezado de la solicitud, forzando que la información se envíe al servidor, que luego podrá identificar que la solicitud es XHR.

A continuación se explica cómo forzar el envío del encabezado ``X-Requested-With`` en Fetch API y otras bibliotecas de JavaScript.

.. contents::
    :local:
    :depth: 2

Obtener API
===========

.. code-block:: javascript

    buscar(url, {
        método: "POST",
        encabezados: {
          "Tipo de contenido": "aplicación/json",
          "X-Requested-With": "XMLHttpRequest"
        }
    });

jQuery
======

Para bibliotecas como jQuery por ejemplo, no es necesario hacer explícito el envío de este encabezado, porque según la `documentación oficial<https://api.jquery.com/jquery.ajax/>` _ es un encabezado estándar para todas las solicitudes ``$.ajax()``. Pero si aun así quieres forzar el envío para no correr riesgos, simplemente hazlo de la siguiente manera:

.. code-block:: javascript

    $.ajax({
        URL: "tu URL",
        encabezados: {'X-Requested-With': 'XMLHttpRequest'}
    });

VueJS
=====

En VueJS solo necesitas agregar el siguiente código a la función ``creado``, siempre y cuando estés usando Axios para este tipo de solicitud.

.. code-block:: javascript

    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest&#39;;

Reaccionar
==========

.. code-block:: javascript

    axios.get("su URL", {encabezados: {'Tipo de contenido': 'aplicación/json'}})

htmx
====

Puedes usar `ajax-header<https://htmx.org/extensions/ajax-header/>` _ extensión.

.. code-block:: html

    <body hx-ext="ajax-header">
    ...
    </body>
