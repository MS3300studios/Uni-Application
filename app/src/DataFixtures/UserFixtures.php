<?php

/**
 * UserFixtures.
 */

namespace App\DataFixtures;

use App\Entity\Enum\UserRole;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class UserFixtures.
 */
class UserFixtures extends AbstractBaseFixtures
{
    /**
     * UserPasswordHasherInterface.
     *
     * @var UserPasswordHasherInterface User password hasher interface
     */
    private UserPasswordHasherInterface $hasher;

    /**
     * Constructor.
     *
     * @param UserPasswordHasherInterface $hasher User Password Hasher Interface
     */
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * Load data.
     */
    protected function loadData(): void
    {
        $this->createMany(1, 'user', function ($i) {
            $user = new User();
            $user->setNickname('Admin3300');
            $user->setEmail('admin3300@example.com');
            $user->setRoles([UserRole::ROLE_ADMIN->value]);
            $user->setPassword(
                $this->hasher->hashPassword(
                    $user,
                    'admin3300',
                )
            );

            return $user;
        });
        $this->manager->flush();
    }
}
