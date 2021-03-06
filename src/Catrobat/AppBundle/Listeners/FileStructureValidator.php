<?php

namespace Catrobat\AppBundle\Listeners;

use Catrobat\AppBundle\Services\ExtractedCatrobatFile;
use Symfony\Component\Finder\Finder;
use Catrobat\AppBundle\Exceptions\InvalidCatrobatFileException;
use Catrobat\AppBundle\Events\ProgramBeforeInsertEvent;
use Catrobat\AppBundle\Exceptions\Upload\UnexpectedFileException;

class FileStructureValidator
{
    public function onProgramBeforeInsert(ProgramBeforeInsertEvent $event)
    {
        $this->validate($event->getExtractedFile());
    }

    public function validate(ExtractedCatrobatFile $file)
    {
        $finder = new Finder();
        $finder->in($file->getPath())
           ->exclude(array('sounds', 'images'))
           ->notPath('/^code.xml$/')
           ->notPath('/^permissions.txt$/')
           ->notPath('/^screenshot.png$/')
           ->notPath('/^manual_screenshot.png$/')
           ->notPath('/^automatic_screenshot.png$/');

        if ($finder->count() > 0) {
            $list = array();
            foreach ($finder as $file) {
                $list[] = $file->getRelativePathname();
            }
            throw new UnexpectedFileException('unexpected files found: '.implode(', ', $list));
        }
    }
}
