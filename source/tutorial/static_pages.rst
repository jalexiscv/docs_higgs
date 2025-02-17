Páginas estáticas
#################

.. contents::
    :local:
    :depth: 2

.. note:: This tutorial assumes you've downloaded Higgs and
   :doc:`instaló el marco <../installation/index>` en su
   entorno de desarrollo.

Lo primero que hará es configurar reglas de enrutamiento para manejar páginas estáticas.

Establecer reglas de enrutamiento
*********************************

El enrutamiento asocia un URI con el método de un controlador. Un controlador es simplemente un
Clase que ayuda a delegar el trabajo. Crearemos un controlador más tarde.

Configuremos reglas de enrutamiento. Abra el archivo de rutas ubicado en **app/Config/Routes.php**.

La única directiva de ruta para empezar debería ser:

.. literalinclude:: static_pages/003.php

Esta directiva dice que cualquier solicitud entrante sin ningún contenido
especificado debe ser manejado por el método ``index()`` dentro del controlador ``Home``.

Agregue las siguientes líneas, **después** de la directiva de ruta para ``'/'``.

.. literalinclude:: static_pages/004.php
   :lines: 2-

Higgs lee sus reglas de enrutamiento de arriba a abajo y enruta el
solicitud a la primera regla coincidente. Cada regla es una expresión regular.
(lado izquierdo) asignado a un controlador y nombre de método
(lado derecho). Cuando llega una solicitud, Higgs busca la primera
coincide y llama al controlador y método apropiados, posiblemente con
argumentos.

Puede encontrar más información sobre el enrutamiento en :doc:`../incoming/routing`.

Aquí, la segunda regla en el objeto ``$routes`` coincide con una solicitud GET
a la ruta URI **/pages**, y se asigna al método ``index()`` de la clase ``Pages``.

La tercera regla en el objeto ``$routes`` hace coincidir una solicitud GET con un segmento URI
usando el marcador de posición ``(:segmento)``, y pasa el parámetro al
Método ``view()`` de la clase ``Pages``.

Hagamos nuestro primer controlador
**********************************

Lo siguiente que vas a hacer es configurar un **controlador** para manejar
páginas estáticas. Un controlador es simplemente una clase que ayuda a delegar el trabajo.
Es el pegamento de su aplicación web.

Crear controlador de páginas
============================

Cree un archivo en **app/Controllers/Pages.php** con lo siguiente
código.

.. important:: You should always be careful about the case of filenames. Many
    los desarrolladores desarrollan en sistemas de archivos que no distinguen entre mayúsculas y minúsculas en Windows o macOS.
    Sin embargo, la mayoría de los entornos de servidores utilizan sistemas de archivos que distinguen entre mayúsculas y minúsculas. Si el
    El caso del nombre del archivo es incorrecto, el código que funciona localmente no funcionará en el
    servidor.

.. literalinclude:: static_pages/001.php

Ha creado una clase llamada ``Pages``, con un método ``view()`` que acepta
un argumento llamado ``$página``. También tiene un método ``index()``, el mismo
como controlador predeterminado que se encuentra en **app/Controllers/Home.php**; ese método
muestra la página de bienvenida de Higgs.

.. note:: There are two ``view()`` functions referred to in this tutorial.
    Uno es el método de clase creado con ``vista de función pública ($page = 'home')``
    y ``return view('welcome_message')`` para mostrar una vista.
    Ambos son *técnicamente* una función. Pero cuando creas una función en una clase,
    se llama método.

La clase ``Pages`` está extendiendo la clase ``BaseController`` que extiende el
Clase ``Higgs\Controller``. Esto significa que la nueva clase Páginas puede acceder al
métodos y propiedades definidos en la clase ``Higgs\Controller``
(**sistema/Controlador.php**).

El **controlador es lo que se convertirá en el centro de cada solicitud** para
su aplicación web. Como cualquier clase de PHP, te refieres a
dentro de sus controladores como ``$this``.

Crear vistas
============

Ahora que ha creado su primer método, es hora de crear una página básica.
plantillas. Crearemos dos "vistas" (plantillas de página) que actúan como
pie de página y encabezado de nuestra página.

Cree el encabezado en **app/Views/templates/header.php** y agregue
el siguiente código::

    <!doctype html>
    <html>
    <head>
        <title>Tutorial de Higgs</title>
    </head>
    <body>

        <h1><?= esc($title) ?></h1>

El encabezado contiene el código HTML básico que querrás mostrar.
antes de cargar la vista principal, junto con un título. También lo hará
genera la variable ``$title``, que definiremos más adelante en el controlador.
Ahora, cree un pie de página en **app/Views/templates/footer.php** que
incluye el siguiente código::

        <em>© 2022</em>
    </body>
    </html>

.. note:: If you look closely in **header.php** template we are using an :php:func:`esc()`
    función. Es una función global proporcionada por Higgs para ayudar a prevenir
    Ataques XSS. Puede leer más sobre esto en :doc:`../general/common_functions`.

