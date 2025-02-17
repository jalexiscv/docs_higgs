#############
Controladores
#############

Los controladores son el corazón de su aplicación, ya que determinan cómo se deben manejar las solicitudes HTTP.

.. contents::
    :local:
    :depth: 2

¿Qué es un controlador?
***********************

Un controlador es simplemente un archivo de clase que maneja una solicitud HTTP.
:doc:`Enrutamiento URI<routing>`  asocia un URI con un controlador. Devuelve un
ver cadena u objeto ``Respuesta``.

Cada controlador que cree debe extender la clase ``BaseController``.
Esta clase proporciona varias funciones que están disponibles para todos sus controladores.

.. _controller-constructor:

Constructor
***********

El controlador de Higgs tiene un constructor especial ``initController()``.
Será llamado por el marco después de la ejecución del constructor de PHP ``__construct()``.

Si desea anular ``initController()``, no olvide agregar ``parent::initController($request, $response, $logger);`` en el método:

.. literalinclude:: controllers/023.php

.. important:: You cannot use ``return`` in the constructor. So ``return redirect()->to('route');`` does not work.

El método ``initController()`` establece las siguientes tres propiedades.

Propiedades incluidas
*********************

El controlador de Higgs proporciona estas propiedades.

Solicitar objeto
================

El :doc:`Solicitar instancia principal de la aplicación</incoming/incomingrequest>` siempre está disponible
como propiedad de clase, ``$this->request``.

Objeto de respuesta
===================

La :doc:`Instancia de respuesta principal de la aplicación</outgoing/response>` siempre está disponible
como propiedad de clase, ``$this->response``.

Objeto registrador
==================

Una instancia de la clase :doc:`Logger <../general/logging>` está disponible como propiedad de clase,
``$this->logger``.

.. _controllers-helpers:

Ayudantes
=========

Puede definir una serie de archivos auxiliares como una propiedad de clase. Siempre que se carga el controlador
Estos archivos auxiliares se cargarán automáticamente en la memoria para que pueda utilizar sus métodos en cualquier lugar.
dentro del controlador:

.. literalinclude:: controllers/001.php

fuerzaHTTPS
***********

Un método conveniente para forzar el acceso a un método a través de HTTPS está disponible en todos
controladores:

.. literalinclude:: controllers/002.php

De forma predeterminada, y en los navegadores modernos que admiten el encabezado HTTP Strict Transport Security, esto
La llamada debería obligar al navegador a convertir llamadas que no sean HTTPS en llamadas HTTPS durante un año. Puede
modifique esto pasando la duración (en segundos) como primer parámetro:

.. literalinclude:: controllers/003.php

.. note:: A number of :doc:`time-based constants </general/common_functions>` are always available for you to use, including ``YEAR``, ``MONTH``, and more.

.. _controllers-validating-data:

Validación de datos
*******************

.. _controller-validatedata:

$this->validarDatos()
=====================

.. versionadded:: 4.2.0

Para simplificar la verificación de datos, el controlador también proporciona el método conveniente
``validarDatos()``.

El método acepta (1) una serie de datos para validar, (2) una serie de reglas,
(3) una serie opcional de mensajes de error personalizados para mostrar si los elementos no son válidos,
(4) un grupo de base de datos opcional para usar.

Los documentos :doc:`Biblioteca de validación</libraries/validation>` tener detalles sobre
formatos de reglas y matrices de mensajes, así como reglas disponibles:

.. literalinclude:: controllers/006.php

.. _controller-validate:

$esto->validar()
================

.. important:: This method exists only for backward compatibility. Do not use it
    en nuevos proyectos. Incluso si ya lo estás usando, te recomendamos que uses
    en su lugar, use el método ``validateData()``.

El controlador también proporciona el método conveniente ``validate()``.

