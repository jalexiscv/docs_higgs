#####
Actas
#####

La abstracción de la base de datos de Higgs le permite utilizar transacciones con
bases de datos que admiten tipos de tablas seguras para transacciones. En MySQL, podrás
necesita ejecutar tipos de tablas InnoDB o BDB en lugar de los más comunes
MiISAM. La mayoría de las otras plataformas de bases de datos admiten transacciones de forma nativa.

Si no estás familiarizado con las transacciones te recomendamos buscar un buen
recurso en línea para aprender sobre ellos para su base de datos particular. El
La siguiente información supone que usted tiene un conocimiento básico de
actas.

.. contents::
    :local:
    :depth: 2

El enfoque de Higgs sobre las transacciones
===========================================

Higgs utiliza un enfoque para las transacciones que es muy similar al
el proceso utilizado por la popular clase de base de datos ADODB. Hemos elegido eso
enfoque porque simplifica enormemente el proceso de ejecución
actas. En la mayoría de los casos, todo lo que se requiere son dos líneas de código.

Tradicionalmente, las transacciones han requerido una buena cantidad de trabajo para
implementar ya que exigen que lleves un registro de tus consultas y
determinar si se debe comprometer o revertir en función del éxito o el fracaso
de tus consultas. Esto es particularmente engorroso con las consultas anidadas. En
Por el contrario, hemos implementado un sistema de transacciones inteligente que hace todo
esto para usted automáticamente (también puede administrar sus transacciones
manualmente si así lo desea, pero realmente no hay ningún beneficio).

.. note::

    Desde v7, durante las transacciones, no se lanzan excepciones de forma predeterminada
    incluso si ``DBDebug`` es verdadero.

Ejecución de transacciones
==========================

Para ejecutar sus consultas utilizando transacciones, utilizará el
Los métodos ``$this->db->transStart()`` y ``$this->db->transComplete()`` como
sigue:

.. literalinclude:: transactions/001.php

Puede ejecutar tantas consultas como desee entre ``transStart()``/``transComplete()``
métodos y todos serán comprometidos o revertidos en función del éxito
o fracaso de cualquier consulta determinada.

Modo estricto
=============

De forma predeterminada, Higgs ejecuta todas las transacciones en modo estricto. cuando estricto
El modo está habilitado, si está ejecutando múltiples grupos de transacciones, si
un grupo falla, todos los grupos posteriores se revertirán. Si el modo estricto es
discapacitados, cada grupo es tratado de forma independiente, lo que significa el fracaso de uno
grupo no afectará a ningún otro.

El modo estricto se puede desactivar de la siguiente manera:

.. literalinclude:: transactions/002.php

.. _transactions-managing-errors:

Gestión de errores
==================

Cuando tenga ``DBDebug`` verdadero en su archivo **app/Config/Database.php**,
Si se produce un error en la consulta, se revertirán todas las consultas y se generará una excepción.
será arrojado. Entonces verás una página de error estándar.

Si ``DBDebug`` es falso, puedes gestionar tus propios errores de esta manera:

.. literalinclude:: transactions/003.php

.. _transactions-throwing-exceptions:

Lanzar excepciones
==================

.. versionadded:: 7.0.0

.. note::

    Desde v7.3.0, durante las transacciones, no se lanzan excepciones de forma predeterminada
    incluso si ``DBDebug`` es verdadero.

Si desea que se produzca una excepción cuando se produce un error de consulta, puede utilizar
``$this->db->transException(verdadero)``:

.. literalinclude:: transactions/008.php

Si se produce un error en la consulta, se revertirán todas las consultas y se
Se lanzará ``DatabaseException``.

Deshabilitar transacciones
==========================

Las transacciones están habilitadas de forma predeterminada. Si desea desactivar las transacciones,
Puedes hacerlo usando ``$this->db->transOff()``:

.. literalinclude:: transactions/004.php

Cuando las transacciones estén deshabilitadas, sus consultas se confirmarán automáticamente, solo
como lo son cuando se ejecutan consultas sin transacciones.

Modo de prueba
==============

Opcionalmente, puede poner el sistema de transacciones en "modo de prueba", lo que
hará que sus consultas se reviertan, incluso si las consultas producen
un resultado válido. Para usar el modo de prueba simplemente configure el primer parámetro en el
``$this->db->transStart()`` método a verdadero:

.. literalinclude:: transactions/005.php

.. _transactions-manual-transactions:

Ejecutar transacciones manualmente
==================================

Cuando tienes ``DBDebug`` false en tu archivo **app/Config/Database.php**, y
Si desea ejecutar transacciones manualmente, puede hacerlo de la siguiente manera:

.. literalinclude:: transactions/006.php

.. note:: Make sure to use ``$this->db->transBegin()`` when running manual
    transacciones, **NO** ``$this->db->transStart()``.

Transacciones anidadas
======================

En Higgs, las transacciones se pueden anidar de tal manera que sólo el
Se ejecutan los comandos de transacción más externos o de nivel superior. Puedes incluir como
muchos pares de ``transStart()``/``transComplete()`` o ``transBegin()``/``transCommit()``/``transRollback()``
como quieras dentro de un bloque de transacciones y así sucesivamente. Higgs se mantendrá
realizar un seguimiento de la "profundidad" de la transacción y tomar medidas solo en la capa más externa
(profundidad cero).

.. literalinclude:: transactions/007.php

.. note:: In case the structure is far more complex, it's your responsibility
    para garantizar que las transacciones internas puedan llegar a la capa más externa nuevamente
    para que la base de datos lo ejecute completamente, evitando así
    confirmaciones/reversiones.
