<?php
/**
 * Created by IntelliJ IDEA.
 * User: Georg
 * Date: 20.10.2015
 * Time: 19:08
 */

namespace Tests;


use Catrobat\AppBundle\Twig\AppExtension;
use Prophecy\Prophet;

class AppExtentionTest extends \PHPUnit_Framework_TestCase
{
    private $prophet;


    private $translationPath = __DIR__ . '/Resources/translations';

    protected function setup()
    {
        parent::setUp();
        $this->prophet = new Prophet();
    }


    /**
     * @test
     */
    public function arrayMustContainFourLanguages()
    {
        $short = "de";

        $appExtention = $this->createAppExtension($short);
        $list = $appExtention->getLanguageOptionsFromPath($this->translationPath);
        $this->assertEquals(count($list), 5);

        $this->assertTrue($this->inArray('Deutsch', $list));
        $this->assertTrue($this->inArray('English', $list));
        $this->assertTrue($this->inArray('italiano', $list));
        $this->assertTrue($this->inArray('polski', $list));
        $this->assertTrue($this->inArray('English (Canada)', $list));
        $this->assertTrue($this->isSelected($short, $list));
    }


    /**
     * @test
     */
    public function englishMustBeSelected()
    {
        $short = "en";
        $notShort = "de";

        $appExtention = $this->createAppExtension($short);
        $list = $appExtention->getLanguageOptionsFromPath($this->translationPath);

        $this->assertTrue($this->isSelected($short, $list));
        $this->assertFalse($this->isSelected($notShort, $list));
    }

    /**
     * @test
     */
    public function englishCanadaMustBeSelected()
    {
        $short = "en_CA";
        $notShort = "en";

        $appExtention = $this->createAppExtension($short);
        $list = $appExtention->getLanguageOptionsFromPath($this->translationPath);

        $this->assertTrue($this->isSelected($short, $list));
        $this->assertFalse($this->isSelected($notShort, $list));
    }


    private function mockReqeustStack($locale)
    {
        $requestStack = $this->prophet->prophesize('Symfony\Component\HttpFoundation\RequestStack');

        $request = $this->prophet->prophesize('Symfony\Component\HttpFoundation\Request');

        $requestStack->getCurrentRequest()->willReturn($request);

        $request->getLocale()->willReturn($locale);

        return $requestStack;
    }


    private function createAppExtension($locale)
    {
        $repo = $this->mockMediaPackageFileRepository();
        $requestStack = $this->mockReqeustStack($locale);
        return new AppExtension($requestStack->reveal(), $repo->reveal());
    }

    private function mockMediaPackageFileRepository()
    {
        return $this->prophet->prophesize('Catrobat\AppBundle\Services\MediaPackageFileRepository');
    }


    private function inArray($needle, $haystack)
    {
        foreach ($haystack as $value) {

            if (strcmp($needle, $value[1]) === 0) {
                return true;
            }

        }
        return false;
    }

    private function isSelected($short, $locales)
    {
        foreach ($locales as $value) {

            if (strcmp($short, $value[0]) === 0 && strcmp("1", $value[2]) === 0) {
                return true;
            }
        }
        return false;
    }
}