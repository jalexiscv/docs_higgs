########
Fábricas
########

.. contents::
    :local:
    :depth: 3

Introducción
************

¿Qué son las fábricas?
======================

Como :doc:`./services`, **Factories** son una extensión de carga automática que ayuda a mantener su código
conciso pero óptimo, sin tener que pasar instancias de objetos entre clases.

Las fábricas son similares a ``$this->load`` de Higgs 3 en los siguientes puntos:

- Cargar una clase
- Compartir la instancia de clase cargada

En su
Más simple, las fábricas proporcionan una forma común de crear una instancia de clase y acceder a ella desde
en cualquier lugar. Esta es una excelente manera de reutilizar los estados de los objetos y reducir la carga de memoria para mantener
múltiples instancias cargadas en su aplicación.

Las fábricas pueden cargar cualquier clase, pero los mejores ejemplos son aquellas clases que se utilizan
para trabajar o transmitir datos comunes. El marco en sí utiliza fábricas internamente, por ejemplo, para
asegúrese de que se cargue la configuración correcta cuando utilice la clase ``Config``.

Diferencias con los servicios
=============================

Las fábricas requieren un nombre de clase concreto para crear instancias y no tienen código para crear instancias.

Entonces, las fábricas no son buenas para crear una instancia compleja que necesita muchas dependencias.
y no puede cambiar la clase de la instancia que se devolverá.

Por otro lado, los Servicios tienen código para crear instancias, por lo que pueden crear una instancia compleja.
que necesita otros servicios o instancias de clase. Cuando obtiene un servicio, los Servicios requieren un nombre de servicio,
no es un nombre de clase, por lo que la instancia devuelta se puede cambiar sin cambiar el código del cliente.

.. _factories-loading-class:

Cargando clases
***************

Cargando una clase
==================

Eche un vistazo a **Modelos** como ejemplo. Podrás acceder a la Fábrica específica de Modelos
utilizando el método estático mágico de la clase Fábricas, ``Factories::models()``.

El nombre del método estático se llama *componente*.

.. _factories-passing-classname-without-namespace:

Pasar nombre de clase sin espacio de nombres
-----------------------------------

Si pasa un nombre de clase sin un espacio de nombres, Factories primero busca en el
Espacio de nombres ``App`` para la ruta correspondiente al nombre del método estático mágico.
``Factories::models()`` busca en el directorio **app/Models**.

Pasando nombre de clase corto
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

En el siguiente código, si tiene ``App\Models\UserModel``, se devolverá la instancia:

.. literalinclude:: factories/001.php

Si no tiene ``App\Models\UserModel``, busca ``Models\UserModel`` en todos los espacios de nombres.

La próxima vez que solicite la misma clase en cualquier parte de su código, Factories se asegurará
recuperas la instancia como antes:

.. literalinclude:: factories/003.php

Pasar un nombre de clase corto con subdirectorios
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Si desea cargar una clase en subdirectorios, utilice ``/`` como separador.
El siguiente código carga **app/Libraries/Sub/SubLib.php** si existe:

.. literalinclude:: factories/013.php
   :lines: 2-

Aprobar el nombre de clase completo y calificado
------------------------------------------------

También puede solicitar un nombre de clase completo y calificado:

.. literalinclude:: factories/002.php
   :lines: 2-

Devuelve la instancia de ``Blog\Models\UserModel`` si existe.

.. note:: Prior to v7.4.0, when you requested a full qualified classname,
    si solo tuviera ``Blog\Models\UserModel``, se devolvería la instancia.
    Pero si tuviera tanto ``App\Models\UserModel`` como ``Blog\Models\UserModel``,
    se devolvería la instancia de ``App\Models\UserModel``.

    Si quería obtener ``Blog\Models\UserModel``, necesitaba desactivar el
    opción ``preferApp``:

    .. literalinclude:: factories/010.php
       :lines: 2-

Funciones de conveniencia
*************************

Se han proporcionado dos funciones de acceso directo para Fábricas. Estas funciones están siempre disponibles.

.. _factories-config:

configuración()
===============

El primero es :php:func:`config()` que devuelve una nueva instancia de una clase Config. El único parámetro requerido es el nombre de la clase:

.. literalinclude:: factories/008.php

modelo()
========

La segunda función, :php:func:`model()` devuelve una nueva instancia de una clase Modelo. El único parámetro requerido es el nombre de la clase:

