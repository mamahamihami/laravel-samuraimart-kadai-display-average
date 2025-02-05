@extends('layouts.app')

@section('content')
    <div class="containner">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <h3 class="mt-3 mb-3"></h3>
                <hr>
                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <input type="email" id="email"
                            class="form-control @error('email') is-invalid @enderror samuraimart-login-input" name="email"
                            value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="メールアドレス">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>メールアドレスが正しくない可能性があります</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="password" id="password"
                            class="form-control @error('password') is-invalid @enderror samuraimart-login-input"
                            name="password" required autocomplete="current-password" autofocus placeholder="パスワード">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>パスワードが正しくない可能性があります</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>

                            <label for="remember"
                                class="form-check-label samuraimart-check-label w-100">次回から自動的にログインする</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="mt-3 btn samuraimart-submit-button w-100">ログイン</button>

                        <a href="{{ route('password.request') }}"
                            class="btn btn-link mt-3 d-flex justify-content-center samuraimart-login-text">パスワードをお忘れの場合</a>
                    </div>
                </form>

                <hr>

                <div class="form-group">
                    <a href="{{ route('register') }}"
                        class="btn btn-link mt-3 d-flex justify-content-center samuraimart-login-text">新規登録</a>
                </div>
            </div>
        </div>
    </div>
@endsection
