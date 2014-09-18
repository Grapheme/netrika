<?php

class UserActionsHistoryTableSeeder extends Seeder{

	public function run(){
		
        Dictionary::create(array('slug'=>'actions-types','name'=>'Типы событий','entity'=> 1,'icon_class'=>'fa-bolt','hide_slug'=>1,'make_slug_from_name'=>1,'name_title'=>'Название типа события','pagination'=>0,'view_access'=>1,'sort_by'=>NULL,'sort_order_reverse'=>0,'sortable'=>1,'order'=>0));
        Dictionary::create(array('slug'=>'actions-history','name'=>'История событий','entity'=> 1,'icon_class'=>'fa-bell','hide_slug'=>1,'make_slug_from_name'=>1,'name_title'=>'','pagination'=>30,'view_access'=>1,'sort_by'=>'created_at','sort_order_reverse'=>1,'sortable'=>0,'order'=>0));

        DicVal::create(array('dic_id'=>10,'slug'=>'dobavleno-reshenie','name'=>'Добавлено решение','order'=>1));
        DicVal::create(array('dic_id'=>10,'slug'=>'otredaktirovano-reshenie','name'=>'Отредактировано решение','order'=>2));
        DicVal::create(array('dic_id'=>10,'slug'=>'udaleno-reshenie','name'=>'Удалено решение','order'=>3));
        DicVal::create(array('dic_id'=>10,'slug'=>'reshenie-sozdan-normativnyy-dokument','name'=>'Решение. Создан нормативный документ','order'=>4));
        DicVal::create(array('dic_id'=>10,'slug'=>'reshenie-otredaktirovan-normativnyy-dokument','name'=>'Решение. Отредактирован нормативный документ','order'=>5));
        DicVal::create(array('dic_id'=>10,'slug'=>'reshenie-udalen-normativnyy-dokument','name'=>'Решение. Удален нормативный документ','order'=>6));
        DicVal::create(array('dic_id'=>10,'slug'=>'dobavlen-proekt','name'=>'Добавлен проект','order'=>7));
        DicVal::create(array('dic_id'=>10,'slug'=>'otredaktirovan-proekt','name'=>'Отредактирован проект','order'=>8));
        DicVal::create(array('dic_id'=>10,'slug'=>'udalen-proekt','name'=>'Удален проект','order'=>9));
        DicVal::create(array('dic_id'=>10,'slug'=>'proekt-sozdan-normativnyy-dokument','name'=>'Проект. Создан нормативный документ','order'=>10));
        DicVal::create(array('dic_id'=>10,'slug'=>'proekt-otredaktirovan-normativnyy-dokument','name'=>'Проект. Отредактирован нормативный документ','order'=>11));
        DicVal::create(array('dic_id'=>10,'slug'=>'proekt-udalen-normativnyy-dokument','name'=>'Проект. Удален нормативный документ','order'=>12));
        DicVal::create(array('dic_id'=>10,'slug'=>'dobavlen-klient','name'=>'Добавлен клиент','order'=>13));
        DicVal::create(array('dic_id'=>10,'slug'=>'otredaktirovan-klient','name'=>'Отредактирован клиент','order'=>14));
        DicVal::create(array('dic_id'=>10,'slug'=>'udalen-klient','name'=>'Удален клиент','order'=>15));
        DicVal::create(array('dic_id'=>10,'slug'=>'klient-sozdano-uchrejdenie','name'=>'Клиент. Создано учреждение','order'=>16));
        DicVal::create(array('dic_id'=>10,'slug'=>'klient-otredaktirovano-uchrejdenie','name'=>'Клиент. Отредактировано учреждение','order'=>17));
        DicVal::create(array('dic_id'=>10,'slug'=>'klient-udaleno-uchrejdenie','name'=>'Клиент. Удалено учреждение','order'=>18));
        DicVal::create(array('dic_id'=>10,'slug'=>'dobavlena-kompaniya','name'=>'Добавлена компания','order'=>19));
        DicVal::create(array('dic_id'=>10,'slug'=>'otredaktirovana-kompaniya','name'=>'Отредактирована компания','order'=>20));
        DicVal::create(array('dic_id'=>10,'slug'=>'udalena-kompaniya','name'=>'Удалена компания','order'=>21));
        DicVal::create(array('dic_id'=>10,'slug'=>'dobavlena-vakansiya','name'=>'Добавлена вакансия','order'=>22));
        DicVal::create(array('dic_id'=>10,'slug'=>'otredaktirovana-vakansiya','name'=>'Отредактирована вакансия','order'=>23));
        DicVal::create(array('dic_id'=>10,'slug'=>'udalena-vakansiya','name'=>'Удалена вакансия','order'=>24));

    }

}