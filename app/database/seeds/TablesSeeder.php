<?php

class TablesSeeder extends Seeder{

	public function run(){

		#DB::table('settings')->truncate();

		Setting::create(array('id' => 1,'name' => 'language','value' => 'ru',));

        Dictionary::create(array('slug'=>'sliders','name'=>'Слайдер','entity'=> 1,'icon_class'=>'fa-caret-square-o-right','hide_slug'=>1,'make_slug_from_name'=>1,'name_title'=>'Наименование слайда','pagination'=>0,'view_access'=>2,'sort_by'=>NULL,'sort_order_reverse'=>0,'sortable'=>1,'order'=>1));
        Dictionary::create(array('slug'=>'solutions','name'=>'Решения','entity'=> 1,'icon_class'=>'fa-thumb-tack','hide_slug'=>1,'make_slug_from_name'=>1,'name_title'=>'Название решения','pagination'=>0,'view_access'=>2,'sort_by'=>NULL,'sort_order_reverse'=>0,'sortable'=>1,'order'=>2));
        Dictionary::create(array('slug'=>'projects','name'=>'Проекты','entity'=> 1,'icon_class'=>'fa-bookmark','hide_slug'=>1,'make_slug_from_name'=>1,'name_title'=>'Название проекта','pagination'=>0,'view_access'=>2,'sort_by'=>NULL,'sort_order_reverse'=>0,'sortable'=>1,'order'=>3));
        Dictionary::create(array('slug'=>'clients','name'=>'Клиенты','entity'=> 1,'icon_class'=>'fa-android','hide_slug'=>1,'make_slug_from_name'=>1,'name_title'=>'Наименование клиента','pagination'=>0,'view_access'=>2,'sort_by'=>NULL,'sort_order_reverse'=>0,'sortable'=>1,'order'=>4));
        Dictionary::create(array('slug'=>'companies','name'=>'Компании','entity'=> 1,'icon_class'=>'fa-apple','hide_slug'=>1,'make_slug_from_name'=>1,'name_title'=>'Наименование компании','pagination'=>0,'view_access'=>2,'sort_by'=>NULL,'sort_order_reverse'=>0,'sortable'=>1,'order'=>5));
        Dictionary::create(array('slug'=>'vacancies','name'=>'Вакансии','entity'=> 1,'icon_class'=>'fa-user-md','hide_slug'=>1,'make_slug_from_name'=>1,'name_title'=>'Название вакансии','pagination'=>0,'view_access'=>2,'sort_by'=>NULL,'sort_order_reverse'=>0,'sortable'=>1,'order'=>6));
        Dictionary::create(array('slug'=>'entities-tags','name'=>'Теги','entity'=> 1,'icon_class'=>'fa-tags','hide_slug'=>1,'make_slug_from_name'=>1,'name_title'=>'Название тега','pagination'=>0,'view_access'=>1,'sort_by'=>NULL,'sort_order_reverse'=>0,'sortable'=>1,'order'=>7));

        Dictionary::create(array('slug'=>'solution-documents','name'=>'Норматив. документы (Решения)','entity'=> 0,'icon_class'=>'fa-file-text','hide_slug'=>1,'make_slug_from_name'=>1,'name_title'=>'Название документа','pagination'=>0,'view_access'=>2,'sort_by'=>NULL,'sort_order_reverse'=>0,'sortable'=>1,'order'=>8));
        Dictionary::create(array('slug'=>'project-documents','name'=>'Норматив. документы (Проекты)','entity'=> 0,'icon_class'=>'fa-file-text','hide_slug'=>1,'make_slug_from_name'=>1,'name_title'=>'Название документа','pagination'=>0,'view_access'=>2,'sort_by'=>NULL,'sort_order_reverse'=>0,'sortable'=>1,'order'=>9));

        Dictionary::create(array('slug'=>'clients-institutions','name'=>'Учреждения','entity'=> 0,'icon_class'=>'fa-building','hide_slug'=>1,'make_slug_from_name'=>1,'name_title'=>'Название учреждения','pagination'=>0,'view_access'=>2,'sort_by'=>NULL,'sort_order_reverse'=>0,'sortable'=>1,'order'=>10));
	}
}