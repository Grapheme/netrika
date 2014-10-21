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
            'message_name' => array(
                'title' => 'Имя',
                'type' => 'text',
            ),
            'message_email' => array(
                'title' => 'email',
                'type' => 'text',
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

    #/*
    'first_line_modifier' => function($line, $dic, $dicval) {
        return '<a href="' . URL::route('feedback.view', $dicval->id) . '" target="_blank">' . $line . '</a> <i class="fa fa-arrow-right"></i>';
    },
    #*/

    #/*
    'second_line_modifier' => function($line, $dic, $dicval) {
        return 'От: ' . $dicval->message_name . ($dicval->message_email ? ' &lt;<a href="mailto:' . $dicval->message_email . '">' . $dicval->message_email . '</a>>' : '') . ', ' . $dicval->created_at->format('d.m.Y в H:i');
    },
    #*/

    /**
     * Перезаписываем права групп для работы с данным словарем.
     * В данном случае пользователям из группы "Модераторы" запрещено добавлять новые записи.
     */
    'group_actions' => array(
        'moderator' => function() {
            return array(
                'dicval_create' => 0,
                'dicval_edit' => 0,
            );
        },

    ),

    'seo' => false,
);