Agregar lógica al controlador
*****************************

Crea home.php y about.php
=========================

Anteriormente configuró un controlador con un método ``view()``. El método
acepta un parámetro, que es el nombre de la página que se va a cargar.

Los cuerpos de las páginas estáticas se ubicarán en el directorio **app/Views/pages**.

En ese directorio, cree dos archivos llamados **home.php** y **about.php**.
Dentro de esos archivos, escriba algo de texto (lo que desee) y guárdelo.
Si te gusta ser particularmente poco original, prueba "¡Hola mundo!".

Páginas completas::view() Método
================================

Para cargar esas páginas, deberá verificar si las solicitadas
La página realmente existe. Este será el cuerpo del método ``view()``
en el controlador ``Pages`` creado anteriormente:

.. literalinclude:: static_pages/002.php

Y agregue ``use Higgs\Exceptions\PageNotFoundException;`` después de la línea ``namespace``
para importar la clase ``PageNotFoundException``.

Ahora, cuando la página solicitada existe, se carga, incluido el encabezado y
pie de página y se devuelve al usuario. Si un controlador devuelve una cadena, es
mostrado al usuario.

.. note:: Controllers must return a string or a :doc:`Response <../outgoing/response>` object.

Si la página solicitada no existe, se muestra el error "Página 404 no encontrada".

La primera línea de este método comprueba si la página realmente existe.
La función nativa ``is_file()`` de PHP se utiliza para comprobar si el archivo
es donde se espera que esté. La ``PageNotFoundException`` es una Higgs
excepción que hace que se muestre la página de error predeterminada.

En la plantilla de encabezado, se usó la variable ``$title`` para personalizar el
Título de la página. El valor del título se define en este método, pero en lugar de
Al asignar el valor a una variable, se asigna al elemento del título.
en la matriz ``$data``.

Lo último que hay que hacer es cargar las vistas en el orden
deberían mostrarse. La función :php:func:`view()` integrada en
Para ello se utilizará Higgs. El segundo parámetro en ``view()``
La función se utiliza para pasar valores a la vista. Cada valor en la matriz ``$data``
se asigna a una variable con el nombre de su clave. Entonces el valor de
``$data['title']`` en el controlador es equivalente a ``$title`` en el
vista.

.. note:: Any files and directory names passed into the :php:func:`view()` function MUST
    coincida con el caso del directorio real y el archivo en sí o el sistema
    arrojar errores en plataformas que distinguen entre mayúsculas y minúsculas. Puedes leer más sobre esto en
    :doc:`../salientes/vistas`.

Ejecutando la aplicación
************************

¿Listo para probar? No puede ejecutar la aplicación utilizando el servidor integrado de PHP,
ya que no procesará adecuadamente las reglas **.htaccess** que se proporcionan en
**público**, y que eliminan la necesidad de especificar "**index.php/**"
como parte de una URL. Higgs tiene su propio comando que puedes usar.

Desde la línea de comando, en la raíz de tu proyecto:

.. code-block:: console

    servicio de chispa php

iniciará un servidor web, accesible en el puerto 8080. Si configura el campo de ubicación
en su navegador a **localhost:8080**, debería ver la página de bienvenida de Higgs.

Ahora visite **localhost:8080/home**. ¿Se dirigió correctamente a ``view()``?
método en el controlador ``Pages``? ¡Impresionante!

Deberías ver algo como lo siguiente:

.. image:: ../images/tutorial1.png
    :align: center

Ahora puede probar varias URL en el campo de ubicación del navegador para ver cuáles son las ``Páginas``.
El controlador que hiciste arriba produce...

.. table::
    :widths: 20 80

    +---------------------------------+-----------------------------------------------------------------+
    | URL                             | Will show                                                       |
    +=================================+=================================================================+
    | localhost:8080/                 | la página de "bienvenida" del Higgs. los resultados del         |
    |                                 | ``index()`` método en el controlador ``Home``.                  |
    +---------------------------------+-----------------------------------------------------------------+
    | localhost:8080/pages            | los resultados del método ``index()`` dentro de nuestras        |
    |                                 | ``Páginas`` controlador, que debe mostrar la página de          |
    |                                 | "bienvenida" de Higgs.                                          |
    +---------------------------------+-----------------------------------------------------------------+
    | localhost:8080/home             | muestre la página de "inicio" que creó anteriormente, porque    |
    |                                 | explícitamentelo pedí. los resultados del método ``view()``     |
    |                                 | dentro de nuestro Controlador ``Páginas``.                      |
    +---------------------------------+-----------------------------------------------------------------+
    | localhost:8080/about            | la página "acerca de" que creó anteriormente, porque            |
    |                                 | explícitamente lo pedí.                                         |
    +---------------------------------+-----------------------------------------------------------------+
    | localhost:8080/shop             | aparece una página de error "404 - Archivo no encontrado",      |
    |                                 | porque no hay **aplicación/Views/pages/shop.php**.              |
    +---------------------------------+-----------------------------------------------------------------+

