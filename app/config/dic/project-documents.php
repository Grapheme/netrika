<?php

return array(

    'fields' => function () {

        $dics_slugs = array(
            'projects',
        );
        $dics = Dic::whereIn('slug', $dics_slugs)->with('values')->get();
        $dics = Dic::modifyKeys($dics, 'slug');
        #Helper::tad($dics);
        $lists = Dic::makeLists($dics, 'values', 'name', 'id');
        #Helper::dd($lists);

        return array(
            'project_id' => array(
                'title' => 'Проект',
                'type' => 'select',
                'values' => $lists['projects'],
                'default' => (int)Input::get('filter.fields.project_id')
            ),
            'description_document' => array(
                'title' => 'Полное наименование документа',
                'type' => 'textarea',
            ),
            'url_document' => array(
                'title' => 'Ссылка на документ (необязательно)',
                'type' => 'text',
            ),
        );

    },


    'menus' => function($dic, $dicval = NULL) {
        $menus = array();
        $menus[] = array('raw' => '<br/>');

        $dics_slugs = array(
            'projects',
        );
        $dics = Dic::whereIn('slug', $dics_slugs)->with('values')->get();
        $dics = Dic::modifyKeys($dics, 'slug');
        $lists = Dic::makeLists($dics, 'values', 'name', 'id');
        #Helper::tad($lists);

        $menus[] = array(
            'link' => action('entity.index','projects'),
            'title' => "<i class='fa fa-arrow-circle-left'></i> Проекты",
            'class' => 'btn btn-default'
        );
        $menus[] = Helper::getDicValMenuDropdown('project_id', 'Все проекты', $lists['projects'], $dic);
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
        'after_store' => function ($dic, $dicval) {
            Event::fire('proekt-sozdan-normativnyy-dokument', array(array('title'=>$dicval->name)));
        },
        'after_update' => function ($dic, $dicval) {
            Event::fire('proekt-otredaktirovan-normativnyy-dokument', array(array('title'=>$dicval->name)));
        },
        'after_destroy' => function ($dic, $dicval) {
            Event::fire('proekt-udalen-normativnyy-dokument', array(array('title'=>$dicval->name)));
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


    /**
     * Максимальное количество элементов в списке.
     * Если достигнуто - кнопка "Добавить" будет скрыта.
     */
    'max_elements' => 10,

    'seo' => false,
);
