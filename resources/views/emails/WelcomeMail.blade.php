<!DOCTYPE html>
<html>

<head>
    <title>Welcome to {{ config('app.name') }}</title>
</head>

<body>
    <h1>Welcome, Umang!</h1>
    <p>Thank you for joining our platform.</p>
    <p>Your account has been successfully created.</p>

    <a href="{{ url('/dashboard') }}"
        style="background: #4CAF50; color: white; padding: 10px 20px; text-decoration: none;">
        Go to Dashboard
    </a>

    <p>Best regards,<br>{{ config('app.name') }} Team</p>
</body>

</html>
