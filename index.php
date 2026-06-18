<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Parking System - Login</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary-yellow: #FFDE42;
            --input-bg: #4C5C2D;
            --bg-gradient: linear-gradient(135deg, #FFDE42 0%, #9FCB98 100%);
        }

        body, html {
            height: 100%;
            margin: 0;
            overflow: hidden;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: var(--bg-gradient);
        }

        /* --- SPLASH & LOGO --- */
        #splash {
            position: fixed;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 100;
            pointer-events: none;
        }

        .logo-box img {
            width: 200px;
            transition: all 1s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        }

        .logo-box.move-to-card img {
            transform: translateY(-135px) scale(0.6);
        }

        /* --- LOGIN CARD --- */
        #login-wrapper {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .login-card {
            background-color: var(--primary-yellow);
            padding: 40px 30px;
            border-radius: 15px;
            width: 320px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        /* Ruang logo diperlebar agar tidak menabrak judul saat logo diturunkan */
        .logo-space { height: 50px; } 
        .login-card h2 { font-size: 1.1rem; margin-bottom: 25px; font-weight: bold; }

        .form-group { text-align: left; margin-bottom: 20px; }
        .form-group label { display: block; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }

        .input-container {
            display: flex;
            align-items: center;
            position: relative;
        }

        .input-container input {
            flex: 1;
            padding: 12px 15px;
            border: none;
            border-radius: 10px;
            background-color: var(--input-bg);
            color: white;
            font-size: 0.9rem;
            outline: none;
        }

        .input-user { padding-left: 50px !important; }
        .input-pass { padding-right: 50px !important; }

        .bi-icon {
            background-color: white;
            color: black;
            width: 45px; 
            height: 45px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            font-size: 1.4rem;
            position: relative;
            z-index: 2;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .icon-left { margin-right: -45px; left: -5px; }
        .icon-right { margin-left: -45px; right: -5px; }

        .btn-login {
            background: #1B0C0C;
            color: white;
            border: none;
            padding: 12px 45px;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            width: 100%;
            transition: transform 0.2s;
        }

        .btn-login:active { transform: scale(0.95); }
    </style>
</head>
<body>

    <div id="splash">
        <div class="logo-box" id="main-logo">
            <img src="logo.png" alt="Logo">
        </div>
    </div>

    <div id="login-wrapper">
        <div class="login-card">
            <div class="logo-space"></div>
            <h2>HALAMAN LOGIN KEBDARAAN</h2>
            
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <div class="input-container">
                        <div class="bi-icon icon-left">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <input type="text" name="username" class="input-user" placeholder="Username..." required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-container">
                        <input type="password" name="password" class="input-pass" placeholder="Password..." required>
                        <div class="bi-icon icon-right">
                            <i class="bi bi-lock-fill"></i>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-login">LOGIN</button>
            </form>
        </div>
    </div>

    <script>
        window.onload = () => {
            setTimeout(() => {
                const logoContainer = document.getElementById('main-logo');
                const wrapper = document.getElementById('login-wrapper');
                const splash = document.getElementById('splash');

                logoContainer.classList.add('move-to-card');
                wrapper.style.opacity = "1";

                setTimeout(() => {
                    splash.style.display = "none";
                    document.querySelector('.logo-space').innerHTML = '<img src="logo.png" style="width:110px; margin-top:-10px">';
                }, 1000); 
            }, 1000);
        };
    </script>
</body>
</html>