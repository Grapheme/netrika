<?php

return array(

    'fields' => function () {

        return array(
            'subject_type' => array(
                'title' => 'Форма',
                'type' => 'select',
                'values' => array(
                    'demo' => 'Запрос на демонстрацию решения',
                    'vacancy' => 'Отклик на вакансию',
                ),
            ),
            'message_text' => array(
                'title' => 'Текст обращения',
                'type' => 'textarea',
            ),
        );
    },


    'menus' => function($dic, $dicval = NULL) {
        $menus = array();
        return $menus;
    },


    'actions' => function($dic, $dicval) {},

    'hooks' => array(

        'before_index_view' => function ($dic, $dicvals) {
        },

    ),

    /*
    'first_line_modifier' => function($line, $dic, $dicval) {
        $actions_types =  Config::get('temp.index_dics');
        return @$actions_types[$dicval->action_id]->name.'. '.$dicval->title;
    },

    'second_line_modifier' => function($line, $dic, $dicval) {
        $users =  Config::get('temp.users');
        return @$users[$dicval->user_id]->name.'. '.myDateTime::SwapDotDateWithTime($dicval->created_time);
    },
    */

    /**
     * Перезаписываем права групп для работы с данным словарем.
     * В данном случае пользователям из группы "Модераторы" запрещено добавлять новые записи.
     */
    'group_actions' => array(
        'moderator' => function() {
            return array(
                'dicval_create' => 0,
            );
        },

    ),

    'seo' => false,
);
