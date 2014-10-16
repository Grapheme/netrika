<?
/**
 * MENU_PLACEMENTS: main_menu=Основное меню|additional_menu=Дополнительное меню|footer_menu=Меню в подвале
 */
?>
<? #Helper::tad($page); ?>
@if (@is_object($page->seo))
@section('title'){{ $page->seo->title ? $page->seo->title : $page->name }}@stop
@section('description'){{ $page->seo->description }}@stop
@section('keywords'){{ $page->seo->keywords }}@stop
@elseif (@is_object($page->meta))
@section('title')
{{{ $page->name }}}@stop
@elseif (@is_object($seo))
@section('title'){{ $seo->title }}@stop
@section('description'){{ $seo->description }}@stop
@section('keywords'){{ $seo->keywords }}@stop
@endif
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
    	@include(Helper::layout('head'))
	    @yield('style')
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        @include(Helper::layout('header'))

        @section('content')
            {{ @$content }}
        @show

        @section('footer')
            {{-- @file_get_contents(Helper::inclayout('footer')) --}}
            @include(Helper::layout('footer'))
        @show

        @include(Helper::layout('scripts'))

        @section('overlays')
        @show

        @section('scripts')
        @show

    </body>
</html>