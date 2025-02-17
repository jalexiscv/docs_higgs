######################
Configuración en Higgs
######################

En Higgs, cada clase que requiere configuración tiene su propio archivo en app/Config. Estos archivos definen clases
simples donde las configuraciones necesarias son propiedades públicas. A diferencia de otros frameworks que consolidan
configuraciones en un único archivo, Higgs distribuye los elementos configurables entre archivos específicos para cada
clase. Esto mejora la modularidad y claridad del código. Para crear o modificar configuraciones, simplemente accede a
los archivos correspondientes en la carpeta app/Config. Por ejemplo, para una clase llamada Pager, encontrarás su
configuración en app/Config/Pager.php.

.. toctree::
    :titlesonly:

    Trabajando con Archivos de Configuración  <../general/configuration-files>
    Variables de Entorno (DotEnv)  <../general/configuration-dotenv>
    Registradores  <../general/configuration-registers>
