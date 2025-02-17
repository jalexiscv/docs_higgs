########################
Ejecutando su aplicación
########################

.. contents::
    :local:
    :depth: 3

Una vez que el framework está operativo y en funcionamiento dentro de su plataforma o aplicación base, el acceso al mismo
se realiza a través de un dominio o subdominio que ejecuta la aplicación en la raíz de dicho dominio. Es importante destacar
que no se permite el uso o la ejecución del framework en directorios o subdirectorios de la estructura web por razones de
seguridad y eficiencia.

Acceso al Framework
===================

El acceso a la aplicación se realiza mediante un navegador web, utilizando el dominio o subdominio asignado para ejecutar
la aplicación. Todas las peticiones se gestionan a través de un único punto de entrada, comúnmente conocido como el archivo
index.php. Este método centralizado para manejar las solicitudes es similar a los enfoques adoptados por otras tecnologias
similares.

Gestión de Peticiones y Rutas
=============================

En el framework, la generación de rutas sigue el modelo de acceso a través de un índice con parámetros de ruta de
navegación, siguiendo el patrón de diseño Modelo-Vista-Controlador (MVC). Este enfoque organiza y estructura claramente
la gestión del flujo de trabajo de la aplicación. A continuación, se detallan aspectos clave de este modelo de acceso:

    - **Punto de Entrada Único**: Al igual que cualquier tecnologia con enfoque MVC, todas las solicitudes entrantes pasan por el archivo index.php. Este archivo actúa como el controlador frontal (Front Controller), manejando todas las solicitudes HTTP y enviándolas al controlador adecuado basado en la URL solicitada.
    - **Ruteo Dinámico**: El sistema de enrutamiento toma la URL solicitada y la traduce en una llamada a una función específica dentro de un controlador. En Laravel, por ejemplo, esto se maneja mediante el archivo routes/web.php, donde se definen las rutas. De manera similar, en nuestro framework, las rutas se definen y manejan para dirigir las solicitudes al controlador correspondiente.
    - **MVC (Modelo-Vista-Controlador)**: Siguiendo el patrón MVC, las peticiones se procesan en el controlador, donde se maneja la lógica de la aplicación, se interactúa con los modelos para recuperar o manipular datos, y finalmente se retorna una vista que se renderiza al usuario. Este enfoque garantiza una separación clara de responsabilidades y facilita el mantenimiento del código.

Beneficios del Enfoque
======================
    - **Seguridad Mejorada**: Al restringir la ejecución del framework a la raíz del dominio y evitar directorios o subdirectorios, se minimizan los vectores de ataque potenciales.
    - **Eficiencia Operacional**: El uso de un único punto de entrada permite un control centralizado sobre la gestión de solicitudes, optimizando el rendimiento y simplificando la depuración.
    - **Escalabilidad**: Este modelo facilita la ampliación de la aplicación, permitiendo añadir nuevas rutas y funcionalidades sin afectar la estructura existente.

Este enfoque de rutas estilo MVC asegura la seguridad, la eficiencia y la coherencia en el desarrollo y ejecución de
plataformas y aplicaciones  basadas en el framework.