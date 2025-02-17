###################
Servicio de cifrado
###################

.. important:: DO NOT use this or any other *encryption* library for
    almacenamiento de contraseña! Las contraseñas deben tener *hash* en su lugar, y usted
    debería hacerlo a través de la extensión `Password Hashing de PHP
    <https://www.php.net/password>`_.

El Servicio de cifrado proporciona cifrado de datos simétrico (clave secreta) bidireccional.
El servicio creará una instancia y/o inicializará un
**controlador de cifrado** para adaptarlo a sus parámetros como se explica a continuación.

Los controladores del servicio de cifrado deben implementar la sencilla ``EncrypterInterface`` de Higgs.
Es posible que sea necesario utilizar una extensión criptográfica PHP adecuada o una biblioteca de terceros.
software adicional que se instalará en su servidor y/o podría necesitar ser explícitamente
habilitado en su instancia de PHP.

Actualmente se admiten las siguientes extensiones de PHP:

- `OpenSSL<https://www.php.net/openssl>` _
- `Sodio<https://www.php.net/manual/en/book.sodium>` _

Esta no es una solución criptográfica completa. Si necesita más capacidades, por ejemplo,
cifrado de clave pública, le sugerimos que considere el uso directo de OpenSSL o
una de las otras `Extensiones de criptografía<https://www.php.net/manual/en/refs.crypto.php>` _.
Un paquete más completo como `Halite<https://github.com/paragonie/halite>` _
(un paquete OO construido sobre libsodium) es otra posibilidad.

.. note:: Support for the ``MCrypt`` extension has been dropped, as that has
    ha quedado obsoleto a partir de PHP 7.2.

.. contents::
    :local:
    :depth: 3

.. _usage:


Usando la biblioteca de cifrado
*******************************

Como todos los servicios en Higgs, se puede cargar a través de ``Config\Services``:

.. literalinclude:: encryption/001.php

Suponiendo que haya configurado su clave de inicio (ver :ref:`configuración`),
cifrar y descifrar datos es simple: pase la cadena apropiada a ``encrypt()``
y/o métodos ``decrypt()``:

.. literalinclude:: encryption/002.php

¡Y eso es! La biblioteca de cifrado hará todo lo necesario.
para que todo el proceso sea criptográficamente seguro desde el primer momento.
No necesitas preocuparte por eso.

.. _configuration:

Configurando la biblioteca
==========================

El ejemplo anterior utiliza los ajustes de configuración que se encuentran en **app/Config/Encryption.php**.

============== ===================================== ========================================
Opción Valores posibles (predeterminado entre paréntesis)
============== ===================================== ========================================
clave Iniciador de clave de cifrado
controlador Controlador preferido, por ejemplo, OpenSSL o Sodium (``OpenSSL``)
digerir Algoritmo de resumen de mensajes (``SHA512``)
blockSize [**SodiumHandler** solamente] Longitud del relleno en bytes (``16``)
cifrado [**OpenSSLHandler** solamente] Cifrado a utilizar (``AES-256-CTR``)
encryptKeyInfo [**OpenSSLHandler** solamente] Información de clave de cifrado (``''``)
authKeyInfo [**OpenSSLHandler** solamente] Información de clave de autenticación (``''``)
rawData [**OpenSSLHandler** solamente] Si el texto cifrado debe ser sin formato (``true``)
============== ===================================== ========================================

Puede reemplazar la configuración del archivo de configuración pasando una configuración
objeto propio a la llamada ``Servicios``. La variable ``$config`` debe ser
una instancia de la clase ``Config\Encryption``.

.. literalinclude:: encryption/003.php

.. _encryption-compatible-with-H3:

Configuración para mantener la compatibilidad con H3
------------------------------------------------

.. versionadded:: 7.0.0

Desde v7.3.0, puede descifrar datos cifrados con el cifrado de H3.
Si necesita descifrar dichos datos, utilice la siguiente configuración para mantener la compatibilidad.

.. literalinclude:: encryption/013.php

Algoritmos de autenticación HMAC compatibles
----------------------------------------

Para la autenticación de mensajes HMAC, la biblioteca de cifrado admite
uso de la familia de algoritmos SHA-2:
=========== ==================== ==================== =========
Algoritmo Longitud bruta (bytes) Longitud codificada en hexadecimal (bytes)
=========== ==================== ==================== =========
SHA512 64 128
SHA384 48 96
SHA256 32 64
SHA224 28 56
=========== ==================== ==================== =========

