<?php

namespace App\DataFixtures;

use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends AbstractBaseFixtures
{
    private UserRepository $repo;

    public function __construct(
        UserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function load(ObjectManager $manager): void
    {
        $user = $this->repo->find(1);
        $this->addReference(self::USER_REF, $user);
    }
}
