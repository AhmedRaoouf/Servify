<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Verification</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h3 {
            color: #007bff;
        }

        p {
            margin-bottom: 20px;
        }

        .verification-code {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
            background-color: #d4edda;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .note {
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Hello!</h3>
        <p>
            Thank you for registering with us. To complete your registration, please use the verification code below:
        </p>
        <div class="verification-code">{{ $code }}</div>
        <p class="note">
            Note: This verification code is valid for a limited time. Please do not share it with anyone for security reasons.
        </p>
    </div>
</body>
</html>
