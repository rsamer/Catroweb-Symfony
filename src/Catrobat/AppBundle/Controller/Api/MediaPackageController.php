<?php

namespace Catrobat\AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class MediaPackageController extends Controller
{
  /**
   * @Route("/pocket-library/{package_name}.json", name="api_pocket_library", defaults={"_format": "json"})
   * @Method({"GET"})
   */
  public function getMediaPackageAction(Request $request, $package_name)
  {
    /**
     * @var $package \Catrobat\AppBundle\Entity\MediaPackage
     * @var $file \Catrobat\AppBundle\Entity\MediaPackageFile
     * @var $category \Catrobat\AppBundle\Entity\MediaPackageCategory
     */
    $flavor = $request->getSession()->get('flavor');

    $em = $this->getDoctrine()->getManager();
    $package = $em->getRepository('\Catrobat\AppBundle\Entity\MediaPackage')
      ->findOneBy(array('name_url' => $package_name));

    if (!$package) {
      throw $this->createNotFoundException('Unable to find Package entity.');
    }

    $categories = array();
    foreach($package->getCategories() as $category) {
      $files = array();
      foreach($category->getFiles() as $file) {
        $flavors_arr = preg_replace("/ /", "", $file->getFlavor());
        $flavors_arr = explode(",", $flavors_arr);
        if(!$file->getActive() || ($file->getFlavor() != null && !in_array($flavor, $flavors_arr))) {
          continue;
        }
        $mediapackageFileRepository = $this->get('mediapackagefilerepository');
        $files[] = array(
          'id' => $file->getId(),
          'name' => $file->getName(),
          'url' => $mediapackageFileRepository->getWebPath($file->getId(), $file->getExtension())
        );
      }
      $categories[] = array(
        'name' => $category->getName(),
        'files' => $files,
        'priority' => $category->getPriority()
      );
    }

    usort($categories, function($a,$b) {
      if($a['priority'] == $b['priority'])
        return 0;
      return ($a['priority'] > $b['priority']) ? -1 : 1;
    });

    return JsonResponse::create($categories);
  }
}