##########
Paginación
##########

Higgs proporciona una biblioteca de paginación muy simple pero flexible que es fácil de temaizar, funciona con el modelo,
y capaz de admitir múltiples paginadores en una sola página.

.. contents::
    :local:
    :depth: 2


Cargando la biblioteca
**********************

Como todos los servicios en Higgs, se puede cargar a través de ``Config\Services``, aunque normalmente no será necesario
para cargarlo manualmente:

.. literalinclude:: pagination/001.php

.. _paginating-with-models:


Paginar con modelos
*******************

En la mayoría de los casos, utilizará la biblioteca Pager para paginar los resultados que recupere de la base de datos.
Cuando se utiliza el modelo :doc:`</models/model>``, puedes usar su método incorporado ``paginate()`` para automáticamente
recupere el lote actual de resultados, así como configure la biblioteca de buscapersonas para que esté lista para usar en sus controladores.
Incluso lee la página actual que debería mostrar desde la URL actual a través de una variable de consulta ``página=X``.

Para proporcionar una lista paginada de usuarios en su aplicación, el método de su controlador se vería así:

.. literalinclude:: pagination/002.php

En este ejemplo, primero creamos una nueva instancia de nuestro ``UserModel``. Luego completamos los datos para enviarlos a la vista.
El primer elemento son los resultados de la base de datos, **usuarios**, que se recuperan para la página correcta y devuelven
10 usuarios por página. El segundo elemento que debe enviarse a la vista es la propia instancia del buscapersonas. Como conveniencia,
el Modelo conservará la instancia que utilizó y la almacenará en la propiedad pública, ``$pager``. Entonces, agarramos
eso y asígnelo a la variable ``$pager`` en la vista.

Personalización de consultas para paginación
============================================

Para personalizar una consulta de paginación en un modelo, puede agregar
:doc:`Métodos del Generador de consultas <../database/query_builder>` antes de ``paginate()``
método.

Añadiendo DONDE
------------

Si desea agregar condiciones WHERE, puede especificar las condiciones directamente:

.. literalinclude:: pagination/003.php
    :lines: 2-

Puede mover las condiciones a un método separado:

.. literalinclude:: pagination/017.php

.. literalinclude:: pagination/018.php
    :lines: 2-

Añadiendo UNIRSE
-----------

Puedes unirte a otra mesa:

.. literalinclude:: pagination/016.php

.. important:: It is important to understand that the ``Model::paginate()`` method
    utiliza el **Modelo** y la instancia del **Query Builder** en el modelo.
    Por lo tanto, intentar usar ``Model::paginate()`` con :ref:`db-query`
    **no funcionará** porque ``$db->query()`` ejecuta la consulta inmediatamente
    y no está asociado con el Generador de consultas.

Si necesita una consulta SQL complicada que no puede escribir con Query Builder,
intente usar :ref:`db-query` y `Paginación manual`_.

Visualización de enlaces de buscapersonas
=========================================

Dentro de la vista, debemos indicarle dónde mostrar los enlaces resultantes:

    <?= $pager->enlaces() ?>

Y eso es todo lo que se necesita. La clase Pager mostrará los enlaces de la primera y última página, así como los enlaces siguiente y anterior.
para cualquier página con más de dos páginas a cada lado de la página actual.

Es importante tener en cuenta que el patrón de biblioteca para Siguiente y Anterior es diferente del que se utiliza en la forma tradicional de paginación de resultados.

Siguiente y Anterior aquí están vinculados al grupo de enlaces que se mostrarán en la estructura de paginación, y no a la página de registros siguiente o anterior.

Si prefiere una salida más simple, puede utilizar el método ``simpleLinks()``, que sólo utiliza enlaces "más antiguos" y "más nuevos".
en lugar de los enlaces de paginación de detalles::

    <?= $pager->Enlaces simples() ?>

Detrás de escena, la biblioteca carga un archivo de vista que determina cómo se formatean los enlaces, lo que simplifica
modificar según sus necesidades. Consulte a continuación para obtener detalles sobre cómo personalizar completamente la salida.

Paginar múltiples resultados
============================

Si necesita proporcionar enlaces de dos conjuntos de resultados diferentes, puede pasar nombres de grupos a la mayor parte de la paginación.
métodos para mantener los datos separados:

.. literalinclude:: pagination/004.php

Configuración de página manualmente
===================================

Si necesita especificar qué página de resultados devolver, puede especificar la página como tercer argumento. Esto puede ser
útil cuando tienes una manera diferente a la variable predeterminada ``$_GET`` para controlar qué página mostrar.

.. literalinclude:: pagination/005.php

Especificación del segmento URI para la página
==============================================

También es posible utilizar un segmento URI para el número de página, en lugar del parámetro de consulta de página. Simplemente especifique el
número de segmento que se utilizará como cuarto argumento. Los URI generados por el buscapersonas se verían entonces
como **https://domain.tld/foo/bar/[pageNumber]** en lugar de **https://domain.tld/foo/bar?page=[pageNumber]**.

.. literalinclude:: pagination/006.php

Tenga en cuenta: el valor ``$segment`` no puede ser mayor que el número de segmentos de URI más 1.


Paginación manual
*****************

Es posible que encuentre ocasiones en las que solo necesite crear una paginación basada en datos conocidos. Puedes crear enlaces manualmente.
con el método ``makeLinks()``, que toma la página actual, el número de resultados por página y
el número total de elementos como primer, segundo y tercer parámetro, respectivamente:

.. literalinclude:: pagination/015.php

Esto, de forma predeterminada, mostrará los enlaces de la manera normal, como una serie de enlaces, pero puede cambiar la visualización.
plantilla utilizada pasando el nombre de la plantilla como cuarto parámetro. Más detalles se pueden encontrar en lo siguiente
secciones::

    $paginador->makeLinks($página, $porpágina, $total, 'nombre_plantilla');

También es posible utilizar un segmento URI para el número de página, en lugar del parámetro de consulta de página, como se describe en
la sección anterior. Especifique el número de segmento que se utilizará como quinto parámetro de ``makeLinks()``::

    $paginador->makeLinks($página, $porPágina, $total, 'nombre_plantilla', $segmento);

Tenga en cuenta: el valor ``$segment`` no puede ser mayor que el número de segmentos de URI más 1.

Si necesita mostrar muchos buscapersonas en una página, entonces podría resultar útil un parámetro adicional que definirá un grupo:

.. literalinclude:: pagination/007.php

La biblioteca de paginación utiliza el parámetro de consulta **página** para consultas HTTP de forma predeterminada (si no se proporciona ningún grupo o nombre de grupo ``predeterminado``) o ``página_[nombre de grupo]`` para nombres de grupos personalizados.


Paginar solo con consultas esperadas
************************************

De forma predeterminada, todas las consultas GET se muestran en los enlaces de paginación.

Por ejemplo, al acceder a la URL **https://domain.tld?search=foo&amp;order=asc&amp;hello=i+am+here&amp;page=2**, se puede generar el enlace de la página 3, junto con los demás enlaces, de la siguiente manera:

.. literalinclude:: pagination/008.php

El método ``only()`` le permite limitar esto sólo a las consultas ya esperadas:

.. literalinclude:: pagination/009.php

La consulta *página* está habilitada de forma predeterminada. Y ``only()`` actúa en todos los enlaces de paginación.


Personalizando los enlaces
**************************

Ver configuración
=================

Cuando los enlaces se muestran en la página, utilizan un archivo de vista para describir el HTML. Puedes cambiar fácilmente la vista.
que se utiliza editando **app/Config/Pager.php**:

.. literalinclude:: pagination/010.php

Esta configuración almacena el alias y :doc:`rutas de vista con espacios de nombres</outgoing/views>`  por la opinión de que
debería ser usado. Las vistas ``default_full`` y ``default_simple`` se utilizan para ``links()`` y ``simpleLinks()``
métodos, respectivamente. Para cambiar la forma en que se muestran en toda la aplicación, puede asignar una nueva vista aquí.

Por ejemplo, supongamos que crea un nuevo archivo de vista que funciona con el marco Foundation CSS y
coloca ese archivo en **app/Views/Pagers/foundation_full.php**. Dado que el directorio **aplicación** es
espacio de nombres como ``App``, y todos los directorios debajo de él se asignan directamente a segmentos del espacio de nombres, puede ubicar
el archivo de vista a través de su espacio de nombres::

    'default_full' => 'Aplicación\Vistas\Pagers\foundation_full'

Sin embargo, dado que se encuentra en el directorio estándar **app/Views**, no es necesario asignarle un espacio de nombre ya que
El método ``view()`` puede localizarlo por nombre de archivo. En ese caso, simplemente puede proporcionar el subdirectorio y el nombre del archivo::

    'default_full' => 'Buscapersonas/foundation_full'

Una vez que haya creado la vista y la haya configurado en la configuración, se utilizará automáticamente. no tienes que hacerlo
reemplazar las plantillas existentes. Puedes crear tantas plantillas adicionales como necesites en la configuración
archivo. Una situación común sería necesitar diferentes estilos para el frontend y el backend de su aplicación.

.. literalinclude:: pagination/011.php

Una vez configurado, puede especificarlo como último parámetro en ``links()``, ``simpleLinks()`` y ``makeLinks()``.
métodos::

    <?= $pager->enlaces('grupo1', 'front_full')?>
    <?= $pager->enlaces simples('grupo2', 'front_full')?>
    <?= $pager->makeLinks($página, $perPage, $total, 'front_full')?>

Creando la vista
================

Cuando crea una nueva vista, solo necesita crear el código necesario para crear los enlaces de paginación.
No debes crear divs envolventes innecesarios ya que pueden usarse en varios lugares y solo limitas su
utilidad. Es más fácil demostrar la creación de una nueva vista mostrándole la plantilla ``default_full`` existente:

.. literalinclude:: pagination/012.php

establecerSurroundCount()
------------------

En la primera línea, el método ``setSurroundCount()`` especifica que queremos mostrar dos enlaces a cada lado de
el enlace de la página actual. El único parámetro que acepta es el número de enlaces a mostrar.

.. note:: You must call this method first to generate correct pagination links.

tieneAnterior() y tieneSiguiente()
-------------------------

Estos métodos devuelven un valor booleano "verdadero" si hay más enlaces que se pueden mostrar en ambos lados de la página actual.
basado en el valor pasado a `setSurroundCount()`_.

Por ejemplo, digamos que tenemos 20 páginas de datos. La corriente
La página es la página 3. Si el recuento circundante es 2, los siguientes enlaces se mostrarán así:

    1 | 2 | 3 | 4 | 5

Dado que el primer enlace mostrado es la página uno, ``hasPrevious()`` devolvería ``false`` ya que no hay página cero. Sin embargo,
``hasNext()`` devolvería ``true`` ya que hay 15 páginas adicionales de resultados después de la página cinco.

obtenerAnterior() y obtenerSiguiente()
-------------------------

Estos métodos devuelven la **URL** de las páginas de resultados anteriores o siguientes a ambos lados de los enlaces numerados.

Por ejemplo, tiene la página actual configurada en 5 y desea que los enlaces antes y después (el recuento envolvente) sean 2 cada uno, eso le dará algo como esto:

    3 | 4 | 5 | 6 | 7

``getPrevious()`` devuelve la URL de la página 2. ``getNext()`` devuelve la URL de la página 8.

Si desea obtener las páginas 4 y 6, utilice `getPreviousPage() &amp; getNextPage()`_ en su lugar.

obtenerPrimero() y obtenerÚltimo()
----------------------

Al igual que `getPrevious() &amp; getNext()`_, estos métodos devuelven la **URL** a la primera y última página del
conjunto resultante.

Enlaces()
-------

Devuelve una serie de datos sobre todos los enlaces numerados. La matriz de cada enlace contiene el uri del enlace, el
título, que es solo el número, y un booleano que indica si el enlace es el enlace actual/activo o no:

.. literalinclude:: pagination/013.php

En el código presentado para la estructura de paginación estándar, los métodos `getPrevious() &amp; getNext()`_ se utilizan para obtener los enlaces a los grupos de paginación anterior y siguiente respectivamente.

Si desea utilizar la estructura de paginación donde anterior y siguiente serán enlaces a las páginas anterior y siguiente según la página actual, simplemente reemplace los métodos `getPrevious() &amp; getNext()`_ con `getPreviousPage() &amp; getNextPage() `_, y los métodos `hasPrevious() &amp; hasNext()`_ por `hasPreviousPage() &amp; hasNextPage()`_ respectivamente.

Vea a continuación un ejemplo con estos cambios:

.. literalinclude:: pagination/014.php

tienePáginaAnterior() y tienePáginaSiguiente()
---------------------------------

Este método devuelve un valor booleano "verdadero" si hay enlaces a una página antes y después, respectivamente, de la página actual que se muestra.

Por ejemplo, digamos que tenemos 20 páginas de datos. La corriente
La página es la página 3. Si el recuento circundante es 2, los siguientes enlaces se mostrarán así:

    1 | 2 | 3 | 4 | 5

``hasPreviousPage()`` devolvería ``true`` ya que existe la página 2. Y,
``hasNextPage()`` devolvería ``true`` ya que hay la página 4.

.. note:: The difference to `hasPrevious() & hasNext()`_ is that they are based
    en la página actual mientras que `hasPrevious() &amp; hasNext()`_ se basan en el conjunto
    de enlaces que se mostrarán antes y después de la página actual según el valor
    pasado en `setSurroundCount()`_.

obtenerPáginaAnterior() y obtenerPáginaSiguiente()
---------------------------------

Estos métodos devuelven una **URL** para las páginas anterior y siguiente en relación con la página actual que se muestra.

Por ejemplo, tiene la página actual configurada en 5 y desea que los enlaces antes y después (el recuento envolvente) sean 2 cada uno, eso le dará algo como esto:

    3 | 4 | 5 | 6 | 7

``getPreviousPage()`` devuelve la URL de la página 4. ``getNextPage()`` devuelve la URL de la página 6.

.. note:: `getPrevious() & getNext()`_ returns the URL for the previous or next
    páginas de resultados a ambos lados de los enlaces numerados.

Si desea números de página en lugar de URL, puede utilizar los siguientes métodos:

obtenerNúmero de página anterior() y obtenerNúmero de página siguiente()
---------------------------------------

Estos métodos devuelven el número de página de las páginas anteriores o siguientes en relación con la página actual que se muestra.

obtenerNúmeroPrimeraPágina() y obtenerNúmeroÚltimaPágina()
------------------------------------------

Estos métodos devuelven los números de página de la primera y última página del conjunto de
enlaces que se mostrarán. Por ejemplo, si el conjunto de enlaces que se mostrarán es algo como esto::

    3 | 4 | 5 | 6 | 7

``getFirstPageNumber()`` devolverá 3 mientras que ``getLastPageNumber()`` devolverá 7.

.. note:: To obtain the page numbers of the first and last pages in the entire
    conjunto de resultados, puede utilizar el siguiente enfoque: el número de la primera página es siempre 1 y `getPageCount()`_ se puede utilizar para
    recuperar el último número de página.

obtenerNúmero de página actual()
----------------------

Este método devuelve el número de página de la página actual.

getPageCount()
--------------

Este método devuelve el número total de páginas.
