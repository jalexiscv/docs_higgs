####################
Respuestas de prueba
####################

La clase ``TestResponse`` proporciona una serie de funciones útiles para analizar y probar respuestas.
de sus casos de prueba. Por lo general, se le proporcionará una ``Respuesta de prueba`` como resultado de su
:doc:`Pruebas del controlador<controllers>`  o :doc:`Pruebas de funciones HTTP<feature>` , pero siempre puedes
cree el suyo propio directamente usando cualquier ``ResponseInterface``:

.. literalinclude:: response/001.php
   :lines: 2-

.. contents::
    :local:
    :depth: 2

Probando la respuesta
*********************

Ya sea que haya recibido una ``Respuesta de prueba`` como resultado de sus pruebas o que haya creado una usted mismo,
Hay una serie de afirmaciones nuevas que puede utilizar en sus pruebas.

Accediendo a Solicitud/Respuesta
================================

pedido()
---------

Puede acceder directamente al objeto Solicitud, si se configuró durante la prueba:

.. literalinclude:: response/002.php
   :lines: 2-

respuesta()
-----------

Esto le permite acceso directo al objeto de respuesta:

.. literalinclude:: response/003.php
   :lines: 2-

Comprobación del estado de la respuesta
=======================================

está bien()
-----------

Devuelve un valor booleano verdadero/falso en función de si la respuesta se percibe como "correcta". Esto está determinado principalmente por
un código de estado de respuesta en el 200 o 300. Un cuerpo vacío no se considera válido, a menos que se trate de redirecciones.

.. literalinclude:: response/004.php
   :lines: 2-

afirmarOK()
-----------

Esta afirmación simplemente utiliza el método ``isOK()`` para probar una respuesta. ``assertNotOK()`` es lo inverso de esta afirmación.

.. literalinclude:: response/005.php
   :lines: 2-

esRedirect()
------------

Devuelve un valor booleano verdadero/falso en función de si la respuesta es una respuesta redirigida.

.. literalinclude:: response/006.php
   :lines: 2-

afirmarRedirect()
-----------------

Afirma que la respuesta es una instancia de RedirectResponse. ``assertNotRedirect()`` es lo inverso de esta afirmación.

.. literalinclude:: response/007.php
   :lines: 2-

afirmarRedirectTo()
-------------------

Afirma que la respuesta es una instancia de RedirectResponse y el destino
coincide con el uri proporcionado.

.. literalinclude:: response/008.php
   :lines: 2-

getRedirectUrl()
----------------

Devuelve la URL establecida para RedirectResponse, o nula en caso de error.

.. literalinclude:: response/009.php
   :lines: 2-

afirmarEstado(int $código)
--------------------------

Afirma que el código de estado HTTP devuelto coincide con $code.

.. literalinclude:: response/010.php
   :lines: 2-

Afirmaciones de sesión
======================

afirmarSessionHas(cadena $clave, $valor = nulo)
-----------------------------------------------

Afirma que existe un valor en la sesión resultante. Si se pasa $value, también afirmará que el valor de la variable
coincide con lo especificado.

.. literalinclude:: response/011.php
   :lines: 2-

afirmarSessionMissing(cadena $clave)
------------------------------------

Afirma que la sesión resultante no incluye la clave $ especificada.

.. literalinclude:: response/012.php
   :lines: 2-

Afirmaciones de encabezado
==========================

afirmarHeader(cadena $clave, $valor = nulo)
-------------------------------------------

Afirma que existe un encabezado denominado ``$key`` en la respuesta. Si ``$value`` no está vacío, también afirmará que
los valores coinciden.

.. literalinclude:: response/013.php
   :lines: 2-

afirmarHeaderMissing(cadena $clave)
-----------------------------------

Afirma que no existe un nombre de encabezado ``$key`` en la respuesta.

.. literalinclude:: response/014.php
   :lines: 2-

Afirmaciones de cookies
=======================

afirmarCookie(cadena $clave, $valor = nulo, cadena $prefijo = '')
-----------------------------------------------------------------

Afirma que existe una cookie denominada ``$key`` en la respuesta. Si ``$value`` no está vacío, también afirmará que
los valores coinciden. Puede configurar el prefijo de cookie, si es necesario, pasándolo como tercer parámetro.

.. literalinclude:: response/015.php
   :lines: 2-

afirmarCookieMissing(cadena $clave)
-----------------------------------

Afirma que una cookie denominada ``$key`` no existe en la respuesta.

.. literalinclude:: response/016.php
   :lines: 2-

afirmarCookieExpired(cadena $clave, cadena $prefijo = '')
---------------------------------------------------------

