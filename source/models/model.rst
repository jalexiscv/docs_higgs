#########################
Usando el modelo de Higgs
#########################

.. contents::
    :local:
    :depth: 3

Modelos
*******

El modelo de Higgs proporciona características de conveniencia y funcionalidad adicional.
que la gente usa comúnmente para hacer más conveniente trabajar con una **tabla única** en su base de datos.

Sale de la caja con ayudante.
métodos para muchas de las formas estándar que necesitaría para interactuar con una tabla de base de datos, incluida la búsqueda de registros,
actualizar registros, eliminar registros y más.

.. _accessing-models:

Accediendo a modelos
********************

Los modelos normalmente se almacenan en el directorio **app/Models**. Deben tener un espacio de nombres que coincida con su
ubicación dentro del directorio, como ``espacio de nombres App\Models``.

Puede acceder a los modelos dentro de sus clases creando una nueva instancia o usando la función auxiliar :php:func:`model()`.

.. literalinclude:: model/001.php

El ``model()`` usa ``Factories::models()`` internamente.
Consulte :ref:`factories-loading-class` para obtener detalles sobre el primer parámetro.

Modelo de Higgs
***************

Higgs proporciona una clase de modelo que proporciona algunas características interesantes, que incluyen:

- conexión automática a la base de datos
- métodos CRUD básicos
- validación en el modelo
- :ref:`paginación automática<paginating-with-models>`
- y más

Esta clase proporciona una base sólida desde la cual construir tus propios modelos, permitiéndote
Desarrolle rápidamente la capa de modelo de su aplicación.

Creando tu modelo
*****************

Para aprovechar el modelo de Higgs, simplemente crearía una nueva clase de modelo.
que extiende ``Higgs\Model``:

.. literalinclude:: model/002.php

Esta clase vacía proporciona acceso conveniente a la conexión de la base de datos, el Generador de consultas,
y una serie de métodos de conveniencia adicionales.

initialize()
============

Si necesita configuración adicional en su modelo, puede extender el método ``initialize()``
que se ejecutará inmediatamente después del constructor del modelo. Esto le permite realizar
pasos adicionales sin repetir los parámetros del constructor, por ejemplo extendiendo otros modelos:

.. literalinclude:: model/003.php

Conexión a la base de datos
===========================

Cuando se crea una instancia de la clase por primera vez, si no se pasa ninguna instancia de conexión de base de datos al constructor,
y si no configura la propiedad ``$DBGroup`` en su clase de modelo,
se conectará automáticamente al grupo de base de datos predeterminado, según lo establecido en la configuración de la base de datos.

Puede
modifique qué grupo se utiliza según el modelo agregando la propiedad ``$DBGroup`` a su clase.
Esto garantiza que dentro del modelo cualquier referencia a ``$this->db`` se realice a través del canal apropiado.
conexión.

.. literalinclude:: model/004.php

Reemplazaría "nombre_grupo" con el nombre de un grupo de base de datos definido de la base de datos.
archivo de configuración.

Configurando su modelo
======================

La clase modelo tiene algunas opciones de configuración que se pueden configurar para permitir los métodos de la clase.
para trabajar sin problemas para usted. Los dos primeros son utilizados por todos los métodos CRUD para determinar
qué tabla usar y cómo podemos encontrar los registros requeridos:

.. literalinclude:: model/005.php

$table
------

Especifica la tabla de base de datos con la que trabaja principalmente este modelo. Esto sólo se aplica a la
métodos CRUD incorporados. No está restringido a utilizar únicamente esta tabla por su cuenta.
consultas.

$primaryKey
-----------

Este es el nombre de la columna que identifica de forma única los registros de esta tabla. Este
no necesariamente tiene que coincidir con la clave principal especificada en la base de datos, pero
se usa con métodos como ``find()`` para saber con qué columna hacer coincidir el valor especificado.

.. note:: All Models must have a primaryKey specified to allow all of the features to work
    como se esperaba.

$useAutoIncrement
-----------------

Especifica si la tabla utiliza una función de incremento automático para `$primaryKey`_. Si se establece en "falso"
entonces usted es responsable de proporcionar el valor de la clave principal para cada registro de la tabla. Este
La característica puede ser útil cuando queremos implementar una relación 1:1 o usar UUID para nuestro modelo. El
El valor predeterminado es "verdadero".