La razón para no incluir otros algoritmos populares, como
MD5 o SHA1 es que ya no se consideran lo suficientemente seguros
y como tal, no queremos fomentar su uso.
Si es absolutamente necesario utilizarlos, es fácil hacerlo a través de PHP.
nativo `hash_hmac()<http://php.net/manual/en/function.hash-hmac.php>` _ función.

Por supuesto, en el futuro se añadirán algoritmos más potentes a medida que
aparecen y se vuelven ampliamente disponibles.

Comportamiento por defecto
==========================

De forma predeterminada, la biblioteca de cifrado utiliza el controlador OpenSSL. Ese controlador cifra usando
el algoritmo AES-256-CTR, su *clave* configurada y la autenticación SHA512 HMAC.

Configuración de su clave de cifrado
====================================

Su clave de cifrado **debe** ser tan larga como lo permita el algoritmo de cifrado en uso.
Para AES-256, tiene una longitud de 256 bits o 32 bytes (caracteres).

La clave debe ser lo más aleatoria posible y **no** debe ser una cadena de texto normal.
ni la salida de una función hash, etc. Para crear una clave adecuada,
puede utilizar el método ``createKey()`` de la biblioteca Encryption.

.. literalinclude:: encryption/004.php

La clave se puede almacenar en **app/Config/Encryption.php**, o puede diseñar
un mecanismo de almacenamiento propio y pasar la clave dinámicamente al cifrar/descifrar.

Para guardar su clave en su **app/Config/Encryption.php**, abra el archivo
y establecer:

.. literalinclude:: encryption/005.php

Claves de codificación o resultados
------------------------

Notarás que el método ``createKey()`` genera datos binarios, que
es difícil de manejar (es decir, copiar y pegar puede dañarlo), por lo que puede usar
``bin2hex()`` o ``base64_encode`` para trabajar con la clave en
una manera más amigable. Por ejemplo:

.. literalinclude:: encryption/006.php

Es posible que la misma técnica le resulte útil para los resultados.
de cifrado:

.. literalinclude:: encryption/007.php

Uso de prefijos al almacenar claves
------------------------------

Puede aprovechar dos prefijos especiales para almacenar su
claves de cifrado: ``hex2bin:`` y ``base64:``. Cuando estos prefijos
precede inmediatamente al valor de su clave, ``Encryption``
analizar inteligentemente la clave y aún así pasar una cadena binaria a
la biblioteca.

.. literalinclude:: encryption/008.php

De manera similar, ¡también puedes usar estos prefijos en tu archivo **.env**!
::

    // Para hex2bin
    cifrado.clave = hex2bin:<your-hex-encoded-key>

    // o
    cifrado.clave = base64:<your-base64-encoded-key>

Relleno
=======

A veces, la longitud de un mensaje puede proporcionar mucha información sobre su naturaleza. Si
un mensaje es de "sí", "no" y "tal vez", cifrar el mensaje no ayuda: saber
la longitud es suficiente para saber cuál es el mensaje.

El relleno es una técnica para mitigar esto, haciendo que la longitud sea un múltiplo de un tamaño de bloque determinado.

El relleno se implementa en ``SodiumHandler`` usando ``sodium_pad`` y ``sodium_unpad`` nativos de libsodium.
funciones. Esto requiere el uso de una longitud de relleno (en bytes) que se agrega al texto sin formato.
mensaje antes del cifrado y eliminado después del descifrado. El relleno es configurable a través del
Propiedad ``$blockSize`` de ``Config\Encryption``. Este valor debe ser mayor que cero.

.. important:: You are advised not to devise your own padding implementation. You must always use
    la implementación más segura de una biblioteca. Además, las contraseñas no deben rellenarse. Uso de
    No se recomienda el relleno para ocultar la longitud de una contraseña. Un cliente dispuesto a enviar
    en su lugar, una contraseña de un servidor debería tener un hash (incluso con una sola iteración de la función hash).
    Esto garantiza que la longitud de los datos transmitidos sea constante y que el servidor no
    obtenga fácilmente una copia de la contraseña.

Notas del controlador de cifrado
================================

Notas de OpenSSL
-------------

El `OpenSSL<https://www.php.net/openssl> La extensión `_ ha sido una parte estándar de PHP durante mucho tiempo.

El controlador OpenSSL de Higgs utiliza el cifrado AES-256-CTR.

La *clave* que proporciona su configuración se utiliza para derivar otras dos claves, una para
cifrado y otro para autenticación. Esto se consigue mediante una técnica conocida
como una función de derivación de claves basada en HMAC<https://en.wikipedia.org/wiki/HKDF>` _ (HKDF).

Notas de sodio
------------

