<?php

namespace App\DataFixtures;

use App\Entity\Equipment;
use App\Entity\Order;
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
        $maxItemsAmount = 10;
        $maxItemsPerOrder = 2;
        $maxTransportPerStation = 10;
        $numberOfOrders = 1;
        $items = [
            'Toilet',
            'Bed sheets',
            'Sleeping bag',
            'Camping table',
            'Chair'
        ];

        $limit = $generator->numberBetween(2, $maxNumberOfStations);

        $stations = [];
        for ($i = 0; $i < $limit; $i++) {
            $station = new Station();
            $station->setName($generator->city);
            array_push($stations, $station);

            $manager->persist($station);

            $equipment = $this->generateEquipment($items, 'station', $maxItemsAmount);
            foreach ($equipment as $item) {
                $item->setStation($station);
                $manager->persist($item);
            }

            $transport = $this->generateTransport('station', $maxTransportPerStation);
            foreach ($transport as $item) {
                $item->setStation($station);
                $manager->persist($item);
            }
        }

        for ($k = 0; $k < $numberOfOrders; $k++) {

            $order = new Order();

            [$start, $end] = $generator->randomElements($stations, 2);

            $order->setStartLocation($start);
            $order->setEndLocation($end);

            $startInFeature = $generator->boolean;

            $startDate = $generator->numberBetween(1, 90) * $startInFeature ? 1 : -1;
            $interval = $generator->numberBetween(1, 90);

            $start = $generator->dateTimeBetween("$startDate days", "+ $interval days");
            $end = clone $start;
            $end->modify("+ $interval days");

            $order->setStartDate($start);
            $order->setEndDate($end);

            $equipment = $this->generateEquipment($items, 'order', $maxItemsPerOrder);
            foreach ($equipment as $item) {
                $order->addEquipment($item);
                $manager->persist($item);
            }

            $transport = $this->generateTransport('order', 1);
            $manager->persist($transport);
            $order->addTransport($transport);

            $manager->persist($order);
        }

        $manager->flush();
    }


    private function generateEquipment(
        array $items,
        string $location,
        int $maxItemsAmount,
    ): array {
        $generator = Factory::create();

        $itemsLimit = $generator->numberBetween(1, count($items));

        $equipments = [];
        for ($k = 0; $k < $itemsLimit; $k++) {
            $equipment = new Equipment();
            $equipment->setName($generator->/*unique()->*/randomElement($items));
            $equipment->setAmount($generator->numberBetween(1, $maxItemsAmount));
            $equipment->setLocation($location);

            array_push($equipments, $equipment);
        }

        return $equipments;
    }

    private function generateTransport(
        string $location,
        int $max
    ): array | Transport {
        $generator = Factory::create();
        $transportLimit = $generator->numberBetween(1, $max);

        $transports = [];
        for ($k = 0; $k < $transportLimit; $k++) {
            $transport = new Transport();
            $transport->setLocation($location);

            array_push($transports, $transport);
        }

        return count($transports) < 2 ? $transports[0] : $transports;
    }
}
