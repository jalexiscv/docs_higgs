<?php

use Higgs\Database\RawSql;

$sql = "id > 2 AND name != 'Accountant'";
$builder->where(new RawSql($sql));
