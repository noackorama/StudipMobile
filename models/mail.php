<?php

namespace Studip\Mobile;

require_once $this->trails_root .'/models/course.php';

class Mail {

    /**
     *  Get latest 30 Messages from a user starting
     *  width intervall.
     *  @param $user_id         owner of the message
     *  @param $intervall       where to start
     *  @param $inpox           list from inbox or outbox
     */
    static function findAllByUser($user_id, $intervall, $inbox = true)
    {
        return self::get_mails($user_id, $intervall, $inbox);
    }

    static function findMsgById($user_id, $msg_id, $mark = 0)
    {
        return self::get_mail($user_id, $msg_id, $mark);
    }

    static function deleteMessage($id, $user_id)
    {
        $stmt = \DBManager::get()->prepare("UPDATE `message_user`
            SET deleted = '1'
            WHERE message_user.user_id = ?
            AND message_user.message_id = ?");
        $stmt->execute(array($user_id, $id));
    }

    static function get_mail($user_id, $msg_id, $mark = 0)
    {
        if ($msg_id == null) {
            return null;
        }

        // Nachricht auslesen
        $result = array();
        $db = \DBManager::get();

        $stmt = $db->prepare(
           "SELECT

              auth_user_md5.user_id,
              auth_user_md5.Vorname AS vorname,
              auth_user_md5.Nachname AS nachname,

              message.message_id AS message_id,
              message.message  AS message,
              message.subject  AS subject,
              message.autor_id AS autor_id,
              message.mkdate   AS mkdate,

              message_user.message_id,
              message_user.user_id AS receiver,

              GROUP_CONCAT(DISTINCT CONCAT(dokument_id, ':', filename)) AS attachments,
              COUNT(DISTINCT dokument_id) AS num_attachments

            FROM message
            LEFT JOIN auth_user_md5 ON message.autor_id = auth_user_md5.user_id
            LEFT JOIN message_user USING (message_id)
            LEFT JOIN dokumente ON range_id=message_user.message_id

            WHERE message.message_id     =  ?
                AND message_user.user_id =  ?
                AND message_user.deleted =  '0'
            GROUP BY message.message_id
            LIMIT 0,1");

        $stmt->execute(array($msg_id, $user_id));

        $row = $stmt->fetch();

        $attachments = array();
        foreach (explode(',', $row['attachments']) as $attachment) {
            if (!strlen($attachment)) {
                continue;
            }
            list($dokument_id, $filename) = explode(":", $attachment);
            $attachments[$dokument_id] = $filename;
        }

        $result = array(
            'id'              => $row['message_id'],
            'title'           => $row['subject'],
            'author'          => $row['vorname'] . ' ' . $row['nachname'],
            'author_id'       => $row['autor_id'],
            'message'         => $row['message'],
            'mkdate'          => $row['mkdate'],
            'receiver'        => get_fullname($row['receiver']),
            'num_attachments' => $row['num_attachments'],
            'attachments'     => $attachments
        );

        if ($mark == 1) {
            $stmt = $db->prepare("UPDATE `message_user`
                SET readed = '0'
                WHERE   message_user.user_id    = ?
                    AND message_user.message_id = ?");
        } else {
            $stmt = $db->prepare("UPDATE `message_user`
                SET readed = '1'
                WHERE   message_user.user_id    = ?
                    AND message_user.message_id = ?");
        }

        $stmt->execute(array($user_id, $msg_id));

        return $result;
    }

    static function get_mails($user_id, $intervall, $inbox = true)
    {
        $items = array();
        $db = \DBManager::get();

        if ($inbox == true) {

            $query = "
                  SELECT
                    message.*,
                    message_user.readed,
                    auth_user_md5.Vorname,
                    auth_user_md5.Nachname,
                    auth_user_md5.username,
                    COUNT(dokument_id) AS num_attachments
                  FROM message_user
                  LEFT JOIN message USING (message_id)
                  LEFT JOIN auth_user_md5 ON (autor_id=auth_user_md5.user_id)
                  LEFT JOIN dokumente ON range_id=message_user.message_id
                  WHERE message_user.user_id = :user_id AND message_user.snd_rec = 'rec'
                    AND message_user.deleted = 0
                  GROUP BY message_user.message_id
                  ORDER BY message_user.mkdate DESC";

            $stmt = $db->prepare($query);
            $stmt->execute(array(':user_id' => $user_id));

            while ($row = $stmt->fetch()) {
                $items[] = array(
                    'id'              => $row['message_id'],
                    'title'           => $row['subject'],
                    'author'          => $row['Vorname'] . ' ' . $row['Nachname'],
                    'author_id'       => $row['autor_id'],
                    'message'         => $row['message'],
                    'mkdate'          => $row['mkdate'],
                    'readed'          => $row['readed'],
                    'num_attachments' => $row['num_attachments']
                );
            }

        } else {
            $query = "
                  SELECT message.*,
                         auth_user_md5.user_id AS rec_uid, auth_user_md5.vorname AS rec_vorname,
                         auth_user_md5.nachname AS rec_nachname, auth_user_md5.username AS rec_uname,
                         COUNT(DISTINCT mu.user_id) AS num_rec, COUNT(dokument_id) AS num_attachments
                  FROM message_user
                  LEFT JOIN message_user AS mu ON (message_user.message_id = mu.message_id AND mu.snd_rec = 'rec')
                  LEFT JOIN message ON (message.message_id = message_user.message_id)
                  LEFT JOIN auth_user_md5 ON (mu.user_id = auth_user_md5.user_id)
                  LEFT JOIN dokumente ON (range_id = message_user.message_id)
                  WHERE message_user.user_id = :user_id
                    AND message_user.snd_rec = 'snd' AND message_user.deleted = 0
                  GROUP BY message_user.message_id
                  ORDER BY message_user.mkdate DESC";
/*
            $count -= 1;
            $psm['count']           = $count;
            $psm['count_2']         = $tmp_move_to_folder - ($n+1);
            $psm['rec_uid']         = $row['rec_uid'];
            $psm['rec_vorname']     = $row['rec_vorname'];
            $psm['rec_nachname']    = $row['rec_nachname'];
            $psm['rec_uname']       = $row['rec_uname'];
            $psm['num_rec']         = $row['num_rec'];

*/
            $stmt = $db->prepare($query);
            $stmt->execute(array(':user_id' => $user_id));

            while ($row = $stmt->fetch()) {
                $items[] = array(
                    'id'              => $row['message_id'],
                    'title'           => $row['subject'],
                    'message'         => $row['message'],
                    'mkdate'          => $row['mkdate'],
                    'num_rec'         => $row['num_rec'],
                    'rec_vorname'     => $row['rec_vorname'],
                    'rec_nachname'    => $row['rec_nachname'],
                    'num_attachments' => $row['num_attachments']
                );
            }
        }


        return $items;
    }

    static function findAllInvolvedMembers($userId)
    {
        //get all seminars
        $seminare = Course::findAllByUser($userId);
        $seminar_ids = array();
        foreach ($seminare AS $seminar) {
            $seminar_ids[] = $seminar['Seminar_id'];
        }

        $query = "SELECT seminar_user.Seminar_id, seminar_user.user_id, seminar_user.visible,
                  seminar_user.status, auth_user_md5.Vorname, auth_user_md5.Nachname, user_info.title_front
                  FROM   seminar_user
                  JOIN   auth_user_md5 ON auth_user_md5.user_id = seminar_user.user_id
                  JOIN   user_info     ON auth_user_md5.user_id = user_info.user_id
                  WHERE Seminar_id IN (:seminar_ids)
                  ORDER BY auth_user_md5.Nachname";


        $stmt = \DBManager::get()->prepare($query);
        $stmt->bindParam(':seminar_ids', $seminar_ids, \StudipPDO::PARAM_ARRAY);
        $stmt->execute();

        $result = $stmt->fetchAll();

        // remove dublicates and add all user_id's to array
        $user_ids = array();
        foreach ($result as $member) {
            if (!in_array($member["user_id"], $user_ids)) {
                array_push($user_ids, $member["user_id"]);
            }
        }

        //löschen der eigenen id
        unset($user_ids[array_search($userId,$user_ids)]);

        //jetzt alle einmal in ausgaben array packen
        $ausgabe = array();
        foreach ($result as $member) {
            if (in_array($member["user_id"] , $user_ids)) {
                array_push($ausgabe, $member);
                unset($user_ids[array_search($member["user_id"],$user_ids)]);
            }
        }

        return $ausgabe;
    }

    static function send($empf, $betreff, $nachricht, $abs)
    {
        //Nachricht Objekt erstellen
        $message = new \messaging();

        // wenn empfänger kein array, mach ein draus
        if (is_array($empf)) {
            $empf_array = array($empf);
        } else {
            $empf_array = $empf;
        }

        //senden der Nachricht
        $send = $message->insert_message(mysql_escape_string(utf8_decode($nachricht)), mysql_escape_string($empf_array),
                                         mysql_escape_string($abs), '', '', '', '',mysql_escape_string( utf8_decode($betreff)), '', 'normal');
        return $send > 0;
    }
}
