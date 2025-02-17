Crear noticias
##############

.. contents::
    :local:
    :depth: 3

Ahora sabes cómo leer datos de una base de datos usando Higgs, pero
aún no has escrito ninguna información en la base de datos. En esta sección,
ampliará su controlador de noticias y el modelo creado anteriormente para incluir
esta funcionalidad.

Habilitar filtro CSRF
*********************

Antes de crear un formulario, habilitemos la protección CSRF.

Abra el archivo **app/Config/Filters.php** y actualice la propiedad ``$methods`` como se muestra a continuación:

.. literalinclude:: create_news_items/001.php

Configura el filtro CSRF para que se habilite para todas las solicitudes **POST**.
Puede leer más sobre la protección CSRF en :doc:`Security <../libraries/security>` biblioteca.

.. Warning:: In general, if you use ``$methods`` filters, you should :ref:`disable Auto Routing (Legacy) <use-defined-routes-only>`
    porque :ref:`auto-routing-legacy` permite que cualquier método HTTP acceda a un controlador.
    Acceder al controlador con un método inesperado podría pasar por alto el filtro.

Agregar reglas de enrutamiento
******************************

Antes de que pueda comenzar a agregar noticias a su aplicación Higgs
debe agregar una regla adicional al archivo **app/Config/Routes.php**. Asegúrese de que su
El archivo contiene lo siguiente:

.. literalinclude:: create_news_items/004.php

La directiva de ruta para ``'news/new'`` se coloca antes de la directiva para ``'news/(:segment)'`` para garantizar que se muestre el formulario para crear una noticia.

La línea ``$routes->post()`` define el enrutador para una solicitud POST. Coincide
sólo una solicitud POST a la ruta URI **/news**, y se asigna al método ``create()`` de
la clase ``Noticias``.

Puede leer más sobre los diferentes tipos de enrutamiento en :ref:`defined-route-routing`.

Crear un formulario
*******************

Crear noticia/crear Ver archivo
===============================

Para ingresar datos en la base de datos, necesita crear un formulario donde pueda
introducir la información a almacenar. Esto significa que necesitarás un formulario
con dos campos, uno para el título y otro para el texto. derivarás
la babosa de nuestro título en el modelo.

Cree una nueva vista en **app/Views/news/create.php**:

.. literalinclude:: create_news_items/006.php

Probablemente sólo haya cuatro cosas aquí que parezcan desconocidas.

La función :php:func:`session()` se utiliza para obtener el objeto Sesión,
y ``session()->getFlashdata('error')`` se usa para mostrar el error relacionado con la protección CSRF
al usuario. Sin embargo, de forma predeterminada, si falla una verificación de validación CSRF, se generará una excepción.
así que todavía no funciona. Consulte :ref:`csrf-redirection-on-failure` para obtener más información.

La función :php:func:`validation_list_errors()` proporcionada por :doc:`../helpers/form_helper`
se utiliza para informar errores relacionados con la validación del formulario.

La función :php:func:`csrf_field()` crea una entrada oculta con un token CSRF que ayuda a proteger contra algunos ataques comunes.

La función :php:func:`set_value()` proporcionada por :doc:`../helpers/form_helper` se utiliza para mostrar
datos de entrada antiguos cuando se producen errores.

Controlador de noticias
=======================

Vuelve a tu controlador de ``Noticias``.

Agregue News::new() para mostrar el formulario
----------------------------------------------

Primero, cree un método para mostrar el formulario HTML que ha creado.

.. literalinclude:: create_news_items/002.php

Cargamos el :doc:`Form helper <../helpers/form_helper>` con el
:php:func:función `ayudante()`. La mayoría de las funciones auxiliares requieren que el auxiliar sea
cargado antes de su uso.

Luego devuelve la vista del formulario creado.

Agregue News::create() para crear una noticia
---------------------------------------------

A continuación, cree un método para crear una noticia a partir de los datos enviados.

Vas a hacer tres cosas aquí:

Primero, comprueba si los datos enviados pasaron las reglas de validación.
2. guarda la noticia en la base de datos.
3. devuelve una página de éxito.

.. literalinclude:: create_news_items/005.php

El código anterior agrega mucha funcionalidad.

Recuperar los datos
^^^^^^^^^^^^^^^^^^^

Primero, usamos :doc:`IncomingRequest <../incoming/incomingrequest>`
objeto ``$this->request``, que el framework establece en el controlador.

