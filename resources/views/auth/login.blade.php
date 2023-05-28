@extends('master_layout.layout')

@section('content')

@section('title', 'Login Page')

<body>
    <br>

    <div class="container" id="container">

        <div class="form-container sign-up-container">

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <h1>Create Account</h1>

                <div>
                    <label hidden>{{ __('Name') }}</label>
                    <input type="text" name="name" placeholder="Name" class="field-input @error('name') is-invalid @enderror" value="{{ old('name') }}" required pattern="[A-Za-z ]+">

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div>
                    <label hidden>{{ __('Email Address') }}</label>
                    <input type="email" name="email" placeholder="Email" class="field-input @error('email') is-invalid @enderror" value="{{ old('email') }}" required>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div>
                    <label hidden>{{ __('Password') }}</label>
                    <input type="password" name="password" placeholder="Password" class="field-input @error('password') is-invalid @enderror" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div>
                    <label hidden>{{ __('Confirm Password') }}</label>
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" class="field-input" required>
                </div>
                <button class="btn" type="submit">{{ __('Register') }}</button>
            </form>
        </div>

        <div class="form-container sign-in-container">
            <form method="POST" id="loginForm" action="{{ route('login') }}">
                @csrf
                @if(isset($errorMessage))
                <div class="alert alert-danger" id="error-message">{{ $errorMessage }}</div>
                @endif
                <h1>Sign In</h1>

                <div>
                    <label hidden>{{ __('Email Address') }}</label>
                    <input type="email" name="email" placeholder="Email" class="field-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div>
                    <label hidden>{{ __('Password') }}</label>
                    <input type="password" name="password" placeholder="Password" class="field-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <button type="submit" class="btn">{{ __('Login') }}</button>
            </form>

        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello World!</h1>
                    <p>Enter your details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
</body>

<script type="text/javascript">
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });
    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });

    setTimeout(function() {
        document.getElementById('error-message').classList.add('d-none');
    }, 5000);
</script>

<style>
    body {
        background-image: url('https://images.unsplash.com/photo-1651475123597-4c282bf620a7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1708&q=80');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        backdrop-filter: blur(5px);
    }

    h1 {
        font-weight: bold;
        margin: 0;
    }

    h2 {
        text-align: center;
    }

    p {
        font-size: 14px;
        font-weight: 100;
        line-height: 20px;
        letter-spacing: 0.5px;
        margin: 20px 0 30px;
    }

    span {
        font-size: 12px;
    }

    a {
        color: #333;
        font-size: 14px;
        text-decoration: none;
        margin: 15px 0;
    }

    button {
        border-radius: 20px;
        border: 1px solid #432B1E;
        background-color: #432B1E;
        color: #FFFFFF;
        font-size: 12px;
        font-weight: bold;
        padding: 12px 45px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: transform 80ms ease-in;
    }

    button:active {
        transform: scale(0.95);
    }

    button:focus {
        outline: none;
    }

    .ghost {
        display: inline-block;
        font-family: sans-serif;
        font-weight: 600;
        font-size: 16px;
        color: #fff;
        margin: 1rem auto;
        padding: 0.7rem 2rem;
        border-radius: 30em;
        border-style: none;
        position: relative;
        z-index: 1;
        overflow: hidden;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 2px;
        background-color: transparent;
        box-shadow: 1px 1px 12px #000000;
    }

    .ghost::before {
        content: "";
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        background-color: #fff;
        transform: translateX(-101%);
        transition: all .3s ease;
        z-index: -1;
    }

    .ghost:hover {
        color: #272727;
        transition: all .3s ease;
    }

    .ghost:hover::before {
        transform: translateX(0);
    }

    .btn {
        width: 6.5em;
        height: 2.3em;
        margin: 0.5em;
        background: black;
        color: white;
        border: none;
        border-radius: 0.625em;
        font-size: 20px;
        cursor: pointer;
        position: relative;
        z-index: 1;
        overflow: hidden;
    }

    .btn:hover {
        color: black;
    }

    .btn:after {
        content: "";
        background: white;
        position: absolute;
        z-index: -1;
        left: -20%;
        right: -20%;
        top: 0;
        bottom: 0;
        transform: skewX(-45deg) scale(0, 1);
        transition: all 0.5s;
    }

    .btn:hover:after {
        transform: skewX(-45deg) scale(1, 1);
        -webkit-transition: all 0.5s;
        transition: all 0.5s;
    }

    form {
        background-color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 50px;
        height: 100%;
        text-align: center;
    }

    /* From uiverse.io by @alexruix */
    .field-input {
        line-height: 28px;
        border: 2px solid transparent;
        border-bottom-color: #777;
        padding: .2rem 0;
        outline: none;
        background-color: transparent;
        color: #0d0c22;
        transition: .3s cubic-bezier(0.645, 0.045, 0.355, 1);
    }

    .field-input:focus,
    input:hover {
        outline: none;
        padding: .2rem 1rem;
        border-radius: 1rem;
        border-color: #777;
    }

    .field-input::placeholder {
        color: #777;
    }

    .field-input:focus::placeholder {
        opacity: 0;
        transition: opacity .3s;
    }

    .container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25),
            0 10px 10px rgba(0, 0, 0, 0.22);
        overflow: hidden;
        width: 768px;
        max-width: 100%;
        min-height: 500px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, 30%);
        margin-top: -90px;
    }

    .form-container {
        position: absolute;
        top: 0;
        height: 100%;
        transition: all 0.6s ease-in-out;
    }

    .form-container input {
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .sign-in-container {
        left: 0;
        width: 50%;
        z-index: 2;
    }

    .container.right-panel-active .sign-in-container {
        transform: translateX(100%);
    }

    .sign-up-container {
        left: 0;
        width: 50%;
        opacity: 0;
        z-index: 1;
    }

    .container.right-panel-active .sign-up-container {
        transform: translateX(100%);
        opacity: 1;
        z-index: 5;
        animation: show 0.6s;
    }

    @keyframes show {

        0%,
        49.99% {
            opacity: 0;
            z-index: 1;
        }

        50%,
        100% {
            opacity: 1;
            z-index: 5;
        }
    }

    .overlay-container {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        transition: transform 0.6s ease-in-out;
        z-index: 100;
    }

    .container.right-panel-active .overlay-container {
        transform: translateX(-100%);
    }

    .overlay {
        background: #FF416C;
        background: -webkit-linear-gradient(to right, #b51f1a, #7e2423);
        background: linear-gradient(90deg, rgba(44, 27, 20, 1) 31%, rgba(94, 67, 47, 1) 100%);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: 0 0;
        color: #FFFFFF;
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .container.right-panel-active .overlay {
        transform: translateX(50%);
    }

    .overlay-panel {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 40px;
        text-align: center;
        top: 0;
        height: 100%;
        width: 50%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .overlay-left {
        transform: translateX(-20%);
    }

    .container.right-panel-active .overlay-left {
        transform: translateX(0);
    }

    .overlay-right {
        right: 0;
        transform: translateX(0);
    }

    .container.right-panel-active .overlay-right {
        transform: translateX(20%);
    }

    .social-container {
        margin: 20px 0;
    }

    .social-container a {
        border: 1px solid #DDDDDD;
        border-radius: 50%;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        margin: 0 5px;
        height: 40px;
        width: 40px;
    }
</style>
@endsection