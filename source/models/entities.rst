########################
Usando clases de entidad
########################

Higgs apoya las clases de Entidad como ciudadano de primera clase, manteniendo
su uso es completamente opcional. Se utilizan comúnmente como parte del patrón Repositorio, pero pueden
ser usado directamente con el :doc:`Modelo</models/model>` si eso se adapta mejor a sus necesidades.

.. contents::
    :local:
    :depth: 2


Uso de entidad
**************

En esencia, una clase Entidad es simplemente una clase que representa una única fila de la base de datos. Tiene propiedades de clase.
para representar las columnas de la base de datos y proporciona métodos adicionales para implementar la lógica empresarial para
esa fila.

.. note:: For ease of understanding, the explanation here is based on the case of
    utilizando una base de datos. Sin embargo, Entidad también se puede utilizar para datos que no vienen
    de una base de datos.

La característica principal, sin embargo, es que no sabe nada sobre cómo persistir. Eso es
responsabilidad del modelo o de la clase de repositorio. De esa manera, si algo cambia sobre cómo necesita guardar el
objeto, no es necesario cambiar la forma en que se utiliza ese objeto en toda la aplicación.

Esto hace posible
use archivos JSON o XML para almacenar los objetos durante una etapa de creación rápida de prototipos y luego cambie fácilmente a un
base de datos cuando hayas demostrado que el concepto funciona.

Veamos una entidad de usuario muy simple y cómo trabajaríamos con ella para ayudar a aclarar las cosas.

Supongamos que tiene una tabla de base de datos llamada ``usuarios`` que tiene el siguiente esquema::

    identificación - número entero
    nombre de usuario - cadena
    correo electrónico - cadena
    contraseña - cadena
    creado_en - fecha y hora

.. important:: ``attributes`` is a reserved word for internal use. If you use it as a column name, the Entity does not work correctly.

Crear la clase de entidad
=========================

Ahora crea una nueva clase de entidad. Dado que no existe una ubicación predeterminada para almacenar estas clases y no encaja
Con la estructura de directorios existente, cree un nuevo directorio en **app/Entities**. Crea el
Entidad misma en **app/Entities/User.php**.

.. literalinclude:: entities/001.php

En su forma más simple, esto es todo lo que necesita hacer, aunque lo haremos más útil en un minuto.

Crear el modelo
===============

Primero crea el modelo en **app/Models/UserModel.php** para que podamos interactuar con él:

.. literalinclude:: entities/002.php

El modelo utiliza la tabla ``usuarios`` en la base de datos para todas sus actividades. Hemos configurado la propiedad ``$allowedFields``
para incluir todos los campos que queremos que cambien fuera de las clases. Los campos ``id``, ``created_at`` y ``updated_at``
son manejados automáticamente por la clase o la base de datos, por lo que no queremos cambiarlos. Finalmente, hemos configurado nuestra Entidad
clase como ``$returnType``. Esto garantiza que todos los métodos del modelo que devuelven filas de la base de datos devolverán
instancias de nuestra clase de entidad de usuario en lugar de un objeto o matriz como de costumbre.

Trabajar con la clase de entidad
================================

Ahora que todas las piezas están en su lugar, trabajará con la clase Entidad como lo haría con cualquier otra clase:

.. literalinclude:: entities/003.php

Quizás hayas notado que la clase ``Usuario`` no ha establecido ninguna propiedad para las columnas, pero aún puedes
acceder a ellos como si fueran bienes públicos. La clase base, ``Higgs\Entity\Entity``, se encarga de esto por usted, como
además de brindar la capacidad de verificar las propiedades con ``isset()`` o ``unset()`` la propiedad y realizar un seguimiento
de qué columnas han cambiado desde que se creó el objeto o se extrajo de la base de datos.

.. note:: The Entity class stores the data in the class property ``$attributes`` internally.

