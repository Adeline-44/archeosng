<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\FloatType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $UID;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $adr1;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $adr2;

    #[ORM\Column(type: 'smallint')]
    private $categorie;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $city;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $cp;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $createdBy;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $firstName;

    #[ORM\Column(type: 'smallint')]
    private $genre;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 100)]
    private $lastName;

    #[ORM\Column(type: 'boolean')]
    private $militaire;

    #[ORM\Column(type: 'integer')]
    private $militaireDays;

    #[ORM\Column(type: 'float', options: ['default' =>151.67])]
    private $monthBase;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $poste;

    #[ORM\Column(type: 'float', options: ['default' => 35])]
    private $weekBase;

    #[ORM\Column(type: 'integer')]
    private $cadreEmploi;

    #[ORM\OneToMany(mappedBy: 'employee_id', targetEntity: WorkingPeriod::class)]
    private $workingPeriods;

    public function __construct()
    {
        $this->workingPeriods = new ArrayCollection();
        $this->monthBase = 151.67;
        $this->weekBase = 35;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUID(): ?string
    {
        return $this->UID;
    }

    public function setUID(?string $UID): self
    {
        $this->UID = $UID;

        return $this;
    }

    public function getAdr1(): ?string
    {
        return $this->adr1;
    }

    public function setAdr1(?string $adr1): self
    {
        $this->adr1 = $adr1;

        return $this;
    }

    public function getAdr2(): ?string
    {
        return $this->adr2;
    }

    public function setAdr2(?string $adr2): self
    {
        $this->adr2 = $adr2;

        return $this;
    }

    public function getCategorie(): ?int
    {
        return $this->categorie;
    }

    public function setCategorie(int $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(?string $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?string $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getGenre(): ?int
    {
        return $this->genre;
    }

    public function setGenre(int $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function isMilitaire(): ?bool
    {
        return $this->militaire;
    }

    public function setMilitaire(bool $militaire): self
    {
        $this->militaire = $militaire;

        return $this;
    }

    public function getmilitaireDays(): ?int
    {
        return $this->militaireDays;
    }

    public function setmilitaireDays(int $militaireDays): self
    {
        $this->militaireDays = $militaireDays;

        return $this;
    }

    public function getMonthBase(): ?float
    {
        return $this->monthBase;
    }

    public function setMonthBase(float $monthBase): self
    {
        $this->monthBase = $monthBase;

        return $this;
    }

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(?string $poste): self
    {
        $this->poste = $poste;

        return $this;
    }

    public function getWeekBase(): ?float
    {
        return $this->weekBase;
    }

    public function setWeekBase(float $weekBase): self
    {
        $this->weekBase = $weekBase;

        return $this;
    }

    public function getCadreEmploi(): ?int
    {
        return $this->cadreEmploi;
    }

    public function setCadreEmploi(int $cadreEmploi): self
    {
        $this->cadreEmploi = $cadreEmploi;

        return $this;
    }

   /* public static class Intervalle {
    private int $duree;
    private float $multiplicateur;
    private bool $last;

    public function Intervalle(int $duree, float $multiplicateur) {
        $this->duree = $duree;
        $this->multiplicateur = $multiplicateur;
        $this->last = false;
    }

    public function Intervalle(float $multiplicateur, bool $last) {
        $this->duree = 0;
        $this->multiplicateur = $multiplicateur;
        $this->last = $last;
    }

    public function getDuree(): int {
        return $this->duree;
    }

    public function getMultiplicateur(): float {
        return $this->multiplicateur;
    }

    public function isLast(): bool {
        return $this->last;
    }
}

private static ArrayList<Intervalle> grilleCSpc = new ArrayList<Intervalle>();
private static ArrayList<Intervalle> grilleCSpv = new ArrayList<Intervalle>();

static {
    // pour les grades C2 : grille pour les services publics
        grilleCSpc.add(new Intervalle(480, 0f));
		grilleCSpc.add(new Intervalle(480, 0.75f));
		grilleCSpc.add(new Intervalle(960, 0f));
		grilleCSpc.add(new Intervalle(960, 0.75f));
		grilleCSpc.add(new Intervalle(960, 0.75f));
		grilleCSpc.add(new Intervalle(960, 0.75f));
		grilleCSpc.add(new Intervalle(960, 0.75f));
		grilleCSpc.add(new Intervalle(1440, 0.5f));
		grilleCSpc.add(new Intervalle(1440, 0.5f));
		grilleCSpc.add(new Intervalle(1920, 0f));
		grilleCSpc.add(new Intervalle(1920, 0.375f));
		grilleCSpc.add(new Intervalle(0.75f, true));

		// pour les grades C2 : grille pour les services privés
		grilleCSpv.add(new Intervalle(720, 0f));
		grilleCSpv.add(new Intervalle(720, 0.5f));
		grilleCSpv.add(new Intervalle(1440, 0f));
		grilleCSpv.add(new Intervalle(1440, 0.5f));
		grilleCSpv.add(new Intervalle(1440, 0.5f));
		grilleCSpv.add(new Intervalle(1440, 0.5f));
		grilleCSpv.add(new Intervalle(1440, 0.5f));
		grilleCSpv.add(new Intervalle(2160, (1 / 3)));
		grilleCSpv.add(new Intervalle(2160, (1 / 3)));
		grilleCSpv.add(new Intervalle(0f, true));
	}
*/


    /**
     * @return Collection<int, WorkingPeriod>
     */
    public function getWorkingPeriods(): Collection
    {
        return $this->workingPeriods;
    }

    public function addWorkingPeriod(WorkingPeriod $workingPeriod): self
    {
        if (!$this->workingPeriods->contains($workingPeriod)) {
            $this->workingPeriods[] = $workingPeriod;
            $workingPeriod->setEmployeeId($this);
        }

        return $this;
    }

    public function removeWorkingPeriod(WorkingPeriod $workingPeriod): self
    {
        if ($this->workingPeriods->removeElement($workingPeriod)) {
            // set the owning side to null (unless already changed)
            if ($workingPeriod->getEmployeeId() === $this) {
                $workingPeriod->setEmployeeId(null);
            }
        }

        return $this;
    }

    /**
     * retourne un nombre jours sous la forme d'une chaine de caractères <p> si
     * le paramètre fullDisplay = TRUE, la forme adoptée sera: X années, X mois
     * et X jours <p> sinon, seule la somme des jours sera affichée : X jours
     * <p> le calcul part du postulat que chaque mois compte 30 jours
     */
    private function formatDays(int $numberOfDays, bool $fullDisplay): ?string {

		$result = "";
		if ($fullDisplay) {
			$totalDays = $numberOfDays;
			$years = $totalDays / 360;
			$totalDays %= 360;
			$months = $totalDays / 30;
			$totalDays %= 30;
			// $sb est la chaine de sortie
			$sb = "";
			if ($numberOfDays == 0) {
				$sb .= "0 jour";
			} else {
                if ($years > 0)
                    $sb .= ($years." an".($years > 1 ? "s" : ""));
                if ($months > 0)
                    $sb .= " ".($years > 0 ? ($totalDays > 0 ? ", " : "et ") : "").$months." mois";
                if ($totalDays > 0)
                    $sb .= ((($years > 0 || $months > 0) ? " et " : " ").$totalDays ." jour".($totalDays > 1 ? "s" : ""));
            }
        $result = $sb;
        }
		else {
            $result = ($numberOfDays > 0) ? $numberOfDays." jours" : $numberOfDays." jour";
        }
    return $result;
    }

    /**
     * <p> Retourne la sommes des jours pris en compte pour l'ensemble des
     * périodes de travail effectuées du type (public ou privé) passé en
     * paramamètre. <p> Cette somme est arrondie à l'entier inférieur
     *
     * @param type
     *            WorkingPeriod.TYPE_SERVICE_PUBLIC ou
     *            WorkingPeriod.TYPE_SERVICE_PRIVE
     * @return le nombre total de jours pris en compte
     */
    /*private function getTotalDays(int $type): int {
		$total = 0;
		$wp = $this->workingPeriods;
		for($wp : $this->getWorkingPeriods($type))
		for (WorkingPeriod wp : getWorkingPeriods($type)) {
			$total += wp.getComputedDays();
		}
    return (int) Math.floor(total);
    }*/

}
