<?php

class PublicNetrikaController extends BaseController {

    public static $name = 'netrika';
    public static $group = 'netrika';

    ## Routing rules of module
    public static function returnRoutes($prefix = null) {

        ## Генерим роуты без префикса, и назначаем before-фильтр i18n_url.
        ## Это позволяет нам делать редирект на урл с префиксом только для этих роутов, не затрагивая, например, /admin и /login
        Route::group(array(), function() {
            Route::get('/news/{url}', array('as' => 'news_full', 'uses' => __CLASS__.'@showFullNews'));
            #Route::get('/news',      array('as' => 'news',      'uses' => __CLASS__.'@showNews'));
            Route::get('/solution/{url}', array('as' => 'solution-one', 'uses' => __CLASS__.'@showSolution'));
            Route::get('/project/{url}',  array('as' => 'project-one',  'uses' => __CLASS__.'@showProject'));
            Route::post('/request-demo',  array('as' => 'request-demo',  'uses' => __CLASS__.'@postRequestDemo'));
        });
    }

    /****************************************************************************/

	public function __construct(){

        $this->module = array(
            'name' => self::$name,
            'group' => self::$group,
            #'rest' => self::$group,
            'tpl' => static::returnTpl('admin'),
            'gtpl' => static::returnTpl(),
            'class' => __CLASS__,

            #'entity' => self::$entity,
            #'entity_name' => self::$entity_name,
        );
        View::share('module', $this->module);
	}


    ## Функция для просмотра полной мультиязычной новости
    public function showFullNews($url = false) {

        #Helper::dd($url);

        /**
         * Получаем текущую новость
         */
        $new = Dic::valueBySlugs('newslist', $url);
        $new->extract(1);
        #Helper::tad($new);
        /**
         * Изображение и галерея у текущей новости
         */
        if (isset($new->image_id) && $new->image_id > 0) {
            $new->image = Photo::firstOrNew(array('id' => $new->image_id));
        }
        if (isset($new->gallery_id) && $new->gallery_id > 0) {
            $new->gallery = Gallery::firstOrNew(array('id' => $new->gallery_id));
            $new->gallery->load('photos');
        }
        #Helper::tad($new);

        /**
         * IDs тегов текущей новости
         */
        $tags_ids = Dic::makeLists($new->related_dicvals, false, 'id');
        #Helper::dd($tags_ids);

        /**
         * Получаем IDs новостей, у которых есть такие же теги, как у текущей
         */
        $related_news_ids_obj = DicValRel::whereIn('dicval_child_id', $tags_ids)->get();
        #Helper::tad($related_news_ids_obj);
        $related_news_ids = Dic::makeLists($related_news_ids_obj, false, 'dicval_parent_id');
        $related_news_ids = array_unique($related_news_ids);
        #Helper::dd($related_news_ids);

        /**
         * Получаем "похожие" новости, с учетом условий
         */
        $related_news = Dic::valuesBySlug('newslist', function($query) use ($new, $related_news_ids){
            $query->where('id', '!=', $new->id);
            $query->whereIn('id', $related_news_ids);
            $query->orderBy('created_at', 'DESC');
            $query->with('related_dicvals');
            $query->take(3);
        });
        #Helper::tad($related_news);


        /**
         * Предыдущая новость
         */
        $prev_new = Dic::valuesBySlug('newslist', function($query) use ($new){
            $query->where('id', '!=', $new->id);
            $query->where('created_at', '<', $new->created_at);
            $query->take(1);
        });
        $prev_new = @$prev_new[0];
        #Helper::d($prev_new);

        /**
         * Следующая новость
         */
        $next_new = Dic::valuesBySlug('newslist', function($query) use ($new){
            $query->where('id', '!=', $new->id);
            $query->where('created_at', '>', $new->created_at);
            $query->take(1);
        });
        $next_new = @$next_new[0];
        #Helper::dd($next_new);


        return View::make(Helper::layout('news-one'), compact('new', 'related_news', 'prev_new', 'next_new'));
    }

