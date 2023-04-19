<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\WorkingPeriod;
use App\Form\EmployeeTypeCType;
use App\Form\WorkingPeriodType;
use App\Form\WorkingPeriodTypeC;
use App\Repository\EmployeeRepository;
use App\Repository\ProfessionRepository;
use App\Repository\WorkingPeriodRepository;
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
    public function index($id, Request $request, EntityManagerInterface $entityManager, EmployeeRepository $employeeRepository,
                          WorkingPeriodRepository $workingPeriodRepository): Response
    {

        $employee = $employeeRepository->findOneBy(['id' => $id]);
        //dd($employee);
        $workingPeriod = new WorkingPeriod();
        // On créé le formulaire.
        if($employee->getCategorie()!= 3) {
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
                $workingPeriod->setHours(0);
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
                'workingperiod' => $workingPeriod,
                'wps' => $workingPeriodRepository->findBy(['employee_id' => $id])
            ]);
        }

        //Cas de catégorie C
        else {
            $form = $this->createForm(WorkingPeriodTypeC::class, $workingPeriod);
            // on créé le formulaire pour la base heures/semaine et heures/mois de l'employee
            $form2 = $this->createForm(EmployeeTypeCType::class, $employee);
            $form2->handleRequest($request);
            $form->handleRequest($request);

                //Second formulaire validé
                if ($form->isSubmitted() && $form->isValid()) {
                    $form2->getData();
                    $entityManager->persist($employee);
                    $entityManager->flush();


                    $workingPeriod->setEmployeeId($employee);
                    $startDate = $workingPeriod->getStartDate();
                    $endDate = $workingPeriod->getEndDate();
                    $test = $workingPeriod->getJPC();
                    // $workingPeriod->setProf($form->get('prof')->getData());
                    //$workingPeriod->setHours($test);
                    $workingPeriod->getCat();

                    //Si on reprend une période du privé, le type =2 on fixe la catégorie à P
                    if ($workingPeriod->getType() == 2) {
                        $workingPeriod->setCat('P');
                    }
                    else {
                        $workingPeriod->setCat('C');
                    }
                    //$workingPeriod->setCat($employee->getCategorie());
                    //$workingPeriod->setProf($test2);
                    //dd($form->getData());

                    $entityManager->persist($workingPeriod);
                    $entityManager->flush();

                    return $this->redirectToRoute('app_calcul_anciennete', ['id' => $employee->getId()]);
                }

            return $this->render('calcul_anciennete/indexC.html.twig', [
                'employee' => $employee,
                'form' => $form->createView(),
                'form2' => $form2->createView(),
                'workingperiod' => $workingPeriod,
                'wps' => $workingPeriodRepository->findBy(['employee_id' => $id])
            ]);
        }

    }



}
