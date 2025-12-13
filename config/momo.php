<?php
/**
 * Cấu hình MoMo Payment Gateway
 */

return [
    // Endpoint API sandbox
    'endpoint' => 'https://test-payment.momo.vn/v2/gateway/api/create',
    
    // Thông tin đối tác (Sandbox - Demo)
    'partnerCode' => 'MOMOBKUN20180529',
    'accessKey' => 'klm05TvNBzhg7h7j',
    'secretKey' => 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa',
    
    // URL callback
    'returnUrl' => 'http://localhost/gioithieudulichtravinh/payment-return.php?method=momo',
    'notifyUrl' => 'http://localhost/gioithieudulichtravinh/api/momo-ipn.php',
];
?>
