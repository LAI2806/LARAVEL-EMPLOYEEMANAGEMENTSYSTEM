<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: #f5f6fa;
            min-height: 100vh;
        }

        .login-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .login-image-side {
            flex: 1;
            display: none;
        }

        .login-image-side img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .login-form-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            min-height: 100vh;
        }

        .login-card {
            background: #fff;
            border-radius: 24px;
            padding: 40px 32px;
            width: 100%;
            max-width: 420px;
        }

        .login-input {
            width: 100%;
            padding: 12px 14px 12px 40px;
            border-radius: 12px;
            border: 1.5px solid #e8e8f4;
            font-size: 14px;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            background: #f8f8fc;
            color: #1a1a2e;
        }
        .login-input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,.15);
            background: #fff;
        }
        .login-input.is-invalid { border-color: #ef4444; }

        .login-label {
            font-size: 11px;
            font-weight: 600;
            color: #94a3b8;
            margin-bottom: 6px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            border-radius: 14px;
            border: none;
            background: #6366f1;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: background .15s;
        }
        .login-btn:hover { background: #4f46e5; }

        .invalid-msg { font-size: 12px; color: #ef4444; margin-top: 4px; }

        .remember-check { accent-color: #6366f1; }

        .field-wrap { position: relative; }

        .field-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: #c4c4d4;
            pointer-events: none;
        }

        @media (min-width: 768px) {
            .login-image-side { display: block; }
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    <div class="login-image-side">
        <img src="{{ asset('images/akin.jpg') }}" alt="Workplace">
    </div>

    <div class="login-form-side">
        <div class="login-card">

            <div class="text-center mb-4">
                <div style="width:52px;height:52px;background:#eeedfe;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                    <i class="bi bi-house-heart-fill" style="color:#6366f1;font-size:24px;"></i>
                </div>
                <h3 class="mt-2 mb-0 fw-bold">Welcome back!</h3>
                <small class="text-muted fw-light">Please enter your credentials</small>
            </div>

            @if (session('status'))
                <div style="background:#d1fae5;border:1px solid #6ee7b7;border-radius:9px;padding:12px 16px;font-size:13px;color:#065f46;margin-bottom:16px;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="login-label">Email Address</label>
                    <div class="field-wrap">
                        <i class="bi bi-envelope field-icon"></i>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="login-input @error('email') is-invalid @enderror"
                               required autofocus>
                    </div>
                    @error('email')
                        <div class="invalid-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="login-label">Password</label>
                    <div class="field-wrap">
                        <i class="bi bi-lock field-icon"></i>
                        <input type="password"
                               name="password"
                               class="login-input @error('password') is-invalid @enderror"
                               required>
                    </div>
                    @error('password')
                        <div class="invalid-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
                    <label style="font-size:13px;color:#64748b;display:flex;align-items:center;gap:6px;cursor:pointer;">
                        <input class="remember-check" type="checkbox" name="remember" id="remember_me">
                        Remember me
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           style="font-size:13px;color:#6366f1;text-decoration:none;font-weight:600;">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="login-btn">Login</button>
            </form>

        </div>
    </div>

</div>

</body>
</html>