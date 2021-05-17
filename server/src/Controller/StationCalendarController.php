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

            $ordersOnThisDate = array_reduce($orders, function ($acc, Order $order) use ($dt) {
                if ($dt->greaterThanOrEqualTo($order->getStartDate()) && $dt->lessThanOrEqualTo($order->getEndDate())) {
                    $acc->transports += count($order->getTransports());
                }

                if ($dt->greaterThanOrEqualTo($order->getEndDate())) {
                    $acc->transportsReady += count($order->getTransports());
                }

                return $acc;
            }, $orderObject);


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
            $object->equipment = $station->getEquipment();

            $dt->addDay();
            array_push($objects, $object);
        }


        return $this->json($objects);
    }
}
