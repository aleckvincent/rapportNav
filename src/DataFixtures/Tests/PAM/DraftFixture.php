<?php

namespace App\DataFixtures\Tests\PAM;

use App\Entity\Agent;
use App\Entity\FonctionAgent;
use App\Entity\PAM\CategoryPamIndicateur;
use App\Entity\PAM\CategoryPamMission;
use App\Entity\PAM\PamDraft;
use App\Entity\PAM\PamEquipage;
use App\Entity\PAM\PamEquipageAgent;
use App\Entity\PAM\PamIndicateur;
use App\Entity\PAM\PamMission;
use App\Entity\PAM\PamRapportId;
use App\Entity\Service;
use App\Request\PAM\DraftRequest;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Symfony\Component\Serializer\SerializerInterface;

class DraftFixture extends Fixture implements FixtureGroupInterface {

    protected $serializer;

    public function __construct(SerializerInterface $serializer) {
        $this->serializer = $serializer;
    }

    public static function getGroups(): array {
        return ['test'];
    }

    public function load(ObjectManager $manager)
    {
        $twoMonthsAgo = new \DateTime('-2 months');
        $oneMonthAgo = new \DateTime('-1 month');

        $this->generate($manager, $twoMonthsAgo, 4);
        $this->generate($manager, $oneMonthAgo, 5);

        $manager->flush();
    }


    /**
     * @param ObjectManager $manager
     * @param \DateTime     $startDateTime
     *
     * @return void
     */
    private function generate(ObjectManager $manager, \DateTime $startDateTime, int $keyID)
    {
        $id = 'MED-' . $startDateTime->format('Y') . '-' . $keyID;
        $draft = new PamDraft();
        $service = $manager->getRepository(Service::class)->findOneBy(['nom' => 'PAM_test']);

        $body = new DraftRequest();
        $body->setStartDatetime($startDateTime);
        $body->setNbJoursMer(14);
        $body->setMouillage(1);

        $agent = new Agent();
        $agent->setNom('Doe');
        $agent->setPrenom('John');
        $agent->setService($service);
        $agent->setDateArrivee(\DateTimeImmutable::createFromMutable($startDateTime));

        $fonction = new FonctionAgent();
        $fonction->setNom('Agent de test');
        $membre = new PamEquipageAgent();
        $membre->setAgent($agent);
        $membre->setFonction($fonction);
        $equipage = new PamEquipage();
        $equipage->addMembre($membre);
        $body->setEquipage($equipage);

        $catMissions = $manager->getRepository(CategoryPamMission::class)->findAll();
        $catIndicateurs = $manager->getRepository(CategoryPamIndicateur::class)->findAll();
        $mission = new PamMission();
        $mission->setCategory($catMissions[0]);
        $mission->setChecked(true);

        for($i = 1; $i <= 10; $i++) {
            $indicateur = new PamIndicateur();
            $indicateur->setPrincipale(44);
            $indicateur->setSecondaire(8);
            $indicateur->setTotal(52);
            $indicateur->setObservations('Test observation');
            $indicateur->setCategory($catIndicateurs[$i]);
            $mission->addIndicateur($indicateur);
        }

        $body->addMission($mission);
        $body->setStartDatetime($startDateTime);
        $json = $this->serializer->serialize($body, 'json', ['groups' => 'draft']);

        $draft->setBody($json);
        $draft->setNumber($id);
        $draft->setStartDatetime($startDateTime);
        $draft->setCreatedBy($service);

        $rapportID = new PamRapportId();
        $rapportID->setId($id);

        $manager->persist($draft);
        $manager->persist($rapportID);
    }
}
