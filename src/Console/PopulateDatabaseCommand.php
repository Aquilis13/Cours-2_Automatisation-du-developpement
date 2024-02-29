<?php

namespace App\Console;

use App\Models\Company;
use App\Models\Employee;
use App\Models\Office;
use Illuminate\Support\Facades\Schema;
use Slim\App;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

require  __DIR__ . '/../../vendor/autoload.php';
require  __DIR__ . '/../../vendor/fakerphp/faker/src/autoload.php';

class PopulateDatabaseCommand extends Command
{
    private App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('db:populate');
        $this->setDescription('Populate database');
    }

    protected function execute(InputInterface $input, OutputInterface $output ): int
    {
        $output->writeln('Populate database...');

        /** @var \Illuminate\Database\Capsule\Manager $db */
        $db = $this->app->getContainer()->get('db');

        $db->getConnection()->statement("SET FOREIGN_KEY_CHECKS=0");
        $db->getConnection()->statement("TRUNCATE `employees`");
        $db->getConnection()->statement("TRUNCATE `offices`");
        $db->getConnection()->statement("TRUNCATE `companies`");
        $db->getConnection()->statement("SET FOREIGN_KEY_CHECKS=1");

        $faker = \Faker\Factory::create('fr_FR');

        $nbCompagnies = 5;
        $nbOffices = 7;
        $nbEmployees = 13;

        /**
         * Création des données de la table COMPAGNIES
         */
        for ($i = 1; $i <= $nbCompagnies; $i++) {
            // Génération des données aléatoires
            $name = $faker->company;
            $phone = $faker->phoneNumber;
            $email = $faker->companyEmail;
            $website = $faker->url;
            $image = $faker->imageUrl(400, 300, 'business');

            // Mise en place de la requête à la base de données
            $db->getConnection()->statement("INSERT INTO `companies` VALUES 
                ($i, '$name', '$phone', '$email', '$website', '$image', now(), now(), null)"
            );
        }
        
        /**
         * Création des données de la table OFFICES
         */
        for ($i = 1; $i <= $nbOffices; $i++) {
            // Génération des données aléatoires
            $name = $faker->company;
            $address = $faker->address;
            $city = $faker->city;
            $zipCode = $faker->postcode;
            $country = $faker->country;
            $email = $faker->companyEmail;
            $phone = $faker->phoneNumber;
            $companyId = $faker->numberBetween(1, $nbCompagnies);

            // Mise en place de la requête à la base de données
            $db->getConnection()->statement("INSERT INTO `offices` VALUES 
                ($i,'$name','$address','$city','$zipCode','$country','$email', '$phone', $companyId, now(), now())
            ");
        }

        // /**
        //  * Création des données de la table EMPLOYEES
        //  */
        for ($i = 1; $i <= $nbEmployees; $i++) {
            // Génération des données aléatoires
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;
            $officeId = $faker->numberBetween(1, $nbOffices);
            $email = $faker->companyEmail;
            $phone = $faker->phoneNumber;
            $jobTitle = $faker->jobTitle;

            // Mise en place de la requête à la base de données
            $db->getConnection()->statement("INSERT INTO `employees` VALUES
                ($i,'$firstName','$lastName', $officeId, '$email', '$phone','$jobTitle', now(), now())
            ");
        }        

        $db->getConnection()->statement("update companies set head_office_id = 1 where id = 1;");
        $db->getConnection()->statement("update companies set head_office_id = 3 where id = 2;");

        $output->writeln('Database created successfully!');
        return 0;
    }
}