.. warning:: Instead of ``validate()``, use ``validateData()`` to validate POST
    solo datos. ``validate()`` usa ``$request->getVar()`` que devuelve
    ``$_GET``, ``$_POST`` o ``$_COOKIE`` en ese orden (dependiendo de php.ini
    `solicitud-orden<https://www.php.net/manual/en/ini.core.php#ini.request-order>` _).
    Los valores más nuevos anulan los valores más antiguos. Los valores POST pueden ser anulados por el
    cookies si tienen el mismo nombre.

El método acepta una serie de reglas en el primer parámetro,
y en el segundo parámetro opcional, una serie de mensajes de error personalizados para mostrar
si los artículos no son válidos.

Internamente, esto utiliza el controlador
Instancia ``$this->request`` para obtener los datos a validar.

Los documentos :doc:`Biblioteca de validación</libraries/validation>` tener detalles sobre
formatos de reglas y matrices de mensajes, así como reglas disponibles:

.. literalinclude:: controllers/004.php

.. warning:: When you use the ``validate()`` method, you should use the
    :ref:`obtenerValidado()<validation-getting-validated-data>` método para obtener el
    datos validados. Debido a que el método ``validate()`` utiliza el
    :ref:`Validación::conSolicitud()<validation-withrequest>` método internamente,
    y valida los datos de
    :ref:`$solicitud->getJSON()<incomingrequest-getting-json-data>`
    o :ref:`$solicitud->getRawInput()<incomingrequest-retrieving-raw-data>`
    o :ref:`$solicitud->getVar()<incomingrequest-getting-data>` , y un atacante
    podría cambiar qué datos se validan.

.. note:: The :ref:`$this->validator->getValidated() <validation-getting-validated-data>`
    El método se puede utilizar desde v7.4.0.

Si le resulta más sencillo mantener las reglas en el archivo de configuración, puede reemplazar
la matriz ``$rules`` con el nombre del grupo como se define en **app/Config/Validation.php**:

.. literalinclude:: controllers/005.php

.. note:: Validation can also be handled automatically in the model, but sometimes it's easier to do it in the controller. Where is up to you.

Métodos de protección
*********************

En algunos casos, es posible que desee ocultar ciertos métodos del acceso público.
Para lograr esto, simplemente declare el método como "privado" o "protegido".
Eso evitará que sea atendido mediante una solicitud de URL.

Por ejemplo, si tuvieras que definir un método como este para el controlador ``Helloworld``:

.. literalinclude:: controllers/007.php

y definir una ruta (``helloworld/utitilty``) para el método. Entonces intentar acceder a él utilizando la siguiente URL no funcionará::

    ejemplo.com/index.php/helloworld/utility

El enrutamiento automático tampoco funcionará.

.. _controller-auto-routing-improved:

Ruta automática (mejorada)
**************************

.. versionadded:: 4.2.0

Desde la versión 4.2.0, se introdujo el nuevo enrutamiento automático más seguro.

.. note:: If you are familiar with Auto Routing, which was enabled by default
    desde Higgs 3 hasta 4.1.x, puedes ver las diferencias en
    :ref:`Registro de cambios v7.2.0<v420-new-improved-auto-routing>` .

Esta sección describe la funcionalidad del nuevo enrutamiento automático.
Enruta automáticamente una solicitud HTTP y ejecuta el método de controlador correspondiente.
sin definiciones de ruta.

Desde v7.2.0, el enrutamiento automático está deshabilitado de forma predeterminada. Para usarlo, consulte :ref:`enabled-auto-routing-improved`.

Considere este URI::

    ejemplo.com/index.php/helloworld/

En el ejemplo anterior, Higgs intentaría encontrar un controlador llamado ``App\Controllers\Helloworld`` y cargarlo cuando el enrutamiento automático está habilitado.

.. note:: When a controller's short name matches the first segment of a URI, it will be loaded.

Probémoslo: ¡Hola mundo!
========================

Creemos un controlador simple para que puedas verlo en acción. Usando su editor de texto, cree un archivo llamado **Helloworld.php**,
y ponga el siguiente código en él. Notarás que el controlador ``Helloworld`` está extendiendo el ``BaseController``. puede
También extienda ``Higgs\Controller`` si no necesita la funcionalidad de BaseController.

