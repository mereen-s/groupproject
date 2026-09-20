<?php
function e($s){ return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); }
function redirect($page, $extra=''){ header('Location: '.BASE_URL.'/index.php?page='.$page.$extra); exit; }
function flash($msg=null){
  if ($msg !== null) { $_SESSION['flash'] = $msg; return; }
  $m = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $m;
}
function view($name, $data=[]){
  extract($data);
  require __DIR__.'/../views/_header.php';
  require __DIR__.'/../views/'.$name.'.php';
  require __DIR__.'/../views/_footer.php';
}
