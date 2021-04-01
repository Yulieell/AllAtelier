<?php
namespace udalost\webapp\middlewares;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


Class Cors{
    private $c;

    public function __construct(\Slim\Container $c){
        $this->c = $c;
    }

        public function checkHeaderOrigin(Request $rq, Response $rs, callable $next){
            
        if ($rq->getHeader('Origin')) {
            $response = $next($rq, $rs)
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Max-Age', '1728000');
        return $response;
            
        } else {
            $rs = $rs->withStatus(401)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode(['type' => 'error', 'Error_code' => 401, 'message :' => 'no Origin Header found']));
            return $rs;
        }
        
    }
} 