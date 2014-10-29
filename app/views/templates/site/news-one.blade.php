<?
/**
 * TITLE: Страница одной новости
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
@extends(Helper::layout())


@section('style')
@stop


@section('content')

        <section class="title-block title-main">
            <div class="container_12">
                <section class="title-content min-pad">
                    <div class="grid_9">
                        <div class="head-top-info">
                            <span class="news-date"><span class="day">{{ $new->created_at->format('d') }}</span> / {{ $new->created_at->format('m') }} / {{ $new->created_at->format('Y') }}</span>
                            @if (count($new->related_dicvals))
                            <ul class="tags-ul adp-top-smar">
                                @foreach ($new->related_dicvals as $tag)
                                <li class="tag-{{ $tag->slug }} active">{{ $tag->name }}
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>
                    <div class="grid_3 head-nav">
                        <div class="prj-arrows">
                            @if (isset($prev_new) && is_object($prev_new) && $prev_new->id)
                            <a href="{{ URL::route('news_full', $prev_new->slug) }}" class="desc-icon prev"></a>
                            @endif
                            @if (isset($next_new) && is_object($next_new) && $next_new->id)
                            <a href="{{ URL::route('news_full', $next_new->slug) }}" class="desc-icon next"></a>
                            @endif
                        </div>
                        <a href="{{ URL::route('page', 'newslist') }}"><i class="lit-icon icon-projects"></i> Все новости</a>
                    </div>
                    <div class="grid_8">
                        <h1>
                            {{ $new->name }}
                        </h1>
                    </div>
                    <div class="clearfix"></div>
                </section>
                <div class="clearfix"></div>
            </div>
        </section>

        <section class="gray-section js-news-one">
            <div class="container_12">
                <div class="grid_8 grid_t12 grid_m12 news-content">

                    @if ($new->gallery)
                        <div class="grid_6 grid_t9 alpha">&nbsp;
                            <div class="js-news-fotorama">
                                @foreach ($new->gallery->photos as $photo)
                                <img src="{{ $photo->full() }}">
                                @endforeach
                            </div>
                        </div>
                        <div class="grid_2 grid_t3 omega">
                            <div class="head-nav">
                                <a href="#" class="desc-icon prev js-fotorama-control" data-direction="<"></a>
                                <a href="#" class="desc-icon next js-fotorama-control" data-direction=">"></a>
                            </div>
                        </div>
                    @elseif ($new->image)
                        <div class="grid_6 grid_t9 alpha">&nbsp;
                            <div class="js-news-fotorama">
                                <img src="{{ $new->image->full() }}">
                            </div>
                        </div>
                    @endif


                    <div class="grid_8 grid_t12 grid_m12 alpha omega news-text">

                        {{ $new->preview }}

                        {{ $new->content }}

                        <div class="head-nav nav-dark">
                            @if (isset($prev_new) && is_object($prev_new) && $prev_new->id)
                            <a href="{{ URL::route('news_full', $prev_new->slug) }}" class="desc-icon prev"></a>
                            @endif
                            @if (isset($next_new) && is_object($next_new) && $next_new->id)
                            <a href="{{ URL::route('news_full', $next_new->slug) }}" class="desc-icon next"></a>
                            @endif
                            <a href="{{ URL::route('page', 'newslist') }}"><i class="lit-icon icon-projects"></i> Все новости</a>
                        </div>
                    </div>
                </div>
                <div class="grid_4 grid_t12 adp-no-mar js-relative-news adp-top-mar">
                    <div class="js-relative-in">
                        @if (count($related_news))
                            <div class="grid_12">
                                <h2>Похожие новости</h2>
                            </div>
                            <div class="clearfix"></div>
                            @foreach ($related_news as $related_new)
                                <div class="news-item grid_t6 js-one-relative">
                                    <div class="news-preview">
                                        <span class="news-date"><span class="day">{{ $related_new->created_at->format('d') }}</span> / {{ $related_new->created_at->format('m') }} / {{ $related_new->created_at->format('Y') }}</span>
                                        <a href="{{ URL::route('news_full', $related_new->slug) }}" class="title">
                                            {{ $related_new->name }}
                                        </a>
                                    </div>
                                    @if (count($related_new->related_dicvals))
                                    <ul class="tags-ul">
                                        @foreach ($related_new->related_dicvals as $tag)
                                        <li class="tag-{{ $tag->slug }} active">{{ $tag->name }}
                                        @endforeach
                                    </ul>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </section>


@stop


@section('footer')
    @parent
@stop


@section('scripts')
        {{ HTML::script(Config::get('site.theme_path').'/js/vendor/fotorama.js') }}
        <script>
            $(document).news_page();
        </script>
@stop