El BaseController proporciona un lugar conveniente para cargar componentes y realizar funciones que necesitan todos sus
controladores. Puede ampliar esta clase en cualquier controlador nuevo.

.. literalinclude:: controllers/020.php

Luego guarde el archivo en su directorio **app/Controllers**.

.. important:: The file must be called **Helloworld.php**, with a capital ``H``. When you use Auto Routing, Controller class names MUST start with an uppercase letter and ONLY the first character can be uppercase.

.. important:: A controller method that will be executed by Auto Routing (Improved) needs HTTP verb (``get``, ``post``, ``put``, etc.) prefix like ``getIndex()``, ``postCreate()``.

Ahora visite su sitio usando una URL similar a esta::

    ejemplo.com/index.php/helloworld

Si lo hiciste bien deberías ver::

    ¡Hola Mundo!

Esto es válido:

.. literalinclude:: controllers/009.php

Esto **no** es válido:

.. literalinclude:: controllers/010.php

Esto **no** es válido:

.. literalinclude:: controllers/011.php

Además, asegúrese siempre de que su controlador extienda el controlador principal
clase para que pueda heredar todos sus métodos.

.. note::

    El sistema intentará hacer coincidir el URI con los controladores haciendo coincidir cada segmento con
    directorios/archivos en **aplicación/Controladores**, cuando no se encontró una coincidencia con las rutas definidas.
    Es por eso que sus directorios/archivos DEBEN comenzar con una letra mayúscula y el resto DEBE estar en minúsculas.

    Si desea otra convención de nomenclatura, debe definirla manualmente utilizando el
    :ref:`Enrutamiento de ruta definida<defined-route-routing>` .
    A continuación se muestra un ejemplo basado en el cargador automático PSR-4:

    .. literalinclude:: controllers/012.php

Métodos
=======

Visibilidad del método
-----------------

Cuando define un método que es ejecutable a través de una solicitud HTTP, el método debe ser
declarado como ``público``.

.. warning:: For security reasons be sure to declare any new utility methods as ``protected`` or ``private``.

Método predeterminado
--------------

En el ejemplo anterior, el nombre del método es ``getIndex()``.
El método (verbo HTTP + ``Index()``) se denomina **método predeterminado** y se carga si el **segundo segmento** del URI está vacío.

Métodos normales
--------------

El segundo segmento del URI determina qué método en el
Se llama al controlador.

Vamos a intentarlo. Agregue un nuevo método a su controlador:

.. literalinclude:: controllers/021.php

Ahora cargue la siguiente URL para ver el método ``getComment()``::

    ejemplo.com/index.php/helloworld/comment/

Deberías ver tu nuevo mensaje.

Pasar segmentos de URI a sus métodos
====================================

Si su URI contiene más de dos segmentos, se pasarán a su
método como parámetros.

Por ejemplo, digamos que tiene un URI como este::

    ejemplo.com/index.php/products/shoes/sandals/123

A su método se le pasarán los segmentos URI 3 y 4 (``'sandals'`` y ``'123'``):

.. literalinclude:: controllers/022.php

Controlador predeterminado
==========================

El controlador predeterminado es un controlador especial que se utiliza cuando un URI termina con
un nombre de directorio o cuando un URI no está presente, como será el caso cuando solo su
Se solicita la URL raíz del sitio.

Definición de un controlador predeterminado
-----------------------

Probémoslo con el controlador ``Helloworld``.

Para especificar un controlador predeterminado, abra su **app/Config/Routing.php**
archivo y establezca esta propiedad::

    cadena pública $defaultController = 'Holamundo&#39;;

Donde ``Helloworld`` es el nombre de la clase de controlador que desea utilizar.

Y comenta la línea en **app/Config/Routes.php**:

.. literalinclude:: controllers/016.php
    :lines: 2-

Si ahora navega hasta su sitio sin especificar ningún segmento de URI,
vea el mensaje "Hola mundo".

