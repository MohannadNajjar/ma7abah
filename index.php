<?php
require __DIR__.'/db.php';
$C=content_parse();
function v($s,$k){global $C;return trim((string)($C[$s][$k]??''),"\" \t\r");}
function e($t){return htmlspecialchars($t,ENT_QUOTES,'UTF-8');}
function items($p,$keys){global $C;$o=[];foreach($C as $n=>$s){if(!preg_match('/^'.$p.'\d+$/',$n)||!is_array($s))continue;$r=[];$any=false;foreach($keys as $k){$r[$k]=v($n,$k);if($r[$k]!=='')$any=true;}if($any)$o[]=$r;}return $o;}
function h2($t){return $t!==''?'<h2>'.e($t).'</h2>':'';}
$email=v('site','email');if(!filter_var($email,FILTER_VALIDATE_EMAIL))$email='';
$photo=v('site','photo');$name=v('site','name');$desc=v('site','description');
$host=$_SERVER['HTTP_HOST']??'';$https=(!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||($_SERVER['HTTP_X_FORWARDED_PROTO']??'')==='https';
$base=preg_match('/^[A-Za-z0-9.-]+(:\d+)?$/',$host)?($https?'https':'http').'://'.$host.rtrim(str_replace('\\','/',dirname($_SERVER['SCRIPT_NAME'])),'/').'/':'';
$projects=items('project',['icon','title','text','url']);
$ideas=items('idea',['icon','title','text','url']);
$stats=items('stat',['num','label']);
$about=array_filter(array_map(fn($k)=>v('about',$k),['p1','p2','p3','p4']));
$hasAbout=$about||$stats;
$title=v('hero','title');$mark=v('hero','highlight');$t=e($title);
if($mark!==''&&strpos($t,e($mark))!==false)$t=str_replace(e($mark),'<span>'.e($mark).'</span>',$t);
$chips=[];foreach(['c1','c2','c3','c4'] as $k){$x=v('chips',$k);if($x!=='')$chips[$k]=$x;}
$ICONS=require __DIR__.'/icons.php';$soc=[];foreach($ICONS as $k=>$d){$u=v('social',$k);if(preg_match('~^https?://~i',$u))$soc[$k]=$u;}
$ctaOn=$email&&(v('cta','title')!==''||v('cta','text')!==''||v('cta','button')!=='');
$tg=['c2'=>$ideas?'#ideas':'','c3'=>$projects?'#works':'','c4'=>$ctaOn?'#contact':''];
function cards($list){foreach($list as $i=>$p){$u=preg_match('~^https?://~i',$p['url'])?$p['url']:'';$tg=$u?'a':'article';
echo '<'.$tg.' class="card'.($i==0&&$GLOBALS['feat']?' wide':'').($u?' lnk':'').'"'.($u?' href="'.e($u).'" target="_blank" rel="noopener"':'').'>';
if($p['icon']!=='')echo '<div class="ico">'.e($p['icon']).'</div>';
echo '<div>';if($p['title']!=='')echo '<h3>'.e($p['title']).'</h3>';if($p['text']!=='')echo '<p>'.e($p['text']).'</p>';echo '</div>'.($u?'<span class="go" aria-hidden="true">←</span>':'').'</'.$tg.'>';}}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title><?=e(v('site','title')?:$name)?></title>
<?php if($desc!==''):?><meta name="description" content="<?=e($desc)?>">
<meta property="og:description" content="<?=e($desc)?>">
<?php endif;?><meta property="og:type" content="website">
<meta property="og:locale" content="ar_AR">
<meta property="og:title" content="<?=e(v('site','title')?:$name)?>">
<?php if($base):?><meta property="og:url" content="<?=e($base)?>">
<?php if($photo!==''):?><meta property="og:image" content="<?=e($base.(strpos($photo,'?')!==false?$photo:rawurlencode($photo)))?>">
<?php endif;endif;?><meta name="twitter:card" content="summary">
<meta name="theme-color" content="#101a33">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;800;900&display=swap" rel="stylesheet">
<style>
:root{--bg:#f3f5f9;--surface:#fff;--ink:#111a33;--mute:#5b6579;--line:#dde2ec;--sun:#f0b030;--sun-ink:#2a1d00;--leaf:#5f8f66;--hero:#101a33}
@media (prefers-color-scheme:dark){:root{--bg:#0b1226;--surface:#141e3a;--ink:#eef1f8;--mute:#9aa6bf;--line:#26325a;--hero:#070d1e}}
*,*::before,*::after{box-sizing:border-box}
html{scroll-behavior:smooth;scroll-padding-top:90px}
body{margin:0;background:var(--bg);color:var(--ink);font-family:Cairo,Tahoma,system-ui,sans-serif;line-height:1.8;-webkit-font-smoothing:antialiased}
a{color:inherit}
:focus-visible{outline:3px solid var(--sun);outline-offset:3px;border-radius:8px}
.wrap{width:min(1080px,100% - 40px);margin-inline:auto}
nav{position:sticky;top:12px;z-index:10;margin:12px auto 0;width:min(1080px,100% - 28px);display:flex;align-items:center;justify-content:space-between;gap:12px;padding:10px 18px;background:color-mix(in srgb,var(--surface) 90%,transparent);backdrop-filter:blur(12px);border:1px solid var(--line);border-radius:18px}
nav b{font-weight:900;font-size:1.15rem}
nav ul{display:flex;gap:22px;list-style:none;margin:0;padding:0;font-weight:600;font-size:.95rem}
nav ul a{text-decoration:none;color:var(--mute)}nav ul a:hover{color:var(--ink)}
.btn{display:inline-block;background:var(--sun);color:var(--sun-ink);font-weight:800;text-decoration:none;padding:10px 22px;border-radius:999px;transition:transform .2s}
.btn:hover{transform:translateY(-2px)}
.hero{margin-top:-64px;padding:110px 0 0;background:var(--hero);clip-path:polygon(0 0,100% 0,100% 82%,0 100%);position:relative;overflow:hidden}
.hero::before{content:"";position:absolute;inset:auto -10% -30% auto;width:60%;aspect-ratio:1;background:radial-gradient(circle,var(--leaf) 0,transparent 65%);opacity:.35}
.stage{position:relative;height:min(430px,88vw);display:grid;place-items:center;padding-bottom:30px}
.photo{position:relative;z-index:1;width:min(330px,68vw);aspect-ratio:1;border-radius:50%;border:8px solid var(--sun);overflow:hidden;background:var(--sun);box-shadow:0 30px 60px -20px #0009;animation:rise .9s cubic-bezier(.2,.8,.2,1) both}
.photo img{width:100%;height:100%;object-fit:cover;display:block}
.chip{position:absolute;z-index:2;background:var(--surface);color:var(--ink);padding:8px 18px;border-radius:999px;font-weight:700;font-size:.95rem;box-shadow:0 14px 30px -12px #0008;transition:transform .25s ease-out;white-space:nowrap}
.c1{top:14%;right:6%}.c2{top:8%;left:8%}.c3{bottom:26%;left:4%}.c4{bottom:20%;right:4%}
@keyframes rise{from{opacity:0;transform:scale(.85) translateY(24px)}}
.intro{text-align:center;padding:36px 0 50px}
.intro small{color:var(--mute);font-weight:600}
h1{font-size:clamp(2rem,6vw,3.6rem);line-height:1.25;margin:.2em auto .3em;font-weight:900;max-width:16em}
h1 span{background:linear-gradient(transparent 62%,var(--sun) 62%)}
.intro p{max-width:34em;margin:0 auto 26px;color:var(--mute);font-size:1.1rem}
.contactbar{display:flex;flex-wrap:wrap;gap:16px;align-items:center;justify-content:space-between;border-top:1px solid var(--line);margin-top:44px;padding-top:22px;text-align:start}
.contactbar a{text-decoration:none;font-weight:700}
.social{display:flex;flex-wrap:wrap;gap:10px}
.si{width:44px;height:44px;display:grid;place-items:center;border-radius:50%;background:var(--surface);border:1px solid var(--line);color:var(--ink);transition:transform .2s,background .2s,color .2s}
.si:hover{background:var(--sun);color:var(--sun-ink);transform:translateY(-3px)}
a.chip{text-decoration:none}a.chip:hover{background:var(--sun);color:var(--sun-ink)}
.sec{padding:30px 0 60px}
.sec h2{display:flex;align-items:center;gap:16px;font-size:1.8rem;margin:0 0 28px;font-weight:800}
.sec h2::before{content:"";width:60px;height:3px;background:var(--sun);border-radius:2px}
.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:20px}
.card{background:var(--surface);border:1px solid var(--line);border-radius:24px;padding:26px;display:flex;flex-direction:column;gap:10px;transition:transform .25s,border-color .25s}
.card:hover{transform:translateY(-5px);border-color:var(--sun)}
.ico{width:46px;height:46px;border-radius:14px;background:var(--sun);display:grid;place-items:center;font-size:1.4rem;flex:none}
.card h3{margin:0;font-size:1.2rem}.card p{margin:0;color:var(--mute)}
a.card{text-decoration:none;color:inherit}
.card .go{margin-top:auto;font-size:1.5rem;font-weight:800;color:var(--sun)}
.card.wide .go{margin-top:0;margin-inline-start:auto}
.card.wide{grid-column:1/-1;flex-direction:row;align-items:center;gap:26px;background:var(--hero);color:#eef1f8;border:0}
.card.wide p{color:#b6c0d8}
.about{display:grid;grid-template-columns:1fr 1fr;gap:34px;align-items:center}
.about.one{grid-template-columns:1fr}
.about p{color:var(--mute);font-size:1.1rem;margin:0 0 14px}
.stats{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.stats div{background:var(--surface);border:1px solid var(--line);border-radius:20px;padding:20px;font-weight:600;color:var(--mute)}
.stats b{display:block;font-size:2rem;color:var(--ink);font-weight:900}
.cta{background:var(--sun);color:var(--sun-ink);border-radius:32px;padding:clamp(28px,6vw,60px);text-align:center}
.cta h2{justify-content:center;margin:0 0 8px;font-size:clamp(1.6rem,4vw,2.4rem)}.cta h2::before{display:none}
.cta p{margin:0 0 22px;font-size:1.1rem}
.cta .btn{background:var(--ink);color:var(--bg);font-size:1.05rem;padding:12px 30px}
footer{padding:30px 0 40px;text-align:center;color:var(--mute);font-size:.9rem}
@media(max-width:720px){nav ul{display:none}.about{grid-template-columns:1fr}.chip{font-size:.8rem;padding:6px 12px}.card.wide{flex-direction:column;align-items:flex-start}.c1{right:2%}.c2{left:2%}.c3{left:0}.c4{right:0}}
@media(prefers-reduced-motion:reduce){*{animation:none!important;transition:none!important;scroll-behavior:auto}}
</style>
</head>
<body>
<nav aria-label="التنقل الرئيسي">
<b><?=e($name)?></b>
<ul>
<?php if($hasAbout&&v('about','title')!==''):?><li><a href="#about"><?=e(v('about','title'))?></a></li><?php endif;?>
<?php if($projects&&v('works','title')!==''):?><li><a href="#works"><?=e(v('works','title'))?></a></li><?php endif;?>
<?php if($ideas&&v('ideas','title')!==''):?><li><a href="#ideas"><?=e(v('ideas','title'))?></a></li><?php endif;?>
</ul>
<?php if($email&&v('site','nav_button')!==''):?><a class="btn" href="<?=$ctaOn?'#contact':'mailto:'.e($email)?>"><?=e(v('site','nav_button'))?></a><?php endif;?>
</nav>

<header class="hero">
<div class="wrap stage" id="stage">
<?php foreach($chips as $k=>$x):$h=$tg[$k]??'';$tag=$h?'a':'span';?><<?=$tag?> class="chip <?=$k?>" data-d="<?=['c1'=>14,'c2'=>-10,'c3'=>-16,'c4'=>12][$k]?>"<?=$h?' href="'.$h.'"':''?>><?=e($x)?></<?=$tag?>>
<?php endforeach;?>
<?php if($photo!==''):?><div class="photo"><img src="<?=e($photo)?>" alt="<?=e(v('site','photo_alt'))?>" width="640" height="640" fetchpriority="high"></div><?php endif;?>
</div>
</header>

<main class="wrap">
<?php if($title!==''||v('hero','text')!==''||$email||$soc):?>
<section class="intro">
<?php if(v('hero','greeting')!==''):?><small><?=e(v('hero','greeting'))?></small><?php endif;?>
<?php if($title!==''):?><h1><?=$t?></h1><?php endif;?>
<?php if(v('hero','text')!==''):?><p><?=e(v('hero','text'))?></p><?php endif;?>
<?php if($projects&&v('hero','button')!==''):?><a class="btn" href="#works"><?=e(v('hero','button'))?></a><?php endif;?>
<?php if($email||$soc):?><div class="contactbar">
<?php if($email):?><span><a href="mailto:<?=e($email)?>"><?=e($email)?></a></span><?php endif;?>
<?php if($soc):?><span class="social"><?php foreach($soc as $k=>$u):$d=$ICONS[$k];?><a class="si" href="<?=e($u)?>" target="_blank" rel="noopener" aria-label="<?=e($d[0])?>" title="<?=e($d[0])?>"><svg viewBox="0 0 <?=$d[1]?> <?=$d[2]?>" width="22" height="22" fill="currentColor" aria-hidden="true"><path d="<?=$d[3]?>"/></svg></a><?php endforeach;?></span><?php endif;?>
</div><?php endif;?>
</section>
<?php endif;?>

<?php if($projects):$feat=true;?>
<section class="sec" id="works"><?=h2(v('works','title'))?><div class="grid"><?php cards($projects);?></div></section>
<?php endif;?>

<?php if($hasAbout):?>
<section class="sec" id="about"><?=h2(v('about','title'))?>
<div class="about<?=($about&&$stats)?'':' one'?>">
<?php if($about):?><div><?php foreach($about as $p):?><p><?=e($p)?></p><?php endforeach;?></div><?php endif;?>
<?php if($stats):?><div class="stats"><?php foreach($stats as $s):?><div><?php if($s['num']!==''):?><b><?=e($s['num'])?></b><?php endif;?><?=e($s['label'])?></div><?php endforeach;?></div><?php endif;?>
</div></section>
<?php endif;?>

<?php if($ideas):$feat=false;?>
<section class="sec" id="ideas"><?=h2(v('ideas','title'))?><div class="grid"><?php cards($ideas);?></div></section>
<?php endif;?>

<?php if($ctaOn):?>
<section class="sec" id="contact"><div class="cta">
<?=h2(v('cta','title'))?>
<?php if(v('cta','text')!==''):?><p><?=e(v('cta','text'))?></p><?php endif;?>
<?php if(v('cta','button')!==''):?><a class="btn" href="mailto:<?=e($email)?>"><?=e(v('cta','button'))?></a><?php endif;?>
</div></section>
<?php endif;?>
</main>
<?php if(v('site','footer')!==''):?><footer><?=e(v('site','footer'))?></footer><?php endif;?>
<script>
(function(){var s=document.getElementById('stage');if(!s||matchMedia('(prefers-reduced-motion:reduce)').matches)return;
var c=s.querySelectorAll('.chip');
s.addEventListener('pointermove',function(e){var r=s.getBoundingClientRect(),x=(e.clientX-r.left)/r.width-.5,y=(e.clientY-r.top)/r.height-.5;
c.forEach(function(n){var d=+n.dataset.d;n.style.transform='translate('+x*d*2+'px,'+y*d*2+'px)'})});
s.addEventListener('pointerleave',function(){c.forEach(function(n){n.style.transform=''})});})();
</script>
</body>
</html>
