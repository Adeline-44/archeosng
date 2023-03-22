<?php

namespace App\Entity;

use App\Repository\WorkingPeriodRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Validator\Constraints\Date;

#[ORM\Entity(repositoryClass: WorkingPeriodRepository::class)]
class WorkingPeriod
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $endDate;

    #[ORM\Column(type: 'float')]
    private $hours;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $startDate;

    #[ORM\Column(type: 'integer')]
    private $type;

    #[ORM\ManyToOne(targetEntity: Employee::class, inversedBy: 'workingPeriods')]
    private $employee_id;


    #[ORM\Column(type: 'string', length: 1)]
    private $cat;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prof = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getHours(): ?float
    {
        return $this->hours;
    }

    public function setHours(float $hours): self
    {
        $this->hours = $hours;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getEmployeeId(): ?Employee
    {
        return $this->employee_id;
    }

    public function setEmployeeId(?Employee $employee_id): self
    {
        $this->employee_id = $employee_id;

        return $this;
    }


    public function getCat(): ?string
    {
        return $this->cat;
    }

    public function setCat(string $cat): self
    {
        $this->cat = $cat;

        return $this;
    }

    public function getProf(): ?string
    {
        return $this->prof;
    }

    public function setProf(?string $prof): self
    {
        $this->prof = $prof;

        return $this;
    }

    /**
     * Calcul du nombre de jours retenus
     * Nb jours entre date début et date de fin
     * @return int
     */
    public function getJR(): int
    {
        $days = 0;
        $cstart = new \DateTimeImmutable();
        $cend = new \DateTimeImmutable();

        $cstart = ($this->startDate);
        $cend = ($this->endDate);

        $cstartDayOfMonth = $cstart->format('d');
        $cendDayOfMonth = $cend->format('d');
        $cstartMonth = $cstart->format('m');
        $cendMonth = $cend->format('m');
        $cstartYear = $cstart->format('y');
        $cendYear = $cend->format('y');

        if (($cstartYear == $cendYear) && ($cstartMonth == $cendMonth)) {
            if (date_format($cend, 'L') == 1 && $cendMonth == '02') {
                $days += ($cendDayOfMonth >= 29 ? 30 : $cendDayOfMonth) + 1 - $cstartDayOfMonth;
            } else if ($cendMonth == '02') {
                $days += ($cendDayOfMonth >= 28 ? 30 : $cendDayOfMonth) + 1 - $cstartDayOfMonth;
            } else {
                $days += (min(30, $cendDayOfMonth) + 1) - $cstartDayOfMonth;
            }
        }
        else {
            /*$days += 31-$cstartDayOfMonth;
            $ctemp = $cend;

            $ctemp->sub(new \DateInterval('P1M')); // on enlève un mois
            $ctempMonth = $ctemp->format('m');
            $ctempYear = $ctemp->format('y');
            $ctemp = date_create($ctempYear.'-'.$ctempMonth.'-01');

            $current = $ctempYear+$ctempMonth;
            $start = $cstartYear+$cstartMonth;
			while ($current > $start) {
                $days += 30;
                $ctemp->sub(new \DateInterval('P1M'));
                //ctemp.add(GregorianCalendar.MONTH,-1);
                $ctempMonth = $ctemp->format('m');
                $ctempYear = $ctemp->format('y');
                $current = $ctempYear + $ctempMonth;
                //current = Integer.parseInt(ctemp.get(GregorianCalendar.YEAR) + String.format("%02d", ctemp.get(GregorianCalendar.MONTH)));
                $start = $cstartYear+$cstartMonth;
                //start = Integer.parseInt(cstartYear + String.format("%02d", cstartMonth));
                //Logger.debug("%s >= %s", current, start);
            }

			// calcul du reliquat en jours pour la période de fin
			// on distingue ici le cas de février où une période
			// qui se termine le 27 se verra ajouter 27 jours, alors que si elle
			// se termine le 28 une année non bissextile, se verra ajouter 30 jours.
			if (date_format($cend, 'L') == 1 && $cendMonth == '02') {
                $days += $cendDayOfMonth >= 29 ? 30 : $cendDayOfMonth;
            } else if ($cendMonth == '02'){
                $days += $cendDayOfMonth >= 28 ? 30 : $cendDayOfMonth;
            } else {
                $days += $cendDayOfMonth >= 30 ? 30 : $cendDayOfMonth;
            }*/
            $diff = $cstart->diff($cend);
            $months = $diff->y * 12 + $diff->m;
            $days += floor(($diff->d + $months * 30 + $diff->h / 24));
            $thirties = ($days * 30);
            $test = ($diff->d)+1;

            if($days% 12 == 0) { $days = $days; }
            else if ($days% 12 == 2)$days = $days+1;
            else if ($days% 12 == 3)$days = $days+2;
            else if ($days% 12 == 4)$days = $days+1;
            else $days=$days+1;

        }
        //echo "Différence en trentièmes : " . $thirties . "";
        //echo "Différence en jours : " . $days . "";
        //echo "Différence en années, mois et jours : " . $diff->y . " ans, " . $diff->m . " mois, " . $test . " jours";
        return $days;

    }

    /**
     * Retourne le jour mois années d'un nmobre de jours
     * @return string
     */
    public function getJMA($jours): string
    {
        $annees = floor($jours / 360);
        $mois = floor(($jours % 360) / 30);
        $joursRestants = ($jours % 360) % 30;
        $resultat = '';
        if ($annees > 0) {
            $resultat .= $annees . ' an(s) ';
        }
        if ($mois > 0) {
            $resultat .= $mois . ' mois ';
        }
        if ($joursRestants > 0) {
            $resultat .= $joursRestants . ' jour(s)';
        }
        return $resultat;
    }


    /**
     * Calcul du nombre d'années reteneus
     * Nb jours entre date début et date de fin
     * @return int
     */
    public function getAR(): int
    {
        $totalYears = 0;
        $cstart = new \DateTimeImmutable();
        $cend = new \DateTimeImmutable();

        $cstart = ($this->startDate);
        $cend = ($this->endDate);
        $interval = $cend->diff($cstart);
        $totalYears = $interval->y;
        return $totalYears;
    }


    /**
     * Calcul du nombre de jour à prendre en compte
     * @return int
     */
    public function getJPC(): int
    {
        $jpc = 0;
        // on récupère les jours et annees retenus
        $joursRetenus = $this->getJR();
        $anneesRetenues = $this->getAR();
        // on récupère la catégorie de la workingPeriod à enregistrer
        $cat = $this->getCat();
        //on récupère la catégorie de l'employé
        $categorie = $this->getEmployeeId()->getCategorie();

        switch($categorie) {
            case "1": // Catégorie de l'employée : A
                switch ($cat) { // Catégorie des périodes à reprendre
                    case "A":
                        // Catégorie A - reprise A
                        if($anneesRetenues <= 12) {
                            $val = 0.5 * $joursRetenus;
                            $jpc = round($val, 0,PHP_ROUND_HALF_UP);
                        }
                        else {
                            $temp = $joursRetenus - 4320;
                            $jpc = 2160 + $temp*0.75;
                            $jpc = round($jpc, 0,PHP_ROUND_HALF_UP);
                        }
                        break;
                    case "B":
                        // Catégorie A - reprise B
                        if($anneesRetenues < 7) { $jpc = 0;}
                        elseif ( $anneesRetenues < 16) {
                            $temp = $joursRetenus - 2520; //2520 jours=7 ans
                            $jpc = floor((0.375 * $temp));
                        }
                        else  {
                            $temp = $joursRetenus - 5760; // 16 ans en jours
                            $jpc = ((9*6/16*360) + (($temp)*9/16));
                            $jpc = round($jpc,0,PHP_ROUND_HALF_DOWN);
                        }
                        break;
                    case "C":
                        // Catégorie A - reprise C
                        if($anneesRetenues < 10) { $jpc = 0;}
                        else {
                            $temp = $joursRetenus - 3600; // 10 ans
                            $jpc = 6/16 * $temp;
                        }
                        break;
                    case "P":
                        // Catégorie A - reprise privé
                        $jpc = 1/2 * $joursRetenus;
                        $max = 7*30*12; // maximum 7 ans
                        if ($jpc > $max) { $jpc = $max; }
                        break;
                }
            break;
            case "2": // Catégorie B
                switch ($cat) {
                    case "A":
                        // Catégorie B - reprise A
                        $jpc = 3/4 * $joursRetenus;
                        break;
                    case "B":
                        // Catégorie B - reprise B
                        $jpc = 3/4 * $joursRetenus;
                        break;
                    case "C" :
                        // Catégorie B, reprise C
                        $jpc = 1/2 * $joursRetenus;
                        break;
                    case "P" :
                        // Catégorie B, reprise privé
                        $jpc = 1/2 * $joursRetenus;
                        $max = 8*30*12; // maximum 8 ans
                        if ($jpc > $max) { $jpc = $max; }
                        break;

                }
            break;
            case "3": // Catégorie C
                switch ($cat) {
                    case 1:
                        $jpc = 0;
                        break;
                    case 2:
                        $jpc = 10;
                        break;
                    case 3:
                        $jpc = 100;
                        break;
                }
            break;
        }

      // Catégorie C, reprise A, B,C

        // Catégorie C, reprise privé

        return $jpc;
    }

    /**
     * Calcul du nombre de jours entre 2 dates
     * Calcul effectué selon la règle des trentièmes
     * (un mois dure 30 jours, une année 360 jours)
     * Prends en compte les années bissextiles lorsque la période débute où se termine par le mois de février
     *
     * @return int
     */
    public function getEffectiveDays(): int
    {

        $totalDays = 0;
        $timezone = \IntlTimeZone::createDefault();
        $cstart = new \DateTimeImmutable();
        $cend = new \DateTimeImmutable();
        //$cstart = new \IntlGregorianCalendar($timezone, 'fr_FR');
        //$cend = new \IntlGregorianCalendar($timezone, 'fr_FR');

        $cstart = ($this->startDate);
        $cend = ($this->endDate);

        $cstartDayOfMonth = $cstart->format('d');
        $cendDayOfMonth = $cend->format('d');

        $cstartMonth = $cstart->format('m');
        $cendMonth = $cend->format('m');

        $cstartYear = $cstart->format('Y');
        $cendYear = $cend->format('Y');

        // cas même mois de la même année
        if (($cstartYear == $cendYear) && ($cstartMonth == $cendMonth)) {
            //Mois de février
            if ($cend->format('L')==1 && $cendMonth == 2)  {
                $totalDays += ($cendDayOfMonth >= 29 ? 30 : $cendDayOfMonth)+1 - $cstartDayOfMonth;
            } else if ($cendMonth == 2){
                $totalDays += ($cendDayOfMonth >= 28 ? 30 : $cendDayOfMonth)+1 - $cstartDayOfMonth;
            } else {
                $totalDays += (min(30, $cendDayOfMonth)+1)-$cstartDayOfMonth;
            }
        }
        else {
            //debugger_print("------------------");
            date_default_timezone_set('Europe/Paris');
            $deb = new \DateTimeImmutable();
            //$deb = new \DateTime("dd/MM/yyy");
           // $deb->format($cstart->getTime());
            $end = new \DateTimeImmutable();
            //$end = new \DateTime("dd/MM/yyy");
            //$end->format($cend->getTime());
            //debugger_print("Calcul du $deb au $end");

            // calcul du reliquat en jours pour la période de départ
            // selon la règle des trentièmes, on compte ici 30 jours
            // même en février, année bissextile ou non.
            // Ainsi pour une période qui débute le 25/02,
            // le début de la période jusqu'au mois de mars, comptera 5 jours
            $totalDays += 31 - $cstartDayOfMonth;
            //debugger_print("Total Jours 1: $totalDays");

            // calcul du nombre de jours pour les mois intermédiaires
            $ctemp = new \DateTimeImmutable();
            $ctemp = $cend;
            $ctemp = $ctemp->createFromFormat('d',1); // On se place sur le 1er jour du mois
            //$ctemp->set(\IntlGregorianCalendar::FIELD_DAY_OF_MONTH, 1);
            $ctemp = $ctemp->modify('-1 month');
            //$ctemp->add(\IntlGregorianCalendar::FIELD_MONTH, -1);

            $current = $ctemp->format('Y') + $ctemp->format('m');
            $start = $cstartYear + $cstartMonth;
            //debugger_print("Current : $current / start : $start");
            while ($current > $start) {
                $totalDays += 30;
                $ctemp = $ctemp->modify('-1 month');
                $current = $ctemp->format('Y') + $ctemp->format('m');
                $start = $cstartYear + $cstartMonth;
               // debugger_print("Current : $current / start : $start");
            }

            //debugger_print("Total jour 2 : $totalDays");

            // calcul du reliquat en jours pour la période de fin
            // on distingue ici le cas de février où une période
            // qui se termine le 27 se verra ajouter 27 jours, alors que si elle
            // se termine le 28 une année non bissextile, se verra ajouter 30 jours.
            if ($cend->format('L')==1 && $cendMonth == 'FEBRUARY') {

                $totalDays += $cendDayOfMonth >= 29 ? 30 : $cendDayOfMonth;
            } elseif ($cendMonth == 'FEBRUARY') {
                $totalDays += $cendDayOfMonth >= 28 ? 30 : $cendDayOfMonth;
            } else {
                $totalDays += $cendDayOfMonth >= 30 ? 30 : $cendDayOfMonth;
            }
            //debugger_print("Total jours 3 : $totalDays");
        }
        return $totalDays;
    }

    /**
     * le nombre de jours pris en compte.
     * agent nommé sur un poste de catégorie C : proratisation en fonction de la base stagiaire mensuelle
     * agent nommé sur un poste A ou B : pas de proratisation
     *
     */
    public function getComputedDays(): float {
        if($this->getEmployeeId()->getCategorie() != 3) { // Catégorie C
            return $this->getEffectiveDays();
        }
        else {
            $potential = $this->hours / (($this->getEmployeeId()->getMonthBase() / 30 * $this->getEffectiveDays())) * $this->getEffectiveDays();
            $result = $potential > $this->getEffectiveDays() ? $potential : $this->getEffectiveDays();

            return $result;
        }
    }

}
