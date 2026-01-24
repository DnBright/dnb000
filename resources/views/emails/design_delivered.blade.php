<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Design Ready</title>
    <style>
      body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; color:#111827; }
      .btn { display:inline-block; padding:10px 16px; background:#4F46E5; color:white; border-radius:6px; text-decoration:none }
      .container { max-width:600px; margin:20px auto; padding:18px; border:1px solid #e5e7eb; border-radius:8px; }
      .muted { color:#6b7280; }
    </style>
  </head>
  <body>
    <div class="container">
      <h2 style="margin:0 0 8px 0">Your design is ready</h2>
      <p class="muted">Hello {{ $order->customer->name ?? 'Customer' }},</p>
      <p>We have delivered the final design for your order <strong>#{{ $order->order_id }}</strong>.</p>

      <p style="margin:18px 0">
        <a class="btn" href="{{ $url }}">Download final files</a>
      </p>

      <p class="muted">If the button doesn't work, copy and paste the link below into your browser:</p>
      <p class="muted"><a href="{{ $url }}">{{ $url }}</a></p>

      <hr style="border:none;border-top:1px solid #eef2ff;margin:20px 0" />
      <p class="muted">Order details</p>
      <p style="margin:0">Service: {{ $order->package->name ?? 'Design Protocol' }}</p>
      <p style="margin:0">Amount: Rp {{ number_format($order->package->price ?? 0, 0, ',', '.') }}</p>
      <p style="margin-top:18px" class="muted">Thanks for using Dark & Bright.</p>
    </div>
  </body>
</html>
