<?php

/**
 * @namespace BwfAlternateModel
 */
namespace BwfAlternateModel;

/**
 *
 * @package        BwfAlternateModel
 * @author         Mikhail Levykin <roa72@mail.ru>
 * @changedby      $Author: beowulfus $
 * @version        SVN: $Id: $
 * @revision       SVN: $
 * @link           $HeadURL: $
 * @date           $Date: $
 */
class Module
{

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'
            )
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'bwfCsvModel' => function ($sm)
                {
                    return new \BwfAlternateModel\CsvModel(
                        $sm->get('Response'));
                }, 
                'bwfPdfModel' => function ($sm)
                {
                    return new \BwfAlternateModel\PdfModel(
                        $sm->get('Response'));
                }
            )
        );
    }

}



