<?php
declare(strict_types=1);
session_set_cookie_params(['httponly'=>true,'samesite'=>'Lax','secure'=>!empty($_SERVER['HTTPS'])]);
session_start();
$dir=__DIR__;$passf="$dir/admin_pass.php";$cf="$dir/content.txt";
function e($t){return htmlspecialchars((string)$t,ENT_QUOTES,'UTF-8');}
function q($s){$s=preg_replace('/[\x00-\x1F\x7F]+/u',' ',(string)$s);return mb_substr(trim(str_replace('"','”',$s)),0,2000);}
$_SESSION['csrf']??=bin2hex(random_bytes(16));$csrf=$_SESSION['csrf'];
$post=$_SERVER['REQUEST_METHOD']==='POST';
if($post&&!hash_equals($csrf,(string)($_POST['csrf']??''))){http_response_code(400);exit('طلب غير صالح، أعد تحميل الصفحة.');}
$hash=is_file($passf)?(require $passf):null;
$err='';
function top($t){echo '<!DOCTYPE html><html lang="ar" dir="rtl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex"><title>'.e($t).'</title><style>
:root{--ink:#111a33;--sun:#f0b030;--line:#dde2ec;--mute:#5b6579}*{box-sizing:border-box}
body{margin:0;background:#f3f5f9;color:var(--ink);font:16px/1.7 Tahoma,system-ui,sans-serif}
.w{width:min(760px,100% - 28px);margin:20px auto 90px}
h1{font-size:1.5rem;margin:0}h2{font-size:1.1rem;margin:0 0 12px}
.bar{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:18px}
.box{background:#fff;border:1px solid var(--line);border-radius:18px;padding:18px;margin-bottom:16px}
label{display:block;font-size:.9rem;color:var(--mute);margin:10px 0 3px}
input,textarea{width:100%;padding:10px 12px;border:1px solid var(--line);border-radius:10px;font:inherit;background:#fff;color:var(--ink)}
textarea{min-height:76px;resize:vertical}input:focus,textarea:focus{outline:3px solid var(--sun);border-color:transparent}
button,.b{background:var(--sun);color:#2a1d00;border:0;border-radius:999px;padding:10px 22px;font:inherit;font-weight:700;cursor:pointer;text-decoration:none;display:inline-block}
.g{background:#fff;color:var(--ink);border:1px solid var(--line)}.x{background:#fff;color:#b3261e;border:1px solid #e6c4c1;padding:6px 14px}
.row{border:1px dashed var(--line);border-radius:14px;padding:4px 14px 14px;margin-bottom:12px}
.ok{background:#e3f4e6;color:#1d5a2a;padding:10px 14px;border-radius:12px;margin-bottom:14px}.er{background:#fde8e6;color:#8a1c14;padding:10px 14px;border-radius:12px;margin-bottom:14px}
.save{position:fixed;inset:auto 0 0 0;background:#fffe;backdrop-filter:blur(8px);border-top:1px solid var(--line);padding:12px;text-align:center}
.th{width:96px;height:96px;border-radius:50%;object-fit:cover;border:3px solid var(--sun)}
</style></head><body><div class="w">';}
function bot(){echo '</div></body></html>';}

if(!$hash){
 if($post&&($_POST['a']??'')==='setup'){
  $p=(string)($_POST['pw']??'');
  if(mb_strlen($p)<8)$err='كلمة المرور يجب ألا تقل عن 8 أحرف.';
  elseif($p!==($_POST['pw2']??''))$err='كلمتا المرور غير متطابقتين.';
  else{file_put_contents($passf,'<?php return '.var_export(password_hash($p,PASSWORD_DEFAULT),true).';',LOCK_EX);session_regenerate_id(true);$_SESSION['ok']=1;$_SESSION['csrf']=bin2hex(random_bytes(16));header('Location: admin.php');exit;}
 }
 top('إعداد لوحة التحكم');echo '<div class="box"><h1>إعداد كلمة المرور</h1><p>اختر كلمة مرور للوحة التحكم (أول مرة فقط).</p>';
 if($err)echo '<div class="er">'.e($err).'</div>';
 echo '<form method="post"><input type="hidden" name="csrf" value="'.e($csrf).'"><input type="hidden" name="a" value="setup"><label>كلمة المرور</label><input type="password" name="pw" required minlength="8" autocomplete="new-password"><label>تأكيد كلمة المرور</label><input type="password" name="pw2" required autocomplete="new-password"><p><button>حفظ ودخول</button></p></form></div>';bot();exit;
}
if(!($_SESSION['ok']??false)){
 if($post&&($_POST['a']??'')==='login'){
  if(password_verify((string)($_POST['pw']??''),$hash)){session_regenerate_id(true);$_SESSION['ok']=1;$_SESSION['csrf']=bin2hex(random_bytes(16));header('Location: admin.php');exit;}
  sleep(1);$err='كلمة المرور غير صحيحة.';
 }
 top('دخول');echo '<div class="box"><h1>لوحة التحكم</h1>';
 if($err)echo '<div class="er">'.e($err).'</div>';
 echo '<form method="post"><input type="hidden" name="csrf" value="'.e($csrf).'"><input type="hidden" name="a" value="login"><label>كلمة المرور</label><input type="password" name="pw" required autofocus autocomplete="current-password"><p><button>دخول</button></p></form></div>';bot();exit;
}
if($post&&($_POST['a']??'')==='logout'){session_destroy();header('Location: admin.php');exit;}

$ICONS=require __DIR__.'/icons.php';$soc=[];foreach($ICONS as $k=>$d)$soc[$k]=$d[0];
$S=[
'site'=>['بيانات الموقع',['title'=>'عنوان الصفحة (تبويب المتصفح)','name'=>'الاسم','photo_alt'=>'وصف الصورة','description'=>'وصف الموقع (يظهر في البحث وعند مشاركة الرابط)','email'=>'البريد الإلكتروني','nav_button'=>'نص زر القائمة','footer'=>'نص التذييل']],
'hero'=>['الواجهة الأولى',['greeting'=>'التحية','title'=>'العنوان الرئيسي','highlight'=>'كلمة مميّزة داخل العنوان','text'=>'النص','button'=>'نص زر الأعمال']],
'chips'=>['الشارات حول الصورة',['c1'=>'الشارة 1','c2'=>'الشارة 2','c3'=>'الشارة 3','c4'=>'الشارة 4']],
'social'=>['روابط التواصل (رابط كامل يبدأ بـ https:// — ما تتركه فارغًا لا يظهر)',$soc],
'works'=>['قسم الأعمال',['title'=>'عنوان القسم']],
'about'=>['قسم النبذة',['title'=>'عنوان القسم','p1'=>'فقرة 1','p2'=>'فقرة 2','p3'=>'فقرة 3','p4'=>'فقرة 4']],
'ideas'=>['قسم الأفكار',['title'=>'عنوان القسم']],
'cta'=>['بطاقة التواصل الأخيرة',['title'=>'العنوان','text'=>'النص','button'=>'نص الزر']]];
$ic=['icon'=>'أيقونة (إيموجي)','title'=>'العنوان','text'=>'الوصف','url'=>'رابط (اختياري، يبدأ بـ https://)'];
$G=['project'=>['عناصر الأعمال','عمل',$ic],'stat'=>['الأرقام','رقم',['num'=>'الرقم','label'=>'الوصف']],'idea'=>['عناصر الأفكار','فكرة',$ic]];
$after=['works'=>'project','about'=>'stat','ideas'=>'idea'];
$area=['text','p1','p2','p3','p4','description'];

$C=@parse_ini_file($cf,true,INI_SCANNER_RAW)?:[];
function v($s,$k){global $C;return trim((string)($C[$s][$k]??''),"\" \t\r");}
function items($p,$keys){global $C;$o=[];foreach($C as $n=>$s){if(!preg_match('/^'.$p.'\d+$/',$n)||!is_array($s))continue;$r=[];foreach($keys as $k=>$_)$r[$k]=v($n,$k);$o[]=$r;}return $o;}

if($post&&($_POST['a']??'')==='save'){
 $out="; يُحرَّر من لوحة التحكم admin.php\n\n";$warn=[];
 $ln=fn($k,$x)=>$x===''?"$k =":"$k = \"$x\"";
 $photo=q($_POST['site']['photo']??'');
 if(!preg_match('/^[\w.-]+\.(jpg|png|webp)$/i',$photo))$photo=v('site','photo');
 if(!empty($_FILES['photo']['tmp_name'])&&($_FILES['photo']['error']??1)===UPLOAD_ERR_OK){
  $i=@getimagesize($_FILES['photo']['tmp_name']);
  $ext=[IMAGETYPE_JPEG=>'jpg',IMAGETYPE_PNG=>'png',IMAGETYPE_WEBP=>'webp'][$i[2]??0]??null;
  if(!$ext||$_FILES['photo']['size']>5000000)$warn[]='الصورة يجب أن تكون JPG أو PNG أو WebP وبحجم أقل من 5MB.';
  else{$n='photo-'.time().'.'.$ext;if(move_uploaded_file($_FILES['photo']['tmp_name'],"$dir/$n")){$old=v('site','photo');if(strpos($old,'photo-')===0)@unlink("$dir/".basename($old));$photo=$n;}else $warn[]='تعذّر رفع الصورة (تحقق من صلاحيات المجلد).';}
 }
 foreach($S as $sec=>[$_t,$fs]){
  $out.="[$sec]\n";
  foreach($fs as $k=>$_){
   $x=q($_POST[$sec][$k]??'');
   if($sec==='site'&&$k==='email'&&$x!==''&&!filter_var($x,FILTER_VALIDATE_EMAIL)){$warn[]='البريد الإلكتروني غير صالح فلم يُحفظ.';$x='';}
   if($sec==='social'&&$x!==''&&!preg_match('~^https?://~i',$x)){$warn[]="رابط $k يجب أن يبدأ بـ https:// فلم يُحفظ.";$x='';}
   $out.=$ln($k,$x)."\n";
  }
  if($sec==='site')$out.=$ln('photo',$photo)."\n";
  $out.="\n";
  if(isset($after[$sec])){$g=$after[$sec];$n=0;
   foreach(($_POST[$g]??[]) as $row){if(!is_array($row))continue;$r=[];$any=false;
    foreach($G[$g][2] as $k=>$_){$r[$k]=q($row[$k]??'');if($k==='url'&&$r[$k]!==''&&!preg_match('~^https?://~i',$r[$k]))$r[$k]='';if($r[$k]!=='')$any=true;}
    if(!$any)continue;$n++;$out.="[$g$n]\n";foreach($r as $k=>$x)$out.=$ln($k,$x)."\n";$out.="\n";}}
 }
 $tmp=$cf.'.tmp';
 if(is_file($cf))@copy($cf,$dir.'/content.bak');
 if(file_put_contents($tmp,$out,LOCK_EX)!==false&&rename($tmp,$cf)){$_SESSION['flash']=['ok','تم الحفظ.'.($warn?' — '.implode(' ',$warn):'')];}
 else $_SESSION['flash']=['er','تعذّر الحفظ، تحقق من صلاحيات الكتابة على المجلد.'];
 header('Location: admin.php');exit;
}
$fl=$_SESSION['flash']??null;unset($_SESSION['flash']);

function fld($n,$l,$x,$ta){return '<label>'.e($l).'</label>'.($ta?'<textarea name="'.e($n).'">'.e($x).'</textarea>':'<input name="'.e($n).'" value="'.e($x).'">');}
function rowh($g,$i,$fs,$vals,$lbl,$area){$h='<div class="row"><label style="font-weight:700;color:#111a33">'.e($lbl).'</label>';
 foreach($fs as $k=>$l)$h.=fld($g."[$i][$k]",$l,$vals[$k]??'',in_array($k,$area));
 return $h.'<p><button type="button" class="x" data-del>حذف</button></p></div>';}
top('لوحة التحكم');
echo '<div class="bar"><h1>لوحة التحكم</h1><span><a class="b g" href="index.php" target="_blank">عرض الموقع</a> <form method="post" style="display:inline"><input type="hidden" name="csrf" value="'.e($csrf).'"><input type="hidden" name="a" value="logout"><button class="g">خروج</button></form></span></div>';
if($fl)echo '<div class="'.($fl[0]==='ok'?'ok':'er').'">'.e($fl[1]).'</div>';
echo '<p style="color:#5b6579">أي حقل تتركه فارغًا لن يظهر في الموقع.</p>';
echo '<form method="post" enctype="multipart/form-data"><input type="hidden" name="csrf" value="'.e($csrf).'"><input type="hidden" name="a" value="save"><input type="hidden" name="site[photo]" value="'.e(v('site','photo')).'">';
foreach($S as $sec=>[$t,$fs]){
 echo '<div class="box"><h2>'.e($t).'</h2>';
 if($sec==='site'&&v('site','photo')!=='')echo '<img class="th" src="'.e(v('site','photo')).'" alt="">';
 if($sec==='site')echo '<label>تغيير الصورة (JPG / PNG / WebP)</label><input type="file" name="photo" accept="image/jpeg,image/png,image/webp">';
 foreach($fs as $k=>$l)echo fld("{$sec}[$k]",$l,v($sec,$k),in_array($k,$area));
 echo '</div>';
 if(isset($after[$sec])){$g=$after[$sec];[$gt,$gl,$gf]=$G[$g];
  echo '<div class="box"><h2>'.e($gt).'</h2><div id="l-'.$g.'">';
  foreach(items($g,$gf) as $i=>$r)echo rowh($g,$i,$gf,$r,$gl,$area);
  echo '</div><button type="button" class="g" data-add="'.$g.'">+ إضافة '.e($gl).'</button>';
  echo '<template id="t-'.$g.'">'.rowh($g,'__i__',$gf,[],$gl,$area).'</template></div>';}
}
echo '<div class="save"><button>حفظ التغييرات</button></div></form>
<script>
document.addEventListener("click",function(e){var a=e.target.closest("[data-add]"),d=e.target.closest("[data-del]");
if(a){var g=a.dataset.add,t=document.getElementById("t-"+g).innerHTML.replace(/__i__/g,Date.now());document.getElementById("l-"+g).insertAdjacentHTML("beforeend",t)}
if(d&&confirm("حذف هذا العنصر؟"))d.closest(".row").remove()});
</script>';
bot();
