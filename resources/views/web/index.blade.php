@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-2">
            @component('components.sidebar', ['categories' => $categories, 'major_categories' => $major_categories])
            @endcomponent
        </div>
        <div class="col-9">
            <h1>おすすめ商品</h1>
            <div class="row">
                @foreach ($recommend_products as $recommend_product)
                    <div class="col-4">
                        <a href="{{ route('products.show', $recommend_product) }}">
                            @if ($recommend_product->image !== '')
                                <img src="{{ asset($recommend_product->image) }}" class="img-thumbnail">
                            @else
                                <img src="{{ asset('img/dummy.png') }}" class="img-thumbnail">
                            @endif
                        </a>
                        <div class="row">
                            <div class="col-12">
                                @php
                                    // 平均価格を取得(小数第1位まで null対策)
                                    $average_score = $recommend_product->reviews->avg('score');
                                    $formatted_score =
                                        $average_score !== null
                                            ? ($average_score == floor($average_score)
                                                ? floor($average_score)
                                                : number_format($average_score, 1))
                                            : null;

                                    // 星の数を計算
                                    $fullStars = floor($average_score); // 完全な星の数
                                    $hasHalfStar = $average_score - $fullStars >= 0.5; // 0.5以上なら半分の星を追加
                                @endphp
                                <p class="samuraimart-product-label mt-2">
                                    {{ $recommend_product->name }}<br>

                                    {{-- 評価 （レビューがある場合のみ表示） --}}
                                    @if ($formatted_score !== null)
                                        <div class="samuraimart-star-rating" data-rate="{{ $average_score }}">
                                            {{-- ★を表示 --}}
                                            @for ($i = 0; $i < $fullStars; $i++)
                                                ★
                                            @endfor

                                            {{-- 半分の★を表示 --}}
                                            @if ($hasHalfStar)
                                                <span class="half-star">★</span>
                                            @endif

                                            <span class="averege-score">{{ $formatted_score }}</span> <!-- 平均評価の数値表示 -->
                                        </div>
                                    @endif

                                    <label>\{{ $recommend_product->price }}</label>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="d-flex justify-content-between">
                <h1>新着商品</h1>
                <a href="{{ route('products.index', ['sort' => 'id', 'direction' => 'desc']) }}">もっと見る</a>
            </div>
            <div class="row">

                @foreach ($recently_products as $recently_product)
                    <div class="col-3">
                        <a href="{{ route('products.show', $recently_product) }}">
                            @if ($recently_product->image !== '')
                                <img src="{{ asset($recently_product->image) }}" class="img-thumbnail">
                            @else
                                <img src="{{ asset('img/dummy.png') }}" class="img-thumbnail">
                            @endif
                        </a>

                        <div class="row">
                            <div class="col-12">
                                @php
                                    // 平均価格を取得(小数第1位まで null対策)
                                    $average_score = $recently_product->reviews->avg('score');
                                    $formatted_score =
                                        $average_score !== null
                                            ? ($average_score == floor($average_score)
                                                ? floor($average_score)
                                                : number_format($average_score, 1))
                                            : null;
                                    // 星の数を計算
                                    $fullStars = floor($average_score); // 完全な星の数
                                    $hasHalfStar = $average_score - $fullStars >= 0.5; // 0.5以上なら半分の星を追加
                                @endphp

                                <p class="samuraimart-product-label mt-2">
                                    {{ $recently_product->name }}<br>

                                    {{-- 評価 （レビューがある場合のみ表示） --}}
                                    @if ($formatted_score !== null)
                                        <div class="samuraimart-star-rating" data-rate="{{ $average_score }}">
                                            {{-- ★を表示 --}}
                                            @for ($i = 0; $i < $fullStars; $i++)
                                                ★
                                            @endfor
                                            {{-- 半分の★を表示 --}}
                                            @if ($hasHalfStar)
                                                <span class="half-star">★</span>
                                            @endif
                                            <span class="averege-score">{{ $formatted_score }}</span> <!-- 平均評価の数値表示 -->
                                        </div>
                                    @endif

                                    <label>\{{ $recently_product->price }}</label>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection
