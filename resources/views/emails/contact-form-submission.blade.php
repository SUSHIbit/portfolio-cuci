<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4f46e5;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f9fafb;
            padding: 30px;
            border: 1px solid #e5e7eb;
        }
        .footer {
            background-color: #374151;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 0 0 8px 8px;
            font-size: 14px;
        }
        .field {
            margin-bottom: 20px;
        }
        .field-label {
            font-weight: bold;
            color: #4f46e5;
            margin-bottom: 5px;
        }
        .field-value {
            background-color: white;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
        }
        .message-content {
            white-space: pre-line;
            line-height: 1.6;
        }
        .meta-info {
            background-color: #eff6ff;
            padding: 15px;
            border-radius: 6px;
            border-left: 4px solid #3b82f6;
            margin-top: 20px;
        }
        .meta-info small {
            color: #6b7280;
        }
        .action-buttons {
            margin-top: 20px;
            text-align: center;
        }
        .action-button {
            display: inline-block;
            background-color: #4f46e5;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📧 New Contact Form Submission</h1>
        <p>Someone reached out through your portfolio website</p>
    </div>

    <div class="content">
        <div class="field">
            <div class="field-label">👤 Name:</div>
            <div class="field-value">{{ $contactMessage->name }}</div>
        </div>

        <div class="field">
            <div class="field-label">📧 Email:</div>
            <div class="field-value">
                <a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a>
            </div>
        </div>

        <div class="field">
            <div class="field-label">💬 Message:</div>
            <div class="field-value">
                <div class="message-content">{{ $contactMessage->message }}</div>
            </div>
        </div>

        <div class="meta-info">
            <strong>📅 Submitted:</strong> {{ $contactMessage->created_at->format('F j, Y \a\t g:i A') }}<br>
            <small>{{ $contactMessage->created_at->diffForHumans() }}</small>
        </div>

        <div class="action-buttons">
            <a href="mailto:{{ $contactMessage->email }}?subject=Re: Contact from Portfolio&body=Hi {{ $contactMessage->name }},%0D%0A%0D%0AThank you for reaching out!"
               class="action-button">Reply via Email</a>
        </div>
    </div>

    <div class="footer">
        <p>📱 This message was sent from your portfolio contact form</p>
        <p><small>{{ config('app.name') }} • {{ now()->format('Y') }}</small></p>
    </div>
</body>
</html>