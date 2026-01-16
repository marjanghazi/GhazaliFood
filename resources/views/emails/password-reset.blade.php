<!DOCTYPE html>
<html>
<head>
    <title>Password Reset - Ghazali Food</title>
</head>
<body>
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
        <div style="background-color: #28a745; color: white; padding: 20px; text-align: center;">
            <h1>Ghazali Food</h1>
        </div>
        
        <div style="padding: 30px; background-color: #f8f9fa;">
            <h2>Password Reset Request</h2>
            <p>Hello {{ $user->name }},</p>
            <p>You recently requested to reset your password for your Ghazali Food account.</p>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $resetUrl }}" 
                   style="background-color: #28a745; color: white; padding: 12px 30px; 
                          text-decoration: none; border-radius: 5px; font-weight: bold;">
                    Reset Your Password
                </a>
            </div>
            
            <p>If you didn't request a password reset, please ignore this email.</p>
            <p>This link will expire in 1 hour for security reasons.</p>
            
            <p style="margin-top: 30px;">
                Best regards,<br>
                <strong>Ghazali Food Team</strong>
            </p>
        </div>
        
        <div style="background-color: #343a40; color: white; padding: 15px; text-align: center; font-size: 12px;">
            <p>&copy; {{ date('Y') }} Ghazali Food. All rights reserved.</p>
            <p>123 Food Street, Culinary City, CC 12345</p>
        </div>
    </div>
</body>
</html>