<?php

use App\Models\TopicCategory;

return [
    'title'   => '分類',
    'single'  => '分類',
    'model'   => TopicCategory::class,

    // 对 CRUD 动作的单独權限控制，其他动作不指定默认为通过
    'action_permissions' => [
        // 刪除權限控制
        'delete' => function () {
            // 只有站长才能刪除話題分類
            return Auth::user()->hasRole('Founder');
        },
    ],

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'name' => [
            'title'    => '名稱',
            'sortable' => false,
        ],
        'description' => [
            'title'    => '描述',
            'sortable' => false,
        ],
        'operation' => [
            'title'  => '管理',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'name' => [
            'title' => '名稱',
        ],
        'description' => [
            'title' => '描述',
            'type'  => 'textarea',
        ],
    ],
    'filters' => [
        'id' => [
            'title' => '分類 ID',
        ],
        'name' => [
            'title' => '名稱',
        ],
        'description' => [
            'title' => '描述',
        ],
    ],
    'rules'   => [
        'name' => 'required|min:1|unique:categories'
    ],
    'messages' => [
        'name.unique'   => '分類名稱在資料庫裡有重複，請選用其他名稱。',
        'name.required' => '請確保名稱至少一个字符以上',
    ],
];
