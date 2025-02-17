*******************
Trabajar con URI
****************

Higgs proporciona una solución orientada a objetos para trabajar con URI en su aplicación. Usar esto lo hace
simple para garantizar que la estructura sea siempre correcta, sin importar cuán complejo pueda ser el URI, además de agregar
URI relativo a uno existente y resolverlo de forma segura y correcta.

.. contents::
    :local:
    :depth: 2


Creando instancias de URI
=========================

Crear una instancia de URI es tan simple como crear una nueva instancia de clase.

Cuando crea la nueva instancia, puede pasar una URL completa o parcial en el constructor y se analizará.
en sus secciones apropiadas:

.. literalinclude:: uri/001.php
    :lines: 2-

Alternativamente, puede usar la función :php:func:`service()` para devolverle una instancia:

.. literalinclude:: uri/003.php
    :lines: 2-

Desde v7.4.0, si no pasa una URL, devuelve la URI actual:

.. literalinclude:: uri/002.php
    :lines: 2-

.. note:: The above code returns the ``SiteURI`` instance, that extends the ``URI``
    clase. La clase ``URI`` es para URI generales, pero la clase ``SiteURI`` es
    para los URI de su sitio.

El URI actual
---------------

Muchas veces, todo lo que realmente desea es un objeto que represente la URL actual de esta solicitud.
Puede utilizar la función :php:func:`current_url()` disponible en :doc:`../helpers/url_helper`:

.. literalinclude:: uri/004.php
    :lines: 2-

Debe pasar ``true`` como primer parámetro; de lo contrario, devolverá la representación de cadena de la URL actual.

Este URI se basa en la ruta (relativa a su ``baseURL``) según lo determinado por el objeto de solicitud actual y
su configuración en ``Config\App`` (``baseURL``, ``indexPage`` y ``forceGlobalSecureRequests``).

Suponiendo que estás en un controlador que extiende ``Higgs\Controller``,
También puede obtener la instancia actual de SiteURI:

.. literalinclude:: uri/005.php
    :lines: 2-


Cadenas URI
===========

Muchas veces, todo lo que realmente desea es obtener una representación de cadena de un URI. Esto es fácil de hacer simplemente lanzando
el URI como una cadena:

.. literalinclude:: uri/006.php

Si conoce las partes del URI y solo quiere asegurarse de que todo esté formateado correctamente, puede generar una cadena
usando el método estático ``createURIString()`` de la clase URI:

.. literalinclude:: uri/007.php

.. important:: When ``URI`` is cast to a string, it will attempt to adjust project URLs to the
    configuración definida en ``Config\App``. Si necesita la representación de cadena exacta e inalterada
    luego use ``URI::createURIString()`` en su lugar.


Las partes de URI
=================

Una vez que tenga una instancia de URI, puede configurar o recuperar cualquiera de las distintas partes del URI. Esta sección proporcionará
detalles sobre cuáles son esas piezas y cómo trabajar con ellas.

Esquema
------

El esquema suele ser 'http' o 'https', pero se admite cualquier esquema, incluido 'archivo', 'mailto', etc.

.. literalinclude:: uri/008.php

Autoridad
---------

Muchos URI contienen varios elementos que se conocen colectivamente como "autoridad". Esto incluye cualquier información de usuario,
el host y el número de puerto. Puede recuperar todas estas piezas como una sola cadena con ``getAuthority()``
método, o puede manipular las partes individuales.

.. literalinclude:: uri/009.php

De forma predeterminada, esto no mostrará la parte de la contraseña, ya que no querrás mostrársela a nadie. Si quieres
para mostrar la contraseña, puede utilizar el método ``showPassword()``. Esta instancia de URI seguirá mostrando esa contraseña
hasta que lo apagues nuevamente, así que asegúrate siempre de apagarlo tan pronto como hayas terminado:

.. literalinclude:: uri/010.php

Si no desea mostrar el puerto, pase ``true`` como único parámetro:

.. literalinclude:: uri/011.php

.. note:: If the current port is the default port for the scheme it will never be displayed.

Información de usuario
--------

La sección de información de usuario es simplemente el nombre de usuario y la contraseña que puede ver con un URI de FTP. Mientras puedas conseguir
esto como parte de la Autoridad, también puedes recuperarlo tú mismo:

.. literalinclude:: uri/012.php

De forma predeterminada, no mostrará la contraseña, pero puedes anularla con el método ``showPassword()``:

.. literalinclude:: uri/013.php

Anfitrión
----

La parte del host del URI suele ser el nombre de dominio de la URL. Esto se puede configurar y recuperar fácilmente con el
Métodos ``getHost()`` y ``setHost()``:

.. literalinclude:: uri/014.php

Puerto
----

El puerto es un número entero entre 0 y 65535. Cada esquema tiene un valor predeterminado asociado.

.. literalinclude:: uri/015.php

Cuando se utiliza el método ``setPort()``, se comprobará que el puerto esté dentro del rango válido y se asignará.

Camino
----

El camino son todos los segmentos dentro del propio sitio. Como era de esperar, los métodos ``getPath()`` y ``setPath()``
se puede utilizar para manipularlo:

.. literalinclude:: uri/016.php

.. note:: When setting the path this way, or any other way the class allows, it is sanitized to encode any dangerous
    caracteres y elimine los segmentos de puntos por seguridad.

.. note:: Since v7.4.0, the ``SiteURI::getRoutePath()`` method,
    devuelve la ruta URI relativa a baseURL y ``SiteURI::getPath()``
    El método siempre devuelve la ruta URI completa con ``/`` inicial.

Consulta
-----

Los datos de la consulta se pueden manipular a través de la clase utilizando representaciones de cadenas simples.

Obtener/configurar consulta
^^^^^^^^^^^^^^^^^^^^^^^^^^^

Los valores de consulta sólo pueden
establecerse como una cadena actualmente.

.. literalinclude:: uri/017.php

El método ``setQuery()`` sobrescribe cualquier variable de consulta existente.

.. note:: Query values cannot contain fragments. An InvalidArgumentException will be thrown if it does.

Configuración de consulta desde matriz
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Puede establecer valores de consulta utilizando una matriz:

.. literalinclude:: uri/018.php

El método ``setQueryArray()`` sobrescribe cualquier variable de consulta existente.

Agregar valor de consulta
^^^^^^^^^^^^^^^^^^^^^^^^^

Puedes agregar un valor al
colección de variables de consulta sin destruir las variables de consulta existentes con el método ``addQuery()``. La primera
El parámetro es el nombre de la variable y el segundo parámetro es el valor:

.. literalinclude:: uri/019.php

Filtrar valores de consulta
^^^^^^^^^^^^^^^^^^^^^^^^^^^

Puede filtrar los valores de consulta devueltos pasando una matriz de opciones al método ``getQuery()``, ya sea con un
*sólo* o una clave *excepto*:

.. literalinclude:: uri/020.php

Esto solo cambia los valores devueltos durante esta llamada. Si necesita modificar los valores de consulta del URI de forma más permanente,

Cambiar valores de consulta
^^^^^^^^^^^^^^^^^^^^^^^^^^^

puedes usar los métodos ``stripQuery()`` y ``keepQuery()`` para cambiar la colección de variables de consulta del objeto real:

.. literalinclude:: uri/021.php

.. note:: By default ``setQuery()`` and ``setQueryArray()`` methods uses native ``parse_str()`` function to prepare data.
    Si desea utilizar reglas más liberales (que permiten que los nombres de las claves contengan puntos), puede utilizar un método especial
    ``useRawQueryString()`` de antemano.

Fragmento
--------

Los fragmentos son la parte al final de la URL, precedida por el signo de almohadilla (``#``). En las URL HTML estos son enlaces.
a un ancla en la página. Los URI de medios pueden utilizarlos de otras maneras.

.. literalinclude:: uri/022.php


Segmentos URI
=============

Cada sección del camino entre las barras es un único segmento.

.. note:: In the case of your site URI, URI Segments mean only the URI path part
    relativo a la URL base. Si su baseURL contiene subcarpetas, los valores
    será diferente de la ruta URI actual.

La clase URI proporciona una forma sencilla de determinar
cuáles son los valores de los segmentos. Los segmentos comienzan en 1 siendo el extremo izquierdo del camino.

.. literalinclude:: uri/023.php

También puede establecer un valor predeterminado diferente para un segmento en particular utilizando el segundo parámetro del método ``getSegment()``. El valor predeterminado es una cadena vacía.

.. literalinclude:: uri/024.php

.. note:: You can get the last +1 segment. When you try to get the last +2 or
    más segmento, se generará una excepción de forma predeterminada. tu podrías prevenir
    lanzando excepciones con el método ``setSilent()``.

Puede obtener un recuento del total de segmentos:

.. literalinclude:: uri/025.php

Finalmente, puedes recuperar una matriz de todos los segmentos:

.. literalinclude:: uri/026.php


Deshabilitar el lanzamiento de excepciones
==========================================

De forma predeterminada, algunos métodos de esta clase pueden generar una excepción. Si desea desactivarlo, puede establecer una bandera especial
eso evitará que se produzcan excepciones.

.. literalinclude:: uri/027.php
