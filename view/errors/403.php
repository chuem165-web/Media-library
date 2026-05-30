<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Forbidden</title>

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
            font-family:Arial,sans-serif;
            background:linear-gradient(
                135deg,
                #f3e8ff 0%,
                #e9d5ff 100%
            );
            padding:20px;
        }

        .error-card{
            width:100%;
            max-width:460px;
            background:white;
            border-radius:18px;
            padding:40px 30px;
            text-align:center;
            border-top:6px solid #7c3aed;
            box-shadow:0 8px 25px rgba(0,0,0,0.1);
        }

        .error-code{
            font-size:68px;
            font-weight:bold;
            color:#7c3aed;
            margin-bottom:10px;
        }

        .error-title{
            font-size:28px;
            margin-bottom:15px;
            color:#2c3e50;
        }

        .error-message{
            color:#666;
            line-height:1.6;
            margin-bottom:25px;
        }

        .home-btn{
            display:inline-block;
            padding:12px 24px;
            background:#7c3aed;
            color:white;
            text-decoration:none;
            border-radius:8px;
        }
    </style>
</head>
<body>

<div class="error-card">

    <div class="error-code">403</div>

    <h1 class="error-title">
        Access Denied
    </h1>

    <p class="error-message">
        You do not have permission to access this page.
    </p>

    <a href="?page=home" class="home-btn">
        Back to Home
    </a>

</div>

</body>
</html>