<?php

namespace Studip\Mobile;

class Contact {

    static function findAllByUser($user)
    {
        $query = "SELECT user_id, buddy, calpermission
                  FROM contact
                  JOIN auth_user_md5 USING (user_id)
                  WHERE owner_id = ?
                  ORDER BY Nachname ASC, Vorname ASC";
        $statement = \DBManager::get()->prepare($query);
        $statement->execute(array($user->id));
        $contacts = $statement->fetchAll();

        return array_map(function ($contact) {
            return array(
                'id'            => $contact['user_id'],
                'name'          => get_fullname($contact['user_id'], 'no_title'),
                'avatar'        => \Avatar::getAvatar($contact['user_id'])->getURL(\Avatar::SMALL),
                'buddy'         => (bool) $contact['buddy'],
                'calpermission' => (bool) $contact['calpermission']
            );
        }, $contacts);
    }
}
