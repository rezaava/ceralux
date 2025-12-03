<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود به پنل </title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --main-bg: #181f2a;
            --sidebar-bg: #151a23;
            --card-bg: #232b39;
            --card-border: #232b39;
            --accent-green: #43e97b;
            --text-main: #e6eaf1;
            --text-secondary: #89a5c5;
            --card-radius: 18px;
            --sidebar-width: 240px;
            --sidebar-width-collapsed: 80px;
            --sidebar-icon-size: 1.4rem;
            --transition: 0.3s cubic-bezier(.4, 2, .6, 1);
        }

        @font-face {
            font-family: yekan;
            src: url({{ asset('fonts/YekanBakh-Medium.ttf') }});
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: yekan, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(67, 233, 123, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(105, 165, 197, 0.1) 0%, transparent 50%);
            z-index: -1;
        }

        .glass-container {
            background: rgba(35, 43, 57, 0.6);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: var(--card-radius);
            border: 1px solid rgba(67, 233, 123, 0.1);
            box-shadow: 
                0 15px 35px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            position: relative;
            overflow: hidden;
        }

        .glass-container::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 130px;
            height: 130px;
            background: linear-gradient(45deg, rgba(67, 233, 123, 0.1), transparent);
            border-radius: 0 0 0 100%;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
        }

        .login-header h1 {
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 10px;
            background: linear-gradient(to right, var(--accent-green), #2bcbba);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .login-header p {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 30px;
            position: relative;
        }

        .input-container {
            position: relative;
        }

        .input-container i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 1.2rem;
            transition: var(--transition);
            z-index: 2;
        }

        .form-control {
            background-color: rgba(25, 33, 48, 0.7);
            border: none;
            border-radius: 10px;
            color: var(--text-main);
            padding: 15px 50px 15px 20px;
            height: 55px;
            transition: var(--transition);
            font-size: 1rem;
        }

        .form-control:focus {
            background-color: rgba(30, 40, 60, 0.8);
            border-color: var(--accent-green);
            box-shadow: 0 0 0 3px rgba(67, 233, 123, 0.2);
            color: var(--text-main);
        }

        .form-label {
            position: absolute;
            right: 50px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            transition: var(--transition);
            pointer-events: none;
            background-color: transparent;
            padding: 0 5px;
            z-index: 1;
        }

        .form-control:focus + .form-label,
        .form-control:not(:placeholder-shown) + .form-label {
            top: -10px;
            right: 20px;
            font-size: 0.85rem;
            color: var(--accent-green);
            /* background-color: rgba(35, 43, 57, 0.9); */
            padding: 0 8px;
            border-radius: 4px;
        }

          /* حل مشکل پیشنهاد کروم (autofill) */
        .form-control:-webkit-autofill,
        .form-control:-webkit-autofill:hover,
        .form-control:-webkit-autofill:focus,
        .form-control:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px rgba(25, 33, 48, 0.7) inset !important;
            -webkit-text-fill-color: var(--text-main) !important;
            transition: background-color 5000s ease-in-out 0s;
            border: 1px solid rgba(137, 165, 197, 0.2);
        }

        /* برای حالت فوکوس autofill */
        .form-control:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 30px rgba(30, 40, 60, 0.8) inset, 0 0 0 3px rgba(67, 233, 123, 0.2) !important;
        }

        .form-control::placeholder {
            color: transparent;
        }

        .btn-login {
            background: linear-gradient(to right, var(--accent-green), #2bcbba);
            border: none;
            border-radius: 10px;
            color: #151a23;
            font-weight: 600;
            padding: 15px;
            width: 100%;
            font-size: 1.1rem;
            transition: var(--transition);
            margin-top: 10px;
            cursor: pointer;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 15px rgba(67, 233, 123, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .additional-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 25px;
            font-size: 0.9rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-secondary);
        }

        .remember-me input {
            accent-color: var(--accent-green);
        }

        .forgot-password {
            color: var(--accent-green);
            text-decoration: none;
            transition: var(--transition);
        }

        .forgot-password:hover {
            text-decoration: underline;
            color: #2bcbba;
        }

        .footer-text {
            text-align: center;
            margin-top: 30px;
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        .footer-text a {
            color: var(--accent-green);
            text-decoration: none;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .glass-container {
                padding: 30px 25px;
            }
            
            .login-header h1 {
                font-size: 1.7rem;
            }
            
            .additional-options {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="glass-container">
            <div class="login-header">
                <h1>ورود به پنل</h1>
                <p>لطفا اطلاعات حساب خود را وارد کنید</p>
            </div>
            
            <form id="loginForm" method="POST" action="">
                @csrf
                <div class="form-group">
                    <div class="input-container">
                        <i class="fas fa-user"></i>
                        <input type="text" class="form-control" id="username" name="username" placeholder="نام کاربری" required>
                        <label for="username" class="form-label">نام کاربری</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="input-container">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="form-control" id="password" name="password" placeholder="رمز عبور" required>
                        <label for="password" class="form-label">رمز عبور</label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i> ورود به سیستم
                </button>
                
                <!-- <div class="additional-options">
                    <div class="remember-me">
                        <input type="checkbox" id="remember">
                        <label for="remember">مرا به خاطر بسپار</label>
                    </div>
                    <a href="#" class="forgot-password">رمز عبور را فراموش کرده‌اید؟</a>
                </div> -->
            </form>
            
            <div class="footer-text">
                <!-- <p>حساب کاربری ندارید؟ <a href="#">ثبت‌نام کنید</a></p> -->
                <p class="mt-2">© 2023 پنل مدیریت. تمامی حقوق محفوظ است.</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- <script>
        // افزودن قابلیت حرکت label به بالا هنگام فوکوس
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-control');
            
            inputs.forEach(input => {
                // بررسی مقدار اولیه
                if(input.value) {
                    input.nextElementSibling.style.top = '0';
                    input.nextElementSibling.style.fontSize = '0.85rem';
                    input.nextElementSibling.style.color = 'var(--accent-green)';
                    input.nextElementSibling.style.backgroundColor = 'rgba(35, 43, 57, 0.9)';
                }
                
                // مدیریت رویداد فوکوس
                input.addEventListener('focus', function() {
                    this.nextElementSibling.style.top = '0';
                    this.nextElementSibling.style.fontSize = '0.85rem';
                    this.nextElementSibling.style.color = 'var(--accent-green)';
                    this.nextElementSibling.style.backgroundColor = 'rgba(35, 43, 57, 0.9)';
                });
                
                // مدیریت رویداد بلور
                input.addEventListener('blur', function() {
                    if(!this.value) {
                        this.nextElementSibling.style.top = '50%';
                        this.nextElementSibling.style.fontSize = '1rem';
                        this.nextElementSibling.style.color = 'var(--text-secondary)';
                        this.nextElementSibling.style.backgroundColor = 'transparent';
                    }
                });
            });
            
            // مدیریت ارسال فرم
            document.getElementById('loginForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const username = document.getElementById('username').value;
                const password = document.getElementById('password').value;
                
                if(username && password) {
                    // در اینجا می‌توانید درخواست ورود به سرور ارسال کنید
                    alert(`ورود با موفقیت انجام شد!\nنام کاربری: ${username}`);
                    
                    // ریست کردن فرم
                    this.reset();
                    
                    // بازگرداندن labelها به حالت اولیه
                    document.querySelectorAll('.form-label').forEach(label => {
                        label.style.top = '50%';
                        label.style.fontSize = '1rem';
                        label.style.color = 'var(--text-secondary)';
                        label.style.backgroundColor = 'transparent';
                    });
                } else {
                    alert('لطفاً نام کاربری و رمز عبور را وارد کنید.');
                }
            });
        });
    </script> -->
@if (session('error'))
  <script>
    Swal.fire({
    icon: "error",
    title: "خطا توجه  !",
    text: " {{ session('error') }}",
    timer: 3000,
    timerProgressBar: true,
    confirmButtonText: "باشه",
    
  });
  </script>
@endif
</body>
</html>