.. note:: If you set `$useAutoIncrement`_ to ``false``, then make sure to set your primary
    clave en la base de datos a ``único``. De esta manera te asegurarás de que todas las características del modelo
    seguirá funcionando igual que antes.

$returnType
-----------

Los métodos CRUD del modelo le quitarán un paso de trabajo y regresarán automáticamente
los datos resultantes, en lugar del objeto Resultado. Esta configuración le permite definir
el tipo de datos que se devuelven. Los valores válidos son '**array**' (el valor predeterminado), '**object**' o **completamente
nombre calificado de una clase** que se puede usar con ``getCustomResultObject()`` del objeto Result
método. El uso de la constante especial ``::class`` de la clase permitirá que la mayoría de los IDE
Complete automáticamente el nombre y permita funciones como refactorización para comprender mejor su código.

.. _model-use-soft-deletes:

$useSoftDeletes
---------------

Si es verdadero, entonces cualquier llamada al método ``delete()`` establecerá ``deleted_at`` en la base de datos, en lugar de
en realidad eliminando la fila. Esto puede preservar datos cuando se pueda hacer referencia a ellos en otro lugar, o
puede mantener una "papelera de reciclaje" de objetos que se pueden restaurar, o incluso simplemente conservarla como
parte de un rastro de seguridad. Si es verdadero, los métodos **find*()** solo devolverán filas no eliminadas, a menos que
el método ``withDeleted()`` se llama antes de llamar al método **find*()**.

Esto requiere un campo DATETIME o INTEGER en la base de datos según el modelo.
Configuración `$dateFormat`_. El nombre del campo predeterminado es ``deleted_at`` sin embargo este nombre puede ser
configurado con cualquier nombre de su elección utilizando la propiedad `$deletedField`_.

.. important:: The ``deleted_at`` field must be nullable.

$allowedFields
--------------

Esta matriz debe actualizarse con los nombres de los campos que se pueden configurar durante ``save()``, ``insert()`` o
Métodos ``actualizar()``. Cualquier nombre de campo distinto de estos se descartará. Esto ayuda a proteger
en contra de simplemente tomar información de un formulario y arrojarla toda al modelo, lo que resulta en
posibles vulnerabilidades de asignación masiva.

.. note:: The `$primaryKey`_ field should never be an allowed field.

$allowEmptyInserts
------------------

.. versionadded:: 7.0.0

Ya sea para permitir la inserción de datos vacíos. El valor predeterminado es "falso", lo que significa
que si intentas insertar datos vacíos, se producirá una excepción con
"No hay datos para insertar." elevará.

También puede cambiar esta configuración con el método :ref:`model-allow-empty-inserts`.

fechas
-----

$useTimestamps
^^^^^^^^^^^^^^

Este valor booleano determina si la fecha actual se agrega automáticamente a todas las inserciones.
y actualizaciones. Si es ``true``, establecerá la hora actual en el formato especificado por `$dateFormat`_. Este
requiere que la tabla tenga columnas denominadas **created_at**, **updated_at** y **deleted_at** en el formato apropiado.
tipo de datos. Consulte también `$createdField`_, `$updatedField`_ y `$deletedField`_.

$dateFormat
^^^^^^^^^^^

Este valor funciona con `$useTimestamps`_ y `$useSoftDeletes`_ para garantizar que se utilice el tipo correcto de
El valor de fecha se inserta en la base de datos. De forma predeterminada, esto crea valores DATETIME, pero
Las opciones válidas son: ``'datetime'``, ``'date'`` o ``'int'`` (una marca de tiempo UNIX). Usando `$useSoftDeletes`_ o
`$useTimestamps`_ con un `$dateFormat`_ no válido o faltante provocará una excepción.

$createdField
^^^^^^^^^^^^^

Especifica qué campo de base de datos usar para la marca de tiempo de creación del registro de datos.
Establezca una cadena vacía (``''``) para evitar actualizarla (incluso si `$useTimestamps`_ está habilitado).

$updatedField
^^^^^^^^^^^^^

Especifica qué campo de base de datos se debe utilizar para mantener la marca de tiempo de actualización del registro de datos.
Establezca una cadena vacía (``''``) para evitar actualizarla (incluso `$useTimestamps`_ está habilitado).

