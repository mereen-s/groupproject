<?php
class Notification {
  public static function create($recipientUserId, $patientId, $source, $message) {
    $st = Db::get()->prepare("INSERT INTO notification(recipient_user_id,patient_id,source,message) VALUES (?,?,?,?)");
    $st->execute([$recipientUserId, $patientId, $source, $message]);
    Audit::log('ALERT_SENT', 'to_user:'.$recipientUserId.' '.$source);
  }
  public static function forUser($userId) {
    $st = Db::get()->prepare("SELECT * FROM notification WHERE recipient_user_id=? ORDER BY status='Viewed', created_at DESC");
    $st->execute([$userId]); return $st->fetchAll();
  }
  public static function unreadCount($userId) {
    $st = Db::get()->prepare("SELECT COUNT(*) c FROM notification WHERE recipient_user_id=? AND status='Unread'");
    $st->execute([$userId]); return $st->fetch()['c'];
  }
  public static function open($id, $userId) {
    $st = Db::get()->prepare("SELECT * FROM notification WHERE notification_id=? AND recipient_user_id=?");
    $st->execute([$id, $userId]); $n = $st->fetch();
    if ($n) {
      Db::get()->prepare("UPDATE notification SET status='Viewed' WHERE notification_id=?")->execute([$id]);
      Audit::log('ALERT_VIEWED', 'notification:'.$id);
    }
    return $n;
  }
}
