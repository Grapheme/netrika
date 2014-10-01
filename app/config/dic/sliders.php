<?php

return array(

    'fields' => function () {

        return array(
            'link_slide' => array(
                'title' => 'Ссылка',
                'type' => 'text',
            ),
            'image_slide' => array(
                'title' => 'Изображение',
                'type' => 'image',
            ),
        );

    },


    'menus' => function($dic, $dicval = NULL) {},

    'actions' => function($dic, $dicval) {},

    'hooks' => array(),

    'seo' => false,
);
