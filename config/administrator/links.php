<?php

use App\Models\Link;

return [
    'title'   => '相關資源',
    'single'  => '相關資源',

    'model'   => Link::class,

    // 访问權限判断
    'permission'=> function()
    {
        // 只允许站长管理相關資源連結
        return Auth::user()->hasRole('Founder');
    },

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'title' => [
            'title'    => '名稱',
            'sortable' => false,
        ],
        'link' => [
            'title'    => '連結',
            'sortable' => false,
        ],
        'operation' => [
            'title'  => '管理',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'title' => [
            'title'    => '名稱',
        ],
        'link' => [
            'title'    => '連結',
        ],
    ],
    'filters' => [
        'id' => [
            'title' => '標籤 ID',
        ],
        'title' => [
            'title' => '名稱',
        ],
    ],
];