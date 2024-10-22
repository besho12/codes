<?php

use Modules\Blog\Entities\BlogPost;

return [
    'posts' => [
        'name' => 'مقالة المدونة',
        'groups' => [
            'featured_image' => 'الصورة المميزة',
            'publish' => 'نشر',
            'categories' => 'الفئات',
            'tags' => 'الوسوم',
            'general' => 'عام',
            'seo' => 'تحسين محركات البحث',
        ],
        'form' => [
            'enable_the_blog_category' => 'تفعيل فئة المدونة',
            'publish_status' => [
                BlogPost::PUBLISHED => 'منشور',
                BlogPost::UNPUBLISHED => 'غير منشور',
            ],
        ],
    ],
    'categories' => [
        'name' => 'فئة المدونة',
    ],
    'tags' => [
        'name' => 'وسم المدونة',
    ],
];
