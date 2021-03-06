<?php

return array(

    'fields' => function () {

        return array(
            /*
            'description_vacancy' => array(
                'title' => 'Описание вакансии',
                'type' => 'textarea_redactor',
            ),
            */
            'link_to_vacancy' => array(
                'title' => 'Ссылка на ресурс hh.ru',
                'type' => 'text',
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
        'after_store' => function ($dic, $dicval) {
            Event::fire('dobavlena-vakansiya', array(array('title'=>$dicval->name)));
        },
        'after_update' => function ($dic, $dicval) {
            Event::fire('otredaktirovana-vakansiya', array(array('title'=>$dicval->name)));
        },
        'after_destroy' => function ($dic, $dicval) {
            Event::fire('udalena-vakansiya', array(array('title'=>$dicval->name)));
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
