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
            ),
            #*/
        );

    },


    'menus' => function($dic, $dicval = NULL) {},

    'actions' => function($dic, $dicval) {},

    'hooks' => array(),

    'seo' => false,
);
