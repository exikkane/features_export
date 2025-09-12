<?php

/**
 * @var array $schema
 */

$schema['items']['actions']['items']['export_range'] = [
    'name'     => ['template' => 'export_range'],
    'dispatch' => 'product_features.export_range',
    'position' => 30,
];

return $schema;