.. important:: When you use Auto Routing (Improved), you must remove the line
    ``$rutas->get('/', 'Inicio::index');``. Porque las rutas definidas toman
    prioridad sobre el enrutamiento automático y los controladores definidos en las rutas definidas
    El enrutamiento automático (mejorado) les niega el acceso por razones de seguridad.

Para obtener más información, consulte la
:ref: documentación `enrutamiento-automático-opciones-de-configuración mejoradas`.

.. _controller-default-method-fallback:

Método alternativo predeterminado
=================================

.. versionadded:: 4.4.0

Si el método del controlador correspondiente al segmento URI del nombre del método
no existe, y si se define el método predeterminado, los segmentos de URI restantes
se pasan al método predeterminado para su ejecución.

.. literalinclude:: controllers/024.php

Cargue la siguiente URL::

    ejemplo.com/index.php/product/15/edit

Al método se le pasarán los segmentos URI 2 y 3 (``'15'`` y ``'edit'``):

.. important:: If there are more parameters in the URI than the method parameters,
    El enrutamiento automático (mejorado) no ejecuta el método y genera 404
    Extraviado.

Retorno al controlador predeterminado
------------------------------

Si el controlador correspondiente al segmento URI del nombre del controlador
no existe, y si el controlador predeterminado ("Home" por defecto) existe en
el directorio, los segmentos URI restantes se pasan al directorio del controlador predeterminado
método predeterminado.

Por ejemplo, cuando tiene el siguiente controlador predeterminado ``Home`` en el
Directorio **aplicación/Controladores/Noticias**:

.. literalinclude:: controllers/025.php

Cargue la siguiente URL::

    ejemplo.com/index.php/news/101

Se encontrarán el controlador ``News\Home`` y el método predeterminado ``getIndex()``.
Por lo tanto, al método predeterminado se le pasarán los segmentos URI 2 (``'101'``):

.. note:: If there is ``App\Controllers\News`` controller, it takes precedence.
    Los segmentos de URI se buscan secuencialmente y se encuentra el primer controlador
    se utiliza.

.. note:: If there are more parameters in the URI than the method parameters,
    El enrutamiento automático (mejorado) no ejecuta el método y genera 404
    Extraviado.

Organizar sus controladores en subdirectorios
=============================================

Si está creando una aplicación grande, es posible que desee crearla jerárquicamente.
Organice o estructure sus controladores en subdirectorios. Higgs
le permite hacer esto.

Simplemente cree subdirectorios en la **aplicación/Controladores** principal,
y coloque sus clases de controlador dentro de ellas.

.. important:: Directory names MUST start with an uppercase letter and ONLY the first character can be uppercase.

Al utilizar esta función, el primer segmento de su URI debe
especifique el directorio. Por ejemplo, digamos que tiene un controlador ubicado aquí::

    aplicación/Controladores/Productos/Zapatos.php

Para llamar al controlador anterior, su URI se verá así:

    ejemplo.com/index.php/products/shoes/show/123

.. note:: You cannot have directories with the same name in **app/Controllers**
    y **público**.
    Esto se debe a que si hay un directorio, el servidor web lo buscará y
    no será encaminado al Higgs.

Cada uno de sus subdirectorios puede contener un controlador predeterminado que será
Se llama si la URL contiene *sólo* el subdirectorio. Simplemente pon un controlador
allí que coincida con el nombre de su controlador predeterminado como se especifica en
su archivo **app/Config/Routing.php**.

Higgs también le permite mapear sus URI utilizando su :ref:`Enrutamiento de ruta definido<defined-route-routing>` ...

.. _controller-auto-routing-legacy:

Enrutamiento automático (heredado)
**********************************

.. important:: This feature exists only for backward compatibility. Do not use it
    en nuevos proyectos. Incluso si ya lo estás usando, te recomendamos que uses
    el :ref:`auto-routing-improved` en su lugar.