.. literalinclude:: factories/009.php

.. _factories-defining-classname-to-be-loaded:

Definición del nombre de clase que se cargará
*********************************************

.. versionadded:: 4.4.0

Puede definir un nombre de clase para cargar antes de cargar la clase con
el método ``Fábricas::define()``:

.. literalinclude:: factories/014.php
   :lines: 2-

El primer parámetro es un componente. El segundo parámetro es un alias de clase.
(el primer parámetro del método estático mágico de Factories) y el tercer parámetro
es el verdadero nombre de clase completo que se cargará.

Después de eso, si carga ``Myth\Auth\Models\UserModel`` con Factories, el
Se devolverá la instancia ``App\Models\UserModel``:

.. literalinclude:: factories/015.php
   :lines: 2-

Parámetros de fábrica
*********************

``Factories`` toma como segundo parámetro una matriz de valores de opciones (descritos a continuación).
Estas directivas anularán las opciones predeterminadas configuradas para cada componente.

Cualquier parámetro adicional pasado al mismo tiempo se reenviará a la clase.
constructor, lo que facilita la configuración de su instancia de clase sobre la marcha. Por ejemplo, digamos
su aplicación utiliza una base de datos separada para la autenticación y desea asegurarse de que cualquier intento
para acceder a los registros de usuario siempre pase por esa conexión:

.. literalinclude:: factories/004.php

Ahora, cada vez que se carga el ``UserModel`` desde ``Factories``, de hecho devolverá un
Instancia de clase que utiliza la conexión de base de datos alternativa.

.. _factories-options:

Opciones de fábricas
********************

Es posible que el comportamiento predeterminado no funcione para todos los componentes. Por ejemplo, diga su componente
El nombre y su ruta no se alinean, o necesita limitar las instancias a un determinado tipo de clase.
Cada componente requiere un conjunto de opciones para dirigir el descubrimiento y la creación de instancias.

========== ============== =========================== ================================== ================= =====================================
Tipo de clave Descripción Predeterminado
========== ============== =========================== ================================== ================= =====================================
cadena de componente o nulo El nombre del componente (si es diferente del ``nulo`` estático (por defecto es el nombre del componente)
                          método). Esto se puede utilizar para crear un alias de un componente con otro.
cadena de ruta o nulo La ruta relativa dentro del espacio de nombres/carpeta para buscar ``nulo`` (el valor predeterminado es el nombre del componente,
                          clases. pero pone el primer carácter en mayúscula)
instanciaDe cadena o nulo Un nombre de clase requerido para coincidir en la instancia devuelta. ``nulo`` (sin filtrado)
getShared booleano Si se debe devolver una instancia compartida de la clase o cargar un ``true``
                          uno nuevo.
preferApp booleano Si una clase con el mismo nombre base en el espacio de nombres de la aplicación es "verdadera"
                          anula otras solicitudes de clase explícitas.
========== ============== =========================== ================================== ================= =====================================

.. note:: Since v7.4.0, ``preferApp`` works only when you request
    :ref:`un nombre de clase sin un espacio de nombres<factories-passing-classname-without-namespace>` .

Comportamiento de las fábricas
******************************

Las opciones se pueden aplicar de una de tres maneras (enumeradas en prioridad ascendente):

* Una clase de configuración ``Config\Factory`` con una propiedad que coincide con el nombre de un componente.
* El método estático ``Factories::setOptions()``.
* Pasar opciones directamente en el momento de la llamada con un parámetro.

Configuraciones
===============

Para configurar las opciones de componentes predeterminadas, cree nuevos archivos de configuración en **app/Config/Factory.php**
que proporciona opciones como una propiedad de matriz que coincide con el nombre del componente.

Ejemplo: Fábricas de filtros
--------------------------

Por ejemplo, si desea crear **Filtros** por fábricas, el nombre del componente será ``filtros``.
Y si desea asegurarse de que cada filtro sea una instancia de una clase que implemente la ``FilterInterface`` de Higgs,
Su archivo **app/Config/Factory.php** podría verse así:

.. literalinclude:: factories/005.php

Ahora puedes crear un filtro con código como ``Factories::filters('SomeFilter')``,
y la instancia devuelta seguramente será un filtro de Higgs.

Esto evitaría el conflicto de un módulo de terceros que tuviera un
ruta de ``Filtros`` no relacionada en su espacio de nombres.

