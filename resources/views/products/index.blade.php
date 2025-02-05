@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-2">
            @component('components.sidebar', ['categories' => $categories, 'major_categories' => $major_categories])
            @endcomponent
        </div>
        <div class="col-9">
            <div class="container">
                @if ($category !== null)
                    <a href="{{ route('products.index') }}">トップ</a> > <a href="#">{{ $major_category->name }}</a> >
                    {{ $category->name }}
                    <h1>{{ $category->name }}の商品一覧{{ $total_count }}件</h1>
                @elseif ($keyword !== null)
                    <a href="{{ route('products.index') }}">トップ</a> > 商品一覧
                    <h1>"{{ $keyword }}"の検索結果{{ $total_count }}件</h1>
                @endif
            </div>
            <div>
                Sort By
                @sortablelink('id', 'ID')
                @sortablelink('price', 'Price')
                @sortablelink('created_at', 'Created_At')
            </div>
            <div class="container mt-4">
                <div class="row w-100">
                    @foreach ($products as $product)
                        <div class="col-3">
                            <a href="{{ route('products.show', $product) }}">
                                @if ($product->image !== '')
                                    <img src="{{ asset($product->image) }}" class="img-thumbnail">
                                @else
                                    <img src="{{ asset('img/dummy.png') }}" class="img-thumbnail">
                                @endif
                            </a>
                            <div class="row">

                                <div class="col-12">
                                    @php
                                        // 平均価格を取得(小数第1位まで null対策)
                                        $average_score = $product->reviews->avg('score');
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
                                        {{ $product->name }}<br>

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
                                                <span class="averege-score">{{ $formatted_score }}</span>
                                                <!-- 平均評価の数値表示 -->
                                            </div>
                                        @endif


                                        <label>\{{ $product->price }}</label>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            {{-- カテゴリーで絞り込んだ条件を保持してページング --}}
            {{ $products->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