$deletedField
^^^^^^^^^^^^^

Especifica qué campo de base de datos usar para eliminaciones temporales. Consulte :ref:`model-use-soft-deletes`.

Validación
----------

$validationRules
^^^^^^^^^^^^^^^^

Contiene una matriz de reglas de validación como se describe en :ref:`validation-array`
o una cadena que contiene el nombre de un grupo de validación, como se describe en la misma sección.
Se describe con más detalle a continuación.

$validationMessages
^^^^^^^^^^^^^^^^^^^

Contiene una serie de mensajes de error personalizados que deben usarse durante la validación, como
descrito en :ref:`validation-custom-errors`. Se describe con más detalle a continuación.

$skipValidation
^^^^^^^^^^^^^^^

Si se debe omitir la validación durante todas las **inserciones** y **actualizaciones**. El valor por defecto
El valor es "falso", lo que significa que los datos siempre intentarán ser validados. Esto es
utilizado principalmente por el método ``skipValidation()``, pero puede cambiarse a ``true`` para que
este modelo nunca se validará.

.. _clean-validation-rules:

$cleanValidationRules
^^^^^^^^^^^^^^^^^^^^^

Si se deben eliminar las reglas de validación que no existen en los datos pasados.
Esto se usa en **actualizaciones**.
El valor predeterminado es "verdadero", lo que significa que las reglas de validación para los campos
que no estén presentes en los datos pasados se eliminarán (temporalmente) antes de la validación.
Esto es para evitar errores de validación al actualizar solo algunos campos.

También puede cambiar el valor mediante el método ``cleanRules()``.

.. note:: Prior to v7.2.7, ``$cleanValidationRules`` did not work due to a bug.

Devoluciones de llamada
-----------------------

$allowCallbacks
^^^^^^^^^^^^^^^

Si se deben utilizar las devoluciones de llamada definidas a continuación. Ver :ref:`model-events`.

$beforeInsert
^^^^^^^^^^^^^
$afterInsert
^^^^^^^^^^^^
$beforeUpdate
^^^^^^^^^^^^^
$afterUpdate
^^^^^^^^^^^^^
$beforeFind
^^^^^^^^^^^
$afterFind
^^^^^^^^^^
$beforeDelete
^^^^^^^^^^^^^
$afterDelete
^^^^^^^^^^^^
$beforeInsertBatch
^^^^^^^^^^^^^^^^^^
$afterInsertBatch
^^^^^^^^^^^^^^^^^
$beforeUpdateBatch
^^^^^^^^^^^^^^^^^^
$afterUpdateBatch
^^^^^^^^^^^^^^^^^

Estas matrices le permiten especificar métodos de devolución de llamada que se ejecutarán en los datos en el
hora especificada en el nombre de la propiedad. Ver :ref:`model-events`.

Trabajar con datos
******************

Encontrar datos
===============

Se proporcionan varias funciones para realizar trabajo CRUD básico en sus tablas, incluyendo ``find()``,
``insertar()``, ``actualizar()``, ``eliminar()`` y más.

find()
------

Devuelve una sola fila donde la clave principal coincide con el valor pasado como primer parámetro:

.. literalinclude:: model/006.php

El valor se devuelve en el formato especificado en `$returnType`_.

Puede especificar más de una fila para devolver pasando una matriz de valores de clave primaria en su lugar.
de solo uno:

.. literalinclude:: model/007.php

.. note:: If no parameters are passed in, ``find()`` will return all rows in that model's table,
    actuando efectivamente como ``findAll()``, aunque menos explícito.

findColumn()
------------

Devuelve nulo o una matriz indexada de valores de columna:

.. literalinclude:: model/008.php

``$column_name`` debe ser el nombre de una sola columna; de lo contrario, obtendrá la ``DataException``.

findAll()
---------

Devuelve todos los resultados:

.. literalinclude:: model/009.php

Esta consulta se puede modificar intercalando comandos del Generador de consultas según sea necesario antes de llamar a este método:

.. literalinclude:: model/010.php

Puede pasar valores de límite y compensación como el primero y el segundo
parámetros, respectivamente:

.. literalinclude:: model/011.php

first()
-------

Devuelve la primera fila del conjunto de resultados. Es mejor utilizarlo en combinación con el generador de consultas.

