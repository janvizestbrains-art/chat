<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MsgNest - Login</title>
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>

<body>
    <main class="login-wrapper">

        <!-- Left: brand panel -->
        <section class="brand-panel">
            <div class="brand-logo">
                <span class="logo-icon">💬</span>
                <span class="logo-text">MsgNest</span>
            </div>
            <h2>Stay connected with the people who matter.</h2>
            <p>Fast, secure and beautifully simple messaging for you and your team.</p>

            <ul class="features">
                <li>✔ Real-time conversations</li>
                <li>✔ Share files and photos easily</li>
                <li>✔ Group chats and online status</li>
            </ul>

            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
        </section>

        <!-- Right: login form -->
        <section class="form-panel">
            <div class="form-box">
                <h1>Welcome back 👋</h1>
                <p class="subtitle">Please login to your account</p>
                @if (session('error'))
                    <p style="color: red">{{ session('error') }}</p>
                @endif

                <form id="loginForm" method="POST" action="{{ route('loginPost') }}">
                    @csrf
                    <div class="field">
                        <label for="email">Email</label>
                        <div class="input-group">
                            <span class="icon">✉</span>
                            <input type="email" id="email" name="email" placeholder="you@example.com" />
                        </div>
                        <small class="error" id="emailError"></small>
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <span class="icon">🔒</span>
                            <input type="password" id="password" name="password" placeholder="Enter your password" />
                            <button type="button" id="togglePassword" class="toggle"
                                aria-label="Show password">Show</button>
                        </div>
                        <small class="error" id="passwordError"></small>
                    </div>

                    <button type="submit" class="btn-primary">Login</button>
                    <p class="success" id="successMsg"></p>
                </form>
                {{-- <div class="divider"><span>or continue with</span></div>

                <div class="social">
                    <button type="button" class="btn-social">G&nbsp; Google</button>
                    <button type="button" class="btn-social">f&nbsp; Facebook</button>
                </div> --}}

        </section>

    </main>

    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
