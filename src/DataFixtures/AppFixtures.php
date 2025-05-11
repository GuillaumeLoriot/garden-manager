<?php

namespace App\DataFixtures;

use App\Entity\Family;
use App\Entity\Plant;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

 public function __construct(private UserPasswordHasherInterface $hasher) 
    {
    }

    public function load(ObjectManager $manager): void
    {

        // j'importe mes données en json et les décode pour travailler avec un tableau associatif
        $familyData = json_decode(file_get_contents(__DIR__.'/data/family_data.json'), true);
        $plantData = json_decode(file_get_contents(__DIR__.'/data/plant_data.json'), true);
        

        // --------- FAMILIES --------------------------------------------------
        $families = [];
        // création des familles
        foreach ($familyData as $familyItem) {
            $family = new Family();
            $family
                ->setName($familyItem['name'])
                ->setDescription($familyItem['description'])
                ->setCharacteristics($familyItem['characteristics'])
                ->setHistory($familyItem['history'])
                ->setMainUse($familyItem['main_use'])
                ->setSlug($familyItem['slug']);
            $manager->persist($family);

            // j'enregistre la toute mes familles dans un tableau pour pouvoir ensuite les lié avec chaque plante
            $families[$family->getSlug()] = $family;
        }

        // --------- PLANTS ------------------------------------------------------
        // Créer les plantes et les associer aux familles
        foreach ($plantData as $plantItem) {

            $familySlug = $plantItem['family_slug'];

            $plant = new Plant();
            $plant
                ->setName($plantItem['name'])
                ->setCategory($plantItem['category'])
                ->setDescription($plantItem['description'])
                ->setPlantPicture($plantItem['plant_picture'])
                ->setSowingPeriodStart(new \DateTime($plantItem['sowing_period_start']))
                ->setSowingPeriodEnd(new \DateTime($plantItem['sowing_period_end']))
                ->setPlantingPeriodStart(new \DateTime($plantItem['planting_period_start']))
                ->setPlantingPeriodEnd(new \DateTime($plantItem['planting_period_end']))
                ->setHarvestPeriodStart(new \DateTime($plantItem['harvest_period_start']))
                ->setHarvestPeriodEnd(new \DateTime($plantItem['harvest_period_end']))
                ->setGerminationDetails($plantItem['germination_details'])
                ->setCultivationDetails($plantItem['cultivation_details'])
                ->setGrowingTime($plantItem['growing_time'])
                ->setWaterNeed($plantItem['water_need'])
                ->setSunlightNeed($plantItem['sunlight_need'])
                ->setSoilNeed($plantItem['soil_need'])
                ->setSupportNeed($plantItem['support_need']);
            


            // j'associe la famille à la plante via le slug. ce slug est unique et me permet de charger 
            // les donnée sans me soucier des id qui change à chaque load des fixtures.
            if (isset($families[$familySlug])) {
                    $plant->setFamily($families[$familySlug]);
            }

            $manager->persist($plant);
        }

         // --------- USERS ----------------------------------------------------------

         $faker = Factory::create('fr_FR');

        for($i=0; $i<7; $i++){
            $user = new User();
            $user
              ->setEmail($faker->email())
              ->setRoles(['ROLE_USER'])
              ->setPassword($this->hasher->hashPassword($user, 'test'))
              ->setUsername($faker->userName())
              ->setCreatedAt($faker->dateTime());
          
            $manager->persist($user);

        }
        $regularUser = new User();
        $regularUser
          ->setEmail('regular@user.com')
          ->setRoles(['ROLE_USER'])
          ->setPassword($this->hasher->hashPassword($user, 'test'))
          ->setUsername($faker->userName())
          ->setCreatedAt($faker->dateTime());
      
        $manager->persist($regularUser);

        $adminUser = new User();
        $adminUser
          ->setEmail('admin@mycorp.com')
          ->setRoles(['ROLE_ADMIN'])
          ->setPassword($this->hasher->hashPassword($adminUser, 'admin'))
          ->setUsername($faker->userName())
          ->setCreatedAt($faker->dateTime());
      
        $manager->persist($adminUser);

         // --------- IMAGES -----------------------------------------



        $manager->flush();
    }
}
