<?
/**
 * TITLE: * Простая страница
 */
?>
@extends(Helper::layout())


@section('style')
@stop


@section('content')

        {{ Helper::tad_($page) }}

        <section class="title-block title-main">
            <div class="container_12">
                <section class="title-content min-pad">
                    <div class="grid_8">
                        <h1>
                            @if (isset($page->seo) && @is_object($page->seo) && $page->seo->h1 != '')
                                {{ $page->seo->h1 }}
                            @else
                                {{ $page->name }}
                            @endif
                        </h1>
                    </div>
                    <div class="clearfix"></div>
                </section>
                <div class="clearfix"></div>
            </div>
        </section>


        @if (count($page->blocks))
            @foreach ($page->blocks as $block_slug => $block)
                <section class="us-section">
                    <div class="container_12">
                        {{ $page->block($block_slug) }}
                    </div>
                </section>
            @endforeach
        @endif

@stop


@section('footer')
    @parent
@stop


@section('scripts')
@stop
