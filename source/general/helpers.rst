####################
Funciones auxiliares
####################

.. contents::
    :local:
    :depth: 2


¿Qué son los ayudantes?
***********************

Los ayudantes, como su nombre indica, le ayudan con las tareas. Cada archivo auxiliar es simplemente un
colección de funciones en una categoría particular. Hay
:doc:`Ayudantes de URL <../helpers/url_helper>`,
que ayudan a crear enlaces, existen :doc:`Form Helpers <../helpers/form_helper>`
que le ayudan a crear elementos de formulario, :doc:`Test Helpers <../helpers/text_helper>`
realizar varias rutinas de formato de texto, :doc:`Cookie Helpers <../helpers/cookie_helper>`
configurar y leer cookies, :doc:`Filesystem Helpers <../helpers/filesystem_helper>` le ayudarán
ocuparse de archivos, etc.

A diferencia de la mayoría de los otros sistemas en Higgs, los ayudantes no están escritos en un
Formato orientado a objetos. Son funciones simples y procedimentales. Cada
La función auxiliar realiza una tarea específica, sin depender de otras.
funciones.

Higgs no carga archivos auxiliares de forma predeterminada, por lo que el primer paso en
usar un ayudante es cargarlo. Una vez cargado, estará disponible globalmente.
en su :doc:`controller <../incoming/controllers>` y
:doc:`vistas <../salientes/vistas>`.

Los ayudantes normalmente se almacenan en su **sistema/Ayudantes**, o
Directorio **aplicación/Ayudantes**.


Cargando ayudantes
******************

.. note:: The :doc:`../helpers/url_helper` is always loaded so you do not need to load it yourself.

Cargando un ayudante
====================

Cargar un archivo auxiliar es bastante sencillo utilizando el siguiente método:

.. literalinclude:: helpers/001.php

El código anterior carga el archivo **name_helper.php**.

.. important:: Higgs helper file names are all lowercase.
    Por lo tanto, ``helper('Name')`` no funcionará en sistemas de archivos que distingan entre mayúsculas y minúsculas.
    como Linux.

Por ejemplo, para cargar el archivo :doc:`../helpers/cookie_helper`, que se llama
**cookie_helper.php**, harías esto:

.. literalinclude:: helpers/002.php

.. note:: The :php:func:`helper()` function does not return a value, so
    No intentes asignarlo a una variable. Úselo como se muestra.

Paquetes de descubrimiento automático y compositor
------------------------------------

De forma predeterminada, Higgs buscará los archivos auxiliares en todos los espacios de nombres definidos.
por :ref:`descubrimiento automático`.
Puede verificar sus espacios de nombres definidos mediante el comando Spark. Ver :ref:`confirmando-espacios de nombres`.

Si utiliza muchos paquetes de Composer, tendrá muchos espacios de nombres definidos.
Higgs escaneará todos los espacios de nombres de forma predeterminada.

Para evitar perder tiempo buscando paquetes de Composer irrelevantes, puede hacerlo manualmente.
especificar paquetes para el descubrimiento automático. Ver :ref:`módulos-especificar-paquetes-compositores`
para detalles.

O puedes :ref:`especificar un espacio de nombres<helpers-loading-from-specified-namespace>`
para un ayudante que desea cargar.

Orden de carga
----------

La función :php:func:`helper()` escaneará todos los espacios de nombres definidos y
cargue TODOS los ayudantes coincidentes del mismo nombre. Esto permite que los ayudantes de cualquier módulo
que se cargará, así como cualquier ayudante que haya creado específicamente para esta aplicación.

El orden de carga es el siguiente:

1. app/Helpers: los archivos cargados aquí siempre se cargan primero.
2. {namespace}/Helpers: todos los espacios de nombres se recorren en el orden en que están definidos.
3. system/Helpers: el archivo base se carga en último lugar.

Cargando múltiples ayudantes
============================

Si necesita cargar más de un ayudante a la vez, puede pasar
una serie de nombres de archivos y se cargarán todos:

.. literalinclude:: helpers/003.php

Cargando en un controlador
==========================

Se puede cargar un asistente en cualquier lugar dentro de los métodos de su controlador (o
incluso dentro de sus archivos Ver, aunque eso no es una buena práctica), ya que
siempre y cuando lo cargues antes de usarlo.

