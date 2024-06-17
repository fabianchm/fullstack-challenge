<?php

declare(strict_types=1);

namespace Tests\Acceptance\Behat;

use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class DemoContext extends RawMinkContext
{
    /** @var KernelInterface */
    private $kernel;

    /** @var Response|null */
    private $response;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @When a demo scenario sends a request to :path
     */
    public function aDemoScenarioSendsARequestTo(string $path): void
    {
        $this->response = $this->kernel->handle(Request::create($path, 'GET'));
    }

    /**
     * @Then the response should be received
     */
    public function theResponseShouldBeReceived(): void
    {
        if ($this->response === null) {
            throw new \RuntimeException('No response received');
        }
    }

    /**
     * @Given I send a PUT request to :arg1 with body:
     */
    public function iSendAPutRequestToWithBody($arg1, PyStringNode $string)
    {
        $this->response = $this->kernel->handle(Request::create($arg1, 'PUT', ["content" => $string->getRaw()]));
    }

    /**
     * @Given the response status code should be :arg1
     */
    public function theResponseStatusCodeShouldBe($arg1)
    {
        Assert::assertTrue($this->response->getStatusCode() === intval($arg1));
    }

    /**
     * @Given the response should be empty
     */
    public function theResponseShouldBeEmpty()
    {
        Assert::isNull($this->response->getContent());
    }

    /**
     * @When I send a POST request to :arg1 with body:
     */
    public function iSendAPostRequestToWithBody($arg1, PyStringNode $string)
    {
        $this->response = $this->kernel->handle(Request::create($arg1, 'POST', ["content" => $string->getRaw()]));
    }

    /**
     * @Given I send a PUT request to :arg1
     */
    public function iSendAPutRequestTo($arg1)
    {
        $this->response = $this->kernel->handle(Request::create($arg1, 'PUT'));
    }

    /**
     * @When I send a PATCH request to :arg1 with body:
     */
    public function iSendAPatchRequestToWithBody($arg1, PyStringNode $string)
    {
        $this->response = $this->kernel->handle(Request::create($arg1, 'PATCH', ["content" => $string->getRaw()]));
    }

    /**
     * @Given I send a DELETE request to :arg1
     */
    public function iSendADeleteRequestTo($arg1)
    {
        $this->response = $this->kernel->handle(Request::create($arg1, 'DELETE'));
    }

    /**
     * @Given I send a PATCH request to :arg1
     */
    public function iSendAPatchRequestTo($arg1)
    {
        $this->response = $this->kernel->handle(Request::create($arg1, 'PATCH'));
    }

    /**
     * @When I send a GET request to :arg1
     */
    public function iSendAGetRequestTo($arg1)
    {
        $this->response = $this->kernel->handle(Request::create($arg1, 'GET'));
    }

    /**
     * @Then the response body should be:
     */
    public function theResponseBodyShouldBe(PyStringNode $string)
    {
        Assert::isTrue($this->response->getContent() === json_decode($string->getRaw(), true));
    }

}
