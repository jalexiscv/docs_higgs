Sección de noticias
###################

.. contents::
    :local:
    :depth: 2

En la última sección, repasamos algunos conceptos básicos del marco.
escribiendo una clase que haga referencia a páginas estáticas. Limpiamos el URI por
agregando reglas de enrutamiento personalizadas. Ahora es el momento de introducir contenido dinámico.
y empezar a utilizar una base de datos.

Crear una base de datos para trabajar
*************************************

La instalación de Higgs supone que ha configurado un sistema apropiado
base de datos, como se describe en los :ref:`requirements<requirements-supported-databases>` .
En este tutorial, proporcionamos código SQL para una base de datos MySQL y
También asumimos que tiene un cliente adecuado para emitir la base de datos.
comandos (mysql, MySQL Workbench o phpMyAdmin).

Necesita crear una base de datos ``ci4tutorial`` que pueda usarse para este tutorial.
y luego configurar Higgs para usarlo.

Usando su cliente de base de datos, conéctese a su base de datos y ejecute el siguiente comando SQL (MySQL)::

    CREAR TABLA noticias (
        id INT SIN FIRMAR NO NULL AUTO_INCREMENT,
        título VARCHAR(128) NO NULO,
        slug VARCHAR(128) NO NULO,
        TEXTO DEL CUERPO NO NULO,
        CLAVE PRIMARIA (id),
        Babosa ÚNICA (babosa)
    );

Además, agregue algunos registros de semillas. Por ahora, solo le mostraremos las declaraciones SQL necesarias.
para crear la tabla, pero debe tener en cuenta que esto se puede hacer mediante programación
una vez que esté más familiarizado con el Higgs; puedes leer sobre :doc:`Migraciones <../dbmgmt/migration>`
y :doc:`Seeds <../dbmgmt/seeds>` para crear configuraciones de bases de datos más útiles más adelante.

Una nota de interés: una "babosa", en el contexto de la publicación web, es una
Texto breve fácil de usar y SEO que se utiliza en una URL para identificar y describir un recurso.

Los registros de semillas podrían ser algo así como::

    INSERTAR EN VALORES de noticias
    (1,'Elvis avistado','elvis-avistado','Elvis fue avistado en el cibercafé Podunk. Parecía que estaba escribiendo una aplicación de Higgs.'),
    (2,'¡Di que no es así!','Di-no-es-así','Los científicos concluyen que algunos programadores tienen sentido del humor.'),
    (3,'Caffeination, Yes!','caffeination-yes','La cafetería más grande del mundo abierta en el lugar y anidada solo para el personal.');

Conéctese a su base de datos
****************************

El archivo de configuración local, **.env**, que creó cuando instaló
Higgs, debería tener la configuración de propiedades de la base de datos descomentada y
configúrelo adecuadamente para la base de datos que desea utilizar. Asegúrate de haber configurado
su base de datos correctamente como se describe en :doc:`../database/configuration`::

    base de datos.default.hostname = localhost
    base de datos.default.database = ci4tutorial
    base de datos.default.nombre de usuario = raíz
    base de datos.contraseña predeterminada = raíz
    base de datos.default.DBDriver = MySQLi

Configurando tu modelo
**********************

En lugar de escribir operaciones de bases de datos directamente en el controlador, las consultas
deben colocarse en un modelo, para que puedan reutilizarse fácilmente más adelante. Modelos
son el lugar donde usted recupera, inserta y actualiza información en su
base de datos u otros almacenes de datos. Proporcionan acceso a sus datos.
Puede leer más sobre esto en :doc:`../models/model`.

Crear modelo de noticias
========================

Abra el directorio **app/Models** y cree un nuevo archivo llamado
**NewsModel.php** y agregue el siguiente código.

.. literalinclude:: news_section/001.php

Este código es similar al código del controlador que se usó anteriormente. Él
crea un nuevo modelo extendiendo ``Higgs\Model`` y carga la base de datos
biblioteca. Esto hará que la clase de base de datos esté disponible a través del
Objeto ``$this->db``.

Agregar el método NewsModel::getNews()
======================================

Ahora que se han configurado la base de datos y el modelo, necesitará un método
para obtener todas nuestras publicaciones de nuestra base de datos. Para ello, la base de datos
capa de abstracción que se incluye con Higgs -
:doc:`Query Builder <../database/query_builder>` - se utiliza en el ``Higgs\Model``. Esto lo hace
Es posible escribir sus 'consultas' una vez y hacer que funcionen en :doc:`all
sistemas de bases de datos compatibles <../intro/requirements>`. La clase modelo
también le permite trabajar fácilmente con Query Builder y proporciona
algunas herramientas adicionales para simplificar el trabajo con datos. Añade el
siguiente código para su modelo.

.. literalinclude:: news_section/002.php
    :lines: 11-18

Con este código podrás realizar dos consultas diferentes. puedes conseguir todo
registros de noticias, o obtener una noticia por su babosa. Es posible que usted tenga
noté que la variable ``$slug`` no tenía escape antes de ejecutar el
consulta; :doc:`Query Builder <../database/query_builder>` hace esto por usted.

