<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Parking System</title>
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
            transform: translateY(-130px) scale(0.5);
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

        .logo-space { height: 70px; }
        .login-card h2 { font-size: 1.1rem; margin-bottom: 25px; font-weight: bold; }

        .form-group { text-align: left; margin-bottom: 20px; }
        .form-group label { display: block; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }

        .input-container {
            display: flex;
            align-items: center;
            position: relative;
        }

        /* INPUT SETTINGS */
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

        /* Padding supaya tulisan tidak ketutup icon */
        .input-user { padding-left: 35px !important; }
        .input-pass { padding-right: 35px !important; }

        /* ICON SETTINGS (Menggunakan Foto Sendiri) */
        .custom-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            position: relative;
            z-index: 2;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            background: #ccc; /* fallback warna */
        }

        .icon-left { margin-right: -25px; }
        .icon-right { margin-left: -25px; }

        .btn-login {
            background: #1B0C0C;
            color: white;
            border: none;
            padding: 12px 45px;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }
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
            <h2>HALAMAN LOGIN</h2>
            
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <div class="input-container">
                        <img src="user-icon.png" class="custom-icon icon-left" alt="User">
                        <input type="text" name="username" class="input-user" placeholder="Username..." required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-container">
                        <input type="password" name="password" class="input-pass" placeholder="Password..." required>
                        <img src="lock-icon.png" class="custom-icon icon-right" alt="Lock">
                    </div>
                </div>

                <button type="submit" class="btn-login">Login</button>
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
                    document.querySelector('.logo-space').innerHTML = '<img src="logo.png" style="width:90px; margin-top:-60px">';
                }, 1000); 
            }, 1000);
        };
    </script>
</body>
</html>