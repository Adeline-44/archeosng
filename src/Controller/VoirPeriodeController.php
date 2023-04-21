<?php

namespace App\Controller;

use App\Entity\WorkingPeriod;
use App\Repository\EmployeeRepository;
use App\Repository\WorkingPeriodRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoirPeriodeController extends AbstractController
{
    #[Route('/voir/{id}', name: 'app_voir_periode')]
    public function index($id, Request $request, WorkingPeriodRepository $workingPeriodRepository,
                          EmployeeRepository $employeeRepository, EntityManagerInterface $entityManager): Response
    {
        $employee = $employeeRepository->findOneBy(['id' => $id]);

        return $this->render('voir_periode/index.html.twig', [
           'wps' => $workingPeriodRepository->findBy(['employee_id' => $id]),
            'employee' => $employee
        ]);
    }

    /**
     * @param Request $request
     * @param $wp
     *
     */
    #[Route('delete/{wp}', name: 'supprimer_wp')]
    public function delete(WorkingPeriod $wp, EntityManagerInterface $em)
    {
        //$id = $wp->getEmployeeId();
       $em->remove($wp);
       $em->flush();

       $this->addFlash('message', "Période supprimée avec succès");
       return $this->redirectToRoute('app_calcul_anciennete', ['id' => $wp->getEmployeeId()->getId()]);

    }

}
