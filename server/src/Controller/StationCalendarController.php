<?php

namespace App\Controller;

use App\Entity\Station;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StationCalendarController extends AbstractController
{
    #[Route('/api/stations/{id}/calendar', name: 'get_calendar')]
    public function index(string $id, ObjectManager $em): Response {
        $objects = [];

        $object = new \stdClass();
        $object->date = '1';

        array_push($objects, $object);
        return $this->json($objects);
    }
}
