<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="{{ asset("theme/js/vendor/jquery-1.10.2.min.js") }}"><\/script>')</script>

        {{ HTML::script("theme/js/main.js") }}
        {{ HTML::script("js/vendor/jquery.validate.min.js") }}
        {{ HTML::script("js/vendor/jquery-form.min.js") }}

        <script>
            $('.solution-select').solutionSelect({{ (isset($solution4form) && is_object($solution4form) && $solution4form->id) ? $solution4form->id : '' }});
        </script>
