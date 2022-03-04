<?php

namespace App\Tests\Functional\Controller\PAM;

use App\DataFixtures\Tests\PAM\ControleTypeFixture;
use App\DataFixtures\Tests\PAM\DraftFixture;
use App\DataFixtures\Tests\PAM\IndicateurTypeFixture;
use App\DataFixtures\Tests\PAM\MissionTypeFixture;
use App\DataFixtures\Tests\PAM\RapportFixture;
use App\DataFixtures\Tests\UsersFixture;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FiltreRapportTest extends WebTestCase {

    use FixturesTrait;

    private $client;

    protected function setUp(): void {
        $this->loadFixtures([
            UsersFixture::class,
            MissionTypeFixture::class,
            IndicateurTypeFixture::class,
            ControleTypeFixture::class,
            RapportFixture::class,
            DraftFixture::class
        ]);

        $this->client = static::createClient([], [
            'PHP_AUTH_USER' => 'alfred.de-musset',
            'PHP_AUTH_PW'   => '1234',
        ]);

        self::bootKernel();
    }

    public function testStatusBrouillon()
    {
        $this->sendRequest('?statut=brouillon');
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(200);
        $this->assertCount(2, $response);
    }

    public function testStatusValide()
    {
        $this->sendRequest('?statut=valide');
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(200);
        $this->assertCount(4, $response);
    }

    public function testStatusAll()
    {
        $this->sendRequest();
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(200);
        $this->assertCount(6, $response);
    }

    public function testMoisEnCours()
    {
        $this->sendRequest('?periode=current');
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(200);
        $this->assertCount(0, $response);
    }

    public function test6DerniersMois()
    {
        $this->sendRequest('?periode=6months');
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(200);
        $this->assertCount(3, $response);
    }

    public function testAnnee2021()
    {
        $this->sendRequest('?periode=annee_2021');
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(200);
        $this->assertCount(3, $response);
    }

    public function testAnnee2020()
    {
        $this->sendRequest('?periode=annee_2020');
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(200);
        $this->assertCount(1, $response);

    }

    public function testMonEquipe()
    {
        $this->sendRequest('?serviceName=PAM_test');
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(200);
        $this->assertCount(6, $response);
    }

    public function testToutesEquipes()
    {
        $this->sendRequest('?serviceName=all');
        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(200);
        $this->assertCount(6, $response);
    }


    private function sendRequest(?string $query = null)
    {
        $this->client->request(
            'GET',
            '/api/pam/rapport/filtre' . $query
        );
    }

}
