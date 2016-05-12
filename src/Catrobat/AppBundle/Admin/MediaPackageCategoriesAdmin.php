<?php

namespace Catrobat\AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class MediaPackageCategoriesAdmin extends Admin
{
    protected $baseRouteName = 'adminmedia_package_category';
    protected $baseRoutePattern = 'media_package_category';

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $file_options = array(
          'required' => ($this->getSubject()->getId() === null),
        );

        $formMapper
            ->add('name', 'text', array('label' => 'Name'))
            ->add('file', 'file', $file_options)
            ->add('package', 'entity', array('class' => 'Catrobat\AppBundle\Entity\MediaPackage', 'required' => true))
            ->add('priority')
            ->add('title_image_or_both', 'choice', array("choices" => array(
                0 => "Title",
                1 => "Image",
                3 => "Title And Image"
            )));
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('package', 'entity', array('class' => 'Catrobat\AppBundle\Entity\MediaPackage'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    public function prePersist($object)
    {
      $file = $object->file;
      if ($file == null) {
        return;
      }
      $object->setExtension($file->guessExtension());
    }

    public function postPersist($object)
    {
      $file = $object->file;
      if ($file == null) {
        return;
      }
      $this->getConfigurationPool()->getContainer()->get('mediapackagefilerepository')->save($file, "category-" . $object->getId(), $object->getExtension());
    }

    public function preUpdate($object)
    {
      $object->old_extension = $object->getExtension();
      $object->setExtension(null);

      $file = $object->file;
      if ($file == null) {
        $object->setExtension($object->old_extension);
        return;
      }
      $object->setExtension($file->guessExtension());
    }

    public function postUpdate($object)
    {
      $file = $object->file;
      if ($file == null) {
        return;
      }
      $this->getConfigurationPool()->getContainer()->get('mediapackagefilerepository')->save($file, "category-" . $object->getId(), $object->getExtension());
    }

    public function preRemove($object)
    {
      $object->removed_id = $object->getId();
    }

    public function postRemove($object)
    {
      $this->getConfigurationPool()->getContainer()->get('mediapackagefilerepository')->remove("category-" . $object->removed_id, $object->getExtension());
    }
}
