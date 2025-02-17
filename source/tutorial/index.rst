##########################
Cree su primera aplicación
##########################

.. contents::
    :local:
    :depth: 2

Descripción general
*******************

Este tutorial tiene como objetivo presentarle el marco de Higgs (IA).
y los principios básicos de la arquitectura MVC. Le mostrará cómo un
La aplicación básica de Higgs se construye paso a paso.

Si no está familiarizado con PHP, le recomendamos que consulte
el `Tutorial PHP de W3Schools<https://www.w3schools.com/php/default.asp>` _ antes de continuar.

En este tutorial, creará una **aplicación de noticias básica**. Tú
Comenzaremos escribiendo el código que puede cargar páginas estáticas. A continuación, tú
creará una sección de noticias que lee noticias de una base de datos.
Finalmente, agregará un formulario para crear noticias en la base de datos.

Este tutorial se centrará principalmente en:

- Conceptos básicos de Modelo-Vista-Controlador
- Conceptos básicos de enrutamiento
- Validación de formulario
- Realización de consultas básicas a bases de datos utilizando el modelo de Higgs.

El tutorial completo se divide en varias páginas, cada una de las cuales explica una
pequeña parte de la funcionalidad del marco de Higgs. Usted irá
a través de las siguientes páginas:

- Introducción, esta página, que le brinda una descripción general de qué
   expect y descarga y ejecuta su aplicación predeterminada.
- :doc:`Páginas estáticas<static_pages>` , que te enseñará los conceptos básicos
   de controladores, vistas y enrutamiento.
- :doc:`Sección de noticias<news_section>` , donde comenzarás a usar modelos.
   y realizará algunas operaciones básicas de bases de datos.
- :doc:`Crear noticias<create_news_items>` , que introducirá
   operaciones de bases de datos más avanzadas y validación de formularios.
- :doc:`Conclusión<conclusion>` , que le dará algunos consejos sobre
   lecturas adicionales y otros recursos.

Disfrute de su exploración del marco de Higgs.

.. toctree::
    :hidden:
    :titlesonly:

    static_pages
    news_section
    create_news_items
    conclusion

Ponerse en marcha
*****************

Instalación de Higgs
====================

Puede descargar una versión manualmente desde el sitio, pero para este tutorial lo haremos
utilice la forma recomendada e instale el paquete AppStarter a través de Composer.
Desde su línea de comando escriba lo siguiente:

.. code-block:: console

    compositor crear-proyecto Higgs(AI)/appstarter ci-news

Esto crea una nueva carpeta, **ci-news**, que contiene el código de su aplicación, con
Higgs instalado en la carpeta del proveedor.

.. _setting-development-mode:

Configuración del modo de desarrollo
====================================

De forma predeterminada, Higgs se inicia en modo de producción. Esta es una característica de seguridad
para mantener su sitio un poco más seguro en caso de que la configuración se estropee una vez que esté activo.
Así que primero arreglemos eso. Copie o cambie el nombre del archivo **env** a **.env**. Abrelo.

Este archivo contiene configuraciones específicas del servidor. Esto significa que nunca necesitarás
envíe cualquier información confidencial a su sistema de control de versiones. Incluye
algunos de los más comunes ya quieres ingresar, aunque todos están comentados
afuera. Así que descomente la línea con ``HIGGS_ENVIRONMENT`` y cambie ``production`` a
``development``::

    HIGGS_ENVIRONMENT = desarrollo

Ejecución del servidor de desarrollo
====================================

Una vez aclarado esto, es hora de ver su aplicación en un navegador. Puede
sírvalo a través de cualquier servidor de su elección, Apache, nginx, etc., pero Higgs
viene con un comando simple que aprovecha el servidor integrado de PHP para obtener
estará listo y funcionando rápidamente en sus máquinas de desarrollo. Escriba lo siguiente en el
línea de comando desde la raíz de su proyecto:

.. code-block:: console

    servicio de chispa php

La página de bienvenida
***********************

Ahora apunte su navegador a la URL correcta y aparecerá una pantalla de bienvenida.
Pruébelo ahora dirigiéndose a la siguiente URL::

    http://localhost:8080

y debería ser recibido por la siguiente página:



Esto significa que su aplicación funciona y puede comenzar a realizar cambios en ella.

Depuración
**********

Barra de herramientas de depuración
===================================

Ahora que estás en modo de desarrollo, verás la llama de Higgs en la parte inferior derecha de tu aplicación. Haga clic en él y verá la barra de herramientas de depuración.

Esta barra de herramientas contiene una serie de elementos útiles a los que puede consultar durante el desarrollo.
Esto nunca se mostrará en entornos de producción. Al hacer clic en cualquiera de las pestañas en la parte inferior
muestra información adicional. Al hacer clic en la X a la derecha de la barra de herramientas, se minimiza.
a un pequeño cuadrado con la llama de Higgs. Si haces clic en eso, la barra de herramientas
se mostrará de nuevo.



Páginas de error
================

Además de esto, Higgs tiene algunas páginas de error útiles cuando se encuentran excepciones o
otros errores en su programa. Abre **app/Controllers/Home.php** y cambia alguna línea
para generar un error (¡eliminar un punto y coma o una llave debería ser suficiente!). Usted será
recibido por una pantalla que se parece a esta:



Hay un par de cosas a tener en cuenta aquí:

1. Al pasar el cursor sobre el encabezado rojo en la parte superior, se abrirá un enlace de **búsqueda**.
   DuckDuckGo.com en una nueva pestaña y buscando la excepción.
2. Al hacer clic en el enlace **argumentos** en cualquier línea del Backtrace se expandirá una lista de
   los argumentos que se pasaron a esa llamada de función.

Todo lo demás debería quedar claro cuando lo veas.

Ahora que sabemos cómo empezar y cómo depurar un poco, comencemos a construir esto.
Pequeña aplicación de noticias.
