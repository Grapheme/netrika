<?php

return array(

    'fields' => function () {

        return array(
            'text_slide' => array(
                'title' => 'Текст на слайде',
                'type' => 'textarea_redactor',
            ),
            /*
            'link_slide' => array(
                'title' => 'Ссылка',
                'type' => 'text',
            ),
            'image_slide' => array(
                'title' => 'Изображение',
                'type' => 'image',
            ),
            */
        );

    },


    'menus' => function($dic, $dicval = NULL) {},

    'actions' => function($dic, $dicval) {},

    'hooks' => array(),

    'seo' => false,
);
