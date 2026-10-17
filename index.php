<?php
date_default_timezone_set('Asia/Jerusalem');
$h = (int) date('G');
$greeting = $h < 12 ? 'صباح الخير' : ($h < 18 ? 'نهارك سعيد' : 'مساء الخير');
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>مرحبا | ma7abah.com</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Reem+Kufi:wght@600&family=Tajawal:wght@400;500&display=swap" rel="stylesheet">
<style>
  :root {
    --sea: #0e3b43;
    --foam: #e6f1ee;
    --sun: #f0b429;
    --ink: #0b2a30;
  }
  * { box-sizing: border-box; margin: 0; }
  body {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    background: var(--sea);
    color: var(--foam);
    font-family: "Tajawal", "Segoe UI", Tahoma, sans-serif;
    font-size: 1.125rem;
    line-height: 1.8;
  }
  main {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 2.5rem 1.5rem;
    max-width: 44rem;
    width: 100%;
    margin-inline: auto;
  }
  .greet { color: var(--sun); font-size: 1.25rem; font-weight: 500; }
  h1 {
    font-family: "Reem Kufi", "Tajawal", serif;
    font-weight: 600;
    font-size: clamp(5rem, 28vw, 11rem);
    line-height: 1.05;
    margin-block: 0.25rem 0.5rem;
  }
  .lead { max-width: 30rem; opacity: 0.9; }
  nav { margin-top: 2.25rem; display: flex; flex-wrap: wrap; gap: 0.75rem; }
  nav a {
    padding: 0.7rem 1.4rem;
    border-radius: 0.5rem;
    text-decoration: none;
    font-weight: 500;
    color: var(--foam);
    border: 1.5px solid var(--foam);
  }
  nav a.main { background: var(--sun); border-color: var(--sun); color: var(--ink); }
  nav a:hover, nav a:focus-visible { outline: 3px solid var(--foam); outline-offset: 2px; }
  footer {
    padding: 1.25rem 1.5rem;
    border-top: 1px solid rgba(230, 241, 238, 0.25);
    font-size: 0.95rem;
    opacity: 0.8;
    text-align: center;
  }
  footer span { direction: ltr; unicode-bidi: embed; }
</style>
</head>
<body>
<main>
  <p class="greet"><?= $greeting ?></p>
  <h1>مرحبا</h1>
  <p class="lead">أهلًا بك في موقعنا. نعمل الآن على تجهيز المحتوى، وسنعود إليك قريبًا بكل جديد.</p>
  <nav>
    <a class="main" href="/p1/">الصفحة الأولى</a>
    <a href="/p2/a.php">الصفحة الثانية</a>
  </nav>
</main>
<footer>© <?= date('Y') ?> <span>ma7abah.com</span></footer>
</body>
</html>
