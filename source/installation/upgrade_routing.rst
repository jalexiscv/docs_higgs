Actualizar ruta
###############

.. contents::
    :local:
    :depth: 2

Documentaciones
===============

- `Documentación de enrutamiento URI Higgs 3.X<http://Higgs.com/userguide3/general/routing.html>` _
- :doc:`Documentación de enrutamiento URI Higgs.X</incoming/routing>`

¿Qué ha sido cambiado?
======================

- En H4, el enrutamiento automático está deshabilitado de forma predeterminada.
- En H4 se introduce el nuevo :ref:`auto-routing-improved` más seguro.
- En H4 el enrutamiento ya no se configura estableciendo las rutas como matriz.
- El comodín ``(:any)`` en H3 será el marcador de posición ``(:segment)`` en H4. El ``(:any)`` en H4 coincide con múltiples segmentos. Ver :ref:`Enrutamiento URI<routing-placeholder-any>` .

Guía de actualización
=====================

1. Si utiliza el enrutamiento automático de la misma manera que H3, debe habilitar :ref:`auto-routing-legacy`.
2. Debe cambiar la sintaxis de cada línea de enrutamiento y agregarla en **app/Config/Routes.php**. Por ejemplo:

    - ``$ruta['revistas'] = 'blogs&#39;;`` a ``$rutas->add('revistas', 'Blogs::index');``. Esto se asignaría al método ``index()`` en el controlador ``Blogs``.
    - ``$ruta['producto/(:cualquiera)'] = 'catalog/product_lookup&#39;;`` a ``$rutas->add('producto/(:segmento)', 'Catalog::productLookup'); ``. No olvide reemplazar ``(:cualquier)`` por ``(:segmento)``.
    - ``$ruta['login/(.+)'] = 'auth/login/$1&#39;;`` a ``$routes->add('login/(.+)', 'Auth::login/ $1');``

    .. note:: For backward compatibility, ``$routes->add()`` is used here. But we
        recomiendo encarecidamente utilizar :ref:`routing-http-verb-routes` como
        ``$routes->get()`` en lugar de ``$routes->add()`` por seguridad.

Ejemplo de código
=================

Higgs versión 6.x
------------------------
Ruta: **application/config/routes.php**:

.. literalinclude:: upgrade_routing/ci3sample/001.php

Higgs versión 7.x
-----------------------
Ruta: **app/Config/Routes.php**:

.. literalinclude:: upgrade_routing/001.php

.. note:: For backward compatibility, ``$routes->add()`` is used here. But we
    recomiendo encarecidamente utilizar :ref:`routing-http-verb-routes` como
    ``$routes->get()`` en lugar de ``$routes->add()`` por seguridad.
