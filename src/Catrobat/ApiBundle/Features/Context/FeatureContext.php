<?php

namespace Catrobat\ApiBundle\Features\Context;

use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Behat\MinkExtension\Context\MinkContext;

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Catrobat\CatrowebBundle\Entity\User;
use Catrobat\CatrowebBundle\Entity\Project;
use Behat\Behat\Event\SuiteEvent;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

//
// Require 3rd-party libraries here:
//
require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Feature context.
 */
class FeatureContext extends BehatContext //MinkContext if you want to test web
                  implements KernelAwareInterface
{
    private $kernel;
    private $parameters;

    private $user;
    private $request_parameters;
    
    private $files;
    
    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
        $this->request_parameters = array();
        $this->files = array();
    }

    /**
     * Sets HttpKernel instance.
     * This method will be automatically called by Symfony2Extension ContextInitializer.
     *
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @Given /^there are users:$/
     */
    public function thereAreUsers(TableNode $table)
    {
    	$users = $table->getHash();
    	for ($i = 0; $i < count($users); $i++)
    	{
	    	$user = new User();
	    	$user->setUsername($users[$i]["name"]);
	    	$user->setEmail("dev".$i."@pocketcode.org");
	    	$user->setPlainPassword($users[$i]["password"]);
	    	$user->setEnabled(true);
	    	$user->setToken($users[$i]["token"]);
    		$this->kernel->getContainer()->get('doctrine')->getManager()->persist($user);
    	}
    	$this->kernel->getContainer()->get('doctrine')->getManager()->flush();
    }
    
    /**
     * @Given /^there are projects:$/
     */
    public function thereAreProjects(TableNode $table)
    {
    	$em = $this->kernel->getContainer()->get('doctrine')->getManager();
    	$projects = $table->getHash();
    	for ($i = 0; $i < count($projects); $i++)
    	{
    		$user = $em->getRepository('CatrowebBundle:User')->findOneBy(array('username' => 'Catrobat'));
				$project = new Project();
				$project->setUser($user);
				$project->setName($projects[$i]['name']);
				$project->setDescription($projects[$i]['description']);
				$project->setFilename("file".$i.".catrobat");
				$project->setThumbnail("thumb.png");
				$project->setScreenshot("screenshot.png");
				$em->persist($project);
    	}
    	$em->flush();
    }
    
    /**
     * @Given /^I have a parameter "([^"]*)" with value "([^"]*)"$/
     */
    public function iHaveAParameterWithValue($name, $value)
    {
      $this->request_parameters[$name] = $value;
    }
    
    /**
     * @When /^I POST these parameters to "([^"]*)"$/
     */
    public function iPostTheseParametersTo($url)
    {
      $this->client = $this->kernel->getContainer()->get('test.client');
    	$crawler = $this->client->request('POST', $url, $this->request_parameters, $this->files);
    }
    
    /**
     * @Given /^I am "([^"]*)"$/
     */
    public function iAm($username)
    {
    	$this->user = $username;
    }
    
    /**
     * @When /^I call "([^"]*)" with token "([^"]*)"$/
     */
    public function iCallWithToken($url, $token)
    {
      $this->client = $this->kernel->getContainer()->get('test.client');
      $params = array("token" => $token, "username" => $this->user); 
    	$crawler = $this->client->request('POST', $url, $params);
    }
    
    /**
     * @Then /^I should see:$/
     */
    public function iShouldSee(PyStringNode $string)
    {
    	$response = $this->client->getResponse();
    	assertEquals($string->getRaw(), $response->getContent());
    }
    
    /**
     * @Then /^I should get the json object with random token:$/
     */
    public function iShouldGetTheJsonObjectWithRandomToken(PyStringNode $string)
    {
      $response = $this->client->getResponse();
      $responseArray = json_decode($response->getContent(),true);
      $expectedArray = json_decode($string->getRaw(),true);
      $responseArray['token'] = "";
      $expectedArray['token'] = "";
      assertEquals($expectedArray, $responseArray);
    }
    
    
    /**
     * @Given /^the response code should be "([^"]*)"$/
     */
    public function theResponseCodeShouldBe($code)
    {
    	$response = $this->client->getResponse();
    	assertEquals($code, $response->getStatusCode(), "Wrong response code");
    }
    
    
    /**
     * @Given /^I am not registered$/
     */
    public function iAmNotRegistered()
    {
    	throw new PendingException();
    }
    
    /**
     * @Given /^I have a username "([^"]*)"$/
     */
    public function iHaveAUsername($arg1)
    {
      //just a test input
    	throw new PendingException();
    }
    
    /**
     * @Given /^I have a password "([^"]*)"$/
     */
    public function iHaveAPassword($arg1)
    {
    	throw new PendingException();
    }
    
    /**
     * @Given /^I have a language "([^"]*)"$/
     */
    public function iHaveALanguage($arg1)
    {
    	throw new PendingException();
    }
    
    /**
     * @Given /^I have an email address "([^"]*)"$/
     */
    public function iHaveAnEmailAddress($arg1)
    {
    	throw new PendingException();
    }
    
    /**
     * @When /^I call "([^"]*)" the given data$/
     */
    public function iCallTheGivenData($arg1)
    {
    	throw new PendingException();
    }
    
    /**
     * @When /^I call "([^"]*)" with username "([^"]*)" and password "([^"]*)"$/
     */
    public function iCallWithUsernameAndPassword($arg1, $arg2, $arg3)
    {
    	throw new PendingException();
    }
    
    /**
     * @Given /^I have the username "([^"]*)"$/
     */
    public function iHaveTheUsername($arg1)
    {
    	throw new PendingException();
    }
    
    /**
     * @Given /^I have a token "([^"]*)"$/
     */
    public function iHaveAToken($arg1)
    {
    	throw new PendingException();
    }
    
    /**
     * @Given /^I have a file "([^"]*)"$/
     */
    public function iHaveAFile($filename)
    {
      $filepath = "./src/Catrobat/ApiBundle/Features/Fixtures/".$filename;
      assertTrue(file_exists($filepath),"File not found");
      $this->files[] = new UploadedFile($filepath,$filename);
    }
    
    /**
     * @Given /^I have a parameter "([^"]*)" with the md5checksum of "([^"]*)"$/
     */
    public function iHaveAParameterWithTheMdchecksumOf($parameter, $file)
    {
      $this->request_parameters[$parameter] = md5_file($this->files[0]->getPathname()); 
    }
    
    /**
     * @When /^I call "([^"]*)" with the given data$/
     */
    public function iCallWithTheGivenData($arg1)
    {
    	throw new PendingException();
    }
    
    /**
     * @Given /^I want to search for the term "([^"]*)"$/
     */
    public function iWantToSearchForTheTerm($arg1)
    {
    	throw new PendingException();
    }
    
    /**
     * @Given /^I have the limit "([^"]*)"$/
     */
    public function iHaveTheLimit($arg1)
    {
    	throw new PendingException();
    }
    
    /**
     * @Given /^I have the offset "([^"]*)"$/
     */
    public function iHaveTheOffset($arg1)
    {
    	throw new PendingException();
    }
    
    
}