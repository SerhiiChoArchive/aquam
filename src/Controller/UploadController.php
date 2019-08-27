<?php declare(strict_types=1);

namespace App\Controller;

use App\Converter;
use App\CsvHandler;
use App\Helper;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class UploadController extends AbstractController
{
    /**
     * @Route("/upload", methods={"POST"})
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function upload(Request $request): RedirectResponse
    {
        $file = $request->files->get('file');

        if (!$file->isValid() || $file->getClientMimeType() !== 'application/vnd.ms-excel') {
            return $this->redirect('/?msg=error');
        }

        if ($request->get('password') !== getenv('UPLOAD_PASSWORD')) {
            return $this->redirect('/?msg=error_pwd_wrong');
        }

        $converter = new Converter($file->getPathName());
        $file_data = new CsvHandler($converter->getCsvFilePath());
        $file_data->saveData();

        return $this->redirect('/?msg=success');
    }
}