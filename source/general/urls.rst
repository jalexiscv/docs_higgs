############
URL de Higgs
############

.. contents::
    :local:
    :depth: 2

De forma predeterminada, las URL en Higgs están diseñadas para ser amigables para los motores de búsqueda y para los humanos. En lugar de utilizar el estándar
enfoque de "cadena de consulta" para las URL que es sinónimo de sistemas dinámicos, Higgs utiliza un enfoque **basado en segmentos**::

    https://example.com/news/article/my_article

Sus URL se pueden definir usando :doc:`Enrutamiento URI</incoming/routing>`  característica con flexibilidad.

La :doc:`Biblioteca URI <../libraries/uri>` y el :doc:`URL Helper <../helpers/url_helper>` contienen funciones que facilitan el trabajo con sus datos URI.

.. _urls-url-structure:

Estructura de URL
=================

La URL base contiene solo el nombre de host
-----------------------------------

Cuando tienes la URL Base **https://www.example.com/** e imaginas la siguiente URL::

    https://www.example.com/blog/news/2022/10?page=2

Usamos los siguientes términos:
========== ============================ ============ ==============================
Término Ejemplo Descripción
========== ============================ ============ ==============================
URL base **https://www.example.com/** La URL base a menudo se indica como **baseURL**.
Ruta URI /blog/news/2022/10
Ruta de ruta /blog/news/2022/10 La ruta del URI relativa a la URL base.
                                        También se denomina **cadena URI**.
Página de consulta=2
========== ============================ ============ ==============================

La URL base contiene subcarpetas
-----------------------

Cuando tienes la URL Base **https://www.example.com/ci-blog/** e imaginas la siguiente URL::

    https://www.example.com/ci-blog/blog/news/2022/10?page=2

Usamos los siguientes términos:
========== ===================================== ==== =======================================
Término Ejemplo Descripción
========== ===================================== ==== =======================================
URL base **https://www.example.com/ci-blog/** La URL base a menudo se indica como **baseURL**.
Ruta URI /ci-blog/blog/news/2022/10
Ruta de ruta /blog/news/2022/10 La ruta del URI relativa a la URL base.
                                                También se denomina **cadena URI**.
Página de consulta=2
========== ===================================== ==== =======================================

.. _urls-remove-index-php:

Eliminando el archivo index.php
===============================

Cuando utilizas el servidor web Apache, de forma predeterminada, el archivo **index.php** será necesario en tus URL::

    ejemplo.com/index.php/news/article/my_article

Si su servidor admite la reescritura de URL, puede eliminar fácilmente este archivo con la reescritura de URL. Esto se maneja de manera diferente
por diferentes servidores, pero aquí mostraremos ejemplos de los dos servidores web más comunes.

.. _urls-remove-index-php-apache:

Servidor Web Apache
-----------------

Apache debe tener habilitada la extensión *mod_rewrite*. Si es así, puede utilizar un archivo ``.htaccess`` con algunas reglas simples.
A continuación se muestra un ejemplo de un archivo de este tipo, utilizando el método "negativo" en el que se redirige todo excepto lo especificado.
elementos:

.. code-block:: apache

    Reescribir motor encendido
    ReescribirCond %{REQUEST_FILENAME} !-f
    ReescribirCond %{REQUEST_FILENAME} !-d
    Reescribir regla ^(.*)$ index.php/$1 [L]

En este ejemplo, cualquier solicitud HTTP que no sea la de directorios y archivos existentes se trata como una
Solicite su archivo index.php.

.. note:: These specific rules might not work for all server configurations.

.. note:: Make sure to also exclude from the above rules any assets that you might need to be accessible from the outside world.

.. _urls-remove-index-php-nginx:

nginx
-----

En nginx, puedes definir un bloque de ubicación y usar la directiva ``try_files`` para obtener el mismo efecto que hicimos con
la configuración de Apache anterior:

.. code-block:: nginx

    ubicación / {
        try_files $uri $uri/ /index.php$is_args$args;
    }

Esto primero buscará un archivo o directorio que coincida con el URI (construyendo la ruta completa a cada archivo desde el
configuración de las directivas raíz y alias), y luego envía la solicitud al archivo index.php junto con los argumentos.
