<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
@extends(Helper::layout())


@section('style')
@stop


@section('content')

        <section class="title-block title-main">
            <div class="container_12">
                <div class="clearfix"></div>
            </div>
        </section>

        <section class="error-section">
            <div class="container_12">
                <div class="grid_12">
                    <div class="error-block code-404">
                        <div class="error-icon"></div>
                        <div class="error-code">
                            404
                        </div>
                        <div class="error-text">
                            Страница не найдена или не существует
                        </div>
                        <div class="error-tomain"><a href="{{ URL::route('mainpage') }}">На главную</a></div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </section>

@stop


@section('footer')
    
@stop


@section('scripts')
@stop
