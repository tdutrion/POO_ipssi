<?php

declare(strict_types=1);

namespace Application\Router;

use Application\Controller\IndexController;
use Application\Controller\LecturerController;
use Cinema\Controller\FilmController;
use Cinema\Controller\ShowFilmController;
use Reseau\Controller\ReseauController;
use Reseau\Controller\MeetingController;
use Reseau\Controller\UserController;
use Reseau\Controller\AjoutController;
use Reseau\Controller\User;
use Exception;

use function explode;
use function preg_match;
use function substr;
use function urldecode;

final class ParseUriStaticNameHelper implements ParseUriHelper
{
    /**
     * @param string $requestUri
     * @return string
     * @throws Exception
     */
    public function parseUri(string $requestUri): string
    {
        $requestUri = \substr($requestUri, 10);
        if ($requestUri === '/') {
            $requestUri = substr($requestUri, 1);
        }

        if ($requestUri === '/reseau'){
            return ReseauController::class;
        }

        if ($requestUri === '/meeting'){
            return MeetingController::class;
        }

        if ($requestUri === '/user'){
            return UserController::class;
        }

        if ($requestUri === '/film') {
            return FilmController::class;
        }

        if ($requestUri === '/ajout'){
            return AjoutController::class;
        }
        
        if (preg_match('#/film/.*#', $requestUri)) {
            $requestUriParams = explode('/', $requestUri);
            $_GET['name'] = urldecode($requestUriParams[2]);
            return ShowFilmController::class;
        }

        if (preg_match('#/lecturer/.*#', $requestUri)) {
            $requestUriParams = explode('/', $requestUri);
            $_GET['lecturer'] = urldecode($requestUriParams[2]);
            return LecturerController::class;
        }

        return IndexController::class;
    }
}
