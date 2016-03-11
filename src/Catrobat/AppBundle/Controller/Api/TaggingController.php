<?php

namespace Catrobat\AppBundle\Controller\Api;

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
     * @Route("/api/tags/getTags.json", name="api_get_tags", defaults={"_format": "json"})
     * @Method({"GET"})
     */
    public function taggingAction(Request $request)
    {
        $tags_repo = $this->get('tagrepository');

        $language = $request->query->get('language', 'en');
        $tags = array();

        $tags['ConstantTags'] = array();


        $results = $tags_repo->getConstantTags($language);

        foreach($results as $tag)
        {
            array_push($tags['ConstantTags'], $tag[$language]);
        }

        return JsonResponse::create($tags);
    }

}
