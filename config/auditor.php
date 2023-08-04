<?php

return [
    // valid value: filesystem, database, and ...
    "driver" => "database",

    "repositories" => [
        "database" => [
            'model' => \CID\AuditTrails\AuditModel::class
        ]
    ]
];
