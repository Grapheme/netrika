<?php

return array(

    'fields' => function () {

        return array();

    },


    'menus' => function($dic, $dicval = NULL) {
        $menus = array();
        return $menus;
    },


    'actions' => function($dic, $dicval) {},

    'hooks' => array(

        'before_index_view' => function ($dic, $dicvals) {
            /**
             * Предзагружаем нужные словари
             */

            $dics = Dic::where('slug', 'actions-types')->first()->values()->get();
            $dics = Dic::modifyKeys($dics,'id');
            Config::set('temp.index_dics', $dics);

            $users = array();
            $usersIDs = (array)array_unique(Dic::makeLists($dicvals,false,'user_id'));
            if (count($usersIDs)) {
                $users = User::whereIn('id', $usersIDs)->get();
                $users = Dic::modifyKeys($users, 'id');
            }
            Config::set('temp.users', $users);
        },

    ),

    'first_line_modifier' => function($line, $dic, $dicval) {
        $actions_types =  Config::get('temp.index_dics');
        return @$actions_types[$dicval->action_id]->name.'. '.$dicval->title;
    },

    'second_line_modifier' => function($line, $dic, $dicval) {
        $users =  Config::get('temp.users');
        return @$users[$dicval->user_id]->name.'. '.myDateTime::SwapDotDateWithTime($dicval->created_time);
    },

    'seo' => false,
);
