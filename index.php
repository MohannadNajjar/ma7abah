<?php
/* الإعدادات: launch = تاريخ الإطلاق، progress = نسبة الإنجاز */
$name_ar  = 'أبو يونس';
$name_en  = 'AboYounis';
$title    = 'AboYounis Personal Website';
$launch   = '2027-01-01 00:00:00';
$progress = 35;
$email    = 'mahabagroup@gmail.com';
$link_x   = '#';
$link_ig  = 'https://www.instagram.com/mohannadnajjar';
$link_in  = '#';
$link_gh  = '#';

/* استقبال البريد */
$msg = ''; $ok = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    if (!empty($_POST['website'])) {
        $msg = 'تعذّر إرسال الطلب.';
    } elseif (!$mail) {
        $msg = 'اكتب بريدًا إلكترونيًا صحيحًا.';
    } else {
        file_put_contents(__DIR__ . '/subscribers.txt', $mail . PHP_EOL, FILE_APPEND | LOCK_EX);
        $ok = true;
        $msg = 'تم التسجيل. سنراسلك عند الإطلاق.';
