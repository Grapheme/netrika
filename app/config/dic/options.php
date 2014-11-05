<?php

return array(

    'fields' => function () {

        return array(
            'description' => array(
                'title' => 'Описание параметра',
                'type' => 'textarea',
                'others' => array(
                    #'class' => 'redactor_450'
                ),
            ),
        );

    },


    'menus' => function($dic, $dicval = NULL) {},

    'actions' => function($dic, $dicval) {},

    'hooks' => array(),

    'seo' => false,

    /**
     * Минимально допустимое количество элементов в списке.
     * Если кол-во элементов в списке <= этого количества - все кнопки "Удалить" для всех элементов будут скрыты.
     */
    'min_elements' => 1,

    /**
     * Перезаписываем права групп для работы с данным словарем.
     */
    'group_actions' => array(
        'moderator' => function() {
            return array(
                'dicval_create' => 0,
            );
        },

    ),

);
