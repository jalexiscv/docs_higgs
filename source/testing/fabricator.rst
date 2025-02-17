#########################
Generando datos de prueba
#########################

A menudo necesitará datos de muestra para que su aplicación ejecute sus pruebas. La clase ``Fabricante``
usa `Falso<https://github.com/FakerPHP/Faker>` _ para convertir modelos en generadores
de datos aleatorios. Utilice fabricantes en sus semillas o casos de prueba para presentar datos falsos para sus pruebas unitarias.

.. contents::
    :local:
    :depth: 2

Modelos compatibles
===================

``Fabricator`` admite cualquier modelo que extienda el modelo central del marco, ``Higgs\Model``.
Puede utilizar sus propios modelos personalizados asegurándose de que implementen ``Higgs\Test\Interfaces\FabricatorModel``:

.. literalinclude:: fabricator/001.php

.. note:: In addition to methods, the interface outlines some necessary properties for the target model. Please see the interface code for details.

Cargando fabricantes
====================

En su forma más básica, un fabricante toma el modelo sobre el que actuar:

.. literalinclude:: fabricator/002.php

El parámetro puede ser una cadena que especifique el nombre del modelo o una instancia del propio modelo:

.. literalinclude:: fabricator/003.php

Definición de formateadores
===========================

Faker genera datos solicitándolos a un formateador. Sin formateadores definidos, ``Fabricator``
Intente adivinar el ajuste más apropiado basándose en el nombre del campo y las propiedades del modelo.
representa, recurriendo a ``$fabricator->defaultFormatter``. Esto puede estar bien si los nombres de sus campos
corresponden con formateadores comunes, o si no le importa mucho el contenido de los campos, pero la mayoría
la mayoría de las veces querrás especificar los formateadores que se utilizarán como segundo parámetro del constructor:

.. literalinclude:: fabricator/004.php

También puede cambiar los formateadores después de inicializar un fabricante utilizando el método ``setFormatters()``.

Formato avanzado
-------------------

A veces, el retorno predeterminado de un formateador no es suficiente. Los proveedores falsos permiten parámetros para la mayoría de los formateadores
para limitar aún más el alcance de los datos aleatorios. Un fabricante comprobará su modelo representativo en busca del ``falso()``
método donde puedes definir exactamente cómo deberían verse los datos falsificados:

.. literalinclude:: fabricator/005.php

Observe en este ejemplo cómo los primeros tres valores son equivalentes a los formateadores anteriores. Sin embargo para ``avatar``
hemos solicitado un tamaño de imagen distinto al predeterminado y ``iniciar sesión`` usa un condicional basado en la configuración de la aplicación,
Ninguno de los cuales es posible usando el parámetro ``$formatters``.

Es posible que desee mantener los datos de prueba separados de sus modelos de producción, por lo que es una buena práctica definir
una clase secundaria en su carpeta de soporte de prueba:

.. literalinclude:: fabricator/006.php

Localización
============

Faker admite muchas configuraciones regionales diferentes. Verifique su documentación para determinar qué proveedores
apoyar a su localidad. Especifique una ubicación en el tercer parámetro al iniciar un fabricante:

.. literalinclude:: fabricator/007.php

Si no se especifica ninguna configuración regional, utilizará la definida en **app/Config/App.php** como ``defaultLocale``.
Puede comprobar la configuración regional de un fabricante existente utilizando su método ``getLocale()``.

Falsificar los datos
====================

Una vez que tenga un fabricante correctamente inicializado, es fácil generar datos de prueba con el comando ``make()``:

.. literalinclude:: fabricator/008.php

Es posible que obtenga algo como esto:

.. literalinclude:: fabricator/009.php

También puedes recuperar muchos de ellos proporcionando un recuento:

.. literalinclude:: fabricator/010.php

El tipo de retorno de ``make()`` imita lo que se define en el modelo representativo, pero se puede
forzar un tipo usando los métodos directamente:

.. literalinclude:: fabricator/011.php

