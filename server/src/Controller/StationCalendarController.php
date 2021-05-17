<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Station;
use Carbon\Carbon;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StationCalendarController extends AbstractController
{
    #[Route('/api/stations/{id}/calendar', name: 'get_calendar')]
    public function index(
        string $id,
        ObjectManager $em
    ): Response {
        $objects = [];

        $dt = Carbon::now();

        $stationRepo = $em->getRepository(Station::class);
        $station = $stationRepo->find($id);

        $orders = $em->getRepository(Order::class)->findUnfinishedIncomingOrdersFor($id);

        dump($orders);

        $showDays = 30;
        for ($i = 0; $i <= $showDays; $i++) {
            $orderObject = $o = new \stdClass();
            $o->transports = 0;
            $o->transportsReady = 0;
            $o->equipment = [];
            $o->equipmentReady = [];

            $ordersOnThisDate = array_reduce($orders, function ($acc, Order $order) use ($dt) {
                if ($dt->greaterThanOrEqualTo($order->getStartDate()) && $dt->lessThanOrEqualTo($order->getEndDate())) {
                    $acc->transports += count($order->getTransports());

                    $equipment = $order->getEquipment();
                    foreach ($equipment as $item) {
                        if (!array_key_exists($item->getName(), $acc->equipment)) {
                            $acc->equipment[$item->getName()] = 0;
                        }
                        $acc->equipment[$item->getName()] += $item->getAmount();
                    }
                }

                if ($dt->greaterThanOrEqualTo($order->getEndDate())) {
                    $acc->transportsReady += count($order->getTransports());

                    $equipment = $order->getEquipment();
                    foreach ($equipment as $item) {
                        if (!array_key_exists($item->getName(), $acc->equipmentReady)) {
                            $acc->equipmentReady[$item->getName()] = 0;
                        }
                        $acc->equipmentReady[$item->getName()] += $item->getAmount();
                    }
                }

                return $acc;
            }, $orderObject);

            dump($orderObject);

            $object = new \stdClass();
            $object->date = $dt->format('D d M');
            $object->weekend = $dt->isWeekend();
            $object->name = $station->getName();

            $inOrder = $ordersOnThisDate->transports;
            $inOrderText = '';
            if ($inOrder > 0) {
                $inOrderText = " ($inOrder)";
            }
            $transports = count($station->getTransports()) + $o->transportsReady;
            $object->transports = $transports . $inOrderText;

            $equipment = [];
            foreach ($station->getEquipment() as $eq) {
                $equipment[$eq->getName()] = $eq->getAmount();
            }

            foreach ($ordersOnThisDate->equipmentReady as $eqName => $amount) {
                if (!array_key_exists($eqName, $equipment)) {
                    $equipment[$eqName] = 0;
                }
                $equipment[$eqName] += $amount;
            }

            foreach ($ordersOnThisDate->equipment as $eqName => $amount) {
                if (!array_key_exists($eqName, $equipment)) {
                    $equipment[$eqName] = "0";
                }
                $equipment[$eqName] .= " ($amount)";
            }

            $object->equipment = $equipment;

            $dt->addDay();
            array_push($objects, $object);
        }


        return $this->json($objects);
    }
}