    public function showSolution($slug) {

        $solution = Dic::valueBySlugs('solutions', $slug);
        $solution->extract(1);
        #Helper::tad($solution);

        $components = Dic::valuesBySlug('solution_components', function($query) use ($solution) {

            /**
             * Фильтр значений по словарю
             * DIC_ID
             */
            #$dic_components = Dic::where('slug', 'solution_components')->first();
            #$query->where('dic_id', $dic_components->id);

            /**
             * Фильтр значений (DicVal) по его доп. полю (DicFieldVal)
             * SOLUTION_id
             */
            $tbl_dicval = (new DicVal())->getTable();
            $tbl_dic_field_val = (new DicFieldVal())->getTable();
            $rand_tbl_alias = md5(time() . rand(999999, 9999999));
            $query->select($tbl_dicval . '.*');
            $query->join($tbl_dic_field_val . ' AS ' . $rand_tbl_alias, $rand_tbl_alias . '.dicval_id', '=', $tbl_dicval . '.id')
                ->where($rand_tbl_alias . '.key', '=', 'solution_id')
                ->where($rand_tbl_alias . '.value', '=', $solution->id);
        });
        DicVal::extracts($components, 1);
        #Helper::tad($components);

        $documents = Dic::valuesBySlug('solution-documents', function($query) use ($solution) {

            /**
             * Фильтр значений (DicVal) по его доп. полю (DicFieldVal)
             * SOLUTION_id
             */
            $tbl_dicval = (new DicVal())->getTable();
            $tbl_dic_field_val = (new DicFieldVal())->getTable();
            $rand_tbl_alias = md5(time() . rand(999999, 9999999));
            $query->select($tbl_dicval . '.*');
            $query->join($tbl_dic_field_val . ' AS ' . $rand_tbl_alias, $rand_tbl_alias . '.dicval_id', '=', $tbl_dicval . '.id')
                ->where($rand_tbl_alias . '.key', '=', 'solution_id')
                ->where($rand_tbl_alias . '.value', '=', $solution->id);
        });
        DicVal::extracts($documents, 1);
        #Helper::tad($documents);


        $projects = Dic::valuesBySlug('projects', function($query) use ($solution) {

            /**
             * Фильтр значений (DicVal) по его доп. полю (DicFieldVal)
             * SOLUTION_id
             */
            $tbl_dicval = (new DicVal())->getTable();
            $tbl_dic_field_val = (new DicFieldVal())->getTable();
            $rand_tbl_alias = md5(time() . rand(999999, 9999999));
            $query->select($tbl_dicval . '.*');
            $query->join($tbl_dic_field_val . ' AS ' . $rand_tbl_alias, $rand_tbl_alias . '.dicval_id', '=', $tbl_dicval . '.id')
                ->where($rand_tbl_alias . '.key', '=', 'solution_id')
                ->where($rand_tbl_alias . '.value', '=', $solution->id);
        });
        DicVal::extracts($projects, 1);
        #Helper::tad($projects);

        $images_ids = Dic::makeLists($projects, false, 'mainpage_image');
        #Helper::d($images_ids);
        if (isset($images_ids) && is_array($images_ids) && count($images_ids)) {
            $images = Photo::whereIn('id', $images_ids)->get();
            if (count($images))
                $images = DicVal::extracts($images, true);
        } else {
            $images = array();
        }
        #Helper::tad($images);

        return View::make(Helper::layout('solution-one'), compact('solution', 'components', 'documents', 'projects', 'images'));
    }

