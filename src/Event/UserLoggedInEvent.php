<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class UserLoggedInEvent extends Event
{
    public const NAME = 'user.logged_in';

    /**
     * @var User
     */
    protected User $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf("User ID: %s", $this->user->getId());
    }
}