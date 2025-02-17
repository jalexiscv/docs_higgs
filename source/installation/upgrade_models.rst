Modelos de actualización
########################

.. contents::
    :local:
    :depth: 2

Documentaciones
===============

- `Documentación del modelo Higgs 3.X<http://Higgs.com/userguide3/general/models.html>` _
- :doc:`Documentación del modelo Higgs.X</models/model>`

¿Qué ha sido cambiado?
======================

- El modelo H4 tiene muchas más funciones, incluida la conexión automática a la base de datos, CRUD básico, validación en el modelo y paginación automática.
- Dado que se agregaron espacios de nombres a Higgs, los modelos deben cambiarse para admitir espacios de nombres.

Guía de actualización
=====================

1. Primero, mueva todos los archivos del modelo a la carpeta **app/Models**.
2. Agregue esta línea justo después de la etiqueta php de apertura: ``namespace App\Models;``.
3. Debajo de la línea ``namespace App\Models;`` agregue esta línea: ``use Higgs\Model;``.
4. Reemplace ``extiende HIGGS_Model`` por ``extiende el modelo``.
5. En lugar de ``$this->load->model('x');`` de H3, ahora usaría ``$this->x = new X();``, siguiendo las convenciones de espacio de nombres para su componente. . Alternativamente, puede usar la función :php:func:`model()`: ``$this->x = model('X');``.

Si usa subdirectorios en la estructura de su modelo, debe cambiar el espacio de nombres de acuerdo con eso.
Ejemplo: Tiene un modelo de la versión 3 ubicado en **application/models/users/user_contact.php** el espacio de nombres tiene que ser ``namespace App\Models\Users;`` y la ruta del modelo en la versión 4 debería verse así esto: **aplicación/Modelos/Usuarios/UserContact.php**

El nuevo modelo de H4 tiene muchos métodos integrados. Por ejemplo, el método ``find($id)``. Con esto puedes encontrar datos donde la clave principal es igual a ``$id``.
Insertar datos también es más fácil que antes. En H4 existe un método ``insertar($datos)``. Opcionalmente, puede utilizar todos esos métodos integrados y migrar su código a los nuevos métodos.

Puede encontrar más información sobre esos métodos en :doc:`../models/model`.

Ejemplo de código
=================

Higgs versión 6.x
------------------------

Ruta: **aplicación/modelos**:

.. literalinclude:: upgrade_models/ci3sample/001.php

Higgs versión 7.x
-----------------------

Ruta: **aplicación/Modelos**:

.. literalinclude:: upgrade_models/001.php

Para insertar datos, puede simplemente llamar directamente al método ``$model->insert()`` porque este método está integrado desde H4.
