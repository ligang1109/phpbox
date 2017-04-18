<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/4/20
 * Time: 8:14
 */

namespace Phpbox\Http;

use Psr\Http\Message\UriInterface;

class Uri implements UriInterface
{
    const PATH_AND_FRAGMENT_FILTER_REGEX = '/(?:[^a-zA-Z0-9_\-\.~:@&=\+\$,\/;%]+|%(?![A-Fa-f0-9]{2}))/';
    const QUERY_FILTER_REGEX             = '/(?:[^a-zA-Z0-9_\-\.~!\$&\'\(\)\*\+,;=%:@\/\?]+|%(?![A-Fa-f0-9]{2}))/';


    private static $supportScheme = array(
        'http' => 80,
        'https' => 443,
        'ftp' => 21,
    );

    private $scheme   = '';
    private $userInfo = '';
    private $host     = '';
    private $port     = null;
    private $path     = '';
    private $query    = '';
    private $fragment = '';


    public function __construct($uri = '')
    {
        if ($uri != '') {
            $uriData = parse_url($uri);
            if ($uriData === false) {
                throw new \InvalidArgumentException("$uri parse failed");
            }

            $this->initByUriData($uriData);
        }
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        $scheme   = $this->getScheme();
        $query    = $this->getQuery();
        $fragment = $this->getFragment();

        $uri = '';
        if ($scheme) {
            $uri .= $scheme . '//';
        }

        $uri .= $this->getAuthority() . $this->getPath();
        if ($query) {
            $uri .= '?' . $query;
        }
        if ($fragment) {
            $uri .= '#' . $fragment;
        }

        return $uri;
    }

    public function withScheme($scheme)
    {
        // TODO: Implement withScheme() method.
        if (!isset(self::$supportScheme[$scheme])) {
            throw new \InvalidArgumentException("$scheme not supported");
        }

        $this->scheme = $scheme;

        return $this;
    }

    public function withUserInfo($user, $password = null)
    {
        // TODO: Implement withUserInfo() method.
        $this->userInfo = $user;
        if (!is_null($password)) {
            $this->userInfo .= ':' . $password;
        }

        return $this;
    }

    public function withHost($host)
    {
        // TODO: Implement withHost() method.
        $this->host = $host;

        return $this;
    }

    public function withPort($port)
    {
        // TODO: Implement withPort() method.
        $port = intval($port);
        if ($port < 1 || $port > 65535) {
            throw new \InvalidArgumentException("Port must between 1 to 65535");
        }

        $this->port = $port;

        return $this;
    }

    public function withPath($path)
    {
        // TODO: Implement withPath() method.
        $this->path = $this->filterPathAndFragment($path);

        return $this;
    }

    public function withQuery($query)
    {
        // TODO: Implement withQuery() method.
        $this->query = $this->filterQuery($query);

        return $this;
    }

    public function withFragment($fragment)
    {
        // TODO: Implement withFragment() method.
        $this->fragment = $this->filterPathAndFragment($fragment);

        return $this;
    }

    public function getScheme()
    {
        // TODO: Implement getScheme() method.
        return $this->scheme;
    }

    public function getAuthority()
    {
        // TODO: Implement getAuthority() method.
        $authority = '';
        if ($this->userInfo != '') {
            $authority .= $this->userInfo . '@';
        }

        $authority .= $this->host;
        if (!is_null($this->port)) {
            $authority .= ':' . $this->port;
        }

        return $authority;
    }

    public function getUserInfo()
    {
        // TODO: Implement getUserInfo() method.
        return $this->userInfo;
    }

    public function getHost()
    {
        // TODO: Implement getHost() method.
        return $this->host;
    }

    public function getPort()
    {
        // TODO: Implement getPort() method.
        if (!is_null($this->port)) {
            return $this->port;
        }

        return $this->scheme ? self::$supportScheme[$this->scheme] : null;
    }

    public function getPath()
    {
        // TODO: Implement getPath() method.
        return $this->path;
    }

    public function getQuery()
    {
        // TODO: Implement getQuery() method.
        return $this->query;
    }

    public function getFragment()
    {
        // TODO: Implement getFragment() method.
        return $this->fragment;
    }


    private function initByUriData($uriData)
    {
        if (isset($uriData['scheme'])) {
            $this->withScheme($uriData['scheme']);
        }
        if (isset($uriData['user'])) {
            $pass = isset($uriData['pass']) ? $uriData['pass'] : null;
            $this->withUserInfo($uriData['user'], $pass);
        }
        if (isset($uriData['host'])) {
            $this->withHost($uriData['host']);
        }
        if (isset($uriData['port'])) {
            $this->withPort($uriData['port']);
        }
        if (isset($uriData['path'])) {
            $this->withPath($uriData['path']);
        }
        if (isset($uriData['query'])) {
            $this->withQuery($uriData['query']);
        }
        if (isset($uriData['fragment'])) {
            $this->withFragment($uriData['fragment']);
        }
    }

    private function filterPathAndFragment($str)
    {
        if (!is_string($str)) {
            throw new \InvalidArgumentException("Path and fragment must be a string");
        }

        return preg_replace_callback(
            self::PATH_AND_FRAGMENT_FILTER_REGEX,
            array($this, 'filterMatch'),
            $str
        );
    }

    private function filterQuery($query)
    {
        if (!is_string($query)) {
            throw new \InvalidArgumentException("Query must be a string");
        }

        return preg_replace_callback(
            self::QUERY_FILTER_REGEX,
            array($this, 'filterMatch'),
            $query
        );
    }

    private function filterMatch($match)
    {
        return rawurlencode($match[0]);
    }
}