.. literalinclude:: model/012.php

withDeleted()
-------------

Si `$useSoftDeletes`_ es verdadero, entonces los métodos **find*()** no devolverán ninguna fila donde ``deleted_at NO ES NULO``.
Para anular esto temporalmente, puede utilizar el método ``withDeleted()`` antes de llamar al método **find*()**.

.. literalinclude:: model/013.php

onlyDeleted()
-------------

Mientras que ``withDeleted()`` devolverá filas eliminadas y no eliminadas, este método modifica
los siguientes métodos **find*()** para devolver solo filas eliminadas temporalmente:

.. literalinclude:: model/014.php

Guardar datos
=============

insert()
--------

El primer parámetro es una matriz asociativa de datos para crear una nueva fila de datos en la base de datos.
Si se pasa un objeto en lugar de una matriz, intentará convertirlo en una matriz.

Las claves de la matriz deben coincidir con el nombre de las columnas en `$table`_, mientras que los valores de la matriz son los valores que se guardarán para esa clave.

El segundo parámetro opcional es de tipo booleano y, si se establece en falso, el método devolverá un valor booleano.
que indica el éxito o fracaso de la consulta.

Puede recuperar la clave principal de la última fila insertada utilizando el método ``getInsertID()``.

.. literalinclude:: model/015.php

.. _model-allow-empty-inserts:

allowEmptyInserts()
-------------------

.. versionadded:: 7.0.0

Puede utilizar el método ``allowEmptyInserts()`` para insertar datos vacíos. El modelo genera una excepción cuando intenta insertar datos vacíos de forma predeterminada. Pero si llama a este método, la verificación ya no se realizará.

.. literalinclude:: model/056.php

También puede cambiar esta configuración con la propiedad `$allowEmptyInserts`_.

Puede habilitar la verificación nuevamente llamando a ``allowEmptyInserts(false)``.

update()
--------

Actualiza un registro existente en la base de datos. El primer parámetro es `$primaryKey`_ del registro a actualizar.
Se pasa una matriz asociativa de datos a este método como segundo parámetro. Las claves de la matriz deben coincidir con el nombre.
de las columnas en una `$table`_, mientras que los valores de la matriz son los valores a guardar para esa clave:

.. literalinclude:: model/016.php

.. important:: Since v7.3.0, this method raises a ``DatabaseException``
    si genera una declaración SQL sin una cláusula WHERE.
    En versiones anteriores, si se llama sin `$primaryKey`_ especificada y
    se generó una declaración SQL sin una cláusula WHERE, la consulta aún
    ejecutar y todos los registros de la tabla se actualizarán.

Se pueden actualizar varios registros con una sola llamada pasando una matriz de claves primarias como primer parámetro:

.. literalinclude:: model/017.php

Cuando necesite una solución más flexible, puede dejar los parámetros vacíos y funciona como el Generador de consultas.
comando de actualización, con el beneficio adicional de validación, eventos, etc.:

.. literalinclude:: model/018.php

.. _model-save:

save()
------

Este es un contenedor de los métodos ``insert()`` y ``update()`` que manejan la inserción o actualización del registro.
automáticamente, en función de si encuentra una clave de matriz que coincida con el valor de **clave principal**:

.. literalinclude:: model/019.php

El método save también puede simplificar mucho el trabajo con objetos de resultados de clases personalizados al reconocer un objeto no simple.
objeto y tomando sus valores públicos y protegidos en una matriz, que luego se pasa al directorio apropiado
método de inserción o actualización. Esto le permite trabajar con clases de Entidad de una manera muy limpia. Las clases de entidad son
clases simples que representan una única instancia de un tipo de objeto, como un usuario, una publicación de blog, trabajo, etc.
La clase es responsable de mantener la lógica de negocios que rodea al objeto en sí, como el formateo.
elementos de cierta manera, etc. No deberían tener idea de cómo se guardan en la base de datos. En su
más simples, podrían verse así:

.. literalinclude:: model/020.php

Un modelo muy sencillo con el que trabajar podría verse así:

.. literalinclude:: model/021.php

