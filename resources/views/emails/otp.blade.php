<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>La Clinic OTP</title>
</head>

<body style="margin:0; padding:0; background:#f6f8fb; font-family:Arial, sans-serif;">

    <div
        style="max-width:600px; margin:40px auto; background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.1);">

        <!-- Header -->
        <div style="background:linear-gradient(135deg,#4CAF50,#2E7D32); padding:20px; text-align:center; color:white;">
            <h1 style="margin:0;">🐾 La Clinic</h1>
            <p style="margin:5px 0 0;">Your Pet Care & Health Center</p>
        </div>

        <!-- Body -->
        <div style="padding:30px; text-align:center;">

            <h2 style="color:#333;">Hello {{ $user->first_name }} 🐶🐱</h2>

            <p style="font-size:16px; color:#555;">
                We received a request to verify your account.
                Please use the OTP code below to complete your registration.
            </p>

            <!-- OTP Box -->
            <div
                style="margin:30px auto; padding:20px; background:#f0fff4; border:2px dashed #4CAF50; display:inline-block; border-radius:10px;">
                <h1 style="margin:0; letter-spacing:8px; color:#2E7D32;">
                    {{ $otp }}
                </h1>
            </div>

            <p style="color:#777; font-size:14px;">
                ⏱ This code will expire in <b>10 minutes</b>
            </p>

            <hr style="margin:25px 0;">

            <p style="font-size:13px; color:#999;">
                If you did not request this, you can ignore this email safely.
            </p>

        </div>

        <!-- Footer -->
        <div style="background:#fafafa; padding:15px; text-align:center; font-size:12px; color:#888;">
            © {{ date('Y') }} La Clinic - Caring for your pets ❤️🐾
        </div>

    </div>

</body>

</html>