Cuando el usuario pasa al método ``save()`` del modelo, automáticamente se encarga de leer las propiedades.
y guardar cualquier cambio en las columnas enumeradas en la propiedad ``$allowedFields`` del modelo. También sabe si crear
una nueva fila o actualizar una existente.

.. note:: When we are making a call to the ``insert()`` all the values from Entity are passed to the method, but when we
    llame a ``update()``, luego solo se pasan los valores que han cambiado.

Propiedades de relleno rápidamente
==================================

La clase Entity también proporciona un método, ``fill()`` que le permite insertar una matriz de pares clave/valor en la clase.
y completar las propiedades de la clase. Cualquier propiedad de la matriz se establecerá en la Entidad. Sin embargo, al guardar mediante
el modelo, sólo los campos en ``$allowedFields`` realmente se guardarán en la base de datos, para que pueda almacenar datos adicionales
en sus entidades sin preocuparse mucho de que los campos perdidos se guarden incorrectamente.

.. literalinclude:: entities/004.php

También puede pasar los datos en el constructor y los datos se pasarán a través del método ``fill()`` durante la creación de instancias.

.. literalinclude:: entities/005.php

Propiedades de acceso masivo
============================

La clase Entity tiene dos métodos para extraer todas las propiedades disponibles en una matriz: ``toArray()`` y ``toRawArray()``.
El uso de la versión sin formato evitará los métodos y lanzamientos mágicos de "captadores". Ambos métodos pueden tomar un primer parámetro booleano.
para especificar si los valores devueltos deben filtrarse por aquellos que han cambiado, y un parámetro final booleano para
haga que el método sea recursivo, en el caso de entidades anidadas.


Manejo de la lógica empresarial
*******************************

Si bien los ejemplos anteriores son convenientes, no ayudan a aplicar ninguna lógica empresarial. La clase de entidad base implementa
algunos métodos inteligentes ``__get()`` y ``__set()`` que buscarán métodos especiales y los usarán en lugar de usar
los atributos directamente, lo que le permite aplicar cualquier lógica empresarial o conversión de datos que necesite.

Aquí hay una entidad de usuario actualizada para proporcionar algunos ejemplos de cómo podría usarse:

.. literalinclude:: entities/006.php

Lo primero que hay que notar es el nombre de los métodos que hemos agregado. Para cada uno, la clase espera el caso_serpiente.
nombre de la columna que se convertirá a PascalCase y con el prefijo ``set`` o ``get``. Estos métodos luego
se llamará automáticamente cada vez que configure o recupere la propiedad de clase usando la sintaxis directa (es decir, ``$usuario->correo electrónico``).
No es necesario que los métodos sean públicos a menos que desee acceder a ellos desde otras clases. Por ejemplo, ``created_at``
Se accederá a la propiedad de clase a través de los métodos ``setCreatedAt()`` y ``getCreatedAt()``.

.. note:: This only works when trying to access the properties from outside of the class. Any methods internal to the
    La clase debe llamar a los métodos ``setX()`` y ``getX()`` directamente.

En el método ``setPassword()`` nos aseguramos de que la contraseña siempre esté codificada.

En ``setCreatedAt()`` convertimos la cadena que recibimos del modelo en un objeto DateTime, asegurando que nuestra zona horaria
es UTC para que podamos convertir fácilmente la zona horaria actual del espectador. En ``getCreatedAt()``, convierte la hora a
una cadena formateada en la zona horaria actual de la aplicación.

Si bien son bastante simples, estos ejemplos muestran que el uso de clases de entidad puede proporcionar una forma muy flexible de hacer cumplir
lógica de negocios y crear objetos que sean agradables de usar.

.. literalinclude:: entities/007.php

.. _entities-special-getter-setter:

Getter/Setter especial
======================

.. versionadded:: 4.4.0

Por ejemplo, si la clase principal de su entidad ya tiene un método ``getParent()``
definido, y su Entidad también tiene una columna llamada ``padre``, cuando intenta agregar
lógica de negocios al método ``getParent()`` en su clase Entidad, el método es
Ya definido.