Este modelo funciona con datos de la tabla ``jobs`` y devuelve todos los resultados como una instancia de ``App\Entities\Job``.
Cuando necesite conservar ese registro en la base de datos, deberá escribir métodos personalizados o utilizar el
método ``save()`` del modelo para inspeccionar la clase, tomar las propiedades públicas y privadas y guardarlas en la base de datos:

.. literalinclude:: model/022.php

.. note:: If you find yourself working with Entities a lot, Higgs provides a built-in :doc:`Entity class </models/entities>`
    que proporciona varias funciones útiles que simplifican el desarrollo de entidades.

Eliminar datos
==============

delete()
--------

Toma un valor de clave principal como primer parámetro y elimina el registro coincidente de la tabla del modelo:

.. literalinclude:: model/023.php

Si el valor `$useSoftDeletes`_ del modelo es verdadero, esto actualizará la fila para establecer ``deleted_at`` en el valor actual.
fecha y hora. Puede forzar una eliminación permanente configurando el segundo parámetro como verdadero.

Se puede pasar una matriz de claves primarias como primer parámetro para eliminar varios registros a la vez:

.. literalinclude:: model/024.php

Si no se pasan parámetros, actuará como el método de eliminación del Generador de consultas, lo que requerirá una llamada a dónde.
previamente:

.. literalinclude:: model/025.php

purgeDeleted()
--------------

Limpia la tabla de la base de datos eliminando permanentemente todas las filas que tienen 'deleted_at IS NOT NULL'.

.. literalinclude:: model/026.php

.. _in-model-validation:

Validación en el modelo
=======================

Validación de datos
---------------

Para muchas personas, validar los datos en el modelo es la forma preferida de garantizar que los datos se mantengan en un único
estándar, sin duplicar código. La clase Modelo proporciona una manera de validar automáticamente todos los datos.
antes de guardar en la base de datos con los métodos ``insert()``, ``update()`` o ``save()``.

.. important:: When you update data, by default, the validation in the model class only
    valida los campos proporcionados. Esto es para evitar errores de validación al actualizar solo algunos campos.

    Pero esto significa que las reglas ``obligatorias*`` no funcionan como se esperaba al actualizar.
    Si desea verificar los campos obligatorios, puede cambiar el comportamiento mediante configuración.
    Consulte :ref:`clean-validation-rules` para obtener más detalles.

Establecer reglas de validación
------------------------

El primer paso es completar la propiedad de clase `$validationRules`_ con los campos y reglas que deben
se aplicado. Si tiene mensajes de error personalizados que desea utilizar, colóquelos en la matriz `$validationMessages`_:

.. literalinclude:: model/027.php

Si prefiere organizar sus reglas y mensajes de error dentro del archivo de configuración de Validación, puede hacerlo
y simplemente establezca `$validationRules`_ con el nombre del grupo de reglas de validación que creó:

.. literalinclude:: model/034.php

La otra forma de establecer las reglas de validación de campos por funciones,

.. php:namespace:: Higgs

.. php:class:: Model

.. php:method:: setValidationRule($field, $fieldRules)

    :param  string $campo:
    :param matriz $fieldRules:

    Esta función establecerá las reglas de validación del campo.

    Ejemplo de uso:

    .. literalinclude:: model/028.php

.. php:method:: setValidationRules($validationRules)

    :matriz de parámetros $reglas de validación:

    Esta función establecerá las reglas de validación.

    Ejemplo de uso:

    .. literalinclude:: model/029.php

La otra forma de configurar el mensaje de validación de campos por funciones,

.. php:method:: setValidationMessage($field, $fieldMessages)

    :param  string $campo:
    :param matriz $fieldMessages:

    Esta función establecerá los mensajes de error de campo.

    Ejemplo de uso:

    .. literalinclude:: model/030.php

.. php:method:: setValidationMessages($fieldMessages)

    :param matriz $fieldMessages:

    Esta función configurará los mensajes de campo.

    Ejemplo de uso:

    .. literalinclude:: model/031.php

Obtener el resultado de la validación
-------------------------

Ahora, cada vez que llame a los métodos ``insert()``, ``update()`` o ``save()``, los datos serán validados. Si falla,
el modelo devolverá un valor booleano **falso**.

.. _model-getting-validation-errors:

Obtener errores de validación
-------------------------

Puede utilizar el método ``errors()`` para recuperar los errores de validación:

.. literalinclude:: model/032.php

