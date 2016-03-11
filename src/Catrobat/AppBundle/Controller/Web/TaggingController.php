<?php

namespace Catrobat\AppBundle\Controller\Web;

use Catrobat\AppBundle\Entity\Program;
use Catrobat\AppBundle\Entity\ProgramInappropriateReport;
use Catrobat\AppBundle\Entity\ProgramManager;
use Catrobat\AppBundle\Entity\Tag;
use Catrobat\AppBundle\Entity\User;
use Catrobat\AppBundle\StatusCode;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Catrobat\AppBundle\Services\FeaturedImageRepository;
use Catrobat\AppBundle\Entity\FeaturedRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Intl\Intl;

class TaggingController extends Controller
{

  /**
   * @Route("/tagging", name="tags")
   * @Method({"GET"})
   */
  public function taggingAction(Request $request)
  {
      /**
       * @var $program_manager ProgramManager
       * @var $program Program
       */
      $program_manager = $this->get('programmanager');
      $em = $this->getDoctrine()->getEntityManager();

      $program = $program_manager->find(1);
      $program2 = $program_manager->find(2);

      $tag = new Tag();
      $tag->setEn("trololol");
      $tag->setDe("trololol");
      $tag->setIt("trololol");
      $tag->setFr("trololol");

      $tag->addProgram($program2);
      $em->persist($tag);
      $em->flush();

      $program->addTag($tag);


      $em->persist($program);
      $em->flush();

      $test = $program->getTags();

      return $this->get('templating')->renderResponse('::test.html.twig', array('test'=>$test->first()));
  }

}
