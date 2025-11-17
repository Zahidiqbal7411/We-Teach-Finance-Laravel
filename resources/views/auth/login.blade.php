<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>We Teach Finance - Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafb;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        #login-container {
            background: #fff;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            text-align: center;
            margin-bottom: 0.5rem;
        }

        p.subtitle {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #666;
            font-size: 0.9rem;
        }

        label {
            display: block;
            margin-bottom: 0.3rem;
            font-weight: bold;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.6rem 0.8rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 0.8rem;
            transform: translateY(-50%);
            cursor: pointer;
            background: none;
            border: none;
        }

        button.submit-btn {
            width: 100%;
            padding: 0.8rem;
            border: none;
            border-radius: 8px;
            background: linear-gradient(to right, #4f46e5, #10b981);
            color: #fff;
            font-weight: bold;
            cursor: pointer;
        }

        .message {
            padding: 0.6rem;
            margin-bottom: 1rem;
            border-radius: 6px;
            font-size: 0.85rem;
        }

        .success {
            background-color: #d1fae5;
            color: #065f46;
        }

        .error {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        small {
            display: block;
            margin-top: -0.5rem;
            margin-bottom: 1rem;
            color: #888;
            font-size: 0.8rem;
        }
    </style>
</head>

<body>

    <div id="login-container">
        <div style="text-align:center; margin-bottom:1.5rem;">
            <!-- Logo -->
            <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 100 100">
                <image href="{{ asset('assets/logo_pic/vteach_logo.jpg') }}" width="100" height="100" />
            </svg>

            <rect fill="none" width="100" height="100" rx="12" />
            <g transform="translate(10,16)">
                <circle cx="20" cy="22" r="12" fill="#4f46e5" opacity="0.9" />
                <rect x="40" y="4" width="26" height="36" rx="4" fill="#10b981" />
                <path d="M12 40 L26 18 L46 30" stroke="#fff" stroke-width="4" stroke-linecap="round"
                    stroke-linejoin="round" />
            </g>
            </svg>
            <h2> We Teach Finance</h2>

        </div>

        <!-- Messages -->
        <div id="messages">
            @if ($errors->any())
            <div class="message error">
                <ul style="margin:0; padding-left: 1.2rem;">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session('status'))
            <div class="message success">
                {{ session('status') }}
            </div>
            @endif
        </div>

        <!-- Login Form -->
        <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf
            <label for="email">User name</label>
            <input id="email" name="email" type="email" required placeholder="Enter your username" ">

            <label for=" password">Password</label>
            <div class="password-wrapper">
                <input id="password" name="password" type="password" required placeholder="Enter password">

            </div>



            <button type="submit" class="submit-btn">Log In</button>
        </form>


    </div>

    <script>
        // Show/hide password
        const pwdInput = document.getElementById('password');
        const toggleBtn = document.querySelector('.toggle-password');

        toggleBtn.addEventListener('click', () => {
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                toggleBtn.textContent = '🙈';
            } else {
                pwdInput.type = 'password';
                toggleBtn.textContent = '👁️';
            }
            pwdInput.focus();
        });

        // Submit form on Enter
        pwdInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('loginForm').submit();
            }
        });
    </script>

</body>

</html>