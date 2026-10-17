<?php
/* ============ الإعدادات — عدّل من هنا ============ */
$site = [
    'name_ar'  => 'أبو يونس',
    'name_en'  => 'AboYounis',
    'title'    => 'AboYounis Personal Website',
    'launch'   => '2007-1-1 00:00:00',   // تاريخ الإطلاق المتوقع
    'progress' => 65,<?php
/* ============ الإعدادات — عدّل من هنا ============ */
$site = [
    'name_ar'  => 'أبو يونس',
    'name_en'  => 'AboYounis',
    'title'    => 'AboYounis Personal Website',
    'launch'   => '2027-1-1 00:00:00',   // تاريخ الإطلاق المتوقع
    'progress' => 35,                       // نسبة الإنجاز %
    'email'    => 'mahabagroup@gmail.com',
    'social'   => [
        'X'         => '#',
        'Instagram' => 'https://www.instagram.com/mohannadnajjar',
        'LinkedIn'  => '#',
        'GitHub'    => '#',
    ],
];

/* ============ استقبال البريد للتنبيه عند الإطلاق ============ */
$msg = ''; $ok = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    if (!empty($_POST['website'])) {            // حقل وهمي ضد البوتات
        $msg = 'تعذّر إرسال الطلب.';
    } elseif (!$mail) {
        $msg = 'اكتب بريدًا إلكترونيًا صحيحًا.';// نسبة الإنجاز %
    'email'    => 'mahabagroup@gmail.com',
    'social'   => [
        'X'         => '#',
        'Instagram' => 'https://www.instagram.com/mohannadnajjar',
        'LinkedIn'  => '#',
        'GitHub'    => '#',
    ],
];

/* ============ استقبال البريد للتنبيه عند الإطلاق ============ */
$msg = ''; $ok = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    if (!empty($_POST['website'])) {            // حقل وهمي ضد البوتات
        $msg = 'تعذّر إرسال الطلب.';
    } elseif (!$mail) {
        $msg = 'اكتب بريدًا إلكترونيًا صحيحًا.';