Afirma que existe una cookie llamada ``$key``, pero ha caducado. Puede configurar el prefijo de cookie, si es necesario, pasándolo
como segundo parámetro.

.. literalinclude:: response/017.php
   :lines: 2-

Ayudantes DOM
=============

La respuesta que recibe contiene una serie de métodos auxiliares para inspeccionar la salida HTML dentro de la respuesta. Estos
son útiles para usar dentro de afirmaciones en sus pruebas.

ver()
-----

Devuelve un valor booleano verdadero/falso en función de si el texto de la página existe o no.
por sí mismo, o más específicamente dentro de
una etiqueta, según lo especificado por tipo, clase o identificación:

.. literalinclude:: response/018.php
   :lines: 2-

El método ``dontSee()`` es exactamente lo contrario:

.. literalinclude:: response/019.php
   :lines: 2-

verElemento()
-------------

Los ``seeElement()`` y ``dontSeeElement()`` son muy similares a los métodos anteriores, pero no te fijes en el
valores de los elementos. En cambio, simplemente verifican que los elementos existan en la página:

.. literalinclude:: response/020.php
   :lines: 2-

verEnlace()
-----------

Puede utilizar ``seeLink()`` para asegurarse de que aparezca un enlace en la página con el texto especificado:

.. literalinclude:: response/021.php
   :lines: 2-

ver en el campo()
-----------------

El método ``seeInField()`` comprueba si existe alguna etiqueta de entrada con el nombre y el valor:

.. literalinclude:: response/022.php
   :lines: 2-

verCheckboxIsChecked()
----------------------

Finalmente, puedes verificar si existe una casilla de verificación y está marcada con el método ``seeCheckboxIsChecked()``:

.. literalinclude:: response/023.php
   :lines: 2-

Afirmaciones DOM
================

Puede realizar pruebas para ver si existen elementos/texto/etc. específicos en el cuerpo de la respuesta con lo siguiente
afirmaciones.

afirmarVer(cadena $búsqueda = nulo, cadena $elemento = nulo)
------------------------------------------------------------

Afirma que el texto/HTML está en la página, ya sea por sí mismo o, más específicamente, dentro
una etiqueta, según lo especificado por tipo, clase o identificación:

.. literalinclude:: response/024.php
   :lines: 2-

afirmarDontSee(cadena $búsqueda = nulo, cadena $elemento = nulo)
----------------------------------------------------------------

Afirma exactamente lo contrario del método ``assertSee()``:

.. literalinclude:: response/025.php
   :lines: 2-

afirmarVerElemento(cadena $búsqueda)
------------------------------------

Similar a ``assertSee()``, sin embargo, esto solo verifica si hay un elemento existente. No busca texto específico:

.. literalinclude:: response/026.php
   :lines: 2-

afirmarDontSeeElement(cadena $búsqueda)
---------------------------------------

Similar a ``assertSee()``, sin embargo, esto solo busca un elemento existente que falta. No comprueba
texto específico:

.. literalinclude:: response/027.php
   :lines: 2-

afirmarVerEnlace(cadena $texto, cadena $detalles = nulo)
-------------------------------------------------- -

Afirma que se encuentra una etiqueta de anclaje con ``$text`` coincidente como cuerpo de la etiqueta:

.. literalinclude:: response/028.php
   :lines: 2-

afirmarSeeInField(cadena $campo, cadena $valor = nulo)
------------------------------------------------------

Afirma que existe una etiqueta de entrada con el nombre y valor:

.. literalinclude:: response/029.php
   :lines: 2-

Trabajar con JSON
=================

Las respuestas con frecuencia contendrán respuestas JSON, especialmente cuando se trabaja con métodos API. Los siguientes métodos
puede ayudar a probar las respuestas.

obtener JSON()
--------------

Este método devolverá el cuerpo de la respuesta como una cadena JSON:

.. literalinclude:: response/030.php
   :lines: 2-

Puedes usar este método para determinar si ``$response`` realmente contiene contenido JSON:

.. literalinclude:: response/031.php
   :lines: 2-

.. note:: Be aware that the JSON string will be pretty-printed in the result.

afirmarJSONFragment(matriz $fragmento)
--------------------------------------

Afirma que ``$fragment`` se encuentra dentro de la respuesta JSON. No es necesario que coincida con todo el valor JSON.

.. literalinclude:: response/032.php
   :lines: 2-

afirmarJSONExact($prueba)
-------------------------

Similar a ``assertJSONFragment()``, pero verifica la respuesta JSON completa para garantizar coincidencias exactas.

Trabajar con XML
================

obtener XML()
-------------

Si su aplicación devuelve XML, puede recuperarlo mediante este método.
