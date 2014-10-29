<?php

return array(

    'fields' => function () {

        return array(
            'text_slide' => array(
                'title' => 'Текст на слайде',
                'type' => 'textarea_redactor',
                'others' => array(
                    'class' => 'redactor_450'
                ),
            ),
            /*
            'link_slide' => array(
                'title' => 'Ссылка',
                'type' => 'text',
            ),
            #*/

            #/*
            'image_slide' => array(
                'title' => 'Фоновое изображение',
                'type' => 'image',
                'params' => array(
                    'maxFilesize' => 1, // MB
                ),
                'first_note' => 'Оптимальный размер: 1600x640',
            ),
            #*/
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

);
