<?php

namespace Studip\Mobile;

require_once $this->trails_root .'/models/course.php';

class Mail {

    static function inbox($user)
    {
        return self::box($user, 'inbox');
    }

    static function outbox($user)
    {
        return self::box($user, 'outbox');
    }

    static function box($user, $box)
    {
        $sndrec = $box === 'inbox' ? 'rec' : 'snd';

        $query = "SELECT message_id
                  FROM message_user
                  WHERE snd_rec = ? AND user_id = ? AND deleted = 0
                  ORDER BY mkdate DESC";
        $statement = \DBManager::get()->prepare($query);
        $statement->execute(array(
            $sndrec,
            $user->id,
        ));
        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }


    static function load($user, $ids, $additional_fields = array()) {

        if (empty($ids)) {
            return array();
        }

        $additional_fields = empty($additional_fields)
                           ? ''
                           : ',' . implode(',', $additional_fields);

        $query = "SELECT m.message_id, mu.user_id AS sender_id, subject,
                         message, m.mkdate, priority, mu.deleted, 1 - mu.readed as sender_unread,
                         GROUP_CONCAT(DISTINCT CONCAT(mu2.user_id, '-', mu2.readed, '-', mu2.deleted)) AS receivers
                         {$additional_fields}
                  FROM message AS m
                  INNER JOIN message_user AS mu ON (m.message_id = mu.message_id AND mu.snd_rec = 'snd')
                  INNER JOIN message_user AS mu2 ON (mu.message_id = mu2.message_id AND mu2.snd_rec = 'rec')
                  WHERE m.message_id IN (:ids) AND :user_id IN (mu.user_id, mu2.user_id)
                  GROUP BY m.message_id";
        if (is_array($ids) and count($ids) > 1) {
            $query .= " ORDER BY m.mkdate DESC";
        }

        $statement = \DBManager::get()->prepare($query);
        $statement->execute(array(
            ':ids'     => $ids,
            ':user_id' => $user->id
        ));
        $messages = $statement->fetchAll(\PDO::FETCH_ASSOC);

        array_walk($messages, function (&$message) use ($user) {
            $message['receivers'] = array_reduce(
                explode(',', $message['receivers']),
                function ($memo, $line) {
                    list($id, $readed, $deleted) = explode('-', $line);
                    $memo[$id] = array('unread' => 1 - $readed, 'deleted' => $deleted);
                    return $memo;
                },
                array());
            $message['attachments']   = Mail::loadAttachments($message['message_id']);

            if (isset($message['receivers'][$user->id])) {
                $message['unread'] = $message['receivers'][$user->id]['unread'];
            } else {
                $message['unread'] = $message['sender_unread'];
            }
        });

        return is_array($ids) ? $messages : reset($messages);
    }

    static function loadAttachments($id)
    {
        $query = "SELECT dokument_id, name, filesize
                  FROM dokumente
                  WHERE range_id = :msg_id AND user_id = seminar_id
                  ORDER BY filename ASC";
        $statement =  \DBManager::get()->prepare($query);
        $statement->bindValue(':msg_id', $id);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }


    static function delete($user, $mail)
    {
        $messaging = new \messaging;
        return $messaging->delete_message($mail['message_id'], $user->id, true);
    }

    static function markMail($user, &$mail, $mark_as_read)
    {
        $db = \DBManager::get();


        if ($mark_as_read && $mail['unread']) {
            $stmt = $db->prepare("UPDATE `message_user`
                SET readed = '1'
                WHERE   message_user.user_id    = ?
                    AND message_user.message_id = ?");

            $stmt->execute(array($user->id, $mail['message_id']));

        } elseif (!$mark_as_read && !$mail['unread']) {
            $stmt = $db->prepare("UPDATE `message_user`
                SET readed = '0'
                WHERE   message_user.user_id    = ?
                    AND message_user.message_id = ?");

            $stmt->execute(array($user->id, $mail['message_id']));
        }

        $mail['unread'] = !$mark_as_read;
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
        if (!is_array($empf)) {
            $empf_array = array($empf);
        } else {
            $empf_array = $empf;
        }

        //senden der Nachricht
        $send = $message->insert_message($nachricht, $empf_array, $abs, '', '', '', '', $betreff, '', 'normal');
        return $send > 0;
    }

    static function getReplySubject($mail)
    {
        return substr($mail['subject'], 0, 4) === 'Re: ' ? $mail['subject'] : ('Re: ' . $mail['subject']);
    }

    static function getQuotedMessage($mail)
    {
        return $mail['message'];
    }

    static function replyTo($user, $mail, $body)
    {
        $re = self::getReplySubject($mail);
        return self::send(get_username($mail['sender_id']), $re, $body, $user->id);
    }
}
