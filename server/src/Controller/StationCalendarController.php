<?php

namespace App\Controller;

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
        $station = $em->getRepository(Station::class)->find($id);

        $object = new \stdClass();
        $object->date = $dt->format('D d M');
        $object->weekend = $dt->isWeekend();
        $object->name = $station->getName();
        $object->transports = count($station->getTransports());
        $object->equipment = $station->getEquipment();


        array_push($objects, $object);

        return $this->json($objects);
    }
}
