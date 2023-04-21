<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeType;
use App\Form\RepriseType;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * On créé un nouvel employé pour un nouveau calcul
 * Où on poursuit un précédent calcul
 */
class NouveauCalculController extends AbstractController
{

    #[Route('/nouveau_calcul', name: 'app_nouveau_calcul')]
    public function index(Request $request, EntityManagerInterface $entityManager, EmployeeRepository $employeeRepository): Response
    {
        $employee = new Employee();
        $form=$this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);
        $session = $request->getSession();
        $session = $session->getId();
        if($form->isSubmitted() && $form->isValid()) {

            $employee->setCreatedBy($session);
            //UID en java est généré par cette formule Math.abs((this.toString() + new Date().toString()).hashCode())
            $now = new \DateTimeImmutable();
            $now = date_format($now, 'dd-mm-yy hh:mm:ss');
            $now = hash('md5',$now);
            $employee->setUID($now);

            //Le cadreEmploi vaut 0 si catégorie C ou B, et on prend la val de la liste déroulante cadreEmploi si catégorie A
            if($employee->getCategorie()==3 OR $employee->getCategorie()==2) { $employee->setCadreEmploi('0'); }

            //si militaire = 0, on set, le militaire month à 0
            if($employee->isMilitaire()==false) {$employee->setmilitaireDays('0');}
            //dd($form->getData());

            $entityManager->persist($employee);
            $entityManager->flush();

            /*$this->addFlash(
                'success',
                'Création ok !'
            );*/

            return $this->redirectToRoute('app_calcul_anciennete', ['id' => $employee->getId()]);
        }

        // Formulaire de reprise du calcul précédent
        $formulaire = $this->createForm(RepriseType::class);
        $formulaire->handleRequest($request);
        //$session = $request->getSession();
        //$session = $session->getId();
        if($formulaire->isSubmitted() && $formulaire->isValid()) {
            $uid = $formulaire->getData("UID");
            //dd($test);
            $employeeReprise = $employeeRepository->findOneBy(['UID' => $uid]);
            return $this->redirectToRoute('app_calcul_anciennete', ['id' => $employeeReprise->getId()]);
        }

        return $this->render('nouveau_calcul/index.html.twig', [
            'form' => $form->createView(),
            'formulaire' => $formulaire->createView()
        ]);
    }
}
