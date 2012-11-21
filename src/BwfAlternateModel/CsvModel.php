<?php
/**
 * @namespace BwfAlternateModel
 */
namespace BwfAlternateModel;

/**
 * @uses Zend\Http\PhpEnvironment\Response
 */
use Zend\Http\PhpEnvironment\Response;

/**
 *
 * @package    BwfAlternateModel
 * @author     Mikhail Levykin <roa72@mail.ru>
 */
class CsvModel
{

    /**
     *
     * @var Zend\Http\PhpEnvironment\Response
     * @access protected
     */
    protected $response;

    /**
     * конструктор
     *
     * @param Zend\Http\PhpEnvironment\Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     *
     * @param Response $response
     * @return BwfAlternateModel\CsvModel
     */
    public function replaceResponse(Response $response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * цепляет к объекту Zend\Http\PhpEnvironment\Response
     * дополнительные заголовки и отправляемый контент.
     *
     * @param String $filepath
     * @param String|NULL $attached_fname
     * @throws \Exception
     * @return Response
     */
    public function __invoke(array $data, $attached_fname = null)
    {
        $csv = '';

        foreach($data as $sub) {
            if(! is_array($sub))
                throw new \Exception(
                    'Данные должны быть в двумерном массиве!');

            $csv .= implode(';', $sub);
            $csv .= "\r\n";
        }

        $attached_fname = $attached_fname == null ? date('Y-m-d-H-i-s') : $attached_fname;

        $this->response->getHeaders()
            ->addHeaderline('Content-type', 'csv/plain')
            ->addHeaderline('Content-length', strlen($csv))
            ->addHeaderline('Content-Disposition',
            'attachment; filename=' . $attached_fname . '.csv');

        $this->response->setContent($csv);

        return $this->response;
    }
}