Obtenemos los elementos necesarios de los datos **POST** del usuario y los configuramos en el
variable ``$datos``.

Validar los datos
^^^^^^^^^^^^^^^^^

A continuación, utilizará la función auxiliar proporcionada por el controlador.
:ref:`validarDatos()<controller-validatedata>`  para validar los datos enviados.
En este caso, los campos título y cuerpo son obligatorios y en la longitud específica.

Higgs tiene una poderosa biblioteca de validación como se demuestra
arriba. Puede leer más sobre :doc:`Biblioteca de validación <../libraries/validation>`.

Si la validación falla, llamamos al método ``new()`` que acabas de crear y devolvemos
el formulario HTML.

Guardar la noticia
^^^^^^^^^^^^^^^^^^

Si la validación pasó todas las reglas, obtenemos los datos validados por
:ref:`$this->validador->getValidated()<validation-getting-validated-data>`  y
configúrelos en la variable ``$post``.

El ``NewsModel`` se carga y se llama. Este se encarga de pasar la noticia.
en el modelo. El método :ref:`model-save` maneja la inserción o actualización del
grabar automáticamente, en función de si encuentra una clave de matriz que coincida con la clave principal
llave.

Esto contiene una nueva función :php:func:`url_title()`. Esta función -
proporcionado por :doc:`URL helper <../helpers/url_helper>` - se desnuda
la cadena que le pasas, reemplazando todos los espacios por guiones (``-``) y hace
Asegúrate de que todo esté en minúsculas. Esto te deja con un bonito
slug, perfecto para crear URI.

Volver a la página de éxito
^^^^^^^^^^^^^^^^^^^^^^^^^^^

Después de esto, los archivos de visualización se cargan y se devuelven para mostrar un mensaje de éxito.
Cree una vista en **app/Views/news/success.php** y escriba un mensaje de éxito.

Esto podría ser tan simple como::

    <p>Noticia creada exitosamente.</p>

NoticiasActualización de modelos
********************************

Lo único que queda es asegurarse de que su modelo esté configurado.
para permitir que los datos se guarden correctamente. El método ``save()`` que fue
utilizado determinará si la información debe insertarse
o si la fila ya existe y debe actualizarse, según la presencia
de una clave primaria. En este caso, no se le pasa ningún campo ``id``,
entonces insertará una nueva fila en su tabla, ``noticias``.

Sin embargo, de forma predeterminada, los métodos de inserción y actualización en el modelo
en realidad no guarda ningún dato porque no sabe qué campos son
seguro para ser actualizado. Edite ``NewsModel`` para proporcionarle una lista de elementos actualizables.
campos en la propiedad ``$allowedFields``.

.. literalinclude:: create_news_items/003.php

Esta nueva propiedad ahora contiene los campos que permitimos guardar en el
base de datos. ¿Notas que omitimos el ``id``? Eso es porque casi
Nunca es necesario hacer eso, ya que es un campo que se incrementa automáticamente en la base de datos.
Esto ayuda a proteger contra vulnerabilidades de asignaciones masivas. Si tu modelo es
Al manejar sus marcas de tiempo, también las omitiría.

Crear una noticia
*****************

Ahora apunte su navegador a su entorno de desarrollo local donde
instaló Higgs y agregue **/news/new** a la URL.
Agrega algunas noticias y mira las diferentes páginas que creaste.

.. image:: ../images/tutorial3.png
    :align: center
    :height: 415px
    :width: 45%

.. image:: ../images/tutorial4.png
    :align: center
    :height: 415px
    :width: 45%

Felicidades
***********

¡Acaba de completar su primera aplicación de Higgs (AI)!

El siguiente diagrama muestra la carpeta **app** de tu proyecto, con todos los
archivos que usted creó o modificó.

.. code-block:: none

    aplicación/
    ├── Configuración
    │ ├── Filtros.php (Modificado)
    │ └── Rutas.php (Modificado)
    ├── Controladores
    │ ├── Noticias.php
    │ └── Páginas.php
    ├── Modelos
    │ └── NewsModel.php
    └── Vistas
        ├── noticias
        │ ├── crear.php
        │ ├── index.php
        │ ├── éxito.php
        │ └── ver.php
        ├── páginas
        │ ├── acerca de.php
        │ └── inicio.php
        └── plantillas
            ├── pie de página.php
            └── encabezado.php
