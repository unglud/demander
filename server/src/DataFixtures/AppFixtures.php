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

        $maxNumberOfStations = 5;
        $maxItemsAmount = 20;
        $maxItemsPerOrder = 2;
        $maxTransportPerStation = 20;
        $numberOfOrders = 20;
        $items = [
            'Toilet',
            'Bed sheets',
            'Sleeping bag',
            'Camping table',
            'Chair'
        ];

        $stations = [];
        for ($i = 0; $i < $maxNumberOfStations; $i++) {
            $station = new Station();
            $station->setName($generator->city);
            array_push($stations, $station);

            $manager->persist($station);

            $equipment = $this->generateEquipment($items, $maxItemsAmount);
            foreach ($equipment as $item) {
                $item->setLocation($station);
                $manager->persist($item);
            }

            $transport = $this->generateTransport($maxTransportPerStation);
            foreach ($transport as $item) {
                $item->setLocation($station);
                $manager->persist($item);
            }
        }

        for ($k = 0; $k < $numberOfOrders; $k++) {

            $order = new Order();

            [$start, $end] = $generator->randomElements($stations, 2);

            $order->setStartLocation($start);
            $order->setEndLocation($end);

            $startInFeature = $generator->boolean;

            $startDate = $generator->numberBetween(1, 30) * $startInFeature ? 1 : -1;
            $interval = $generator->numberBetween(1, 30);

            $start = $generator->dateTimeBetween("$startDate days", "+ $interval days");
            $end = clone $start;
            $end->modify("+ $interval days");

            $order->setStartDate($start);
            $order->setEndDate($end);

            $equipment = $this->generateEquipment($items, $maxItemsPerOrder);
            foreach ($equipment as $item) {
                $order->addEquipment($item);
                $manager->persist($item);
            }

            $transport = $this->generateTransport(1);
            $order->addTransport($transport);
            $manager->persist($transport);

            $manager->persist($order);
        }

        $manager->flush();
    }


    private function generateEquipment(
        array $items,
        int $maxItemsAmount,
    ): array {
        $generator = Factory::create();

        $itemsLimit = $generator->numberBetween(1, count($items));

        $equipments = [];
        for ($k = 0; $k < $itemsLimit; $k++) {
            $equipment = new Equipment();
            $equipment->setName($generator->unique()->randomElement($items));
            $equipment->setAmount($generator->numberBetween(1, $maxItemsAmount));

            array_push($equipments, $equipment);
        }

        return $equipments;
    }

    private function generateTransport(
        int $max
    ): array | Transport {
        $generator = Factory::create();
        $transportLimit = $generator->numberBetween(1, $max);

        $transports = [];
        for ($k = 0; $k < $transportLimit; $k++) {
            $transport = new Transport();

            array_push($transports, $transport);
        }

        return count($transports) < 2 ? $transports[0] : $transports;
    }
}
