<?php

return array(

    'fields' => function () {

        return array(
            'description_mission' => array(
                'title' => 'Описание миссии',
                'type' => 'textarea_redactor',
            ),
            'link_to_file_presentation' => array(
                'title' => 'Добавить файл презентации',
                'type' => 'upload',
                'accept' => 'application/pdf,application/x-download', # .exe,image/*,video/*,audio/*
                'label_class' => 'input-file',
                'handler' => function($value, $element = false) {
                    if (@is_object($element) && @is_array($value)) {
                        $value['module'] = 'dicval';
                        $value['unit_id'] = $element->id;
                    }
                    return ExtForm::process('upload', $value);
                },
            ),
            'gallery' => array(
                'title' => 'Инфогрфика',
                'type' => 'gallery',
                'handler' => function($array, $element) {
                    return ExtForm::process('gallery', array(
                        'module'  => 'dicval_meta',
                        'unit_id' => $element->id,
                        'gallery' => $array,
                        'single'  => true,
                    ));
                }
            ),
            'text_geography' => array(
                'title' => 'Текст о географии',
                'type' => 'textarea_redactor',
            ),
            'licenses' => array(
                'title' => 'Лицензии',
                'type' => 'gallery',
                'handler' => function($array, $element) {
                    return ExtForm::process('gallery', array(
                        'module'  => 'dicval_meta',
                        'unit_id' => $element->id,
                        'gallery' => $array,
                        'single'  => true,
                    ));
                }
            ),
            'description_company' => array(
                'title' => 'Описание профиля компании',
                'type' => 'textarea_redactor',
            ),
        );

    },


    'menus' => function($dic, $dicval = NULL) {
        $menus = array();
        return $menus;
    },


    'actions' => function($dic, $dicval) {
    },

    'hooks' => array(

        'before_all' => function ($dic) {
        },

        'before_index' => function ($dic) {
        },

        'before_index_view' => function ($dic, $dicvals) {
        },

        'before_create_edit' => function ($dic) {
        },
        'before_create' => function ($dic) {
        },
        'before_edit' => function ($dic, $dicval) {
        },

        'before_store_update' => function ($dic) {
        },
        'before_store' => function ($dic) {
        },
        'before_update' => function ($dic, $dicval) {
        },

        'before_destroy' => function ($dic, $dicval) {
        },
    ),

    'seo' => false,
);
