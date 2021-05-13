<?php

namespace App\DataFixtures;

use App\Entity\Equipment;
use App\Entity\Station;
use App\Entity\Transport;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $generator = Factory::create();

        $maxNumberOfStations = 4;
        $maxNumberItems = 10;
        $maxTransportPerStation = 10;
        $items = [
            'Toilet',
            'Bed sheets',
            'Sleeping bag',
            'Camping table',
            'Chair'
        ];
        $maxNumberItemsPerStation = count($items);


        $limit = $generator->numberBetween(1, $maxNumberOfStations);

        for ($i = 0; $i < $limit; $i++) {
            $station = new Station();
            $station->setName($generator->city);

            $manager->persist($station);
            $reset = true;

            $itemsLimit = $generator->numberBetween(1, $maxNumberItemsPerStation);
            for ($k = 0; $k < $itemsLimit; $k++) {
                $equipment = new Equipment();
                $equipment->setName($generator->unique($reset)->randomElement($items));

                $equipment->setAmount($generator->numberBetween(1, $maxNumberItems));
                $equipment->setLocation('station');
                $equipment->setStation($station);
                $manager->persist($equipment);
                $reset=false;
            }

            $transportLimit = $generator->numberBetween(1, $maxTransportPerStation);
            for ($k = 0; $k < $transportLimit; $k++) {
                $transport = new Transport();
                $transport->setLocation('station');
                $transport->setStation($station);
                $manager->persist($transport);
            }

        }

        $manager->flush();
    }
}
