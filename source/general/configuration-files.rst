########################################
Trabajando con Archivos de Configuración
########################################

Obtener un Objeto de Configuración
==================================

Puedes acceder a los archivos de configuración para tus clases de varias maneras.

new keyword
-----------

Usando la palabra clave ``new`` para crear una instancia:

.. literalinclude:: configuration/001.php

.. _configuration-config:

config()
--------

Usando la función :php:func:`config()`:

.. literalinclude:: configuration/002.php

Si no se proporciona un espacio de nombres, buscará el archivo primero en la carpeta **app/Config** y, si no se encuentra, buscará en la carpeta **Config** en todos los espacios de nombres definidos.

Todos los archivos de configuración que vienen con Higgs tienen el espacio de nombres ``Config``. Usar este espacio de nombres en tu aplicación proporcionará el mejor rendimiento ya que sabe exactamente dónde encontrar los archivos.

.. note:: Antes de la versión v7.4.0, ``config()`` encuentra el archivo en **app/Config/** cuando hay una clase con el mismo nombre corto, incluso si especificas un nombre de clase completamente calificado como ``config(\Acme\Blog\Config\Blog::class)``. Este comportamiento se ha corregido en la versión v7.4.0 y devuelve la instancia especificada.

Obtener una Propiedad de Configuración
======================================

Todas las propiedades del objeto de configuración son públicas, por lo que puedes acceder a los ajustes como cualquier otra propiedad:

.. literalinclude:: configuration/003.php

Crear Archivos de Configuración
*******************************

Cuando necesites una nueva configuración, primero crea un nuevo archivo en la ubicación deseada. La ubicación predeterminada del archivo (recomendada para la mayoría de los casos) es **app/Config**.

Puedes colocar archivos de configuración en cualquier carpeta **Config** usando un espacio de nombres diferente.

La clase debe usar el espacio de nombres apropiado y debe extender ``Higgs\Config\BaseConfig`` para asegurarse de que pueda recibir configuraciones específicas del entorno.

Define la clase y llénala con propiedades públicas que representen tus ajustes:

.. literalinclude:: configuration/004.php