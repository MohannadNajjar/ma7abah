<?php
// اتصال بقاعدة البيانات (PostgreSQL) عبر متغير البيئة DATABASE_URL
function db(){
 static $pdo=null,$tried=false;
 if($pdo||$tried)return $pdo;
 $tried=true;
 $u=getenv('DATABASE_URL');
 if(!$u)return null;
 $p=parse_url($u);
 if(!$p||empty($p['host']))return null;
 parse_str($p['query']??'',$q);
 $dsn='pgsql:host='.$p['host'].';port='.($p['port']??5432).';dbname='.ltrim($p['path']??'','/').';sslmode='.($q['sslmode']??'require');
 try{
  $pdo=new PDO($dsn,urldecode($p['user']??''),urldecode($p['pass']??''),[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_TIMEOUT=>10]);
  $pdo->exec('CREATE TABLE IF NOT EXISTS kv(k TEXT PRIMARY KEY, v TEXT NOT NULL)');
 }catch(Throwable $e){error_log('db: '.$e->getMessage());$pdo=null;}
 return $pdo;
}
function kv_get($k){
 $d=db();if(!$d)return null;
 try{$s=$d->prepare('SELECT v FROM kv WHERE k=?');$s->execute([$k]);$r=$s->fetchColumn();return $r===false?null:(string)$r;}
 catch(Throwable $e){error_log('kv_get: '.$e->getMessage());return null;}
}
function kv_set($k,$v){
 $d=db();if(!$d)return false;
 try{$s=$d->prepare('INSERT INTO kv(k,v) VALUES(?,?) ON CONFLICT(k) DO UPDATE SET v=EXCLUDED.v');return $s->execute([$k,$v]);}
 catch(Throwable $e){error_log('kv_set: '.$e->getMessage());return false;}
}
// ذاكرة مؤقتة على القرص: الزيارات العادية لا تلمس قاعدة البيانات
function cache_path($n){return sys_get_temp_dir().'/ma7abah_'.$n;}
function content_text(){
 $c=cache_path('content');
 if(is_file($c)){$t=@file_get_contents($c);if($t!==false&&$t!=='')return $t;}
 $t=kv_get('content');
 if($t!==null&&$t!==''){@file_put_contents($c,$t,LOCK_EX);return $t;}
 $f=__DIR__.'/content.txt';
 return is_file($f)?(string)file_get_contents($f):'';
}
function content_parse(){return @parse_ini_string(content_text(),true,INI_SCANNER_RAW)?:[];}
function content_save($t){
 if(!kv_set('content',$t))return false;
 @file_put_contents(cache_path('content'),$t,LOCK_EX);
 return true;
}
