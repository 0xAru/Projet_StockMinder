<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void

    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 5; $i++) {
            $company = new Company();
            $company->setName($faker->word());
            $company->setAdress($faker->address());
            $company->setZipcode($faker->postcode());
            $company->setCity($faker->city());
            $company->setSiret($faker->siret());
            $company->setDirectorFirstname($faker->firstName($gender = null));
            $company->setDirectorLastname($faker->lastname());
            $manager->persist($company);

            $adminUser = new User();
            $adminUser->setCompany($company);
            $adminUser->setEmail($faker->email());
            $adminUser->setPassword($faker->password(6, 12));
            $adminUser->setEmployeeNumber(1);
            $adminUser->setFirstname($company->getDirectorFirstname());
            $adminUser->setLastname($company->getDirectorLastname());
            $adminUser->setRoles(["admin"]);
            $manager->persist($adminUser);

            for ($j = 0; $j < 5; $j++) {
                $user = new User();
                $user->setFirstname($faker->firstName($gender = null));
                $user->setLastname($faker->lastname());
                $user->setEmployeeNumber($faker->numberBetween(10, 200));
                if($user->getEmployeeNumber() < 100){
                    $user->setRoles(["chef de salle"]);
                } else {
                    $user->setRoles(["serveur"]);
                }
                $user->setCompany($company);
                $manager->persist($user);
            }
        }
        $manager->flush();
    }
}
