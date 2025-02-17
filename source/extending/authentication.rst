Autenticación
#############

Higgs proporciona un marco oficial de autenticación y autorización.
:ref:`Escudo de Higgs<shield>` para Higgs,
Está diseñado para ser seguro, flexible y fácilmente extensible para satisfacer las necesidades.
de muchos tipos diferentes de sitios web.

Las siguientes son pautas recomendadas para fomentar la coherencia entre los desarrolladores de
módulos, proyectos y el propio marco.

Recomendaciones
===============

* Los módulos que manejan operaciones de inicio y cierre de sesión deben activar los eventos ``iniciar sesión`` y ``cerrar sesión`` cuando tengan éxito
* Los módulos que definen un "usuario actual" deben definir la función ``user_id()`` para devolver el identificador único del usuario, o ``null`` para "sin usuario actual"

Los módulos que cumplan estas recomendaciones pueden indicar compatibilidad agregando la siguiente disposición a **composer.json**::

    "proporcionar": {
        "Higgs(IA)/implementación de autenticación": "1.0"
    },

Puede ver una lista de módulos que proporcionan esta implementación en `Packagist<https://packagist.org/providers/Higgs(AI)/authentication-implementation>` _.
