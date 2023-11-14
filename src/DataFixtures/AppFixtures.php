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
        $choices = ['Blonde', 'Brune', 'Blanche', 'Ambrée', 'Fruitée', 'Sansalcool', 'Soft'];
        $randomIndex = $faker->numberBetween(0, 6);
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
        $choices = ['Biologique', 'Sans gluten', 'Sans alcool', 'Avec lactose', 'Avec arachides', 'Local'];
        $randomIndex = $faker->numberBetween(0, 5);
        return $choices[$randomIndex];
    }

    function randomPromotionChoice($faker)
    {
        $choices = [null, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50];
        $randomIndex = $faker->numberBetween(0, 10);
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
            $company->setEmployeePassword("123");
            $company->setLogo($faker->imageUrl($width = 400, $height = 400));
            $manager->persist($company);

            $adminUser = new User();
            $adminUser->setCompany($company);
            $adminUser->setEmail($faker->email());
            $adminUser->setPassword($faker->password(6, 12));
            $adminUser->setEmployeeNumber(1);
            $adminUser->setFirstname($company->getDirectorFirstname());
            $adminUser->setLastname($company->getDirectorLastname());
            $adminUser->setResetToken('');
            $adminUser->setRoles(["ROLE_ADMIN"]);
            $manager->persist($adminUser);

            for ($j = 0; $j < 5; $j++) {
                $user = new User();
                $user->setFirstname($faker->firstName($gender = null));
                $user->setLastname($faker->lastname());
                $user->setEmployeeNumber($faker->numberBetween(10, 200));
                $user->setCompany($company);
                $employeeNumber = $user->getEmployeeNumber();
                $companyId = $user->getCompany();
                $email = $employeeNumber . '@' . $companyId;
                $user->setEmail($email);
                $user->setResetToken('');
                if($user->getEmployeeNumber() > 2 && $user->getEmployeeNumber() < 100){
                    $user->setRoles(["ROLE_CHEF"]);
                } else {
                    $user->setRoles(["ROLE_SERVEUR"]);
                }
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
                $product->setDegreeOfAlcohol($faker->randomDigitNotNull());
                $product->setOrigin($faker->country());
                $product->setCapacity($faker->randomElement([250, 330, 341, 355, 500]));
                $product->setPrice($faker->numberBetween(300, 1500));
                $product->setPromotion($this->randomPromotionChoice($faker));
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
                // Create a DateTime instance from the time string
                $startTime = new \DateTime($faker->time());
                $event->setStartTime($startTime);
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
