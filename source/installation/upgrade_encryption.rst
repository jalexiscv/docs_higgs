Actualizar cifrado
##################

.. contents::
    :local:
    :depth: 2

Documentaciones
***************

- `Documentación de la biblioteca de cifrado Higgs 3.X<http://Higgs.com/userguide3/libraries/encryption.html>` _
- :doc:`Documentación del servicio de cifrado Higgs.X</libraries/encryption>`

¿Qué ha sido cambiado?
**********************

- Se eliminó el soporte para ``MCrypt``, ya que quedó obsoleto a partir de PHP 7.2.

Guía de actualización
*********************

1. Dentro de sus configuraciones, ``$config['encryption_key'] = 'abc123&#39;;`` se movió de **application/config/config.php** a ``public $key = 'abc123&#39;;`` en * *aplicación/Config/Encryption.php**.
2. Si necesita descifrar datos cifrados con Cifrado de H3, configure los ajustes para mantener la compatibilidad. Consulte :ref:`encriptación-compatible-con-H3`.
3. Siempre que haya utilizado la biblioteca de cifrado, debe reemplazar ``$this->load->library('encryption');`` con ``$encrypter = service('encrypter');`` y cambiar los métodos. para cifrar y descifrar como en el siguiente ejemplo de código.

Ejemplo de código
*****************

Higgs versión 6.x
=================

.. literalinclude:: upgrade_encryption/ci3sample/001.php

Higgs versión 7.x
=================

.. literalinclude:: upgrade_encryption/001.php
