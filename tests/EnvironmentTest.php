<?php
namespace Dsc\MercadoLivre;

use Dsc\MercadoLivre\Environments\Production;
use Dsc\MercadoLivre\Environments\Site;
use Dsc\MercadoLivre\Environments\Test;

/**
 * @author Diego Wagner <diegowagner4@gmail.com>
 */
class EnvironmentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Environment
     */
    private $environment;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->environment = $this->getMockForAbstractClass(Environment::class);

        $this->environment->expects($this->any())
             ->method('getWsAuth')
             ->willReturn('ws.auth.test.com');

        $this->environment->expects($this->any())
             ->method('getWsHost')
             ->willReturn('ws.test.com');

        $this->environment->expects($this->any())
             ->method('getOAuthUri')
             ->willReturn('/oauth');
    }

    /**
     * @test
     */
    public function returnCorrectSite()
    {
        $this->assertAttributeEquals(Site::BRASIL, 'site', $this->environment);
    }

    /**
     * @test
     */
    public function returnCorrectConfiguration()
    {
        $configuration = $this->environment->getConfiguration();
        $this->assertInstanceOf(Configuration::class, $configuration);
    }

    /**
     * @test
     */
    public function returnCorrectWSUrlWhenHostIsProduction()
    {
        $url = $this->environment->getWsUrl('/resource');
        $this->assertEquals('ws.test.com/resource', $url);
    }

    /**
     * @test
     */
    public function returnCorrectAuthUrlWhenHostIsProduction()
    {
        $url = $this->environment->getAuthUrl('/auth');
        $this->assertEquals('ws.auth.test.com/auth', $url);
    }

    /**
     * @test
     */
    public function returnCorrectOAuthUrlWhenHostIsProduction()
    {
        $url = $this->environment->getOAuthUri();
        $this->assertEquals('/oauth', $url);
    }

    /**
     * @test
     */
    public function returnCorrectOAuthUrlWhenHostIsTest()
    {
        $url = $this->environment->getOAuthUri();
        $this->assertEquals('/oauth', $url);
    }

    /**
     * @test
     */
    public function isValidShouldReturnTrueWhenHostIsProduction()
    {
        $this->assertTrue(Environment::isWsHostValid(Production::WS_HOST));
    }

    /**
     * @test
     */
    public function isValidShouldReturnTrueWhenHostIsTest()
    {
        $this->assertTrue(Environment::isWsHostValid(Test::WS_HOST));
    }

    /**
     * @test
     */
    public function isValidShouldReturnTrueWhenRegionExistsInEnvironments()
    {
        $this->assertTrue(Environment::isWsAuthValid("MLB"));
    }

    /**
     * @test
     */
    public function isValidShouldReturnFalseWhenRegionNotExistsInEnvironments()
    {
        $this->assertFalse(Environment::isWsAuthValid("AAA"));
    }
}