Esto devuelve una matriz con los nombres de los campos y sus errores asociados que se puede usar para mostrar todos los
errores en la parte superior del formulario, o para mostrarlos individualmente:

.. literalinclude:: model/033.php

Recuperar reglas de validación
---------------------------

Puede recuperar las reglas de validación de un modelo accediendo a sus ``validationRules``
propiedad:

.. literalinclude:: model/035.php

También puede recuperar solo un subconjunto de esas reglas llamando al descriptor de acceso
método directamente, con opciones:

.. literalinclude:: model/036.php

El parámetro ``$options`` es una matriz asociativa con un elemento,
cuya clave es ``'excepto'`` o ``'solo'``, y que tiene como
valorar una serie de nombres de campos de interés:

.. literalinclude:: model/037.php

Marcadores de posición de validación
-----------------------

El modelo proporciona un método simple para reemplazar partes de sus reglas en función de los datos que se le pasan. Este
Suena bastante oscuro pero puede ser especialmente útil con la regla de validación ``is_unique``. Los marcadores de posición son simplemente
el nombre del campo (o clave de matriz) que se pasó como ``$data`` entre llaves. Será
reemplazado por el **valor** del campo entrante coincidente. Un ejemplo debería aclarar esto:

.. literalinclude:: model/038.php

.. note:: Since v7.3.5, you must set the validation rules for the placeholder
    campo (``id``).

En este conjunto de reglas, se establece que la dirección de correo electrónico debe ser única en la base de datos, excepto en la fila
que tiene una identificación que coincide con el valor del marcador de posición. Suponiendo que los datos del formulario POST tuvieran lo siguiente:

.. literalinclude:: model/039.php

entonces el marcador de posición ``{id}`` se reemplazaría con el número **4**, dando esta regla revisada:

.. literalinclude:: model/040.php

Por lo tanto, ignorará la fila en la base de datos que tiene ``id=4`` cuando verifique que el correo electrónico sea único.

.. note:: Since v7.3.5, if the placeholder (``id``) value does not pass the
    validación, el marcador de posición no sería reemplazado.

Esto también se puede utilizar para crear reglas más dinámicas en tiempo de ejecución, siempre y cuando tenga cuidado de que cualquier dinámica
Las claves pasadas no entran en conflicto con los datos de su formulario.

Protegiendo campos
==================

Para ayudar a protegerse contra ataques de asignación masiva, la clase Modelo **requiere** que enumere todos los nombres de los campos.
que se puede cambiar durante las inserciones y actualizaciones en la propiedad de clase `$allowedFields`_. Cualquier dato proporcionado
Además, estos se eliminarán antes de llegar a la base de datos. Esto es excelente para garantizar que las marcas de tiempo,
o las claves primarias no se cambian.

.. literalinclude:: model/041.php

Ocasionalmente, encontrarás ocasiones en las que necesitarás poder cambiar estos elementos. Esto ocurre a menudo durante
pruebas, migraciones o semillas. En estos casos, puedes activar o desactivar la protección:

.. literalinclude:: model/042.php

Cambios en el tipo de devolución en tiempo de ejecución
=======================================================

Puede especificar el formato en el que se deben devolver los datos cuando se utilizan los métodos **find*()** como propiedad de clase,
`$tiporetorno`_. Sin embargo, es posible que en ocasiones desees recibir los datos en un formato diferente. El modelo
proporciona métodos que le permiten hacer precisamente eso.

.. note:: These methods only change the return type for the next **find*()** method call. After that,
    se restablece a su valor predeterminado.

asArray()
---------

Devuelve datos del siguiente método **find*()** como matrices asociativas:

.. literalinclude:: model/047.php

asObject()
----------

Devuelve datos del siguiente método **find*()** como objetos estándar o instancias de clase personalizadas:

.. literalinclude:: model/048.php

Procesamiento de grandes cantidades de datos
============================================

A veces, es necesario procesar grandes cantidades de datos y se corre el riesgo de quedarse sin memoria.
Para simplificar esto, puede utilizar el método chunk() para obtener fragmentos de datos más pequeños que luego pueda
haz tu trabajo. El primer parámetro es el número de filas que se recuperarán en un solo fragmento. El segundo
El parámetro es un cierre que se llamará para cada fila de datos.

