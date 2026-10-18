<?php
// يعرض الصورة المرفوعة من لوحة التحكم (محفوظة في قاعدة البيانات)
require __DIR__.'/db.php';
$cf=cache_path('photo.bin');$cm=cache_path('photo.mime');
if(!is_file($cf)||!is_file($cm)){
 $b=kv_get('photo_b64');$m=kv_get('photo_mime');
 if($b&&in_array($m,['image/jpeg','image/png','image/webp'],true)){
  $bin=base64_decode($b,true);
  if($bin!==false){file_put_contents($cf,$bin,LOCK_EX);file_put_contents($cm,$m,LOCK_EX);}
 }
}
if(!is_file($cf)||!is_file($cm)){http_response_code(404);exit;}
$m=trim((string)file_get_contents($cm));
if(!in_array($m,['image/jpeg','image/png','image/webp'],true)){http_response_code(404);exit;}
header('Content-Type: '.$m);
header('X-Content-Type-Options: nosniff');
header('Cache-Control: public, max-age=31536000, immutable');
header('Content-Length: '.filesize($cf));
readfile($cf);
