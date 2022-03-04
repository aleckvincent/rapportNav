<?php

namespace App\DataFixtures\Tests\PAM;

use App\Entity\FonctionAgent;
use App\Entity\FonctionParticuliereAgent;
use App\Entity\PAM\CategoryPamControle;
use App\Entity\PAM\CategoryPamIndicateur;
use App\Entity\PAM\CategoryPamMission;
use App\Entity\PAM\PamControle;
use App\Entity\PAM\PamEquipage;
use App\Entity\PAM\PamEquipageAgent;
use App\Entity\PAM\PamIndicateur;
use App\Entity\PAM\PamMission;
use App\Entity\PAM\PamRapport;
use App\Entity\PAM\PamRapportId;
use App\Entity\Agent;
use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RapportFixture extends Fixture implements FixtureGroupInterface, OrderedFixtureInterface {

    public static function getGroups(): array {
        return ['test'];
    }

    public function load(ObjectManager $manager)
    {
        $fonction = new FonctionAgent();
        $fonctionParticuliere = new FonctionParticuliereAgent();
        $fonction->setNom('Commandant');
        $fonctionParticuliere->setNom('Chef');
        $manager->persist($fonction);
        $manager->persist($fonctionParticuliere);

        $startYear2020 = new \DateTimeImmutable('2020-04-02');
        $endYear2020 = $startYear2020->add(new \DateInterval('P20D'));

        $startYear2021_first = new \DateTimeImmutable('2021-05-03');
        $endYear2021_first = $startYear2021_first->add(new \DateInterval('P20D'));

        $startYear2021_second = new \DateTimeImmutable('2021-08-03');
        $endYear2021_second = $startYear2021_second->add(new \DateInterval('P20D'));

        $startFiveMonthsAgo = new \DateTimeImmutable("-5 months");
        $endFiveMonthsAgo = $startFiveMonthsAgo->add(new \DateInterval('P20D'));

        $this->createRapport($manager, $startYear2020, $endYear2020, $fonction, $fonctionParticuliere, 1);
        $this->createRapport($manager, $startYear2021_first, $endYear2021_first, $fonction, $fonctionParticuliere, 1);
        $this->createRapport($manager, $startYear2021_second, $endYear2021_second, $fonction, $fonctionParticuliere, 2);
        $this->createRapport($manager, $startFiveMonthsAgo, $endFiveMonthsAgo, $fonction, $fonctionParticuliere, 3);
    }

    private function createRapport(ObjectManager $manager, \DateTimeImmutable $startDateTime,
                                   \DateTimeImmutable $endDateTime, FonctionAgent $fonction,
                                   FonctionParticuliereAgent $fonctionParticuliere, int $keyID)
    {
        $service = $manager->getRepository(Service::class)->findOneBy(['nom' => 'PAM_test']);
        if(!$service) {
            $service = new Service();
            $service->setNom('PAM_test');
            $manager->persist($service);
        }

        $rapport = new PamRapport();

        $rapport->setDistance(41)
            ->setNbJoursMer(41)
            ->setEssence(41)
            ->setAdministratif(41)
            ->setPersonnel(41)
            ->setContrPort(41)
            ->setGoMarine(41)
            ->setTechnique(41)
            ->setRepresentation(41)
            ->setNavEff(41)
            ->setMouillage(41)
            ->setMeteo(41)
            ->setMaintenance(41)
            ->setStartDatetime($startDateTime)
            ->setEndDatetime($endDateTime);

        $catControles = $manager->getRepository(CategoryPamControle::class)->findAll();
        $catIndicateurs = $manager->getRepository(CategoryPamIndicateur::class)->findAll();

        $controle = new PamControle();
        $controle->setPavillon('FR');
        $controle->setNbNavDeroute(2);
        $controle->setCategory($catControles[0]);

        $catMissions = $manager->getRepository(CategoryPamMission::class)->findAll();
        $mission = new PamMission();
        $mission->setCategory($catMissions[0]);
        $mission->setChecked(true);

        for($i = 1; $i <= 10; $i++) {
            $indicateur = new PamIndicateur();
            $indicateur->setPrincipale(10);
            $indicateur->setSecondaire(22);
            $indicateur->setTotal(32);
            $indicateur->setObservations('Test observation');
            $indicateur->setCategory($catIndicateurs[$i]);
            $mission->addIndicateur($indicateur);
        }

        $equipage = new PamEquipage();

        $agent = new Agent();
        $agent->setNom('Colas')
            ->setPrenom('Robert')
            ->setDateArrivee($startDateTime);

        $membre = new PamEquipageAgent();

        $membre->setAgent($agent);
        $membre->setFonction($fonction);
        $membre->setFonctionParticuliere($fonctionParticuliere);

        $equipage->addMembre($membre);

        $rapport->setEquipage($equipage);
        $rapport->addControle($controle);
        $rapport->addMission($mission);



        $rapport->setId('MED-' . $startDateTime->format('Y') . '-' . $keyID);
        $rapport->setCreatedBy($service);

        $rapportID = new PamRapportId();

        $rapportID->setId($rapport->getId());

        $manager->persist($rapportID);
        $manager->persist($rapport);
        $manager->flush();
    }

    public function getOrder() {
        return 4;
    }
}
