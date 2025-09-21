<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Property Inquiry</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #007bff; color: white; padding: 20px; text-align: center; }
        .content { background: #f9f9f9; padding: 20px; }
        .footer { background: #333; color: white; padding: 10px; text-align: center; }
        .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Property Inquiry</h1>
        </div>

        <div class="content">
            <h2>Property Details</h2>
            <p><strong>Title:</strong> {{ $listing->title }}</p>
            <p><strong>Location:</strong> {{ $listing->estate }}, {{ $listing->county }}</p>
            <p><strong>Price:</strong> Ksh {{ number_format($listing->price) }}/month</p>

            <h2>Sender Information</h2>
            <p><strong>Name:</strong> {{ $senderName }}</p>
            <p><strong>Email:</strong> {{ $inquiryMessage->sender_email }}</p>
            <p><strong>Phone:</strong> {{ $inquiryMessage->sender_phone }}</p>

            <h2>Message</h2>
            <p>{{ $inquiryMessage->content }}</p>

              <p>
                <a href="{{ route('listings.show', $listing) }}" class="btn">View Property</a>
                <a href="mailto:{{ $inquiryMessage->sender_email }}" class="btn" style="background: #28a745; margin-left: 10px;">
    Reply via Email
</a>
@if($inquiryMessage->sender_phone)
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inquiryMessage->sender_phone) }}"
       class="btn" style="background: #25D366; margin-left: 10px;">Reply via WhatsApp</a>
@endif
        </div>

        <div class="footer">
            <p>This email was sent from PataNyumba KE - Kenya's Premier Property Rental Platform</p>
            <p><small>You're receiving this email because someone is interested in your property listing.</small></p>
        </div>
    </div>
</body>
</html>
