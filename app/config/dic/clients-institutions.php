<?php

return array(

    'fields' => function () {

        $dics_slugs = array(
            'clients',
        );
        $dics = Dic::whereIn('slug', $dics_slugs)->with('values')->get();
        $dics = Dic::modifyKeys($dics, 'slug');
        #Helper::tad($dics);
        $lists = Dic::makeLists($dics, 'values', 'name', 'id');
        #Helper::dd($lists);

        return array(
            'client_id' => array(
                'title' => 'Проекты',
                'type' => 'select',
                'values' => $lists['clients'],
                'default' => (int)Input::get('filter.fields.client_id')
            ),
            'description_institution' => array(
                'title' => 'Описание',
                'type' => 'textarea_redactor',
            ),
        );
    },


    'menus' => function($dic, $dicval = NULL) {
        $menus = array();
        $menus[] = array('raw' => '<br/>');

        $dics_slugs = array(
            'clients',
        );
        $dics = Dic::whereIn('slug', $dics_slugs)->with('values')->get();
        $dics = Dic::modifyKeys($dics, 'slug');
        $lists = Dic::makeLists($dics, 'values', 'name', 'id');
        #Helper::tad($lists);

        $menus[] = array(
            'link' => action('entity.index','clients'),
            'title' => "<i class='fa fa-arrow-circle-left'></i> Клиенты",
            'class' => 'btn btn-default'
        );
        $menus[] = Helper::getDicValMenuDropdown('client_id', 'Все клиенты', $lists['clients'], $dic);
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
        'after_store' => function ($dic, $dicval) {
            Event::fire('klient-sozdano-uchrejdenie', array(array('title'=>$dicval->name)));
        },
        'after_update' => function ($dic, $dicval) {
            Event::fire('klient-otredaktirovano-uchrejdenie', array(array('title'=>$dicval->name)));
        },
        'after_destroy' => function ($dic, $dicval) {
            Event::fire('klient-udaleno-uchrejdenie', array(array('title'=>$dicval->name)));
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