Esta sección describe la funcionalidad de Auto Routing (Legacy), que es un sistema de enrutamiento de Higgs 3.
Enruta automáticamente una solicitud HTTP y ejecuta el método de controlador correspondiente.
sin definiciones de ruta. El enrutamiento automático está deshabilitado de forma predeterminada.

.. warning:: To prevent misconfiguration and miscoding, we recommend that you do not use
    Enrutamiento automático (heredado). Es fácil crear aplicaciones vulnerables donde el controlador filtra
    o la protección CSRF se omiten.

.. important:: Auto Routing (Legacy) routes a HTTP request with **any** HTTP method to a controller method.

Considere este URI::

    ejemplo.com/index.php/helloworld/

En el ejemplo anterior, Higgs intentaría encontrar un controlador llamado **Helloworld.php** y cargarlo.

.. note:: When a controller's short name matches the first segment of a URI, it will be loaded.

Probémoslo: ¡Hola mundo! (Legado)
=================================

Creemos un controlador simple para que puedas verlo en acción. Usando su editor de texto, cree un archivo llamado **Helloworld.php**,
y ponga el siguiente código en él. Notarás que el controlador ``Helloworld`` está extendiendo el ``BaseController``. puede
También extienda ``Higgs\Controller`` si no necesita la funcionalidad de BaseController.

El BaseController proporciona un lugar conveniente para cargar componentes y realizar funciones que necesitan todos sus
controladores. Puede ampliar esta clase en cualquier controlador nuevo.

Por razones de seguridad, asegúrese de declarar cualquier método de utilidad nuevo como "protegido" o "privado":

.. literalinclude:: controllers/008.php

Luego guarde el archivo en su directorio **app/Controllers**.

.. important:: The file must be called **Helloworld.php**, with a capital ``H``. When you use Auto Routing, Controller class names MUST start with an uppercase letter and ONLY the first character can be uppercase.

Ahora visite su sitio usando una URL similar a esta::

    ejemplo.com/index.php/helloworld

Si lo hiciste bien deberías ver::

    ¡Hola Mundo!

Esto es válido:

.. literalinclude:: controllers/009.php

Esto **no** es válido:

.. literalinclude:: controllers/010.php

Esto **no** es válido:

.. literalinclude:: controllers/011.php

Además, asegúrese siempre de que su controlador extienda el controlador principal
clase para que pueda heredar todos sus métodos.

.. note::

    El sistema intentará hacer coincidir el URI con los controladores haciendo coincidir cada segmento con
    directorios/archivos en **aplicación/Controladores**, cuando no se encontró una coincidencia con las rutas definidas.
    Es por eso que sus directorios/archivos DEBEN comenzar con una letra mayúscula y el resto DEBE estar en minúsculas.

    Si desea otra convención de nomenclatura, debe definirla manualmente utilizando el
    :ref:`Enrutamiento de ruta definida<defined-route-routing>` .
    A continuación se muestra un ejemplo basado en el cargador automático PSR-4:

    .. literalinclude:: controllers/012.php

Métodos (heredados)
===================

En el ejemplo anterior, el nombre del método es ``index()``. El método ``índice()``
siempre se carga de forma predeterminada si el **segundo segmento** del URI es
vacío. Otra forma de mostrar tu mensaje "Hola mundo" sería esta::

    ejemplo.com/index.php/helloworld/index/

**El segundo segmento del URI determina qué método en el
Se llama al controlador.**

Vamos a intentarlo. Agregue un nuevo método a su controlador:

.. literalinclude:: controllers/013.php

Ahora cargue la siguiente URL para ver el método de comentario::

    ejemplo.com/index.php/helloworld/comment/

Deberías ver tu nuevo mensaje.

Pasar segmentos de URI a sus métodos (heredados)
================================================

Si su URI contiene más de dos segmentos, se pasarán a su
método como parámetros.

Por ejemplo, digamos que tiene un URI como este::

    ejemplo.com/index.php/products/shoes/sandals/123

A su método se le pasarán los segmentos URI 3 y 4 (``'sandals'`` y ``'123'``):