Ejemplo: fábricas de bibliotecas
--------------------------

Si desea cargar las clases de su biblioteca en el directorio **app/Libraries** con
``Factories::library('SomeLib')``, la ruta `Bibliotecas` es diferente de la
ruta predeterminada `Biblioteca`.

En este caso, su archivo **app/Config/Factory.php** tendrá este aspecto:

.. literalinclude:: factories/011.php

Ahora puedes cargar tus bibliotecas con el método ``Factories::library()``:

.. literalinclude:: factories/012.php
   :lines: 2-

Método setOptions
=================

La clase ``Factories`` tiene un método estático para permitir la configuración de opciones de tiempo de ejecución: simplemente
proporcione la variedad deseada de opciones usando el método ``setOptions()`` y serán
fusionado con los valores predeterminados y almacenado para la siguiente llamada:

.. literalinclude:: factories/006.php

Opciones de parámetros
======================

La llamada mágica estática de ``Factories`` toma como segundo parámetro una matriz de valores de opciones.
Estas directivas anularán las opciones almacenadas configuradas para cada componente y se pueden
Se utiliza en el momento de la llamada para obtener exactamente lo que necesita. La entrada debe ser una matriz con opción.
nombres como claves para cada valor primordial.

Por ejemplo, de forma predeterminada ``Factories`` supone que desea ubicar una instancia compartida de
un componente. Al agregar un segundo parámetro a la llamada estática mágica, puede controlar si
esa única llamada devolverá una instancia nueva o compartida:

.. literalinclude:: factories/007.php
   :lines: 2-

.. _factories-config-caching:

Configuración de almacenamiento en caché
****************************************

.. versionadded:: 4.4.0

Para mejorar el rendimiento, se ha implementado Config Caching.

Requisito previo
================

.. important:: Using this feature when the prerequisites are not met will prevent
    Higgs funcione correctamente. No utilice esta función en tales casos.

- Para utilizar esta característica, las propiedades de todos los objetos de configuración instanciados en
  Las fábricas no se deben modificar después de la creación de instancias. Dicho de otra manera, la configuración
  las clases deben ser clases inmutables o de solo lectura.
- De forma predeterminada, cada clase de configuración que se almacena en caché debe implementar ``__set_state()``
  método.

Cómo funciona
=============

- Guarde todas las instancias de configuración en las fábricas en un archivo de caché antes del apagado.
  si cambia el estado de las instancias de configuración en las fábricas.
- Restaurar instancias de configuración almacenadas en caché antes de la inicialización de Higgs si es un caché
  está disponible.

En pocas palabras, todas las instancias de configuración mantenidas por las fábricas se almacenan en caché inmediatamente antes.
para apagarse y las instancias almacenadas en caché se utilizan de forma permanente.

Cómo actualizar los valores de configuración
============================================

Una vez almacenadas, las versiones almacenadas en caché nunca caducan. Cambiar un archivo de configuración existente
(o cambiar las variables de entorno) no actualizará el caché ni la configuración
valores.

Entonces, si desea actualizar los valores de configuración, actualice los archivos de configuración o las variables de entorno.
para ellos y deberá eliminar manualmente el archivo de caché.

Puedes usar el comando ``spark cache:clear``:

.. code-block:: console

    caché de chispa de php: borrar

O simplemente elimine el archivo **writable/cache/FactoriesCache_config**.

Cómo habilitar el almacenamiento en caché de configuración
==========================================================

Descomente el siguiente código en **public/index.php**::

    --- a/public/index.php
    +++ b/public/index.php
    @@ -49,8 +49,8 @@ if (! definido('MEDIOAMBIENTE')) {
     }

     // Cargar caché de configuración
    -// $factoriesCache = nuevo \Higgs\Cache\FactoriesCache();
    -// $factoriesCache->load('config');
    +$factoriesCache = nuevo \Higgs\Cache\FactoriesCache();
    +$factoriesCache->load('config');
     // ^^^ Descomente estas líneas si desea utilizar Config Caching.

     /*
    @@ -79,7 +79,7 @@ $aplicación->setContext($contexto);
     $aplicación->ejecutar();

     // Guardar caché de configuración
    -// $factoriesCache->save('config');
    +$factoriesCache->save('config');
     // ^^^ Descomente esta línea si desea utilizar Config Caching.

     // Sale de la aplicación y configura el código de salida para aplicaciones basadas en CLI