Esto se utiliza mejor durante cronjobs, exportaciones de datos u otras tareas grandes.

.. literalinclude:: model/049.php

.. _model-events-callbacks:

Trabajar con el generador de consultas
**************************************

Obteniendo el generador de consultas para la tabla del modelo
=============================================================

El modelo Higgs tiene una instancia del Generador de consultas para la conexión de base de datos de ese modelo.
Puede obtener acceso a la instancia **compartida** del Generador de consultas en cualquier momento que lo necesite:

.. literalinclude:: model/043.php

Este constructor ya está configurado con la `$table`_ del modelo.

.. note:: Once you get the Query Builder instance, you can call methods of the
    :doc:`Generador de consultas <../database/query_builder>`.
    Sin embargo, dado que Query Builder no es un modelo, no puede llamar a métodos del modelo.

Obtener el generador de consultas para otra tabla
=================================================

Si necesita acceso a otra tabla, puede obtener otra instancia del Generador de consultas.
Pase el nombre de la tabla como parámetro, pero tenga en cuenta que esto **no** devolverá
una instancia compartida:

.. literalinclude:: model/044.php

Métodos combinados de generador de consultas y modelo
=====================================================

También puede utilizar los métodos del Generador de consultas y los métodos CRUD del modelo en la misma llamada encadenada, lo que permite
uso muy elegante:

.. literalinclude:: model/045.php

En este caso, opera en la instancia compartida del Generador de consultas que posee el modelo.

.. important:: The Model does not provide a perfect interface to the Query Builder.
    El modelo y el generador de consultas son clases separadas con propósitos diferentes.
    No se debe esperar que devuelvan los mismos datos.

Si el Generador de consultas devuelve un resultado, se devuelve tal cual.
En ese caso, el resultado puede ser diferente al devuelto por el método del modelo.
y puede que no sea lo que se esperaba. Los eventos del modelo no se activan.

Para evitar comportamientos inesperados, no utilice métodos del Generador de consultas que devuelvan resultados.
y especifique el método del modelo al final del encadenamiento de métodos.

.. note:: You can also access the model's database connection seamlessly:

    .. literalinclude:: model/046.php

.. _model-events:

Eventos modelo
**************

Hay varios puntos dentro de la ejecución del modelo en los que puede especificar múltiples métodos de devolución de llamada para ejecutar.
Estos métodos se pueden utilizar para normalizar datos, hacer hash de contraseñas, guardar entidades relacionadas y mucho más.

La siguiente
Los puntos en la ejecución del modelo pueden verse afectados, cada uno a través de una propiedad de clase:

- `$antes de Insertar`_, `$después de Insertar`_
- `$antes de la actualización`_, `$después de la actualización`_
- `$antes de buscar`_, `$después de buscar`_
- `$antes de eliminar`_, `$después de eliminar`_
- `$antes de InsertarBatch`_, `$después de InsertarBatch`_
- `$antes de ActualizarBatch`_, `$después de ActualizarBatch`_

.. note:: ``$beforeInsertBatch``, ``$afterInsertBatch``, ``$beforeUpdateBatch`` and
    ``$afterUpdateBatch`` se puede utilizar desde la versión 7.0.0.

Definición de devoluciones de llamada
=====================================

Usted especifica las devoluciones de llamada creando primero un nuevo método de clase en su modelo para usar.

Este método de clase siempre recibirá una matriz ``$data`` como único parámetro.

El contenido exacto de la matriz ``$data`` variará entre eventos, pero siempre
contener una clave llamada ``datos`` que contiene los datos primarios pasados al original
método. En el caso de los métodos **insert*()** o **update*()**, eso será
los pares clave/valor que se están insertando en la base de datos. Los ``$datos`` principales
La matriz también contendrá los otros valores pasados al método y se detallará.
en `Parámetros de evento`_.

El método de devolución de llamada debe devolver la matriz ``$data`` original para que otras devoluciones de llamada
tener la información completa.

.. literalinclude:: model/050.php

Especificación de devoluciones de llamada para ejecutar
=======================================================

Usted especifica cuándo ejecutar las devoluciones de llamada agregando el nombre del método a la propiedad de clase apropiada (`$beforeInsert`_, `$afterUpdate`_,
etc). Se pueden agregar varias devoluciones de llamada a un solo evento y se procesarán una tras otra. Puede
use la misma devolución de llamada en múltiples eventos:

