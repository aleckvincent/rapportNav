<?php

namespace App\Tests\Functional\Controller\PAM;

use App\DataFixtures\Tests\PAM\ControleTypeFixture;
use App\DataFixtures\Tests\PAM\IndicateurTypeFixture;
use App\DataFixtures\Tests\PAM\MissionTypeFixture;
use App\DataFixtures\Tests\PAM\RapportFixture;
use App\DataFixtures\Tests\ServicesFixture;
use App\DataFixtures\Tests\UsersFixture;
use App\Entity\PAM\PamRapport;
use App\Repository\PAM\PamRapportRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RapportControllerTest extends WebTestCase {

    use FixturesTrait;

    private $client;

    protected function setUp(): void {
        $this->loadFixtures([
            UsersFixture::class,
            MissionTypeFixture::class,
            IndicateurTypeFixture::class,
            ControleTypeFixture::class,
            RapportFixture::class,
        ]);

        $this->client = static::createClient([], [
            'PHP_AUTH_USER' => 'alfred.de-musset',
            'PHP_AUTH_PW'   => '1234',
        ]);

        self::bootKernel();
    }

    public function testRapportSaveSuccess()
    {
        $json = $this->jsonReader('body-test-rapport-success.json');
        $this->sendRequest('/rapport', $json);
        $container = self::$container;
        $serializer = $container->get('serializer');
        $rapportResponse = $serializer->deserialize($this->client->getResponse()->getContent(), PamRapport::class, 'json');
       // dd($this->client->getResponse());
        $rapport = $container->get(PamRapportRepository::class)->find($rapportResponse->getId());

        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
        $this->assertStringContainsString('MED' , $rapportResponse->getId());
        $this->assertNotNull($rapport);
    }

    public function testRapportMissingMandatoryInfo400Error()
    {
        $json = $this->jsonReader('body-test-rapport-missing-mandatory-info.json');
        $this->sendRequest('/rapport', $json);

        $this->assertEquals(400, $this->client->getResponse()->getStatusCode());
    }

    public function testRapportUpdateInformationsGeneralesSuccess()
    {
        $currentYear = new \DateTime();
        $container = self::$container;

        $id = 'MED-' . $currentYear->format('Y') . '-1';

        $json = $this->jsonReader('body-test-rapport-update-informationsGenerales-success.json');
        $this->sendRequest('/rapport/' . $id, $json, 'PUT');


        /** @var PamRapport $updatedRapport */
        $updatedRapport = $container->get(PamRapportRepository::class)->find($id);


        $this->assertEquals(14, $updatedRapport->getMouillage());
        $this->assertEquals(1234, $updatedRapport->getAdministratif());
        $this->assertEquals($id, $updatedRapport->getId());
    }

    public function testRapportUpdateControlesSuccess()
    {
        $currentYear = new \DateTime();
        $container = self::$container;

        $id = 'MED-' . $currentYear->format('Y') . '-1';

        $json = $this->jsonReader('body-test-rapport-update-controles-success.json');
        $this->sendRequest('/rapport/' . $id, $json, 'PUT');

        /** @var PamRapport $updatedRapport */
        $updatedRapport = $container->get(PamRapportRepository::class)->find($id);


        $this->assertEquals(7, $updatedRapport->getControles()[0]->getNbNavireControle());
        $this->assertEquals(3, $updatedRapport->getControles()[0]->getNbPvPecheSanitaire());
        $this->assertEquals('ES', $updatedRapport->getControles()[0]->getPavillon());
        $this->assertEquals($id, $updatedRapport->getId());

    }

    public function testRapportUpdateMissionsSuccess()
    {
        $currentYear = new \DateTime();
        $container = self::$container;

        $id = 'MED-' . $currentYear->format('Y') . '-1';

        $json = $this->jsonReader('body-test-rapport-update-missions-success.json');
        $this->sendRequest('/rapport/' . $id, $json, 'PUT');

        /** @var PamRapport $updatedRapport */
        $updatedRapport = $container->get(PamRapportRepository::class)->find($id);


        $this->assertFalse($updatedRapport->getMissions()[0]->isChecked());
        $this->assertEquals(8, $updatedRapport->getMissions()[0]->getIndicateurs()[0]->getPrincipale());
        $this->assertEquals(4, $updatedRapport->getMissions()[0]->getIndicateurs()[0]->getSecondaire());
        $this->assertEquals(12, $updatedRapport->getMissions()[0]->getIndicateurs()[0]->getTotal());
        $this->assertCount(1, $updatedRapport->getMissions());
        $this->assertEquals($id, $updatedRapport->getId());
    }


    private function sendRequest(string $url, string $body, $method = 'POST')
    {
        $this->client->request(
            $method,
            '/api/pam' . $url,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $body
        );
    }


    private function jsonReader(string $fileName): string
    {
        $path = __DIR__ . '/dist/' . $fileName;
        $file = fopen($path, "r") or die("Unable to open file!");
        $json = (fread($file, filesize($path)));
        fclose($file);

        return$json;
    }

}
