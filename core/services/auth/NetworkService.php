<?php


namespace core\services\auth;

use core\entities\User\User;
use core\entities\User\Network;
use core\repositories\UserRepository;
use Yii;
use yii\authclient\ClientInterface;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

class NetworkService
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * @param $username
     * @param $network
     * @param $identity
     * @return User
     */
    public function auth($network, $identity): User
    {
        if ($user = $this->users->findByNetworkIdentity($network, $identity)) {
                return $user;
            }
        $user = User::signupByNetwork($network, $identity);
        $this->users->save($user);
        return $user;
    }

    public function attach($id, $network, $identity): void
    {
        if ($this->users->findByNetworkIdentity($network, $identity)) {
            throw new \DomainException('Network is already signed up.');
        }
        $user = $this->users->get($id);
        $user->attachNetwork($network, $identity);
        $this->users->save($user);
    }

}