.. literalinclude:: controllers/014.php

Controlador predeterminado (heredado)
=====================================

El controlador predeterminado es un controlador especial que se utiliza cuando un URI termina con
un nombre de directorio o cuando un URI no está presente, como será el caso cuando solo su
Se solicita la URL raíz del sitio.

Definición de un controlador predeterminado (heredado)
--------------------------------------

Probémoslo con el controlador ``Helloworld``.

Para especificar un controlador predeterminado, abra su **app/Config/Routing.php**
archivo y establezca esta propiedad::

    cadena pública $defaultController = 'Holamundo&#39;;

Donde ``Helloworld`` es el nombre de la clase de controlador que desea utilizar.

Y comenta la línea en **app/Config/Routes.php**:

.. literalinclude:: controllers/016.php
    :lines: 2-

Si ahora navega hasta su sitio sin especificar ningún segmento de URI,
vea el mensaje "Hola mundo".

.. note:: The line ``$routes->get('/', 'Home::index');`` is an optimization that you will want to use in a "real-world" app. But for demonstration purposes we don't want to use that feature. ``$routes->get()`` is explained in :doc:`URI Routing <routing>`

Para obtener más información, consulte el
:ref: documentación `enrutamiento-auto-enrutamiento-heredado-configuración-opciones`.

Organizar sus controladores en subdirectorios (heredados)
==================================================== =======

Si está creando una aplicación grande, es posible que desee crearla jerárquicamente.
Organice o estructure sus controladores en subdirectorios. Higgs
le permite hacer esto.

Simplemente cree subdirectorios en la **aplicación/Controladores** principal,
y coloque sus clases de controlador dentro de ellas.

.. important:: Directory names MUST start with an uppercase letter and ONLY the first character can be uppercase.

Al utilizar esta función, el primer segmento de su URI debe
especifique el directorio. Por ejemplo, digamos que tiene un controlador ubicado aquí::

    aplicación/Controladores/Productos/Zapatos.php

Para llamar al controlador anterior, su URI se verá así:

    ejemplo.com/index.php/products/shoes/show/123

.. note:: You cannot have directories with the same name in **app/Controllers** and **public/**.
    Esto se debe a que si hay un directorio, el servidor web lo buscará y
    no será encaminado al Higgs.

Cada uno de sus subdirectorios puede contener un controlador predeterminado que será
Se llama si la URL contiene *sólo* el subdirectorio. Simplemente pon un controlador
allí que coincida con el nombre de su controlador predeterminado como se especifica en
su archivo **app/Config/Routing.php**.

Higgs también le permite mapear sus URI utilizando su :ref:`Enrutamiento de ruta definido<defined-route-routing>` ...

Llamadas a métodos de reasignación
**********************************

.. note:: **Auto Routing (Improved)** does not support this feature intentionally.

Como se señaló anteriormente, el segundo segmento del URI generalmente determina qué
Se llama al método en el controlador. Higgs te permite anular
este comportamiento mediante el uso del método ``_remap()``:

.. literalinclude:: controllers/017.php

.. important:: If your controller contains a method named ``_remap()``,
    **siempre** será llamado independientemente de lo que contenga su URI. Él
    anula el comportamiento normal en el que el URI determina qué método
    Se llama, lo que le permite definir sus propias reglas de enrutamiento de métodos.

La llamada al método anulado (normalmente el segundo segmento del URI)
pasarse como parámetro al método ``_remap()``:

.. literalinclude:: controllers/018.php

Cualquier segmento adicional después del nombre del método se pasa a ``_remap()``. Estos parámetros se pueden pasar al método.
para emular el comportamiento predeterminado de Higgs.

Ejemplo:

.. literalinclude:: controllers/019.php

Ampliación del controlador
**************************

Si desea ampliar el controlador, consulte :doc:`../extending/basecontroller`.

¡Eso es todo!
*************

Esto, en pocas palabras, es todo lo que hay que saber sobre los controladores.