En tal caso, puede utilizar el captador/definidor especial. En lugar de ``getX()``/``setX()``,
establezca ``_getX()``/``_setX()``.

En el ejemplo anterior, si su entidad tiene el método ``_getParent()``, el método
se usará cuando obtenga ``$entity->parent`` y el método ``_setParent()``
se utilizará cuando establezca ``$entidad->padre``.


Mapeo de datos
**************

En muchos puntos de tu carrera, te encontrarás con situaciones en las que el uso de una aplicación ha cambiado y la
Los nombres de columnas originales en la base de datos ya no tienen sentido. O descubre que su estilo de codificación prefiere camelCase
propiedades de clase, pero el esquema de su base de datos requería nombres de casos de serpientes. Estas situaciones se pueden manejar fácilmente
con las funciones de mapeo de datos de la clase Entidad.

Como ejemplo, imagine que tiene la entidad de usuario simplificada que se utiliza en toda su aplicación:

.. literalinclude:: entities/008.php

Tu jefe se acerca a ti y te dice que ya nadie usa nombres de usuario, por lo que estás cambiando para usar solo correos electrónicos para iniciar sesión.
Pero sí quieren personalizar un poco la aplicación, por lo que quieren que cambies el campo ``nombre`` para representar el nombre de un usuario.
nombre completo ahora, no su nombre de usuario como lo hace actualmente. Para mantener las cosas ordenadas y garantizar que las cosas sigan teniendo sentido.
en la base de datos, organiza una migración para cambiar el nombre del campo ``nombre`` a ``nombre_completo`` para mayor claridad.

Haciendo caso omiso de lo artificial que es este ejemplo, ahora tenemos dos opciones sobre cómo arreglar la clase Usuario. Podríamos modificar la clase.
propiedad de ``$name`` a ``$full_name``, pero eso requeriría cambios en toda la aplicación. En cambio, podemos
simplemente asigne la columna ``full_name`` en la base de datos a la propiedad ``$name`` y termine con los cambios de entidad:

.. literalinclude:: entities/009.php

Al agregar el nuevo nombre de nuestra base de datos a la matriz ``$datamap``, podemos decirle a la clase qué propiedad de clase tiene la columna de la base de datos.
debe ser accesible a través de. La clave de la matriz es la propiedad de clase a la que asignarla, donde el valor de la matriz es el
nombre de la columna en la base de datos.

En este ejemplo, cuando el modelo establece el campo ``full_name`` en la clase Usuario, en realidad asigna ese valor al
class' ``$name``, por lo que se puede configurar y recuperar a través de ``$user->name``. El valor seguirá siendo accesible.
a través del ``$user->full_name`` original, también, ya que esto es necesario para que el modelo recupere los datos y los guarde.
a la base de datos. Sin embargo, ``unset()`` y ``isset()`` solo funcionan en la propiedad asignada, ``$user->name``, no en el nombre de la columna de la base de datos.
``$usuario->nombre_completo``.

.. note:: When you use Data Mapping, you must define ``set*()`` and ``get*()`` method
    para el nombre de la columna de la base de datos. En este ejemplo, debe definir ``setFullName()`` y
    ``getFullName()``.


Mutadores
*********

Mutadores de fecha
==================

De forma predeterminada, la clase Entidad convertirá los campos denominados `created_at`, `updated_at` o `deleted_at` en
:doc:`Tiempo </libraries/time>` instancias cada vez que se configuran o recuperan. La clase Time proporciona una gran cantidad
de métodos útiles de forma inmutable y localizada.

Puede definir qué propiedades se convierten automáticamente agregando el nombre a la propiedad ``$dates``:

.. literalinclude:: entities/010.php

Ahora, cuando se establezca cualquiera de esas propiedades, se convertirán en una instancia de tiempo, utilizando el comando de la aplicación.
zona horaria actual, como se establece en **app/Config/App.php**:

.. literalinclude:: entities/011.php

.. _entities-property-casting:

Fundición de propiedad
======================

Puede especificar que las propiedades de su entidad se deben convertir a tipos de datos comunes con la propiedad ``$casts``.
Esta opción debe ser una matriz donde la clave es el nombre de la propiedad de clase y el valor es el tipo de datos.
debe ser lanzado.

La conversión de propiedades afecta tanto a la lectura (obtener) como a la escritura (establecer), pero algunos tipos afectan
solo leer (obtener).

Fundición tipo escalar
-------------------

Las propiedades se pueden convertir a cualquiera de los siguientes tipos de datos:

**entero**, **flotante**, **doble**, **cadena**, **booleano**, **objeto**, **matriz**, **fechahora**, ** marca de tiempo**, **uri** y **int-bool**.
Agregue un signo de interrogación al principio del tipo para marcar la propiedad como anulable, es decir, **?string**, **?integer**.

.. note:: **int-bool** can be used since v7.3.0.

Por ejemplo, si tuviera una entidad de Usuario con una propiedad ``is_banned``, puede convertirla en booleana:

.. literalinclude:: entities/012.php

Transmisión de matriz/Json
------------------

La conversión de matrices/Json es especialmente útil con campos que almacenan matrices serializadas o json en ellos. Cuando se emite como:

* una **matriz**, se deserializarán automáticamente,
* un **json**, se establecerán automáticamente como un valor de ``json_decode($value, false)``,
* un **json-array**, se establecerán automáticamente como un valor de ``json_decode($value, true)``,

cuando establece el valor de la propiedad.
A diferencia del resto de los tipos de datos a los que puede convertir propiedades,:

* **array** el tipo de conversión se serializará,
* **json** y **json-array** cast usarán la función json_encode en

el valor cada vez que se establece la propiedad:

.. literalinclude:: entities/013.php

.. literalinclude:: entities/014.php

Transmisión CSV
-----------

Si sabe que tiene una matriz plana de valores simples, codifíquelos como una cadena serializada o JSON.
puede ser más complejo que la estructura original. La conversión como valores separados por comas (CSV) es
una alternativa más simple dará como resultado una cadena que utiliza menos espacio y se lee más fácilmente
por humanos:

.. literalinclude:: entities/015.php

Almacenado en la base de datos como "rojo, amarillo, verde":

.. literalinclude:: entities/016.php

.. note:: Casting as CSV uses PHP's internal ``implode`` and ``explode`` methods and assumes all values are string-safe and free of commas. For more complex data casts try ``array`` or ``json``.

Fundición personalizada
--------------

Puede definir sus propios tipos de conversión para obtener y configurar datos.

Al principio necesitas crear una clase de controlador para tu tipo.
Digamos que la clase estará ubicada en el directorio **app/Entities/Cast**:

.. literalinclude:: entities/017.php

Ahora necesitas registrarlo:

.. literalinclude:: entities/018.php

Si no necesita cambiar valores al obtener o establecer un valor. Entonces simplemente no implementes el método apropiado:

.. literalinclude:: entities/019.php

Parámetros
----------

En algunos casos, un tipo no es suficiente. En esta situación, puede utilizar parámetros adicionales.
Los parámetros adicionales se indican entre corchetes y se enumeran con una coma.
como ``tipo[param1, param2]``.

.. literalinclude:: entities/020.php

.. literalinclude:: entities/021.php

.. note:: If the casting type is marked as nullable like ``?bool`` and the passed value is not null, then the parameter with
    el valor ``nullable`` se pasará al controlador de tipo de conversión.
    Si el tipo de conversión tiene parámetros predefinidos, se agregará "nullable" al final de la lista.


Comprobación de atributos modificados
*************************************

Puede verificar si un atributo de Entidad ha cambiado desde que fue creado. El único parámetro es el nombre del
atributo a comprobar:

.. literalinclude:: entities/022.php

O para verificar toda la entidad en busca de valores modificados, omita el parámetro:

.. literalinclude:: entities/023.php
