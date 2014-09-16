<?php
/**
 * С помощью данного конфига можно добавлять собственные поля к объектам DicVal.
 * Для каждого словаря (Dic) можно задать индивидуальный набор полей (ключ массива fields).
 * Набор полей для словаря определяется по его системному имени (slug).
 *
 * Для каждого словаря можно определить набор "постоянных" полей (general)
 * и полей для мультиязычных версий записи (i18n).
 * Первые будут доступны всегда, вторые - только если сайт имеет больше чем 1 язык.
 *
 * Каждое поле представлено в наборе именем на форме (ключ массива) и набором свойств (поля массива по ключу).
 * Обязательно должен быть определен тип поля (type) и заголовок (title).
 * Также можно задать следующие свойства:
 * - default - значение поля по-умолчанию
 * - others - набор дополнительных произвольных свойств элемента, таких как class, style, placeholder и т.д.
 * - handler - функция-замыкание, вызывается для обработки значения поля после получения ИЗ формы, перед записью в БД. Первым параметром передается значение поля, вторым - существующий объект DicVal, к которому относится данное поле
 * - value_modifier - функция-замыкание, вызывается для обработки значения поля после получения значения из БД, перед выводом В форму
 * - after_save_js - JS-код, который будет выполнен после сохранения страницы
 * - content - содержимое, которое будет выведено на экран, вместо генерации кода элемента формы
 * - label_class - css-класс родительского элемента
 *
 * Некоторые типы полей могут иметь свои собственные уникальные свойства, например: значения для выбора у поля select; accept для указания разрешенных форматов у поля типа file и т.д.
 *
 * [!] Вывод полей на форму происходит с помощью /app/lib/Helper.php -> Helper::formField();
 *
 * На данный момент доступны следующие поля:
 * - text
 * - textarea
 * - textarea_redactor (доп. JS)
 * - date (не требует доп. JS, работает для SmartAdmin из коробки, нужны handler и value_modifier для обработки)
 * - image (использует ExtForm::image() + доп. JS)
 * - gallery (использует ExtForm::gallery() + доп. JS, нужен handler для обработки)
 * - upload
 * - video
 * - select
 * - checkboxes (замена select-multiple)
 * - checkbox
 *
 * Типы полей, запланированных к разработке:
 * - select-multiple
 * - radio
 * - upload-group
 * - video-group
 *
 * Также в планах - возможность активировать SEO-модуль для каждого словаря по отдельности (ключ массива seo) и обрабатывать его.
 *
 * [!] Для визуального разделения можно использовать следующий элемент массива: array('content' => '<hr/>'),
 *
 * @author Zelensky Alexander
 *
 */
return array(

    'fields' => array(

        'solutions' => array(
            'general' => array(
                'description_target_audience' => array(
                    'title' => 'Описание целевой аудитории',
                    'type' => 'textarea_redactor',
                ),
                'describes_purpose_decision' => array(
                    'title' => 'Описание назначения решения',
                    'type' => 'textarea_redactor',
                ),
                'description_advantages_solution' => array(
                    'title' => 'Описание преимущества решения',
                    'type' => 'textarea_redactor',
                ),
                'image_schemes_work' => array(
                    'title' => 'Изображение схемы работы',
                    'type' => 'image',
                ),
                'identify_features_solution' => array(
                    'title' => 'Описание возможности решения',
                    'type' => 'textarea_redactor',
                ),
                'description_integration' => array(
                    'title' => 'Описание интеграции',
                    'type' => 'textarea_redactor',
                ),
                'description_plans' => array(
                    'title' => 'Описание планов',
                    'type' => 'textarea_redactor',
                ),
                'description_components' => array(
                    'title' => 'Описание компонентов решения',
                    'type' => 'textarea_redactor',
                ),
                'description_partners' => array(
                    'title' => 'Список партнеров',
                    'type' => 'textarea_redactor',
                ),
                'availability_demonstrate' => array(
                    'no_label' => true,
                    'title' => 'Доступность демонстрации решения',
                    'type' => 'checkbox',
                    'label_class' => 'normal_checkbox',
                ),
                'link_to_file_presentation' => array(
                    'title' => 'Добавить файл презентации',
                    'type' => 'upload',
                    'accept' => 'application/pdf,application/x-download', # .exe,image/*,video/*,audio/*
                    'label_class' => 'input-file',
                    'handler' => function($value, $element = false) {
                            if (@is_object($element) && @is_array($value)) {
                                $value['module'] = 'dicval';
                                $value['unit_id'] = $element->id;
                            }
                            return ExtForm::process('upload', $value);
                        },
                ),
                'tags_id' => array(
                    'title' => 'Список тегов',
                    'type' => 'select-multiple',
                    'values' => Dic::valuesBySlug('entities_tags')->lists('name', 'id'),
                    'handler' => function($value, $element) {
                            $value = (array)$value;
                            $value = array_flip($value);
                            foreach ($value as $v => $null)
                                $value[$v] = array('dicval_child_dic' => 'entities_tags');
                            $element->relations()->sync($value);
                            return @count($value);
                        },
                    'value_modifier' => function($value, $element) {
                            $return = (is_object($element) && $element->id)
                                ? $element->relations()->get()->lists('id')
                                : $return = array()
                            ;
                            return $return;
                        },
                ),
            ),
        ),
    ),
);
