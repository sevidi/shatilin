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
     * @param $name *
     * @return User
     */
    public function auth($network, $identity, $name): User
    {

        if ($user = $this->users->findByNetworkIdentity($network, $identity)) {
                return $user;
            }
        $user = User::signupByNetwork($network, $identity, $name);
        $this->users->save($user);
        return $user;
    }

    public function attach($id, $network, $identity, $name): void
    {
        if ($this->users->findByNetworkIdentity($network, $identity)) {
            throw new \DomainException('Network is already signed up.');
        }
        $user = $this->users->get($id);
        $user->attachNetwork($network, $identity, $name);
        $this->users->save($user);
    }

}