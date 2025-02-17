#############
Registradores
#############

Los "Registradores" son cualquier otra clase que pueda proporcionar propiedades de configuración adicionales.
Los registradores proporcionan un medio para modificar una configuración en tiempo de ejecución en espacios de nombres y archivos.

Los registradores funcionan si :ref:`auto-discovery` está habilitado en :doc:`Modules </general/modules>`.
Altera las propiedades de configuración cuando se crea una instancia del objeto Config.

Hay dos formas de implementar un Registrador: **implícito** y **explícito**.

.. nota:: Los valores de **.env** siempre tienen prioridad sobre los Registradores.

Registradores implícitos
====================

Los registradores implícitos pueden cambiar cualquier propiedad de la clase de configuración.

Cualquier espacio de nombres puede definir registradores implícitos utilizando **Config/Registrar.php**
archivo. Estos archivos son clases cuyos métodos se nombran para cada clase de configuración.
desea ampliar.

Por ejemplo, un módulo de terceros o un paquete Composer podría
desea proporcionar una plantilla adicional a ``Config\Pager`` sin sobrescribir lo que tenga un desarrollador
ya configurado. En **src/Config/Registrar.php** habría una clase ``Registrar`` con
el método único ``Pager()`` (tenga en cuenta la distinción entre mayúsculas y minúsculas):

.. literalinclude:: configuration/007.php

Los métodos de registro siempre deben devolver una matriz, con claves correspondientes a las propiedades
del archivo de configuración de destino. Los valores existentes se fusionan y las propiedades del registrador tienen
prioridad de sobrescritura.

Registradores explícitos
====================

Los registradores explícitos solo pueden cambiar las propiedades de la clase de configuración en la que están
registrado.

Un archivo de configuración también puede especificar explícitamente cualquier número de registradores.
Esto se hace agregando una propiedad ``$registrars`` a su archivo de configuración,
que contiene una serie de nombres de registradores candidatos:

.. literalinclude:: configuration/008.php

Para actuar como "registrador", las clases así identificadas deben tener un
función estática con el mismo nombre que la clase de configuración, y debería devolver un valor asociativo
conjunto de configuraciones de propiedades.

Cuando se crea una instancia de su objeto de configuración, recorrerá el
clases designadas en ``$registrars``. Para cada una de estas clases invocará
el método nombrado para la clase de configuración e incorporar las propiedades devueltas.

Un ejemplo de configuración de clase para esto:

.. literalinclude:: configuration/009.php

... y el modelo de ventas regional asociado podría verse así:

.. literalinclude:: configuration/010.php

Con el ejemplo anterior, cuando se crea una instancia de ``MySalesConfig``, terminará con
las tres propiedades declaradas, pero el valor de la propiedad ``$target`` será anulado
al tratar a ``regionalSales`` como un "registrador". Las propiedades de configuración resultantes:

.. literalinclude:: configuration/011.php