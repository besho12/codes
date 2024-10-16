<?php

return [
    'name' => 'الاسم',
    'slug' => 'الرابط',
    'description' => 'الوصف',
    'short_description' => 'الوصف القصير',
    'brand_id' => 'العلامة التجارية',
    'categories' => 'الفئات',
    'tax_class_id' => 'فئة الضريبة',
    'tags' => 'الوسوم',
    'is_virtual' => 'افتراضي',
    'is_active' => 'الحالة',
    'price' => 'السعر',
    'special_price' => 'سعر خاص',
    'special_price_type' => 'نوع السعر الخاص',
    'special_price_start' => 'بداية السعر الخاص',
    'special_price_end' => 'نهاية السعر الخاص',
    'sku' => 'SKU',
    'manage_stock' => 'إدارة المخزون',
    'qty' => 'الكمية',
    'in_stock' => 'توفر المخزون',
    'new_from' => 'جديد من',
    'new_to' => 'جديد إلى',
    'up_sells' => 'البيع الإضافي',
    'cross_sells' => 'البيع المتقاطع',
    'related_products' => 'المنتجات ذات الصلة',

    # product attributes
    'attributes' => [
        '*.attribute_id' => 'السمة',
        '*.values' => 'القيم',
    ],

    # product options
    'options' => [
        '*.name' => 'الاسم',
        '*.type' => 'النوع',
        '*.values.*.label' => 'التسمية',
        '*.values.*.price' => 'السعر',
        '*.values.*.price_type' => 'نوع السعر',
    ],

    # product variations
    'variations' => [
        '*.name' => 'الاسم',
        '*.type' => 'النوع',
        '*.values' => 'القيم',
        '*.values.*.label' => 'التسمية',
        '*.values.*.color' => 'اللون',
        '*.values.*.image' => 'الصورة',
    ],

    # product variants
    'variants' => [
        '*.name' => 'الاسم',
        '*.sku' => 'SKU',
        '*.is_active' => 'الحالة',
        '*.is_default' => 'افتراضي',
        '*.price' => 'السعر',
        '*.special_price' => 'سعر خاص',
        '*.special_price_type' => 'نوع السعر الخاص',
        '*.special_price_start' => 'بداية السعر الخاص',
        '*.special_price_end' => 'نهاية السعر الخاص',
        '*.manage_stock' => 'إدارة المخزون',
        '*.qty' => 'الكمية',
        '*.in_stock' => 'توفر المخزون',
    ],
];
