########################
Prueba de funciones HTTP
########################

Las pruebas de funciones le permiten ver los resultados de una sola llamada a su aplicación. Esto podría estar devolviendo el
resultados de un único formulario web, acceso a un punto final API y más. Esto es útil porque le permite probar todo el
ciclo de vida de una sola solicitud, garantizar que el enrutamiento funcione, que la respuesta tenga el formato correcto, analizar los resultados,
y más.

.. contents::
    :local:
    :depth: 2

La clase de prueba
==================

Las pruebas de funciones requieren que todas sus clases de prueba utilicen ``Higgs\Test\DatabaseTestTrait``
y rasgos ``Higgs\Test\FeatureTestTrait``. Dado que estas herramientas de prueba dependen de una base de datos adecuada
preparación, siempre debe asegurarse de que ``parent::setUp()`` y ``parent::tearDown()``
se llaman si implementa sus propios métodos.

.. literalinclude:: feature/001.php

.. _feature-requesting-a-page:

Solicitar una página
====================

Básicamente, las pruebas de funciones simplemente le permiten llamar a un punto final en su aplicación y obtener los resultados.
Para hacer esto, utiliza el método ``call()``.

1. El primer parámetro es el método HTTP a utilizar (más frecuentemente ``GET`` o ``POST``).
2. El segundo parámetro es la ruta URI en su sitio para probar.
3. El tercer parámetro ``$params`` acepta una matriz que se utiliza para completar el
   variables superglobales para el verbo HTTP que está utilizando. Entonces, un método de **GET**
   tendría la variable ``$_GET`` completa, mientras que una solicitud **POST**
   tener la matriz ``$_POST`` poblada. El ``$params`` también se utiliza en
   :ref:`función-formato-de-la-solicitud`.

   .. note:: The ``$params`` array does not make sense for every HTTP verb, but is
      incluido para mayor coherencia.

.. literalinclude:: feature/002.php
   :lines: 2-

Métodos taquigráficos
---------------------

Existen métodos abreviados para cada uno de los verbos HTTP para facilitar la escritura y aclarar las cosas:

.. literalinclude:: feature/003.php
   :lines: 2-

Establecer diferentes rutas
---------------------------

Puede utilizar una colección personalizada de rutas pasando una serie de "rutas" al método ``withRoutes()``. Esta voluntad
anular cualquier ruta existente en el sistema:

.. literalinclude:: feature/004.php
   :lines: 2-

Cada una de las "rutas" es una matriz de 3 elementos que contiene el verbo HTTP (o "agregar" para todas),
el URI que debe coincidir y el destino de enrutamiento.

Configuración de valores de sesión
----------------------------------

Puede establecer valores de sesión personalizados para usar durante una sola prueba con el método ``withSession()``. Esto requiere una matriz
de pares clave/valor que deben existir dentro de la variable ``$_SESSION`` cuando se realiza esta solicitud, o ``null`` para indicar
que se deben utilizar los valores actuales de ``$_SESSION``. Esto es útil para probar la autenticación y más.

.. literalinclude:: feature/005.php
   :lines: 2-

Configuración de encabezados
----------------------------

Puede establecer valores de encabezado con el método ``withHeaders()``. Esto requiere una serie de pares clave/valor que serían
pasado como encabezado en la llamada:

.. literalinclude:: feature/006.php
   :lines: 2-

Omitir eventos
----------------

Los eventos son útiles para usar en su aplicación, pero pueden resultar problemáticos durante las pruebas. Especialmente eventos que se utilizan.
para enviar correos electrónicos. Puedes decirle al sistema que omita cualquier manejo de eventos con el método ``skipEvents()``:

.. literalinclude:: feature/007.php
   :lines: 2-

.. _feature-formatting-the-request:

Formatear la solicitud
-----------------------

Puede configurar el formato del cuerpo de su solicitud utilizando el método ``withBodyFormat()``. Actualmente esto admite
``json`` o ``xml``.
Esto es útil al probar API JSON o XML para poder configurar la solicitud en la forma que esperará el controlador.

Esto tomará los parámetros pasados a ``call()``, ``post()``, ``get()``... y los asignará al
cuerpo de la solicitud en el formato indicado.

Esto también establecerá el encabezado "Tipo de contenido" para su solicitud en consecuencia.

.. literalinclude:: feature/008.php
   :lines: 2-

.. _feature-setting-the-body:

Configurando el cuerpo
-----------------------

Puede configurar el cuerpo de su solicitud con el método ``withBody()``. Esto te permite formatear el cuerpo como quieras.
para formatearlo. Se recomienda utilizar esto si tiene XML más complicados para probar.

Esto no se configurará
el encabezado "Tipo de contenido" por usted. Si lo necesita, puede configurarlo con el método ``withHeaders()``.

Comprobando la respuesta
========================

``FeatureTestTrait::call()`` devuelve una instancia de ``TestResponse``. Ver :doc:`Respuestas de prueba<response>` en
cómo utilizar esta clase para realizar afirmaciones y verificaciones adicionales en sus casos de prueba.