El retorno de ``make()`` está listo para usarse en pruebas o insertarse en la base de datos. Alternativamente
``Fabricator`` incluye el comando ``create()`` para insertarlo por usted y devolver el resultado. Pendiente
para modelar devoluciones de llamadas, formato de bases de datos y claves especiales como primaria y marcas de tiempo de la devolución
de ``create()`` puede diferir de ``make()``. Es posible que obtenga algo como esto:

.. literalinclude:: fabricator/012.php

De manera similar a ``make()``, puedes proporcionar un recuento para insertar y devolver una matriz de objetos:

.. literalinclude:: fabricator/013.php

Finalmente, puede haber ocasiones en las que desee probar con el objeto de base de datos completo pero en realidad no lo esté.
utilizando una base de datos. ``create()`` toma un segundo parámetro para permitir burlarse del objeto, devolviendo
el objeto con campos de base de datos adicionales arriba sin tocar la base de datos:

.. literalinclude:: fabricator/014.php

Especificación de datos de prueba
=================================

Los datos generados son excelentes, pero a veces es posible que desee proporcionar un campo específico para una prueba sin
comprometiendo la configuración de su formateador. En lugar de crear un nuevo fabricante para cada variante.
puedes usar ``setOverrides()`` para especificar el valor de cualquier campo:

.. literalinclude:: fabricator/015.php

Ahora cualquier dato generado con ``make()`` o ``create()`` siempre usará "Bobby" para el ``primer`` campo:

.. literalinclude:: fabricator/016.php

``setOverrides()`` puede tomar un segundo parámetro para indicar si debe ser persistente
anular o solo para una sola acción:

.. literalinclude:: fabricator/017.php

Observe que después de la primera devolución el fabricante deja de usar las anulaciones:

.. literalinclude:: fabricator/018.php

Si no se proporciona ningún segundo parámetro, los valores pasados persistirán de forma predeterminada.

Ayudante de prueba
==================

A menudo, todo lo que necesitará es un objeto falso único para realizar la prueba. El asistente de prueba proporciona
la función ``fake($model, $overrides, $persist = true)`` para hacer precisamente esto:

.. literalinclude:: fabricator/019.php

Esto equivale a:

.. literalinclude:: fabricator/020.php

Si solo necesita un objeto falso sin guardarlo en la base de datos, puede pasar false al parámetro persist.

Recuentos de mesa
=================

Con frecuencia, sus datos falsificados dependerán de otros datos falsificados. ``Fabricator`` proporciona una información estática
recuento del número de elementos falsificados que ha creado para cada tabla. Considera lo siguiente
ejemplo:

Su proyecto tiene usuarios y grupos. En su caso de prueba desea crear varios escenarios.
con grupos de diferentes tamaños, por lo que usa ``Fabricator`` para crear un montón de grupos.
Ahora desea crear usuarios falsos pero no desea asignarlos a una ID de grupo inexistente.
El método falso de tu modelo podría verse así:

.. literalinclude:: fabricator/021.php

Ahora, crear un nuevo usuario garantizará que sea parte de un grupo válido: ``$usuario = fake(UserModel::class);``

Métodos
-------

``Fabricator`` maneja los recuentos internamente pero también puedes acceder a estos métodos estáticos
para ayudar con su uso:

getCount(cadena $tabla): int
^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Devuelve el valor actual de una tabla específica (predeterminado: 0).

setCount(cadena $tabla, int $cuenta): int
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Establezca el valor para una tabla específica manualmente, por ejemplo, si crea algunos elementos de prueba
sin utilizar un fabricante que aún deseaba tener en cuenta en los recuentos finales.

upCount(cadena $tabla): int
^^^^^^^^^^^^^^^^^^^^^^^^^^^

Incrementa el valor de una tabla específica en uno y devuelve el nuevo valor. (Esto es lo que es
usado internamente con ``Fabricator::create()``).

downCount(cadena $tabla): int
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Disminuya el valor de una tabla específica en uno y devuelva el nuevo valor, por ejemplo si
eliminaste un elemento falso pero querías realizar un seguimiento del cambio.

restablecerConteos()
^^^^^^^^^^^^^^^^^^^^

Restablece todos los recuentos. Buena idea llamar a esto entre casos de prueba (aunque usando
``CIUnitTestCase::$refresh = true`` lo hace automáticamente).
