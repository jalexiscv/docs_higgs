###########################
Clases de sistemas burlones
###########################

Varios componentes dentro del marco proporcionan versiones simuladas de sus clases que se pueden usar durante las pruebas. estas clases
puede tomar el lugar de la clase normal durante la ejecución de la prueba, a menudo proporcionando afirmaciones adicionales para probar esas acciones
han tenido lugar (o no han tenido lugar) durante la ejecución de la prueba. Esto podría ser verificar que los datos se almacenen en caché correctamente,
los correos electrónicos se enviaron correctamente, etc.

.. contents::
    :local:
    :depth: 2

Cache
=====

Puedes simular el caché con el método ``mock()``, usando ``CacheFactory`` como único parámetro.

.. literalinclude:: mocking/001.php

Si bien esto devuelve una instancia de ``Higgs\Test\Mock\MockCache`` que puedes usar directamente, también inserta el
simulacro en la clase Servicio, por lo que cualquier llamada dentro de su código a ``service('cache')`` o ``Config\Services::cache()``
use la clase burlada en su lugar.

Cuando use esto en más de un método de prueba dentro de un solo archivo, debe llamar a ``clean()`` o ``bypass()``.
métodos durante la prueba ``setUp()`` para garantizar un borrón y cuenta nueva cuando se ejecuten las pruebas.

Métodos adicionales
-------------------

Puede indicarle al controlador de caché simulado que nunca realice ningún almacenamiento en caché con el método ``bypass()``. Esto emulará
utilizando el controlador ficticio y garantiza que su prueba no dependa de datos almacenados en caché para sus pruebas.

.. literalinclude:: mocking/002.php

Afirmaciones disponibles
------------------------

Las siguientes nuevas afirmaciones están disponibles en la clase simulada para usar durante las pruebas:

.. literalinclude:: mocking/003.php
