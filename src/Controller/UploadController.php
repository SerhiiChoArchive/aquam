<?php declare(strict_types=1);

namespace App\Controller;

use App\Converter;
use App\CsvHandler;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class UploadController extends AbstractController
{
    /**
     * @Route("/upload", methods={"POST"})
     */
    public function upload(Request $request): RedirectResponse
    {
        $validate = $this->validate($request);

        if (is_string($validate)) {
            return $this->redirect("/?msg=$validate");
        }

        $converter = new Converter($request->files->get('file')->getPathName());
        $file_data = new CsvHandler($converter->getCsvFilePath());
        $file_data->saveData();

        return $this->redirect('/?msg=success');
    }

    private function validate(Request $request): ?string
    {
        $file = $request->files->get('file');

        if (!$file->isValid() || $file->getClientMimeType() !== 'application/vnd.ms-excel') {
            return 'msg=error';
        }

        if ($request->get('password') !== getenv('UPLOAD_PASSWORD')) {
            return 'error_pwd_wrong';
        }

        return null;
    }
}