Se proporcionan los dos métodos utilizados aquí, ``findAll()`` y ``first()``.
por la clase ``Higgs\Model``. Ya conocen la tabla a utilizar según la ``$table``
propiedad que configuramos en la clase ``NewsModel``, anteriormente. Son métodos auxiliares.
que utilizan el Generador de consultas para ejecutar sus comandos en la tabla actual, y
devolviendo una serie de resultados en el formato de su elección. En este ejemplo,
``findAll()`` devuelve una matriz de matriz.

Mostrar las noticias
********************

Ahora que las consultas están escritas, el modelo debe estar vinculado a las vistas.
que van a mostrar las noticias al usuario. Esto se podría hacer
en nuestro controlador ``Páginas`` creado anteriormente, pero para mayor claridad,
Se define un nuevo controlador ``Noticias``.

Agregar reglas de enrutamiento
==============================

Modifique su archivo **app/Config/Routes.php** para que tenga el siguiente aspecto:

.. literalinclude:: news_section/008.php

Esto asegura que las solicitudes lleguen al controlador ``Noticias`` en lugar de
yendo directamente al controlador ``Páginas``. La segunda línea ``$routes->get()``
enruta los URI con un slug al método ``show()`` en el controlador ``News``.

Crear controlador de noticias
=============================

Cree el nuevo controlador en **app/Controllers/News.php**.

.. literalinclude:: news_section/003.php

Al observar el código, es posible que vea alguna similitud con los archivos que
creado anteriormente. Primero, extiende ``BaseController`` que extiende una clase central de Higgs, ``Controller``,
que proporciona un par de métodos de ayuda y garantiza que tenga
acceso a los objetos actuales ``Solicitud`` y ``Respuesta``, así como a los
Clase ``Logger``, para guardar información en el disco.

A continuación, existen dos métodos, uno para ver todas las noticias y otro para una específica.
nuevos artículos.

A continuación, se utiliza la función :php:func:`model()` para crear la instancia ``NewsModel``.
Esta es una función auxiliar. Puede leer más sobre esto en :doc:`../general/common_functions`.
También puedes escribir ``$model = new NewsModel();``, si no lo usas.

Puedes ver que la variable ``$slug`` se pasa al modelo
método en el segundo método. El modelo está utilizando esta babosa para identificar el
noticia a devolver.

Noticias completas::método index()
==================================

Ahora el controlador recupera los datos a través de nuestro modelo, pero
todavía no se muestra nada. Lo siguiente que debe hacer es pasar estos datos a
Las vistas. Modifique el método ``index()`` para que se vea así:

.. literalinclude:: news_section/004.php

El código anterior obtiene todos los registros de noticias del modelo y los asigna a un
variable. El valor del título también se asigna a ``$data['title']``
elemento y todos los datos se pasan a las vistas. Ahora necesitas crear un
vista para representar las noticias.

Crear noticia/índice Ver archivo
================================

Cree **app/Views/news/index.php** y agregue el siguiente fragmento de código.

.. literalinclude:: news_section/005.php

.. note:: We are again using using :php:func:`esc()` to help prevent XSS attacks.
    Pero esta vez también pasamos "url" como segundo parámetro. Eso es porque
    Los patrones de ataque son diferentes según el contexto en el que se produce la salida.
    se utiliza.

Aquí, cada noticia se repite y se muestra al usuario. Puedes ver nosotros
Escribimos nuestra plantilla en PHP mezclado con HTML. Si prefieres usar una plantilla
idioma, puede utilizar :doc:`Ver de Higgs
analizador</outgoing/view_parser>`  o un analizador de terceros.

Noticias completas::show() Método
=================================

La página de resumen de noticias ya está lista, pero aparece una página para mostrar información individual.
Las noticias aún están ausentes. El modelo creado anteriormente está hecho de tal
de una manera que pueda usarse fácilmente para esta funcionalidad. Sólo necesitas
agregue algo de código al controlador y cree una nueva vista. volver a la
controlador ``News`` y actualice el método ``show()`` con lo siguiente:

.. literalinclude:: news_section/006.php

No olvide agregar ``use Higgs\Exceptions\PageNotFoundException;`` para importar
la clase ``PageNotFoundException``.

En lugar de llamar al método ``getNews()`` sin un parámetro, el
Se pasa la variable ``$slug``, por lo que devolverá la noticia específica.

Crear noticia/ver Ver archivo
=============================

Lo único que queda por hacer es crear la vista correspondiente en
**aplicación/Views/news/view.php**. Coloque el siguiente código en este archivo.

.. literalinclude:: news_section/007.php

Apunte su navegador a su página de "noticias", es decir, **localhost:8080/news**,
Deberías ver una lista de las noticias, cada una de las cuales tiene un enlace.
para mostrar solo un artículo.

.. image:: ../images/tutorial2.png
    :align: center
