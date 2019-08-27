<?php declare(strict_types=1);

namespace App\Controller;

use App\Converter;
use App\CsvHandler;
use App\Helper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class UploadController extends AbstractController
{
    /**
     * @Route("/upload", methods={"POST"})
     */
    public function upload()
    {
        $file = Helper::getFileFromRequest($_FILES);

        if (!$file) {
            return $this->redirect('/?msg=error');
        }

        if (!Helper::passwordIsCorrect($_POST)) {
            return $this->redirect('/?msg=error_pwd_wrong');
        }

        $converter = new Converter($file['tmp_name']);
        $file_data = new CsvHandler($converter->getCsvFilePath());
        $file_data->saveData();

        return $this->redirect('/?msg=success');
    }
}