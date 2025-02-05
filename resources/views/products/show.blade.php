@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="row w-75">
            <div class="col-5 offset-1">
                @if ($product->image)
                    <img src="{{ asset($product->image) }}" class="w-100 img-fluid">
                @else
                    <img src="{{ asset('img/dummy.png') }}" class="w-100 img-fluid">
                @endif
            </div>

            <div class="col">
                <div class="d-flex flex-column">
                    <h1 class="">
                        {{ $product->name }}
                    </h1>
                    <p class="">
                        {{ $product->description }}
                    </p>
                    <hr>
                    <p class="d-flex align-items-end">
                        {{ $product->price }}(税込)
                    </p>
                    <hr>
                </div>
                @auth
                    <form method="POST" class="m-3 align-items-end" action="{{ route('carts.store') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <input type="hidden" name="name" value="{{ $product->name }}">
                        <input type="hidden" name="price" value="{{ $product->price }}">
                        <input type="hidden" name="image" value="{{ $product->image }}">
                        <input type="hidden" name="carriage" value="{{ $product->carriage_flag }}">
                        <div class="form-group row">
                            <label for="quantity" class="col-sm-2 col-form-label">数量</label>
                            <div class="col-sm-10">
                                <input type="number" name="qty" id="quantity" min="1" value="1"
                                    class="form-control w-25">
                            </div>
                        </div>
                        <input type="hidden" name="weight" value="0">
                        <div class="row">
                            <div class="col-7">
                                <button type="submit" class="btn samuraimart-submit-button w-100">
                                    <i class="fas fa-shopping-cart"></i>
                                    カートに追加
                                </button>
                            </div>
                            <div class="col-5">
                                @if (Auth::user()->favorite_products()->where('product_id', $product->id)->exists())
                                    <a href="{{ route('favorites.destroy', $product->id) }}"
                                        class="btn samuraimart-favorite-button text-favorite w-100"
                                        onclick="event.preventDefault(); document.getElementById('favorites-destroy-form').submit();">
                                        <i class="fa fa-heart"></i>
                                        お気に入り解除
                                    </a>
                                @else
                                    <a href="{{ route('favorites.store', $product->id) }}"
                                        class="btn samuraimart-favorite-button text-favorite w-100"
                                        onclick="event.preventDefault(); document.getElementById('favorites-store-form').submit();"><i
                                            class="fa fa-heart"></i>お気に入り</a>
                                @endif

                            </div>
                        </div>
                    </form>
                    <form action="{{ route('favorites.destroy', $product->id) }}" id="favorites-destroy-form" method="POST"
                        class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                    <form action="{{ route('favorites.store', $product->id) }}" id="favorites-store-form" method="POST"
                        class="d-none">
                        @csrf
                    </form>
                @endauth
            </div>

            <div class="offset-1 col-11">
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
                <hr class="w-100">
                <h3 class="float-left">カスタマーレビュー</h3>

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
            </div>

            <div class="offset-1 col-10">
                <div class="row">
                    @foreach ($reviews as $review)
                        <div class="offset-md-5 col-md-5">
                            <h3 class="review-score-color">{{ str_repeat('★', $review->score) }}</h3>
                            <p class="h3">{{ $review->title }}</p>
                            <p class="h3">{{ $review->content }}</p>
                            <label>{{ $review->created_at }}{{ $review->user->name }}</label>
                        </div>
                    @endforeach
                </div><br />

                @auth
                    <div class="row">
                        <div class="offset-md-5 col-md-5">
                            <form action="{{ route('reviews.store') }}" method="POST">
                                @csrf
                                <h4>評価</h4>
                                <select name="score" class="form-control m-2 review-score-color">
                                    <option value="5" class="review-score-color">★★★★★</option>
                                    <option value="4" class="review-score-color">★★★★</option>
                                    <option value="3" class="review-score-color">★★★</option>
                                    <option value="2" class="review-score-color">★★</option>
                                    <option value="1" class="review-score-color">★</option>
                                </select>
                                <h4>タイトル</h4>
                                @error('title')
                                    <strong>タイトルを入力してください</strong>
                                @enderror
                                <input type="text" name="title" class="form-control m-2">
                                <h4>レビュー内容</h4>
                                @error('content')
                                    <strong>レビュー内容を入力してください</strong>
                                @enderror
                                <textarea name="content" class="form-control m-2"></textarea>
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="btn samuraimart-submit-button ml-2">レビューを追加</button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
@endsection
