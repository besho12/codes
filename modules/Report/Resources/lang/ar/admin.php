<?php

return [
    'reports' => 'التقارير',
    'no_data' => 'لا توجد بيانات متاحة!',
    'filter' => 'تصفية',
    'filters' => [
        'report_type' => 'نوع التقرير',
        'report_types' => [
            'coupons_report' => 'تقرير القسائم',
            'customers_order_report' => 'تقرير طلبات العملاء',
            'products_purchase_report' => 'تقرير شراء المنتجات',
            'products_stock_report' => 'تقرير مخزون المنتجات',
            'products_view_report' => 'تقرير مشاهدة المنتجات',
            'branded_products_report' => 'تقرير المنتجات ذات العلامة التجارية',
            'categorized_products_report' => 'تقرير المنتجات المصنفة',
            'taxed_products_report' => 'تقرير المنتجات الخاضعة للضريبة',
            'tagged_products_report' => 'تقرير المنتجات المسمى',
            'sales_report' => 'تقرير المبيعات',
            'search_report' => 'تقرير البحث',
            'shipping_report' => 'تقرير الشحن',
            'tax_report' => 'تقرير الضرائب',
        ],
        'date_start' => 'تاريخ البدء',
        'date_end' => 'تاريخ الانتهاء',
        'group_by' => 'تجميع حسب',
        'groups' => [
            'days' => 'أيام',
            'weeks' => 'أسابيع',
            'months' => 'شهور',
            'years' => 'سنوات',
        ],
        'please_select' => 'يرجى الاختيار',
        'status' => 'حالة الطلب',
        'coupon_code' => 'رمز القسيمة',
        'customer_name' => 'اسم العميل',
        'customer_email' => 'بريد العميل الإلكتروني',
        'product' => 'المنتج',
        'sku' => 'SKU',
        'brand' => 'العلامة التجارية',
        'category' => 'الفئة',
        'tax_class' => 'فئة الضريبة',
        'tag' => 'علامة',
        'keyword' => 'الكلمة الرئيسية',
        'quantity_below' => 'الكمية أقل من',
        'quantity_above' => 'الكمية أكبر من',
        'stock_availability' => 'توفر المخزون',
        'stock_availability_states' => [
            'in_stock' => 'متوفر في المخزون',
            'out_of_stock' => 'نفد من المخزون',
        ],
        'shipping_method' => 'طريقة الشحن',
        'tax_name' => 'اسم الضريبة',
    ],
    'table' => [
        'date' => 'التاريخ',
        'orders' => 'الطلبات',
        'products' => 'المنتجات',
        'product' => 'المنتج',
        'products_count' => 'عدد المنتجات',
        'total' => 'الإجمالي',

        # coupons_report
        'coupon_name' => 'اسم القسيمة',
        'coupon_code' => 'رمز القسيمة',

        # customer orders report
        'customer_name' => 'اسم العميل',
        'customer_email' => 'بريد العميل الإلكتروني',
        'customer_group' => 'مجموعة العملاء',
        'guest' => 'زائر',
        'registered' => 'مسجل',

        # products purchase report
        'qty' => 'الكمية',

        # products stock report
        'stock_availability' => 'توفر المخزون',

        # products view report
        'views' => 'المشاهدات',

        # branded products report
        'brand' => 'العلامة التجارية',

        # category products report
        'category' => 'الفئة',

        # taxed products report
        'tax_class' => 'فئة الضريبة',

        # tagged products report
        'tag' => 'علامة',

        # sales report
        'subtotal' => 'المجموع الفرعي',
        'shipping' => 'الشحن',
        'discount' => 'الخصم',
        'tax' => 'الضريبة',

        # search report
        'keyword' => 'الكلمة الرئيسية',
        'results' => 'النتائج',
        'hits' => 'الزيارات',

        # shipping report
        'shipping_method' => 'طريقة الشحن',

        # tax report
        'tax_name' => 'اسم الضريبة',
    ],
];