.. literalinclude:: model/051.php

Además, cada modelo puede permitir (predeterminado) o denegar devoluciones de llamada en toda la clase configurando su propiedad `$allowCallbacks`_:

.. literalinclude:: model/052.php

También puedes cambiar esta configuración temporalmente para una llamada de modelo único usando el método ``allowCallbacks()``:

.. literalinclude:: model/053.php

Parámetros del evento
=====================

Dado que los datos exactos pasados a cada devolución de llamada varían un poco, aquí están los detalles sobre lo que hay en el parámetro ``$data``
pasado a cada evento:
=================== =============================================================================================================
Evento              $datos contenidos
=================== =============================================================================================================
beforeInsert        **datos** = los pares clave/valor que se están insertando. Si un objeto o clase de entidad se pasa al
                    Método ``insert()``, primero se convierte en una matriz.
afterInsert         **id** = la clave principal de la nueva fila, o 0 en caso de error.
                    **datos** = los pares clave/valor que se insertan.
                    **resultado** = los resultados del método ``insert()`` utilizado a través del Generador de consultas.
beforeUpdate        **id** = la matriz de claves principales de las filas que se actualizan.
                    **datos** = los pares clave/valor que se están actualizando. Si un objeto o clase de entidad se pasa al
                    Método ``update()``, primero se convierte en una matriz.
afterUpdate         **id** = la matriz de claves principales de las filas que se actualizan.
                    **datos** = los pares clave/valor que se actualizan.
                    **resultado** = los resultados del método ``update()`` utilizado a través del Generador de consultas.
beforeFind          El nombre del **método** que realiza la llamada, si se solicitó un **singleton** y estos campos adicionales:
                    - ``first()`` Sin campos adicionales
                    - ``find()`` **id** = la clave principal de la fila que se busca.
                    - ``findAll()`` **límite** = el número de filas a buscar.
                    **desplazamiento** = el número de filas que se omitirán durante la búsqueda.
afterFind           Igual que **beforeFind** pero incluye las filas de datos resultantes, o nulo si no se encuentra ningún resultado.
beforeDelete        **id** = clave principal de la fila que se pasa al método ``delete()``.
                    **purgar** = booleano si las filas de eliminación temporal deben eliminarse definitivamente.
afterDelete         **id** = clave principal de la fila que se pasa al método ``delete()``.
                    **purgar** = booleano si las filas de eliminación temporal deben eliminarse definitivamente.
                    **resultado** = el resultado de la llamada ``delete()`` en el Generador de consultas.
                    **datos** = sin usar.
beforeInsertBatch   **data** = matriz asociativa de valores que se están insertando. Si un objeto o clase de entidad se pasa al
                    Método ``insertBatch()``, primero se convierte en una matriz.
afterInsertBatch    **data** = la matriz asociativa de valores que se insertan.
                    **resultado** = los resultados del método ``insertbatch()`` utilizado a través del Generador de consultas.
beforeUpdateBatch   **data** = matriz asociativa de valores que se están actualizando. Si un objeto o clase de entidad se pasa al
                    Método ``updateBatch()``, primero se convierte en una matriz.
afterUpdateBatch    **datos** = los pares clave/valor que se actualizan.
                    **resultado** = los resultados del método ``updateBatch()`` utilizado a través del Generador de consultas.
=================== =============================================================================================================

Modificación de datos de búsqueda*
==================================

Los métodos ``beforeFind`` y ``afterFind`` pueden devolver un conjunto de datos modificado para anular la respuesta normal.
del modelo. Para ``afterFind``, cualquier cambio realizado en ``data`` en la matriz de retorno se devolverá automáticamente
al contexto de llamada. Para que ``beforeFind`` intercepte el flujo de trabajo de búsqueda, también debe devolver un
booleano, ``datosderetorno``:

.. literalinclude:: model/054.php

Creación manual de modelos
**************************

No es necesario ampliar ninguna clase especial para crear un modelo para su aplicación. Todo lo que necesitas es conseguir un
instancia de la conexión de la base de datos y listo. Esto le permite evitar las características de Higgs.
Model le ofrece soluciones listas para usar y crea una experiencia totalmente personalizada.

.. literalinclude:: model/055.php