El `sodio<https://www.php.net/manual/en/book.sodium>` _ la extensión está incluida de forma predeterminada en PHP como
de PHP 7.2.0.

Sodium utiliza los algoritmos XSalsa20 para cifrar, Poly1305 para MAC y XS25519 para el intercambio de claves en
enviar mensajes secretos en un escenario de extremo a extremo. Para cifrar y/o autenticar una cadena usando
una clave compartida, como el cifrado simétrico, Sodium utiliza el algoritmo XSalsa20 para cifrar y
HMAC-SHA512 para la autenticación.

.. note:: Higgs's ``SodiumHandler`` uses ``sodium_memzero`` in every encryption or decryption
    sesión. Después de cada sesión, el mensaje (ya sea en texto plano o cifrado) y la clave de inicio son
    eliminado de los amortiguadores. Es posible que tengas que volver a proporcionar la clave antes de iniciar una nueva sesión.

Longitud del mensaje
====================

Una cadena cifrada suele ser más larga que la cadena de texto sin formato original (según el cifrado).

Esto está influenciado por el propio algoritmo de cifrado, el vector de inicialización (IV)
antepuesto al texto cifrado y el mensaje de autenticación HMAC que también se antepone.
Además, el mensaje cifrado también está codificado en Base64 para que sea seguro.
para almacenamiento y transmisión independientemente del juego de caracteres en uso.

Tenga en cuenta esta información al seleccionar su mecanismo de almacenamiento de datos.
Las cookies, por ejemplo, sólo pueden contener 4K de información.

Usar el servicio de cifrado directamente
========================================

En lugar de (o además de) usar ``Servicios`` como se describe en :ref:`usage`,
puede crear un "Encriptador" directamente o cambiar la configuración de una instancia existente.

.. literalinclude:: encryption/009.php

Recuerde que ``$config`` debe ser una instancia de la clase ``Config\Encryption``.


Referencia de clase
*******************

.. php:namespace:: Higgs\Encryption

.. php:class:: Encryption

    .. php:staticmethod:: createKey([$length = 32])

        :param int $longitud: Longitud de salida
        :devuelve: una clave criptográfica pseudoaleatoria con la longitud especificada, o "falsa" en caso de error
        :rtype: cadena

        Crea una clave criptográfica obteniendo datos aleatorios de
        las fuentes del sistema operativo (*es decir* ``/dev/urandom``).

    .. php:method:: initialize([Encryption $config = null])

        :param Config\\Encryption $config: Parámetros de configuración
        :devuelve: instancia ``Higgs\Encryption\EncrypterInterface``
        :rtype: ``Higgs\Encryption\EncrypterInterface``
        :lanza: ``Higgs\Encryption\Exceptions\EncryptionException``

        Inicializa (configura) la biblioteca para usar diferentes configuraciones.

        Ejemplo:

        .. literalinclude:: encryption/010.php

        Consulte la sección :ref:`configuración` para obtener información detallada.

.. php:interface:: Higgs\Encryption\EncrypterInterface

    .. php:method:: encrypt($data[, $params = null])

        :param  string $data: datos para cifrar
        :param array|string|null $params: Parámetros de configuración (clave)
        :devuelve: datos cifrados
        :rtype: cadena
        :lanza: ``Higgs\Encryption\Exceptions\EncryptionException``

        Cifra los datos de entrada y devuelve su texto cifrado.

        Si pasa parámetros como segundo argumento, el elemento ``key``
        se utilizará como clave inicial para esta operación si ``$params``
        es una matriz; o la clave inicial se puede pasar como una cadena.

        Si está utilizando SodiumHandler y desea pasar un ``blockSize`` diferente
        en tiempo de ejecución, pase la clave ``blockSize`` en la matriz ``$params``.

        Ejemplos:

        .. literalinclude:: encryption/011.php

    .. php:method:: decrypt($data[, $params = null])

        :param  string $data: datos para descifrar
        :param array|string|null $params: Parámetros de configuración (clave)
        :devuelve: datos descifrados
        :rtype: cadena
        :lanza: ``Higgs\Encryption\Exceptions\EncryptionException``

        Descifra los datos de entrada y los devuelve en texto sin formato.

        Si pasa parámetros como segundo argumento, el elemento ``key``
        se utilizará como clave inicial para esta operación si ``$params``
        es una matriz; o la clave inicial se puede pasar como una cadena.

        Si está utilizando SodiumHandler y desea pasar un ``blockSize`` diferente
        en tiempo de ejecución, pase la clave ``blockSize`` en la matriz ``$params``.

        Ejemplos:

        .. literalinclude:: encryption/012.php
