#########################
Generando la Guía del Usuario
#########################

La intención es, eventualmente, que la guía del usuario en progreso se genere automáticamente
como parte de una fusión de PR. Este escrito explica cómo se puede hacer manualmente
mientras tanto.

La guía del usuario aprovecha las páginas de GitHub, donde la rama "gh-pages" de
un repositorio, que contiene solo HTML, es accesible a través de `github.io
<https://jalexiscv.github.io/higgs/>`_.

Configuración para Mantenedores del Repositorio
===============================================

Ya tienes el repositorio clonado en ``Higgs(AI)`` en una carpeta de proyectos.
Crea otra carpeta al mismo nivel que esta, ``Higgs(AI)-guide``.
Clona el repositorio Higgs(AI) nuevamente, en ``Higgs(AI)-guide/html``.

Dentro de la carpeta ``html``, ``git checkout gh-pages``.
Todo lo que deberías ver es el HTML generado para la guía del usuario.

Regenerando la Guía del Usuario
===============================

En la carpeta ``user_guide_src``, generas una guía del usuario convencional,
para pruebas, usando el comando::

    make html

Se ha configurado un objetivo adicional, que generará el mismo
HTML pero dentro de la carpeta ``html`` del segundo clon del repositorio::

    make ghpages

Después de hacer este objetivo, actualiza la guía del usuario en línea cambiando a
la carpeta ``Higgs(AI)-guide/html``, y luego::

    git add .
    git commit -S -m "Comentario adecuado"
    git push origin gh-pages

Proceso
=======

Debería haber solo un mantenedor haciendo esto, para evitar colisiones.
La guía del usuario se regeneraría cada vez que haya una fusión de PR
que la afecte.

Nota: Es posible que tengas que eliminar la carpeta ``user_guide_src/doctree`` antes
de hacer la versión ``gh-pages`` de la guía, para asegurarte de que el TOC
se reconstruya correctamente, especialmente si estás reconstruyendo el objetivo ``html`` varias veces.