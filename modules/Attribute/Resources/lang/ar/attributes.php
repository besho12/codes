<?php

return [
    'attributes' => [
        'attribute_set_id' => 'مجموعة السمات',
        'name' => 'الاسم',
        'categories' => 'الفئات',
        'slug' => 'الرابط',
        'is_filterable' => 'قابل للتصفية',
    ],
    'attribute_sets' => [
        'name' => 'الاسم',
    ],
    'product_attributes' => [
        'attributes.*.attribute_id' => 'السمة',
        'attributes.*.values' => 'القيم',
    ],
];
