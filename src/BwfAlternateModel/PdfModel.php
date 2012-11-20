<?php

namespace BwfAlternateModel;

use Zend\Http\PhpEnvironment\Response;

class PdfModel
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
	 */
	public function __invoke($filepath, $attached_fname = null)
	{
		if(!file_exists($filepath))
			throw new \Exception(sprintf('Файл "%s" не найден!', $filepath));

		ob_start();
		readfile($filepath);
		$data = ob_get_contents();
		ob_end_clean();

		$attached_fname = $attached_fname == null ? date('Y-m-d-H-i-s')
				: $attached_fname;

		$this->response->getHeaders()
				->addHeaderline('Content-type', 'application/pdf')
				->addHeaderline('Content-length', strlen($data))
				->addHeaderline('Content-Disposition',
						'attachment; filename=' . $attached_fname . '.pdf');

		$this->response->setContent($data);

		return $this->response;
	}

}
