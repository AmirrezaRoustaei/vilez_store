<?php
$merchant_id = "XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX"; // کد پذیرنده‌ت رو اینجا بذار
$amount = $_POST['amount']; // مبلغ به تومان
$description = $_POST['description']; // توضیح یا نام محصول
$callback_url = "https://yoursite.com/verify.php"; // لینک برگشت بعد از پرداخت

$data = [
    "merchant_id" => $merchant_id,
    "amount" => $amount,
    "callback_url" => $callback_url,
    "description" => $description,
];

$ch = curl_init("https://api.zarinpal.com/pg/v4/payment/request.json");
curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$result = curl_exec($ch);
$result = json_decode($result, true);
if ($result['data']['code'] == 100) {
    header('Location: https://www.zarinpal.com/pg/StartPay/'.$result['data']['authority']);
} else {
    echo "خطا در اتصال به درگاه: ".$result['errors']['message'];
}
?>
