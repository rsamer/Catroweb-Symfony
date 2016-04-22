<?php
/**
 * Created by PhpStorm.
 * User: eric
 * Date: 20.03.16
 * Time: 17:23
 */

namespace Catrobat\AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ReportAdmin extends Admin
{
  protected $baseRouteName = 'admin_report';
  protected $baseRoutePattern = 'report';

  protected function configureFormFields(FormMapper $formMapper)
  {
  }

  // Fields to be shown on filter forms
  protected function configureDatagridFilters(DatagridMapper $datagridMapper)
  {
  }

  // Fields to be shown on lists
  protected function configureListFields(ListMapper $listMapper)
  {
  }

  protected function configureRoutes(RouteCollection $collection)
  {
    $collection->clearExcept(array('list'));
    $collection->add('deleteComment');
  }


}