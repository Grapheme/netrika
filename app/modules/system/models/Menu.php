<?php

class Menu extends Storage {
	
	protected $guarded = array();
    public $table = 'storages';

    protected $fillable = array(
        'module',
        'name',
        'value',
    );

    public static $rules = array(
		'name' => 'required',
	);

    public function extract($unset = true) {
        $properties = json_decode($this->value);
        if (count($properties))
            foreach ($properties as $key => $value)
                $this->$key = $value;
        if ($unset)
            unset($this->value);
    }

    public static function draw($slug, $options = false) {

        $menu = Storage::where('module', 'menu')->where('name', $slug)->first();
        $value = json_decode($menu->value, 1);
        Helper::dd($value);
        #$menu = self::get_menu_level($value->items, $options);
    }

    /*
    public static function get_menu_level($level, $options = false) {
        if (!is_array($level) || !count($level))
            return false;
        $return = array('<ul>');
        foreach ($level as $item) {

            $return[] = '<li><a href="">' . $item . '</a></li>';
        }
        $return[] = '</ul>';
    }
    */

}