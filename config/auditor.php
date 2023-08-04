<?php

return [
    // valid value: filesystem, database, and ...
    "driver" => "database",

    "database" => [
        "model" => \CID\AuditTrails\AuditModel::class
    ]
];
