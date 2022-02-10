<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

use CodeIgniter\API\ResponseTrait;
use Config\Services;
use Exception;

class Filter_jwt implements FilterInterface
{

    use ResponseTrait;
    public function before(RequestInterface $request, $arguments = null)
    {
        // cek authorization
        $header = $request->getServer('HTTP_AUTHORIZATION');



        try {
            // load helper yang kita buat
            helper('jwt');
            $encodeJWT = getJWT($header);
            validateJWT($encodeJWT);
            return $request;
        } catch (Exception $e) {

            // error Handliing
            $error = [
                "error" => $e->getMessage()
            ];
            // return $this->response->setJSON($error)->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);

            return Services::response()->setJSON($error)
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