Puedes cargar tus ayudantes en tu
constructor del controlador para que estén disponibles automáticamente en
cualquier método, o puede cargar un asistente en un método específico que necesite
él.

Sin embargo, si desea cargar en el constructor de su controlador, puede usar ``$helpers``
propiedad en el Controlador en su lugar. Ver :ref:`Controladores<controllers-helpers>` .

.. _helpers-loading-from-specified-namespace:

Cargando desde el espacio de nombres especificado
=================================================

De forma predeterminada, Higgs buscará los archivos auxiliares en todos los espacios de nombres definidos.
y cargue todos los archivos encontrados.

Si desea cargar solo un asistente en un espacio de nombres específico, anteponga el nombre del
ayudante con el espacio de nombres en el que se puede ubicar. Dentro de ese directorio de espacio de nombres,
el cargador espera que viva dentro de un subdirectorio llamado **Helpers**. Un ejemplo
ayudará a entender esto.

Para este ejemplo, supongamos que hemos agrupado todos nuestros blogs relacionados
código en su propio espacio de nombres, ``Ejemplo\Blog``. Los archivos existen en nuestro servidor en
**Módulos/Blog/**. Entonces, colocaríamos nuestros archivos auxiliares para el módulo del blog en
**Módulos/Blog/Ayudantes/**. Un archivo **blog_helper** estaría en
**Módulos/Blog/Ayudantes/blog_helper.php**. Dentro de nuestro controlador podríamos
use el siguiente comando para cargar el asistente por nosotros:

.. literalinclude:: helpers/004.php

También puedes utilizar la siguiente manera:

.. literalinclude:: helpers/007.php

.. note:: The functions within files loaded this way are not truly namespaced.
    El espacio de nombres se utiliza simplemente como una forma conveniente de localizar los archivos.

.. _auto-loading-helpers:

Ayudantes de carga automática
=============================

.. versionadded:: 7.0.0

Si descubre que necesita un ayudante particular a nivel global a lo largo de su aplicación,
puede decirle a Higgs que lo cargue automáticamente durante la inicialización del sistema.
Esto se hace abriendo el archivo **app/Config/Autoload.php**
y agregando el ayudante a la propiedad ``$helpers``.


Usando un ayudante
******************

Una vez que haya cargado el archivo auxiliar que contiene la función que desea
use, lo llamará de la misma manera que lo haría con una función PHP estándar.

Por ejemplo, para crear un enlace usando la función :php:func:`anchor()` en uno de
tus archivos de vista harías esto:

.. literalinclude:: helpers/005.php

Donde ``Haga clic aquí`` es el nombre del enlace y ``blog/comentarios`` es el
URI del controlador/método al que desea vincularse.


Creando ayudantes
*****************

Crear ayudantes personalizados
==============================

El nombre del archivo auxiliar es **nombre del asistente** y **_helper.php**.

Por ejemplo, para crear un asistente de información, creará un archivo llamado
**app/Helpers/info_helper.php** y agrega una función al archivo:

.. literalinclude:: helpers/008.php

Puede agregar tantas funciones como desee a un único archivo auxiliar.

Ayudantes "ampliantes"
================================

Para "ampliar" los asistentes, cree un archivo en su carpeta **aplicación/ayudantes**
con un nombre idéntico al del Ayudante existente.

Si todo lo que necesita hacer es agregar alguna funcionalidad a un asistente existente:

tal vez agregar una función o dos, o cambiar la forma en que un ayudante en particular
función funciona, entonces es excesivo reemplazar todo el ayudante con
tu versión. En este caso, es mejor simplemente "extender" el Asistente.

.. note:: The term "extend" is used loosely since Helper functions are
    procesal y discreto y no puede extenderse en el modo tradicional.
    sentido programático. Debajo del capó, esto te da la posibilidad de
    agregar o reemplazar las funciones que proporciona un asistente.

Por ejemplo, para ampliar el **Array Helper** nativo, creará un archivo
llamado **app/Helpers/array_helper.php**, y agregue o anule
funciones:

.. literalinclude:: helpers/006.php

.. important:: Do not specify the namespace ``App\Helpers``.

Consulte `Orden de carga`_ para conocer el orden en que se cargan los archivos auxiliares.


¿Ahora que?
***********

En la Tabla de contenido, encontrará una lista de todos los :doc:`Helpers <../helpers/index>` disponibles.
Explore cada uno para ver qué hacen.
