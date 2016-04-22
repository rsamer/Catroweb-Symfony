<?php
/**
 * Created by PhpStorm.
 * User: eric
 * Date: 20.03.16
 * Time: 17:28
 */

namespace Catrobat\AppBundle\Controller\Admin;

use Catrobat\AppBundle\Entity\User;
use Catrobat\AppBundle\Entity\UserManager;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends CRUDController
{
  public function listAction(Request $request = null)
  {
    $program_comments = $this->getDoctrine()
      ->getRepository('AppBundle:UserComment')
      ->findAll();

    $program_details = array(
      'comments' => $program_comments,
      'commentsLength' =>  count($program_comments));

    return $this->render(':Admin:comment_report.html.twig', array(
      'program_details' => $program_details));
  }

  public function deleteCommentAction(Request $request = null)
  {
    $em = $this->getDoctrine()->getManager();
    $comment = $em->getRepository('AppBundle:UserComment')->find($_GET['CommentId']);

    if (!$comment) {
      throw $this->createNotFoundException(
        'No comment found for this id '.$_GET['CommentId']
      );
    }
    $em->remove($comment);
    $em->flush();
    return new Response("ok");
  }
}