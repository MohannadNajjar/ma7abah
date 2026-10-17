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
    }
}
$h = fn($s) => htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
$launchTs = strtotime($launch) * 1000;
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $h($title) ?> — قيد الإنشاء</title>
  <meta name="description" content="الموقع الشخصي لأبو يونس — قيد الإنشاء وسيُطلق قريبًا.">
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Ccircle cx='32' cy='32' r='30' fill='%230B3B3C' stroke='%23E3B04B' stroke-width='3'/%3E%3Ctext x='32' y='42' font-size='28' text-anchor='middle' fill='%23E3B04B' font-family='serif'%3EAY%3C/text%3E%3C/svg%3E">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&family=Reem+Kufi:wght@500;700&family=Tajawal:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main class="stage">

    <header class="brand">
      <div class="logo" role="img" aria-label="شعار أبو يونس">
        <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="gold" x1="0" y1="0" x2="1" y2="1">
              <stop offset="0" stop-color="#F6D98B"/>
              <stop offset="0.5" stop-color="#E3B04B"/>
              <stop offset="1" stop-color="#B98524"/>
            </linearGradient>
          </defs>
          <g class="ring">
            <circle cx="100" cy="100" r="94" fill="none" stroke="url(#gold)" stroke-width="1.5" stroke-dasharray="2 7"/>
          </g>
          <circle cx="100" cy="100" r="82" fill="#0A3132" stroke="url(#gold)" stroke-width="3"/>
          <circle cx="100" cy="100" r="72" fill="none" stroke="url(#gold)" stroke-width="0.8" opacity=".6"/>
          <!-- A -->
          <path d="M52 140 L82 58 L112 140" fill="none" stroke="url(#gold)" stroke-width="9" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M64 114 H100" stroke="url(#gold)" stroke-width="6" stroke-linecap="round"/>
          <!-- Y -->
          <path d="M104 58 L132 96 L160 58 M132 96 V140" fill="none" stroke="#F4EFE3" stroke-width="9" stroke-linecap="round" stroke-linejoin="round"/>
          <circle cx="132" cy="46" r="4.5" fill="url(#gold)"/>
        </svg>
      </div>
      <h1 class="wordmark"><span class="en"><?= $h($name_en) ?></span></h1>
      <p class="name-ar"><?= $h($name_ar) ?></p>
    </header>

    <section class="message">
      <h2>موقعي الشخصي قيد الإنشاء</h2>
      <p>أجهّز مساحة تجمع أعمالي وأفكاري وطريقة التواصل معي في مكان واحد. سأفتحها لك قريبًا.</p>
    </section>

    <section class="countdown" aria-label="الوقت المتبقي للإطلاق" data-launch="<?= $launchTs ?>">
      <div><b id="d">00</b><span>يوم</span></div>
      <div><b id="hh">00</b><span>ساعة</span></div>
      <div><b id="m">00</b><span>دقيقة</span></div>
      <div><b id="s">00</b><span>ثانية</span></div>
    </section>

    <section class="progress" aria-label="نسبة الإنجاز">
      <div class="bar" role="progressbar" aria-valuenow="<?= (int)$progress ?>" aria-valuemin="0" aria-valuemax="100">
        <i style="--p: <?= (int)$progress ?>%"></i>
      </div>
      <p>اكتمل <?= (int)$progress ?>٪ من العمل</p>
    </section>

    <form class="notify" method="post" action="">
      <label for="email">سجّل بريدك لتصلك رسالة عند الإطلاق</label>
      <div class="field">
        <input type="email" id="email" name="email" placeholder="name@example.com" dir="ltr" required>
        <input type="text" name="website" class="hp" tabindex="-1" autocomplete="off" aria-hidden="true">
        <button type="submit">أبلغني</button>
      </div>
      <?php if ($msg): ?>
        <p class="note <?= $ok ? 'ok' : 'err' ?>" role="status"><?= $h($msg) ?></p>
      <?php endif; ?>
    </form>

    <nav class="social" aria-label="روابط التواصل">
      <a href="<?= $h($link_x) ?>" target="_blank" rel="noopener">X</a>
      <a href="<?= $h($link_ig) ?>" target="_blank" rel="noopener">Instagram</a>
      <a href="<?= $h($link_in) ?>" target="_blank" rel="noopener">LinkedIn</a>
      <a href="<?= $h($link_gh) ?>" target="_blank" rel="noopener">GitHub</a>
    </nav>

    <footer>
      <a class="mail" href="mailto:<?= $h($email) ?>" dir="ltr"><?= $h($email) ?></a>
      <p>© <?= date('Y') ?> <?= $h($name_ar) ?> — جميع الحقوق محفوظة</p>
    </footer>

  </main>

  <script>
    (function () {
      var box = document.querySelector('.countdown');
      var t = +box.dataset.launch;
      var ids = { d: 'd', hh: 'hh', m: 'm', s: 's' };
      function pad(n) { return String(n).padStart(2, '0'); }
      function tick() {
        var r = Math.max(0, t - Date.now());
        var v = {
          d: Math.floor(r / 864e5),
          hh: Math.floor(r % 864e5 / 36e5),
          m: Math.floor(r % 36e5 / 6e4),
          s: Math.floor(r % 6e4 / 1e3)
        };
        for (var k in ids) document.getElementById(ids[k]).textContent = pad(v[k]);
      }
      tick(); setInterval(tick, 1000);
    })();
  </script>
</body>
</html>
