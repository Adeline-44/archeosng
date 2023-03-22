<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\WorkingPeriod;
use App\Form\WorkingPeriodType;
use App\Repository\EmployeeRepository;
use App\Repository\ProfessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Ajout d'une période d'activité
 */
class CalculAncienneteController extends AbstractController
{
    public \DateTime $startDate;
	public \DateTime $endDate;
	public float $hours;
	public int $type;
	public string $cat;
	public String $prof;

    public Employee $employee;


    #[Route('/calcul_anciennete/{id}', name: 'app_calcul_anciennete')]
    public function index($id, Request $request, EntityManagerInterface $entityManager, EmployeeRepository $employeeRepository): Response
    {

        $employee = $employeeRepository->findOneBy(['id' => $id]);
        //dd($employee);
        $workingPeriod = new WorkingPeriod();
        // On créé le formulaire.
        $form = $this->createForm(WorkingPeriodType::class, $workingPeriod);
        $form->handleRequest($request);

        // Si le formulaire est envoyé et est valide
        if($form->isSubmitted() && $form->isValid()) {
            //Trucs à faire
            $workingPeriod->setEmployeeId($employee);
            $startDate = $workingPeriod->getStartDate();
            $endDate = $workingPeriod->getEndDate();
            $test = $workingPeriod->getJPC();
           // $workingPeriod->setProf($form->get('prof')->getData());
            $workingPeriod->setHours($test);
            $workingPeriod->getCat();

            //Si on reprend une période du privé, le type =2 on fixe la catégorie à P
            if($workingPeriod->getType() == 2) { $workingPeriod->setCat('P'); }

            //$workingPeriod->setCat($employee->getCategorie());
            //$workingPeriod->setProf($test2);
            ($form->getData());

            $entityManager->persist($workingPeriod);
            $entityManager->flush();

            return $this->redirectToRoute('app_calcul_anciennete', ['id' => $employee->getId()]);

        }
        return $this->render('calcul_anciennete/index.html.twig', [
            'employee' => $employee,
            'form' => $form->createView(),
            'workingperiod' => $workingPeriod
        ]);
    }



}
