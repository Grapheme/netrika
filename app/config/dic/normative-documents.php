<?php

return array(

    'fields' => function () {

        $dics_slugs = array(
            'solutions',
        );
        $dics = Dic::whereIn('slug', $dics_slugs)->with('values')->get();
        $dics = Dic::modifyKeys($dics, 'slug');
        #Helper::tad($dics);
        $lists = Dic::makeLists($dics, 'values', 'name', 'id');
        #Helper::dd($lists);

        return array(
            'solution_id' => array(
                'title' => 'Решение',
                'type' => 'select',
                'values' => $lists['solutions'],
                'default' => (int)Input::get('filter.fields.solution_id')
            ),
            'description_document' => array(
                'title' => 'Описание',
                'type' => 'textarea_redactor',
            ),
            'link_document' => array(
                'title' => 'Добавить файл',
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
        );

    },


    'menus' => function($dic, $dicval = NULL) {
        $menus = array();
        $menus[] = array('raw' => '<br/>');

        $dics_slugs = array(
            'solutions',
        );
        $dics = Dic::whereIn('slug', $dics_slugs)->with('values')->get();
        $dics = Dic::modifyKeys($dics, 'slug');
        $lists = Dic::makeLists($dics, 'values', 'name', 'id');
        #Helper::tad($lists);

        $menus[] = array(
            'link' => action('entity.index','solutions'),
            'title' => "<i class='fa fa-arrow-circle-left'></i> Решения",
            'class' => 'btn btn-default'
        );
        $menus[] = Helper::getDicValMenuDropdown('solution_id', 'Все решения', $lists['solutions'], $dic);
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
