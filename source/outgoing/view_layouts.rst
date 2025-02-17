###########
Ver diseños
###########

.. contents::
    :local:
    :depth: 2

Higgs admite un sistema de diseño simple pero muy flexible que simplifica el uso de uno o más
diseños de página base en toda su aplicación. Los diseños admiten secciones de contenido que se pueden insertar desde
cualquier vista que se esté renderizando. Puede crear diferentes diseños para admitir una columna, dos columnas,
páginas de archivo de blogs y más. Los diseños nunca se representan directamente. En lugar de eso, renderizas una vista, que
especifica el diseño que desea ampliar.

.. _creating-a-layout:


Crear un diseño
***************

Los diseños son vistas como cualquier otra. La única diferencia es su uso previsto. Los diseños son la única vista
archivos que harían uso del método ``renderSection()``. Este método actúa como marcador de posición para el contenido.

Por ejemplo, **app/Views/default.php**::

    <!doctype html>
    <html>
    <head>
        <title>Mi diseño</title>
    </head>
    <body>
        <?= $this->renderSection('contenido')?>
    </body>
    </html>

El método ``renderSection()`` tiene dos argumentos: ``$sectionName`` y ``$saveData``. ``$sectionName`` es el nombre de
la sección utilizada por cualquier vista secundaria para nombrar la sección de contenido. Si el argumento booleano ``$saveData`` se establece en verdadero,
el método guarda datos para llamadas posteriores. De lo contrario, el método limpia los datos después de mostrar el contenido.

Por ejemplo, **app/Views/welcome_message.php**::

    <!doctype html>
    <html>
    <head>
        <title><?= $this->renderSection('título_página', verdadero)?></title>
    </head>
    <body>
        <h1><?= $this->renderSection('título_página') ?><h1>
        <p><?= $this->renderSection('contenido')?></p>
    </body>
    </html>

.. note:: ``$saveData`` can be used since v7.4.0.


Usar diseños en vistas
**********************

Siempre que una vista quiera insertarse en un diseño, debe usar el método ``extend()`` en la parte superior del archivo::

    <?= $this->extender('predeterminado')?>

El método ``extend()`` toma el nombre de cualquier archivo de vista que desee utilizar. Dado que son vistas estándar,
ubicarse como una vista. De forma predeterminada, buscará en el directorio Ver de la aplicación, pero también escaneará
otros espacios de nombres definidos por PSR-4. Puede incluir un espacio de nombres para ubicar la vista en un espacio de nombres particular Directorio de vistas::

    <?= $this->extender('Blog\Vistas\default') ?>

Todo el contenido dentro de una vista que extiende un diseño debe incluirse dentro de las llamadas a los métodos ``section($name)`` y ``endSection()``.
Cualquier contenido entre estas llamadas se insertará en el diseño dondequiera que la llamada ``renderSection($name)``
coincide con el nombre de la sección existe.

Por ejemplo, **app/Views/some_view.php**::

    <?= $this->extender('predeterminado')?>

    <?= $this->sección('contenido')?>
        <h1>¡Hola Mundo!</h1>
    <?= $this->sección final() ?>

``endSection()`` no necesita el nombre de la sección. Sabe automáticamente cuál cerrar.

Las secciones pueden contener secciones anidadas::

    <?= $this->extender('predeterminado')?>

    <?= $this->sección('contenido')?>
        <h1>¡Hola Mundo!</h1>
        <?= $this->sección('javascript')?>
           sea a = 'a&#39;;
        <?= $this->sección final() ?>
    <?= $this->sección final() ?>


Representando la vista
**********************

La representación de la vista y su diseño se realiza exactamente como se mostraría cualquier otra vista dentro de un controlador:

.. literalinclude:: view_layouts/001.php

Representa la Vista **app/Views/some_view.php** y si extiende ``default``,
el diseño **app/Views/default.php** también se usa automáticamente.
El renderizador es lo suficientemente inteligente como para detectar si la vista debe representarse por sí sola o si necesita un diseño.


Incluyendo vistas parciales
***************************

Las vistas parciales son archivos de vista que no amplían ningún diseño. Por lo general, incluyen contenido que se puede reutilizar desde
vista a vista. Cuando utilice diseños de vista, debe usar ``$this->include()`` para incluir cualquier vista parcial.

::

    <?= $this->extender('predeterminado')?>

    <?= $this->sección('contenido')?>
        <h1>¡Hola Mundo!</h1>

        <?= $this->incluir('barra lateral')?>
    <?= $this->sección final() ?>

Al llamar al método ``include()``, puede pasarle todas las mismas opciones que cuando se renderiza una vista normal, incluyendo
directivas de caché, etc.
