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
    return $this->render(':Admin:comment_report.html.twig');
  }
}