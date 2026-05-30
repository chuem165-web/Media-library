<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>

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
            #ffefef 0%,
            #ffe0e0 100%
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
        6px solid #e74c3c;

    animation:fadeIn 0.4s ease;
}

.error-icon{
    font-size:42px;
    margin-bottom:12px;
}

.error-code{

    font-size:68px;
    font-weight:bold;

    color:#e74c3c;

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

    background:#e74c3c;

    color:white;

    text-decoration:none;

    border-radius:8px;

    font-size:14px;

    font-weight:bold;

    transition:0.3s;
}

.home-btn:hover{

    background:#c0392b;

    transform:translateY(-2px);
}

    </style>

</head>

<body>

<div class="error-card">

    <div class="error-icon">
        ⚠️
    </div>

    <div class="error-code">
        404
    </div>

    <h1 class="error-title">
        Page Not Found
    </h1>

    <p class="error-message">
        The page or catalog item you are looking for
        does not exist or may have been removed.
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