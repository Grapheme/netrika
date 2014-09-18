<?php

return array(

    'fields' => function () {

        $dics_slugs = array(
            'solutions',
            'projects',
        );
        $dics = Dic::whereIn('slug', $dics_slugs)->with('values')->get();
        $dics = Dic::modifyKeys($dics, 'slug');
        #Helper::tad($dics);
        $lists = Dic::makeLists($dics, 'values', 'name', 'id');
        #Helper::dd($lists);

        return array(
            'solution_id' => array(
                'title' => 'Категория проекта',
                'type' => 'select',
                'values' => $lists['solutions'],
                'handler' => function($value, $element) {
                    $value = (array)$value;
                    $value = array_flip($value);
                    foreach ($value as $v => $null)
                        $value[$v] = array('dicval_child_dic' => 'solutions');
                    $element->relations()->sync($value);
                    return @count($value);
                },
                'value_modifier' => function($value, $element) {
                    $return = (is_object($element) && $element->id)
                        ? $element->relations()->get()->lists('id')
                        : $return = array()
                    ;
                    return $return;
                },
            ),
            'link_to_project' => array(
                'title' => 'Ссылка на реализованный проект',
                'type' => 'text',
            ),
            'description_objectives' => array(
                'title' => 'Описание целей и задач',
                'type' => 'textarea_redactor',
            ),
            'description_results' => array(
                'title' => 'Описание результатов',
                'type' => 'textarea_redactor',
            ),
            'gallery' => array(
                'title' => 'Изображения',
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
            'description_advantages' => array(
                'title' => 'Описание преимуществ',
                'type' => 'textarea_redactor',
            ),
            'description_features' => array(
                'title' => 'Описание особенностей проекта',
                'type' => 'textarea_redactor',
            ),
            'similar_projects_ids' => array(
                'title' => 'Список похожих проектов',
                'type' => 'select-multiple',
                'values' => $lists['projects'],
                'handler' => function($value, $element) {
                    $value = (array)$value;
                    $value = array_flip($value);
                    foreach ($value as $v => $null)
                        $value[$v] = array('dicval_child_dic' => 'projects');
                    $element->relations()->sync($value);
                    return @count($value);
                },
                'value_modifier' => function($value, $element) {
                    $return = (is_object($element) && $element->id)
                        ? $element->relations()->get()->lists('id')
                        : $return = array()
                    ;
                    return $return;
                },
            ),
        );

    },


    'menus' => function($dic, $dicval = NULL) {
        $menus = array();
        return $menus;
    },


    'actions' => function($dic, $dicval) {
        ## Data from hook: before_index_view
        $dics = Config::get('temp.index_dics');
        $dic_documents = $dics['project-documents'];
        $counts = Config::get('temp.index_counts');
        return '
            <span class="block_ margin-bottom-5_">
                <a href="' . URL::route('entity.index', array('project-documents', 'filter[fields][project_id]' => $dicval->id)) . '" class="btn btn-default">
                    Документы (' . @(int)$counts[$dicval->id][$dic_documents->id] . ')
                </a>
            </span>
        ';
    },

    'hooks' => array(

        'before_all' => function ($dic) {
        },

        'before_index' => function ($dic) {
        },

        'before_index_view' => function ($dic, $dicvals) {
            $dics_slugs = array(
                'project-documents',
            );
            $dics = Dic::whereIn('slug', $dics_slugs)->get();
            $dics = Dic::modifyKeys($dics, 'slug');
            #Helper::tad($dics);
            Config::set('temp.index_dics', $dics);

            $dic_ids = Dic::makeLists($dics, false, 'id');
            #Helper::d($dic_ids);
            $dicval_ids = Dic::makeLists($dicvals, false, 'id');
            #Helper::d($dicval_ids);

            $counts = array();
            if (count($dic_ids) && count($dicval_ids))
                $counts = DicVal::counts_by_fields($dic_ids, array('solution_id' => $dicval_ids));
            #Helper::dd($counts);
            Config::set('temp.index_counts', $counts);
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
