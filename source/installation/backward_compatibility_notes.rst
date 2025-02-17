################################################
Notas de compatibilidad con versiones anteriores
################################################

En nuestro proceso de desarrollo, priorizamos la compatibilidad con versiones anteriores para garantizar una experiencia continua y sin contratiempos para nuestros usuarios. Nuestra estrategia se centra en mantener la estabilidad y funcionalidad de nuestras aplicaciones incluso durante las actualizaciones más pequeñas.

En términos generales, seguimos un enfoque de desarrollo que minimiza los cambios disruptivos en la interfaz de programación de aplicaciones (API) existente. Esto significa que, durante las actualizaciones regulares, como las correcciones de errores y mejoras menores, nos esforzamos por introducir nuevas funcionalidades sin afectar la funcionalidad previamente establecida. Esto garantiza que los usuarios puedan actualizar sus aplicaciones sin preocuparse por problemas de compatibilidad.

Sin embargo, dado que el desarrollo del código es un proceso dinámico y continuo, pueden surgir casos en los que las correcciones de errores necesarias puedan impactar la compatibilidad incluso en actualizaciones menores o parches. En tales circunstancias, nos aseguramos de documentar exhaustivamente todos los cambios significativos en nuestro registro de cambios para proporcionar una visión clara de las modificaciones realizadas y sus posibles implicaciones para los usuarios.

Nuestro compromiso con la transparencia y la calidad impulsa esta práctica, asegurando que nuestros usuarios estén informados y preparados para cualquier cambio que pueda afectar su experiencia con nuestros productos.

Los cambios considerados como no importantes incluyen:
******************************************************
- **Eliminación de elementos obsoletos**: Los elementos que se han vuelto obsoletos y ya no se utilizan activamente pueden ser eliminados en futuras versiones menores o posteriores. Por ejemplo, si un elemento ha estado obsoleto desde la versión 6.1.x, es probable que se elimine en la versión 6.2.0.
- **Mensajes del sistema definidos en system/Language/en/**: Estos mensajes están diseñados exclusivamente para el uso interno del marco y no están cubiertos por la promesa de compatibilidad con versiones anteriores. Si los desarrolladores dependen de la salida de la cadena de idioma, se recomienda que la comparen utilizando la función de llamada (lang('...')) en lugar de depender del contenido en sí.
- **Argumentos con nombre**: Los argumentos con nombre, según la documentación oficial de PHP, no están garantizados por la compatibilidad con versiones anteriores. Por lo tanto, podemos optar por cambiar los nombres de los parámetros de métodos/funciones según sea necesario para mejorar el código base.