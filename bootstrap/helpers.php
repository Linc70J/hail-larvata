<?php

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return Str::limit($excerpt, $length);
}

function model_admin_link($title, $model)
{
    return model_link($title, $model, 'admin');
}

function model_link($title, $model, $prefix = '')
{
    // 获取数据模型的复数蛇形命名
    $model_name = model_plural_name($model);

    // 初始化前缀
    $prefix = $prefix ? "/$prefix/" : '/';

    // 使用站点 URL 拼接全量 URL
    $url = config('app.url') . $prefix . $model_name . '/' . $model->id;

    // 拼接 HTML A 标签，并返回
    return '<a href="' . $url . '" target="_blank">' . $title . '</a>';
}

function model_plural_name($model)
{
    // 从实体中获取完整类名，例如：App\Models\User
    $full_class_name = get_class($model);

    // 获取基础类名，例如：传参 `App\Models\User` 会得到 `User`
    $class_name = class_basename($full_class_name);

    // 蛇形命名，例如：传参 `User`  会得到 `user`, `FooBar` 会得到 `foo_bar`
    $snake_case_name = Str::snake($class_name);

    // 获取子串的复数形式，例如：传参 `user` 会得到 `users`
    return Str::plural($snake_case_name);
}

function setting($key, $default = '', $setting_name = 'site')
{
    if ( ! config()->get($setting_name)) {
        // Decode the settings to an associative array.
        $site_settings = json_decode(file_get_contents(storage_path("/administrator_settings/$setting_name.json")), true);
        // Add the site settings to the application configuration
        config()->set($setting_name, $site_settings);
    }

    // Access a setting, supplying a default value
    return config()->get($setting_name.'.'.$key, $default);
}

function admin_setting($key, $default = '', $setting_name = 'site')
{
    if ( ! config()->get($setting_name)) {
        // Decode the settings to an associative array.
        $site_settings = json_decode(file_get_contents(storage_path("/administrator_settings/$setting_name.json")), true);
        // Add the site settings to the application configuration
        config()->set($setting_name, $site_settings);
    }

    // Access a setting, supplying a default value
    return config()->get($setting_name.'.'.$key, $default);
}
