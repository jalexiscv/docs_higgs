Configuración de actualización
##############################

.. contents::
    :local:
    :depth: 2

Documentaciones
===============

- `Documentación de configuración Higgs 3.X<http://Higgs.com/userguide3/libraries/config.html>` _
- :doc:`Documentación de configuración Higgs.X</general/configuration>`

¿Qué ha sido cambiado?
======================

- En H4, las configuraciones ahora se almacenan en clases que extienden ``Higgs\Config\BaseConfig``.
- La **application/config/config.php** en H3 será **app/Config/App.php**
  y algunos otros archivos como **app/Config/Security.php** para las clases específicas.
- Dentro de la clase de configuración, los valores de configuración se almacenan en propiedades de clase pública.
- Se ha cambiado el método para recuperar los valores de configuración.

Guía de actualización
=====================

1. Debe cambiar los valores en los archivos de configuración predeterminados de H4 de acuerdo con el
   cambios en los archivos H3. Los nombres de las configuraciones son prácticamente los mismos que en H3.
2. Si está utilizando archivos de configuración personalizados en su proyecto H3, debe crearlos
   archivos como nuevas clases PHP en su proyecto H4 en **app/Config**. estas clases
   debe estar en el espacio de nombres ``Config`` y debe extender ``Higgs\Config\BaseConfig``.
3. Una vez que haya creado todas las clases de configuración personalizadas, debe copiar las variables.
   desde la configuración H3 a la nueva clase de configuración H4 como propiedades de clase pública.
4. Ahora, debe cambiar la sintaxis de recuperación de configuración en todos los lugares donde obtenga la configuración.
   valores. La sintaxis de H3 es algo así como ``$this->config->item('item_name');``.
   Tienes que cambiar esto a ``config('MyConfig')->item_name;``.

Ejemplo de código
=================

Higgs versión 6.x
------------------------

Ruta: **application/config/site.php**:

.. literalinclude:: upgrade_configuration/ci3sample/001.php

Higgs versión 7.x
-----------------------

Ruta: **app/Config/Site.php**:

.. literalinclude:: upgrade_configuration/001.php
