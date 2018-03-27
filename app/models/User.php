<?php

namespace DS\Model;

use Phalcon\Db;
use DS\Constants\Paging;
use Phalcon\Mvc\Model\Query;
use DS\Model\Events\UserEvents;
use DS\Model\DataSource\UserStatus;
use DS\Model\Helper\RandomUserImage;
use DS\Component\Mail\Events\SignupMail;

/**
 * User
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 *
 * @method static User findFirstById(int $id)
 */
class User extends UserEvents
{
    /**
     * @return string
     */
    public function getImage(): string
    {
        return str_replace('http://', '//', parent::getImage());
    }

    /**
     * @return UserStats
     */
    public function getStats()
    {
        return UserStats::get($this->id, 'userId');
    }

    /**
     * @param int  $tableId
     * @param bool $upvoters
     * @param bool $subscribers
     * @param bool $contributors
     *
     * @return array
     */
    public function getTableUsers(int $tableId, bool $upvoters = false, bool $subscribers = false, bool $contributors = false, bool $admins = false): array
    {
        $columns = [
            User::class . '.id',
            User::class . '.image',
            User::class . '.name',
            User::class . '.handle',
            User::class . '.tagline',
            User::class . '.location',
            '(SELECT ' . UserFollower::class . '.id FROM ' . UserFollower::class . ' WHERE ' . UserFollower::class . '.userId = ' . User::class . '.id AND ' . UserFollower::class . '.followedByUserId = ' .
            serviceManager()->getAuth()->getUserId() . ') as following',
        ];

        $query = self::query()
                     ->where(Tables::class . '.id = :tableId:', ['tableId' => $tableId])
                     ->groupBy(User::class . '.id')
                     ->limit(Paging::endlessScrollPortions);

        if ($subscribers) {
            $query->innerJoin(TableSubscription::class, TableSubscription::class . '.userId = ' . User::class . '.id');
            $query->innerJoin(Tables::class, TableSubscription::class . '.tableId = ' . Tables::class . '.id');
            $columns[] = TableSubscription::class . '.createdAt as subscribedAt';
        } else {
            $query->leftJoin(TableSubscription::class, TableSubscription::class . '.userId = ' . User::class . '.id');
        }

        if ($upvoters) {
            $query->innerJoin(TableVotes::class, TableVotes::class . '.userId = ' . User::class . '.id');
            $query->innerJoin(Tables::class, TableVotes::class . '.tableId = ' . Tables::class . '.id');
        } else {
            $query->leftJoin(TableVotes::class, TableVotes::class . '.userId = ' . User::class . '.id');
        }

        if ($contributors) {
            $query->innerJoin(TableCells::class, TableCells::class . '.userId = ' . User::class . '.id')
                  ->innerJoin(TableRows::class, TableCells::class . '.rowId = ' . TableRows::class . '.id')
                  ->innerJoin(Tables::class, TableRows::class . '.tableId = ' . Tables::class . '.id');
        } else {
            $query->leftJoin(TableCells::class, TableCells::class . '.userId = ' . User::class . '.id');
        }

        if ($admins) {
            $query->innerJoin(Tables::class, Tables::class . '.ownerUserId = ' . User::class . '.id');
        }

        return $query->columns($columns)->execute()->toArray();
    }

