<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Event;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Trait\SlugTrait;


class AppFixtures extends Fixture
{
    use SlugTrait;
    function randomBrandChoices($faker)
    {
        $choices = ['Brasserie Dupont', 'Mongozo', 'Guinness', 'Erdinger', 'Hoegaarden'];
        $randomIndex = $faker->numberBetween(0, 4);
        return $choices[$randomIndex];
    }

    function randomCategoryChoices($faker)
    {
        $choices = ['Blonde', 'Brune', 'Blanche', 'Ambrée', 'Fruitée'];
        $randomIndex = $faker->numberBetween(0, 4);
        return $choices[$randomIndex];
    }

    function randomStyleChoices($faker)
    {
        $choices = ['IPA', 'Stout', 'Lagger', 'Pils', 'Lambic'];
        $randomIndex = $faker->numberBetween(0, 4);
        return $choices[$randomIndex];
    }

    function randomLabelChoices($faker)
    {
        $choices = ['biologique', 'sans gluten', 'sans alcool', 'avec lactose', 'avec arachides', 'local', ' '];
        $randomIndex = $faker->numberBetween(0, 6);
        return $choices[$randomIndex];
    }
    public function load(ObjectManager $manager): void

    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 5; $i++) {
            $company = new Company();
            $company->setName($faker->word());
            $company->setAddress($faker->address());
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
            for ($k = 0; $k < 5; $k++) {
                $product = new Product();
                $product->setCompany($company);
                $product->setName($faker->word());
                $product->setBrand($this->randomBrandChoices($faker));
                $product->setCategory($this->randomCategoryChoices($faker));
                $product->setStyle($this->randomStyleChoices($faker));
                $product->setCustomerDescription($faker->text(50));
                $product->setEmployeeDescription($faker->text(150));
                $product->setDegreOfAlcohol($faker->randomDigitNotNull());
                $product->setOrigin($faker->country());
                $product->setCapacity($faker->randomElement([250, 330, 341, 355, 500]));
                $product->setPrice($faker->numberBetween(300, 1500));
                $product->setStock($faker->numberBetween(0, 150));
                $product->setThreshold(5);
                $product->setSlug($this->generateSlug($product->getName()));
                $product->setLabel($this->randomLabelChoices($faker));
                $manager->persist($product);
            }
            for ($l = 0; $l < 3; $l++) {
                $event = new Event();
                $event->setCompany($company);
                $event->setName($faker->word(3));
                $currentDate = new \DateTime();
                $event->setStartDate($faker->dateTimeBetween($currentDate, "+30 days"));
                $event->setEndDate($faker->dateTimeBetween($event->getStartDate(), $event->getStartDate()->format('Y-m-d') . "+10 days"));
                // Créer une instance de DateTime à partir de la chaîne de caractères de l'heure
                $startTime = new \DateTime($faker->time());
                $event->setStartTime($startTime);
                // De même pour l'heure de fin, si nécessaire
                $endTime = new \DateTime($faker->time());
                $event->setEndTime($endTime);
                $event->setDisplayTimePeriod($faker->numberBetween(7, 30));
                $event->setTheme($faker->word());
                $event->setImage($faker->imageUrl($width = 400, $height = 400));
                $event->setDescription($faker->text(100));
                $event->setSlug($this->generateSlug($event->getName()));
                $manager->persist($event);
            }
        }
        $manager->flush();
    }
}
