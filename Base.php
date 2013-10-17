<?php //-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub;

use Eden\Core\Base as CoreBase;
use Eden\Curl\Base as Curl;

/**
 * The base class for all classes wishing to integrate with Eden.
 * Extending this class will allow your methods to seemlessly be
 * overloaded and overrided as well as provide some basic class
 * loading patterns.
 *
 * @vendor Eden
 * @package GitHub
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Base extends CoreBase
{
    const INSTANCE = 0; // set to multiton
    const API_URL = 'https://api.github.com/';

    /**
     * Preloads the token.
     *
     * @param string $token
     * @return void
     */
    public function __construct($token)
    {
        Argument::i()->test(1, 'string');
        
        $this->token = $token;
    }

    /**
     * Gets JSON reponse with GET method.
     *
     * @param string $link      [optional] the link
     * @param array  $query     [optional] the query
     * @return array
     */
    public function getResponse($link = '', array $query = array())
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'array')
                ->test(3, 'bool');
        
        return $this->getJSONResponse(Curl::GET, $link, $this->generateQuery($query));
    }

    /**
     * Gets JSON reponse with POST method.
     *
     * @param string $link      [optional] the link
     * @param array  $query     [optional] the query
     * @return array
     */
    public function postResponse($link = '', array $query = array())
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'array')
                ->test(3, 'bool');
        
        return $this->getJSONResponse(Curl::POST, $link, $this->generateQuery($query));
    }

    /**
     * Gets JSON reponse with PUT method.
     *
     * @param string $link      [optional] the link
     * @param array  $query     [optional] the query
     * @return array
     */
    public function putResponse($link = '', array $query = array())
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'array')
                ->test(3, 'bool');
        
        return $this->getJSONResponse(Curl::PUT, $link, $this->generateQuery($query));
    }

    /**
     * Gets JSON reponse with PATCH method.
     *
     * @param string $link      [optional] the link
     * @param array  $query     [optional] the query
     * @return array
     */
    public function patchResponse($link = '', array $query = array())
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'array')
                ->test(3, 'bool');
        
        return $this->getJSONResponse(Curl::PATCH, $link, $this->generateQuery($query));
    }

    /**
     * Gets JSON reponse with DELETE method.
     *
     * @param string $link      [optional] the link
     * @param array  $query     [optional] the query
     * @return array
     */
    public function deleteResponse($link = '', array $query = array())
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'array')
                ->test(3, 'bool');
        
        return $this->getJSONResponse(Curl::DELETE, $link, $this->generateQuery($query));
    }

    /**
     * Validates and generates the query and return the non-null queries.
     *
     * @param array $query the query to be generate
     * @return array
     */
    protected function generateQuery(array $query)
    {
        Argument::i()->test(1, 'array');
        
        $newQuery = array();
        foreach ($query as $key => $value) {
            if ($value) {
                $newQuery[$key] = $value;
            }
        }

        return $newQuery;
    }

    /**
     * Gets the JSON response based on the arguments passed.
     *
     * @param string  $method    the request method
     * @param string  $link      [optional] the link to append
     * @param array   $query     [optional] the query
     * @return array
     */
    protected function getJSONResponse($method, $link = '', array $query = array())
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'array')
                ->test(4, 'bool');
        
        // get the instagram api url
        $url = self::API_URL . $this->connection;
        $url .= '/' . $link;

        $query['access_token'] = $this->token;
        $query = http_build_query($query);
        $curl = Curl::i();

        switch ($method) {
            case Curl::GET:
                $url .= '?' . $query;
                break;
            case Curl::DELETE:
                $url .= '?' . $query;
                $curl->setCustomDelete(); // set method to delete
                break;
            case Curl::PATCH:
                $curl->setPostFields($query); // set post fields
                $curl->setCustomRequest('PATCH'); // set method to patch
                break;
            case Curl::PUT:
                $url .= '?' . $query;
                $curl->setCustomPut(); // set method to put
                break;
            case Curl::POST:
                $curl->setPost(true) // set method to post
                        ->setPostFields($query); // set post fields
                break;
        }
        
        // send it into curl
        $response = $curl->setUrl($url) // sets the url
                ->setConnectTimeout(10) // sets connection timeout to 10 sec.
                ->setFollowLocation(true) // sets the follow location to true
                ->setTimeout(60) // set page timeout to 60 sec
                ->verifyPeer(false) // verifying Peer must be boolean
                ->setUserAgent(Auth::USER_AGENT) // set instagram USER_AGENT
                ->setHeaders('Expect') // set headers to EXPECT
                ->getJsonResponse(); // get the json response

        return $response;
    }
}
