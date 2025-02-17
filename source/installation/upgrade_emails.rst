Actualizar correos electrónicos
###############################

.. contents::
    :local:
    :depth: 2

Documentaciones
===============

- `Documentación por correo electrónico Higgs 3.X<http://Higgs.com/userguide3/libraries/email.html>` _
- :doc:`Documentación por correo electrónico Higgs.X</libraries/email>`

¿Qué ha sido cambiado?
======================
- Sólo han cambiado pequeñas cosas como los nombres de los métodos y la carga de la biblioteca.
- Se ha modificado ligeramente el comportamiento al utilizar el protocolo SMTP. Es posible que no pueda comunicarse correctamente con su servidor SMTP si utiliza la configuración H3. Consulte :ref:`email-ssl-tls-for-smtp` y :ref:`email-preferences`.

Guía de actualización
=====================
1. Dentro de su clase cambie ``$this->load->library('email');`` a ``$email = service('email');``.
2. A partir de ahí, debes reemplazar cada línea que comience con ``$this->email`` por ``$email``.
3. Los métodos de la clase Correo electrónico tienen nombres ligeramente diferentes. Todos los métodos, excepto ``send()``, ``attach()``, ``printDebugger()`` y ``clear()`` tienen un prefijo ``set`` seguido del método anterior. nombre. ``bcc()`` ahora es ``setBcc()`` y así sucesivamente.
4. Los atributos de configuración en **app/Config/Email.php** han cambiado. Debería echar un vistazo a :ref:`setting-email-preferences` para tener una lista de los nuevos atributos.

Ejemplo de código
=================

Higgs versión 6.x
------------------------

.. literalinclude:: upgrade_emails/ci3sample/001.php

Higgs versión 7.x
-----------------------

.. literalinclude:: upgrade_emails/001.php
