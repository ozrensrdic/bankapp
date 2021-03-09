<?php

namespace App\Application\Actions\Docs;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Symfony\Component\Yaml\Yaml;
use Twig\Error\LoaderError;
use \Twig\Error\RuntimeError;
use \Twig\Error\SyntaxError;

class SwaggerAction
{
    public function __construct(private Twig $twig){}

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        // Path to the yaml file
        $yamlFile = __DIR__ . '/../../../../resources/docs/bank.yaml';

        $viewData = [
            'spec' =>json_encode(Yaml::parseFile($yamlFile)),
        ];

        return $this->twig->render($response, 'swagger.twig', $viewData);
    }
}