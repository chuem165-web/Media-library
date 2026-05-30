<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{

            min-height:100vh;

            display:flex;
            justify-content:center;
            align-items:center;

            font-family:Arial, sans-serif;

            background:
                linear-gradient(
                    135deg,
                    #ffe9e9 0%,
                    #ffd6d6 100%
                );

            padding:20px;
        }

        .error-card{

            width:100%;
            max-width:460px;

            background:#fff;

            border-radius:18px;

            padding:40px 30px;

            text-align:center;

            box-shadow:
                0 8px 25px rgba(0,0,0,0.10);

            border-top:
                6px solid #c0392b;

            animation:fadeIn 0.4s ease;
        }

        .error-icon{

            font-size:42px;

            margin-bottom:12px;
        }

        .error-code{

            font-size:68px;
            font-weight:bold;

            color:#c0392b;

            margin-bottom:8px;
        }

        .error-title{

            font-size:28px;

            color:#2c3e50;

            margin-bottom:14px;
        }

        .error-message{

            font-size:15px;

            color:#666;

            line-height:1.5;

            margin-bottom:28px;
        }

        .home-btn{

            display:inline-block;

            padding:12px 24px;

            background:#c0392b;

            color:white;

            text-decoration:none;

            border-radius:8px;

            font-size:14px;

            font-weight:bold;

            transition:0.3s;
        }

        .home-btn:hover{

            background:#962d22;

            transform:translateY(-2px);
        }

        @keyframes fadeIn{

            from{
                opacity:0;
                transform:translateY(20px);
            }

            to{
                opacity:1;
                transform:translateY(0);
            }
        }

    </style>

</head>

<body>

<div class="error-card">

    <div class="error-icon">
        🚨
    </div>

    <div class="error-code">
        500
    </div>

    <h1 class="error-title">
        Server Error
    </h1>

    <p class="error-message">
        Something went wrong on our server.
        Please try again later.
    </p>

    <a
        href="?page=home"
        class="home-btn"
    >
        Back to Home
    </a>

</div>

</body>
</html>