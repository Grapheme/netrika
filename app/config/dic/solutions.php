<?php

return array(

    'fields' => function () {

        $dics_slugs = array(
            'tags',
        );
        $dics = Dic::whereIn('slug', $dics_slugs)->with('values')->get();
        #Helper::dd();
        $dics = Dic::modifyKeys($dics, 'slug');
        #Helper::tad($dics);
        $lists = Dic::makeLists($dics, 'values', 'name', 'id');
        #Helper::dd($lists);

        return array(
            'describes_purpose_decision' => array(
                'title' => 'Описание решения',
                'type' => 'textarea_redactor',
            ),
            'performance_indicators' => array(
                'title' => 'Показатели эффективности (максимум три строки)',
                'type' => 'textarea',
                'first_note' => 'Пример строки: 58% повышение общей эффективности',
                'default' => '100% экономия времени
100% снижение затрат
100% повышение эффективности',
                'others' => array(
                    'onkeyup' => str_replace("\n", ' ', "
var c = 1;
var len = 0;
for (i=0; i<this.value.length; i++) {
    if ( this.value[i] == '\\n' ) {
        ++c;
        if ( c == 4 ) {
            len = i;
            break;
        }
    }
}
if (len > 0) {
    this.value = this.value.slice(0, len + 1);
}
"), ## ONLY 3 LINES AT TEXTAREA
                ),
            ),
            'description_target_audience' => array(
                'title' => 'Целевая аудитория (по одному на строку)',
                'type' => 'textarea',
            ),

            'assignment_solution' => array(
                'title' => 'Назначение решения (по одному на строку)',
                'type' => 'textarea',
            ),
            'description_advantages_solution' => array(
                'title' => 'Преимущества решения (по одному на строку)',
                'type' => 'textarea',
            ),
            'application_solution' => array(
                'title' => 'Применение решения (по одному на строку)',
                'type' => 'textarea',
            ),
            'mainpage_image' => array(
                'title' => 'Фоновое изображение (в списках)',
                'type' => 'image',
            ),
            'image_schemes_work' => array(
                'title' => 'Изображение схемы работы',
                'type' => 'image',
            ),

            'description_integration' => array(
                'title' => 'Описание интеграции',
                'type' => 'textarea_redactor',
            ),

            'identify_features_solution' => array(
                'title' => 'Возможности решения',
                'type' => 'textarea_redactor',
            ),

            'additional_features' => array(
                'title' => 'Дополнительные возможности (по одному на строку)',
                'type' => 'textarea',
            ),
            /*
            'description_plans' => array(
                'title' => 'Описание планов',
                'type' => 'textarea_redactor',
            ),
            */
            /*
            'description_components' => array(
                'title' => 'Описание компонентов решения',
                'type' => 'textarea_redactor',
            ),
            */
            /*
            'description_partners' => array(
                'title' => 'Партнеры решения',
                'type' => 'textarea_redactor',
            ),
            */
            'availability_demonstrate' => array(
                'no_label' => true,
                'title' => 'Доступность демонстрации решения',
                'type' => 'checkbox',
                'label_class' => 'normal_checkbox',
            ),
            'link_to_file_presentation' => array(
                'title' => 'Добавить файл презентации',
                'type' => 'upload',
                'label_class' => 'input-file',
                'others' => [
                    'accept' => 'application/pdf', # .exe,application/pdf,image/*,video/*,audio/*
                ],
                'handler' => function($value, $element = false) {
                    if (@is_object($element) && @is_array($value)) {
                        $value['module'] = 'dicval';
                        $value['unit_id'] = $element->id;
                    }
                    return ExtForm::process('upload', $value);
                },
            ),
            /*
            'tags_id' => array(
                'title' => 'Список тегов',
                'type' => 'select-multiple',
                'values' => $lists['tags'],
                'handler' => function($value, $element) {
                    $value = (array)$value;
                    $value = array_flip($value);
                    foreach ($value as $v => $null)
                        $value[$v] = array('dicval_child_dic' => 'entities-tags');
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
        return $menus;
    },


    'actions' => function($dic, $dicval) {
        ## Data from hook: before_index_view
        $dics = Config::get('temp.index_dics');
        $dic_projects = $dics['projects'];
        $dic_documents = $dics['solution-documents'];
        $dic_components = $dics['solution_components'];
        $counts = Config::get('temp.index_counts');
        return '
            <span class="display-block margin-bottom-5">
                <a href="' . URL::route('entity.index', array('projects', 'filter[fields][solution_id]' => $dicval->id)) . '" class="btn btn-default">
                    Проекты (' . @(int)$counts[$dicval->id][$dic_projects->id] . ')
                </a>
                <a href="' . URL::route('entity.index', array('solution-documents', 'filter[fields][solution_id]' => $dicval->id)) . '" class="btn btn-default">
                    Документы (' . @(int)$counts[$dicval->id][$dic_documents->id] . ')
                </a>
                <a href="' . URL::route('dicval.index', array('solution_components', 'filter[fields][solution_id]' => $dicval->id)) . '" class="btn btn-default">
                    Компоненты (' . @(int)$counts[$dicval->id][$dic_components->id] . ')
                </a>
            </span>
        ';
    },

    'hooks' => array(

        'before_all' => function ($dic) {},
        'before_index' => function ($dic) {},
        'before_index_view' => function ($dic, $dicvals) {
            $dics_slugs = array(
                'projects',
                'solution-documents',
                'solution_components',
            );
            $dics = Dic::whereIn('slug', $dics_slugs)->get();
            $dics = Dic::modifyKeys($dics, 'slug');
            #Helper::d($dics);
            Config::set('temp.index_dics', $dics);

            $dic_ids = Dic::makeLists($dics, false, 'id');
            #Helper::d($dic_ids);
            $dicval_ids = Dic::makeLists($dicvals, false, 'id');
            #Helper::dd($dicval_ids);

            $counts = array();
            if (count($dic_ids) && count($dicval_ids)) {
                $counts = DicVal::counts_by_fields($dic_ids, array('solution_id' => $dicval_ids));
            }
            #Helper::dd($counts);
            Config::set('temp.index_counts', $counts);
        },
        'before_create_edit' => function ($dic) {},
        'before_create' => function ($dic) {},
        'after_store' => function ($dic, $dicval) {
            Event::fire('dobavleno-reshenie', array(array('title'=>$dicval->name)));
        },
        'after_update' => function ($dic, $dicval) {
            Event::fire('otredaktirovano-reshenie', array(array('title'=>$dicval->name)));
        },
        'after_destroy' => function ($dic, $dicval) {
            Event::fire('udaleno-reshenie', array(array('title'=>$dicval->name)));
        },
        'before_edit' => function ($dic, $dicval) {},
        'before_store_update' => function ($dic) {},
        'before_store' => function ($dic) {},
        'before_update' => function ($dic, $dicval) {},
        'before_destroy' => function ($dic, $dicval) {},
    ),

    'seo' => 1,

    'versions' => 1,
);
