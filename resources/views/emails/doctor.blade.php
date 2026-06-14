<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome Doctor</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f6f6f6; padding:20px;">

    <div style="max-width:600px; margin:auto; background:#ffffff; padding:25px; border-radius:10px; border:1px solid #eee;">

        <h2 style="color:#2c3e50; text-align:center;">
            👨‍⚕️ Welcome Dr. {{ $doctor->first_name }}
        </h2>

        <p style="font-size:16px; color:#555;">
            Your account has been successfully created in our system.
        </p>

        <hr style="margin:20px 0;">

        <h3 style="color:#27ae60;">🔐 Login Credentials</h3>

        <p style="font-size:15px;">
            <strong>Email:</strong> {{ $doctor->email }}
        </p>

        <p style="font-size:15px;">
            <strong>Password:</strong>
            <span style="background:#f1f1f1; padding:5px 10px; border-radius:5px;">
                {{ $password }}
            </span>
        </p>

        <hr style="margin:20px 0;">

        <p style="font-size:14px; color:#888;">
            ⚠️ Please change your password after first login for security reasons.
        </p>

        <div style="text-align:center; margin-top:20px;">
            <a href="{{ url('/login') }}"
               style="background:#3498db; color:#fff; padding:10px 20px; text-decoration:none; border-radius:5px;">
                Login Now
            </a>
        </div>

        <p style="margin-top:30px; font-size:12px; text-align:center; color:#aaa;">
            © {{ date('Y') }} Clinic System. All rights reserved.
        </p>

    </div>

</body>
</html>