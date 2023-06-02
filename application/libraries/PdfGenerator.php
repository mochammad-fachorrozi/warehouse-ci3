<?php
defined('BASEPATH') or exit('No direct script access allowed');
// panggil autoload dompdf nya
require_once "../warehouse_ci3/application/libraries/dompdf-master/autoload.inc.php";

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfGenerator
{
	public function generate($html, $filename = '', $paper = null, $orientation = '', $stream = TRUE)
	{
		// var_dump($orientation);
		// die;

		$options = new Options();
		$options->set('isRemoteEnabled', TRUE);
		$dompdf = new Dompdf($options);
		$dompdf->loadHtml($html);
		$dompdf->setPaper($paper, $orientation);
		$dompdf->render();
		if ($stream) {
			$dompdf->stream($filename . ".pdf", array("Attachment" => 0));
			exit();
		} else {
			return $dompdf->output();
		}
	}
}
