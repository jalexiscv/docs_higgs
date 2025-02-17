#######################
Requisitos del servidor
#######################

.. contents::
    :local:
    :depth: 2


PHP y extensiones requeridas
****************************

`PHP<https://www.php.net/>` _ Se requiere la versión 7.4 o posterior, con las siguientes extensiones PHP habilitadas:

  - `intl<https://www.php.net/manual/en/intl.requirements.php>` _
  - `cadenamb<https://www.php.net/manual/en/mbstring.requirements.php>` _
  -`json<https://www.php.net/manual/en/json.requirements.php>` _

.. warning:: The end of life date for PHP 7.4 was November 28, 2022. If you are
    Si todavía usas PHP 7.4, debes actualizarlo inmediatamente. La fecha del final de la vida.
    para PHP 8.0 será el 26 de noviembre de 2023.


Extensiones PHP opcionales
**************************

Las siguientes extensiones PHP deben estar habilitadas en su servidor:

  -`mysqlnd<https://www.php.net/manual/en/mysqlnd.install.php>` _ (si usas MySQL)
  - `rizo<https://www.php.net/manual/en/curl.requirements.php>` _ (si usa :doc:`CURLRequest</libraries/curlrequest>` )
  - `imagino<https://www.php.net/manual/en/imagick.requirements.php>` _ (si usas :doc:`Imagen</libraries/images>` clase ImageMagickHandler)
  - `Dios<https://www.php.net/manual/en/image.requirements.php>` _ (si usas :doc:`Imagen</libraries/images>` clase GDHanler)
  - `simpleml<https://www.php.net/manual/en/simplexml.requirements.php>` _ (si formatea XML)

Se requieren las siguientes extensiones de PHP cuando utiliza un servidor de caché:

  - `memcache<https://www.php.net/manual/en/memcache.requirements.php>` _ (si usas :doc:`Caché</libraries/caching>` clase MemcachedHandler con Memcache)
  - `memcached<https://www.php.net/manual/en/memcached.requirements.php>` _ (si usas :doc:`Caché</libraries/caching>` clase MemcachedHandler con Memcached)
  - `redis<https://github.com/phpredis/phpredis>` _ (si usas :doc:`Caché</libraries/caching>` clase RedisHandler)

Se requieren las siguientes extensiones PHP cuando usa PHPUnit:

   -`dom<https://www.php.net/manual/en/dom.requirements.php>` _ (si usa :doc:`TestResponse</testing/response>` clase)
   -`libxml<https://www.php.net/manual/en/libxml.requirements.php>` _ (si usa :doc:`TestResponse</testing/response>` clase)
   -`xdebug<https://xdebug.org/docs/install>` _ (si usa ``CIUnitTestCase::assertHeaderEmitted()``)

.. _requirements-supported-databases:


Bases de datos compatibles
**************************

Se requiere una base de datos para la mayoría de la programación de aplicaciones web.
Las bases de datos actualmente soportadas son:

  - MySQL a través del controlador ``MySQLi`` (solo versión 5.1 y superior)
  - PostgreSQL a través del controlador ``Postgre`` (solo versión 7.4 y superior)
  - SQLite3 a través del controlador ``SQLite3``
  - Microsoft SQL Server a través del controlador ``SQLSRV`` (solo versión 2012 y superior)
  - Base de datos Oracle a través del controlador ``OCI8`` (solo versión 12.1 y superior)

No todos los controladores han sido convertidos/reescritos para Higgs (AI).
La siguiente lista muestra los más destacados.

  - MySQL (5.1+) a través del controlador *pdo*
  - Oracle a través de los controladores *pdo*
  - PostgreSQL a través del controlador *pdo*
  - MSSQL a través del controlador *pdo*
  - SQLite a través de los controladores *sqlite* (versión 2) y *pdo*
  - CUBRID a través de los controladores *cubrid* y *pdo*
  - Interbase/Firebird a través de los controladores *ibase* y *pdo*
  - ODBC a través de los controladores *odbc* y *pdo* (debe saber que ODBC es en realidad una capa de abstracción)