    /**
     * Get username by email address or username
     *
     * @param $usernameOrEmail
     *
     * @return Abstracts\AbstractUser|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirstByUsernameOrEmail($usernameOrEmail)
    {
        return parent::findFirst(
            [
                'conditions' => 'handle = ?0 OR email = ?1',
                'limit' => 1,
                'bind' => [$usernameOrEmail, $usernameOrEmail],
            ]
        );
    }

    /**
     * Save user credentials. Leave password blank to not update.
     *
     * @param string $email
     * @param string $unhashedPassword
     *
     * @return $this
     */
    public function saveCredentials(string $email, string $unhashedPassword)
    {
        if ($unhashedPassword) {
            $this->setSecuritySalt(serviceManager()->getSecurity()->hash($unhashedPassword));
        }

        $this->setEmail($email)
             ->save();

        return $this;
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $handle
     * @param string $unhashedPassword
     *
     * @return User
     */
    public function addUserFromSignup($name, $handle, $email, $unhashedPassword)
    {
        $user = new User();
        $user->setName($name)
             ->setHandle($handle)
             ->setEmail($email)
             ->setImage(RandomUserImage::get())
             ->setSecuritySalt(serviceManager()->getSecurity()->hash($unhashedPassword))
             ->create();

        // Send mail
        SignupMail::factory($this->getDI())
                  ->prepare($user)
                  ->send();

        return $user;
    }

    /**
     * @param        $name
     * @param        $handle
     * @param        $email
     * @param        $description
     * @param        $tagline
     * @param        $authUid
     * @param        $profileImage
     * @param        $city
     * @param        $website
     * @param string $provider
     *
     * @return User|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function addUserFromAuthService($name, $handle, $email, $description, $tagline, $authUid, $profileImage, $city, $website = '', $provider = 'Facebook')
    {
        $email = $email ? $email : "{$authUid}@" . strtolower($provider) . '.com';
        $user = User::findFirst(
            [
                'conditions' => ' email = ?0 OR authUid = ?1',
                'bind' => [$email, $authUid],
            ]
        );

        if ($user && $user->getAuthProvider() != $provider) {
            throw new \InvalidArgumentException('You already registered with this email address.');
        }

        $urlPattern = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";

        if (!$user) {
            $userHandle = User::findByFieldValue('handle', $handle);
            // Add Auth UserId to handle if a user with the same handle already exists
            if ($userHandle) {
                $handle .= '-' . $authUid;
            }

            $user = new self();

            $user->setEmail($email)
                 ->setName($name)
                 ->setImage($profileImage)
                 ->setAuthProvider($provider)
                 ->setAuthUid($authUid)
                 ->setHandle($handle)
                 ->setLocation($city)
                 ->setDescription($description)
                 ->setTagline($tagline)
                 ->setStatus(UserStatus::OnboardingIncomplete)
                 ->setLastLogin(time());

            if ($website && preg_match($urlPattern, $website)) {
                $user->setWebsite($website);
            }

            $user->create();
        } else {
            $user->setEmail($email)
                 ->setName($name)
                 ->setImage($profileImage)
                 ->setAuthProvider($provider)
                 ->setAuthUid($authUid)
                 ->setHandle($handle)
                 ->setLocation($city)
                 ->setDescription($description)
                 ->setTagline($tagline);

            if ($website && preg_match($urlPattern, $website)) {
                $user->setWebsite($website);
            }

            $user->save();
        }

        return $user;
    }

    public function getRequests()
    {
        $query = $this->readQuery("
             SELECT 
                changeRequests.id, 
                changeRequests.cellid,
                changeRequests.from,
                changeRequests.to,
                changeRequests.comment, 
                changeRequests.status,
                tables.id as table_id,
                tables.title as table_title,
                tables.tagline as table_tagline,
                tables.image as table_image,
                (SELECT COUNT(*) from tableVotes WHERE tableVotes.tableid = tables.id) as votes
            FROM changeRequests
                JOIN tableCells on tableCells.id = changeRequests.cellid
                JOIN tableRows on tableRows.id = tableCells.rowId
                JOIN tables on tables.id = tableRows.tableId
            WHERE changeRequests.userId = $this->id
            ");

        $query->setFetchMode(Db::FETCH_ASSOC);

        return $query->fetchAll() ?: [];
    }

    // Get all user's submissions
    public function getSubmissions()
    {
        $query = $this->readQuery("
            SELECT 
                row_add_request.id, 
                row_add_request.content,
                row_add_request.image,
                row_add_request.comment,
                row_add_request.status,
                row_add_request.table_id,
                row_add_request.createdAt
            FROM 
                row_add_request
            WHERE
                row_add_request.user_id = $this->id
        ");

        $query->setFetchMode(Db::FETCH_ASSOC);
        $add_requests = $query->fetchAll() ?: [];

        foreach ($add_requests as $id => $submission) {
            $table = Tables::findFirstById($submission['table_id']);

            foreach ($table->tableColumns as $column) {
                $add_requests[$id]['columns'][] = $column->title;
            }
        }

        $query = $this->readQuery("
            SELECT 
                row_delete_request.id,
                row_delete_request.row_id,
                row_delete_request.comment,
                row_delete_request.status,
                row_delete_request.createdAt,                
                tableRows.id,
                tableRows.content,
                tableRows.image,
                tableRows.votesCount,
                tableRows.tableId as table_id

            FROM 
                row_delete_request            
            JOIN tableRows ON row_delete_request.row_id = tableRows.id
            WHERE
                row_delete_request.user_id = $this->id
        ");

        $query->setFetchMode(Db::FETCH_ASSOC);
        $delete_requests = $query->fetchAll() ?: [];
        foreach ($delete_requests as $id => $submission) {
            $table = Tables::findFirstById($submission['table_id']);
            $content = '[';

            foreach (json_decode($delete_requests[$id]['content']) as $value) {
                $content .= '"' . $value->content . '",';
            }
            $content = rtrim($content, ',');
            $content .= ']';

            $delete_requests[$id]['content'] = $content;

            foreach ($table->tableColumns as $column) {
                $delete_requests[$id]['columns'][] = $column->title;
            }
        }

        return array_merge($add_requests, $delete_requests);
    }
}
