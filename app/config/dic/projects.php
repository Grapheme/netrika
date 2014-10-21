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
                /*
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
                */
            ),
            'link_to_project' => array(
                'title' => 'Ссылка на реализованный проект',
                'type' => 'text',
            ),

            'description_objectives' => array(
                'title' => 'Описание целей',
                'type' => 'textarea_redactor',
            ),
            'description_tasks' => array(
                'title' => 'Задачи (по одной на строку)',
                'type' => 'textarea',
            ),

            'description_results' => array(
                'title' => 'Описание результатов',
                'type' => 'textarea_redactor',
            ),
            'description_results_num' => array(
                'title' => 'Результаты (по одному на строку)',
                'type' => 'textarea',
            ),

            'mainpage_image' => array(
                'title' => 'Фоновое изображение',
                'type' => 'image',
                'params' => array(
                    'maxFilesize' => 1, // MB
                ),
            ),

            'description_advantages' => array(
                'title' => 'Преимущества (по одному на строку)',
                'type' => 'textarea',
            ),
            'description_features' => array(
                'title' => 'Особенности',
                'type' => 'textarea_redactor',
            ),

            'description_process' => array(
                'title' => 'Описание процесса',
                'type' => 'textarea_redactor',
            ),
            'gallery' => array(
                'title' => 'Изображения процесса',
                'type' => 'gallery',
                'params' => array(
                    'maxFilesize' => 1, // MB
                    'maxFiles' => 2,
                ),
                'handler' => function($array, $element) {
                    return ExtForm::process('gallery', array(
                        'module'  => 'dicval_meta',
                        'unit_id' => $element->id,
                        'gallery' => $array,
                        'single'  => true,
                    ));
                }
            ),

            /*
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
            */
        );

    },


    'menus' => function($dic, $dicval = NULL) {
        $menus = array();
        $menus[] = array('raw' => '<br/>');

        $dics_slugs = array(
            'solutions',
            'project-documents',
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
        ## Data from hook: before_index_view
        $dics = Config::get('temp.index_dics');
        $dic_documents = $dics['project-documents'];
        $counts = Config::get('temp.index_counts');
        #Helper::tad($dics);
        return '
            <span class="block_ margin-bottom-5_">
                <a href="' . URL::route('entity.edit', array('solutions', $dicval->solution_id)) . '" class="btn btn-default">
                    <i class="fa fa-arrow-left"></i>
                    Решение
                </a>
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
                $counts = DicVal::counts_by_fields($dic_ids, array('project_id' => $dicval_ids));
            #Helper::dd($counts);
            Config::set('temp.index_counts', $counts);
        },

        'before_create_edit' => function ($dic) {
        },
        'before_create' => function ($dic) {
        },
        'before_edit' => function ($dic, $dicval) {
        },
        'after_store' => function ($dic, $dicval) {
            Event::fire('dobavlen-proekt', array(array('title'=>$dicval->name)));
        },
        'after_update' => function ($dic, $dicval) {
            Event::fire('otredaktirovan-proekt', array(array('title'=>$dicval->name)));
        },
        'after_destroy' => function ($dic, $dicval) {
            Event::fire('udalen-proekt', array(array('title'=>$dicval->name)));
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

    'seo' => 1,

    'versions' => 1,

    /**
     * Собственные правила валидации данной формы.
     * Не забыть про поле name, которое по умолчанию должно быть обязательным!
     */
    'custom_validation' => <<<JS
    var validation_rules = {
		'name': { required: true },
		'fields[solution_id]': { required: true },
	};
	var validation_messages = {
		'name': { required: "Укажите название" },
		'fields[solution_id]': { required: "Заполните обязательное поле" },
	};
JS
,
);
