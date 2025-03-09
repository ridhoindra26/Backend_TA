<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        .container {
            margin: 0 auto;
            max-width: 600px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .otp {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            color: #ED0125;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>Reset Password</p>
        <p>Silakan masukkan kode OTP berikut untuk melakukan reset password.</p>
        <p class="otp">{{ $token }}</p>
    </div>
</body>
</html>