    public function showProject($slug) {
        $project = Dic::valueBySlugs('projects', $slug);
        $project->extract(1);
        #Helper::tad($project);

        $solution = Dic::valueBySlugAndId('solutions', $project->solution_id);
        $solution->extract(1);
        #Helper::tad($solution);

        $gallery = Gallery::where('id', $project->gallery)->with('photos')->first();
        #Helper::tad($gallery);
        $photos = array();
        if (is_object($gallery))
            foreach ($gallery->photos as $photo)
                $photos[] = $photo->full();
        #$photos_ids = Dic::makeLists($gallery->photos, false, 'full()');
        #Helper::dd($photos);

        $documents = Dic::valuesBySlug('project-documents', function($query) use ($project) {
            /**
             * Фильтр значений (DicVal) по его доп. полю (DicFieldVal)
             * SOLUTION_id
             */
            $tbl_dicval = (new DicVal())->getTable();
            $tbl_dic_field_val = (new DicFieldVal())->getTable();
            $rand_tbl_alias = md5(time() . rand(999999, 9999999));
            $query->select($tbl_dicval . '.*');
            $query->join($tbl_dic_field_val . ' AS ' . $rand_tbl_alias, $rand_tbl_alias . '.dicval_id', '=', $tbl_dicval . '.id')
                ->where($rand_tbl_alias . '.key', '=', 'project_id')
                ->where($rand_tbl_alias . '.value', '=', $project->id);
        });
        DicVal::extracts($documents, 1);
        #Helper::tad($documents);

        $projects = Dic::valuesBySlug('projects', function($query) use ($solution, $project) {
            /**
             * Фильтр значений (DicVal) по его доп. полю (DicFieldVal)
             * SOLUTION_id
             */
            $tbl_dicval = (new DicVal())->getTable();
            $tbl_dic_field_val = (new DicFieldVal())->getTable();
            $rand_tbl_alias = md5(time() . rand(999999, 9999999));
            $query->select($tbl_dicval . '.*');
            $query->join($tbl_dic_field_val . ' AS ' . $rand_tbl_alias, $rand_tbl_alias . '.dicval_id', '=', $tbl_dicval . '.id')
                ->where($rand_tbl_alias . '.key', '=', 'solution_id')
                ->where($rand_tbl_alias . '.value', '=', $solution->id);
            #$query->where($tbl_dicval . '.id', '!=', $project->id);
            $query->take(5);
        });
        DicVal::extracts($projects, 1);
        #Helper::tad($projects);

        $images_ids = Dic::makeLists($projects, false, 'mainpage_image');
        #Helper::d($images_ids);
        if (isset($images_ids) && is_array($images_ids) && count($images_ids)) {
            $images = Photo::whereIn('id', $images_ids)->get();
            if (count($images))
                $images = DicVal::extracts($images, true);
        } else {
            $images = array();
        }
        #Helper::tad($images);

        /**
        * Предыдущий проект
        */
        $prev_project = Dic::valuesBySlug('projects', function($query) use ($project){
            $query->where('id', '!=', $project->id);
            $query->where('created_at', '<', $project->created_at);
            $query->take(1);
        });
        $prev_project = @$prev_project[0];
        #Helper::d($prev_project);

        /**
         * Следующий проект
         */
        $next_project = Dic::valuesBySlug('projects', function($query) use ($project, $solution){
            /**
             * Фильтр значений (DicVal) по его доп. полю (DicFieldVal)
             * SOLUTION_id
             */
            $tbl_dicval = (new DicVal())->getTable();
            $tbl_dic_field_val = (new DicFieldVal())->getTable();
            $rand_tbl_alias = md5(time() . rand(999999, 9999999));
            $query->select($tbl_dicval . '.*');
            $query->join($tbl_dic_field_val . ' AS ' . $rand_tbl_alias, $rand_tbl_alias . '.dicval_id', '=', $tbl_dicval . '.id')
                ->where($rand_tbl_alias . '.key', '=', 'solution_id')
                ->where($rand_tbl_alias . '.value', '=', $solution->id);

            $query->where($tbl_dicval.'.id', '!=', $project->id);
            $query->where($tbl_dicval.'.created_at', '>', $project->created_at);
            $query->take(1);
        });
        $next_project = @$next_project[0];
        #Helper::dd($next_project);


        return View::make(Helper::layout('project-one'), compact('project', 'solution', 'gallery', 'photos', 'documents', 'projects', 'images', 'prev_project', 'next_project'));
    }


    public function postRequestDemo() {

        #Helper::d(Input::all());

        #sleep(5);
        #App::abort(404);

        if(!Request::ajax())
            App::abort(404);

        $solution_id = Input::get('solution_id');

        #if (!strpos($room_type, '.'))
        #    App::abort(404);
        #Helper::dd($room_type);
        #list($room_id, $price_type) = explode('.', $room_type);

        $solution = Dic::valueBySlugAndId('solutions', $solution_id);

        if (!is_object($solution)) {
            App::abort(404);
        }

        #Helper::tad($solution);

        $json_request = array('status' => TRUE, 'responseText' => '');

        ## Send confirmation to user - with password
        $data = Input::all();
        $data['solution'] = $solution;
        Mail::send('emails.request-demo', $data, function ($message) use ($data) {
            $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
            $message->subject('Заказ на демонстрацию решения: ' . $data['solution']->name);
            $message->to(Config::get('mail.feedback.address'));

            $ccs = Config::get('mail.feedback.cc');
            if (isset($ccs) && is_array($ccs) && count($ccs))
                foreach ($ccs as $cc)
                    $message->cc($cc);

        });
        #Helper::dd($result);
        return Response::json($json_request, 200);

    }

}