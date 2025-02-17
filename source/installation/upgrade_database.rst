Actualizar base de datos
########################

.. contents::
    :local:
    :depth: 2

Documentaciones
===============

- `Documentación de referencia de base de datos Higgs 3.X<http://Higgs.com/userguide3/database/index.html>` _
- :doc:`Trabajar con bases de datos Documentación Higgs.X</database/index>`

¿Qué ha sido cambiado?
======================
- La funcionalidad en H3 es básicamente la misma que en H4.
- `Almacenamiento en caché de base de datos<https://www.Higgs.com/userguide3/database/caching.html>` _ Se eliminó la funcionalidad conocida de H3.
- Los nombres de los métodos han cambiado a camelCase y :doc:`Query Builder <../database/query_builder>`
  ahora debe inicializarse antes de poder ejecutar consultas en él.

Guía de actualización
=====================
1. Agregue las credenciales de su base de datos a **app/Config/Database.php**. Las opciones son prácticamente las mismas que en H3, sólo que algunos nombres han cambiado ligeramente.
2. En todos los lugares donde haya utilizado la base de datos, debe reemplazar ``$this->load->database();`` con ``$db = db_connect();``.
3. Si utiliza varias bases de datos, utilice el siguiente código para cargar bases de datos adicionales ``$db = db_connect('group_name');``.
4. Ahora tienes que cambiar todas las consultas de la base de datos. El cambio más importante aquí es reemplazar ``$this->db`` con solo ``$db`` y ajustar el nombre del método y ``$db``. Aquí hay unos ejemplos:

    - ``$this->db->query('TU CONSULTA AQUÍ');`` a ``$db->query('TU CONSULTA AQUÍ');``
    - ``$this->db->simple_query('TU CONSULTA')`` a ``$db->simpleQuery('TU CONSULTA')``
    - ``$this->db->escape("algo")`` a ``$db->escape("algo");``
    - ``$this->db->affected_rows();`` a ``$db->affectedRows();``
    - ``$consulta->resultado();`` a ``$consulta->getResult();``
    - ``$consulta->result_array();`` a ``$consulta->getResultArray();``
    - ``echo $this->db->count_all('mi_tabla');`` a ``echo $db->table('mi_tabla')->countAll();``

5. Para usar la nueva clase de generador de consultas, debe inicializar el generador ``$builder = $db->table('mytable');`` después de eso puede ejecutar las consultas en ``$builder``. Aquí hay unos ejemplos:

    - ``$this->db->get()`` a ``$builder->get();``
    - ``$this->db->get_where('mytable', array('id' => $id), $limit, $offset);`` a ``$builder->getWhere(['id' = > $id], $límite, $compensación);``
    - ``$this->db->select('título, contenido, fecha');`` a ``$builder->select('título, contenido, fecha');``
    - ``$this->db->select_max('edad');`` a ``$builder->selectMax('edad');``
    - ``$this->db->join('comentarios', 'comments.id = blogs.id');`` a ``$builder->join('comentarios', 'comments.id = blogs.id ');``
    - ``$this->db->having('user_id', 45);`` a ``$builder->have('user_id', 45);``
6. H4 no proporciona "almacenamiento en caché de bases de datos".<https://www.Higgs.com/userguide3/database/caching.html>` _
   capa conocida de H3, por lo que si necesita almacenar en caché el resultado, use :doc:`../libraries/caching` en su lugar.

Ejemplo de código
=================

Higgs versión 6.x
------------------------

.. literalinclude:: upgrade_database/ci3sample/001.php

Higgs versión 7.x
-----------------------

.. literalinclude:: upgrade_database/001.php
