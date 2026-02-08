<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $isReferrer ? 'Referral Bonus' : 'Welcome Bonus' }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="text-align: center; margin-bottom: 30px;">
        <h1 style="color: #6B21A8; margin-bottom: 5px;">
            @if($isReferrer)
                You Earned a Referral Bonus!
            @else
                Welcome Bonus Credited!
            @endif
        </h1>
    </div>

    <p>Dear {{ $recipient->name }},</p>

    @if($isReferrer)
        <p>Great news! <strong>{{ $otherUser->name }}</strong> used your referral code and their payment has been verified.</p>
        <p>As a thank you, <strong>&euro;{{ number_format($amount, 2) }}</strong> has been credited to your PlaceMeNet wallet.</p>
    @else
        <p>Welcome to PlaceMeNet! Your payment has been verified and as a welcome bonus for using a referral code, <strong>&euro;{{ number_format($amount, 2) }}</strong> has been credited to your wallet.</p>
    @endif

    <div style="background: #F3E8FF; border-radius: 8px; padding: 20px; margin: 20px 0; text-align: center;">
        <p style="margin: 0; font-size: 14px; color: #6B21A8;">Credit Added</p>
        <p style="margin: 5px 0 0; font-size: 28px; font-weight: bold; color: #6B21A8;">&euro;{{ number_format($amount, 2) }}</p>
    </div>

    <p>You can view your wallet balance and transaction history on your <a href="{{ url('/services/wallet') }}" style="color: #6B21A8;">wallet page</a>.</p>

    @if($isReferrer)
        <p>Keep sharing your referral code to earn more rewards!</p>
    @else
        <p>Once you have a verified payment, you'll also receive your own referral code to share with friends and earn more bonuses.</p>
    @endif

    <p style="margin-top: 30px; font-size: 12px; color: #666;">
        Once your wallet balance reaches &euro;50, you can request a bank payout.
    </p>

    <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">

    <p style="font-size: 12px; color: #999; text-align: center;">
        This email was sent by PlaceMeNet. If you have any questions, please contact us.
    </p>
</body>
</html>
