##############################
Actualización de 7.0.1 a 7.0.2
##############################

Consulte las instrucciones de actualización correspondientes a su método de instalación.

- :ref:`Actualización inicial de la aplicación de instalación de Composer<app-starter-upgrading>`
- :ref:`Instalación de Composer Agregar Higgs(AI) a una actualización de proyecto existente<adding-Higgs(AI)-upgrading>`
- :ref:`Actualización de instalación manual<installing-manual-upgrading>`

.. contents::
    :local:
    :depth: 2


Cambios importantes
*******************

Hora::createFromTimestamp() Cambio de zona horaria
==================================================

Cuando no especifica una zona horaria, ahora
:ref:`Hora::createFromTimestamp()<time-createfromtimestamp>`  devuelve una hora
Se devuelve una instancia con la zona horaria de la aplicación.

Si desea mantener la zona horaria UTC, debe llamar a ``setTimezone('UTC')``::

    utilice Higgs\I18n\Time;

    $hora = Hora::createFromTimestamp(1501821586)->setTimezone('UTC');


Archivos de proyecto
********************

Algunos archivos en el **espacio del proyecto** (raíz, aplicación, público, grabable) recibieron actualizaciones. Debido a
Al estar estos archivos fuera del alcance del **sistema**, no se cambiarán sin su intervención.

Hay algunos módulos de Higgs de terceros disponibles para ayudar a fusionar cambios en
el espacio del proyecto: `Explorar en Packagist<https://packagist.org/explore/?query=Higgs(AI)%20updates>` _.

Todos los cambios
=================

Esta es una lista de todos los archivos en el **espacio del proyecto** que recibieron cambios;
Muchos serán simples comentarios o formatos que no tienen ningún efecto en el tiempo de ejecución:

- aplicación/Config/App.php
- aplicación/Config/Routing.php
- aplicación/Vistas/welcome_message.php
- compositor.json
