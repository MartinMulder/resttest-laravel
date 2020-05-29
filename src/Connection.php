<?php

namespace RestTest\Laravel;

class Connection
{
	protected static $instance;

	protected $host;
	protected $hosts = [];
	protected $port = 0;
	protected $username;
	protected $password;
	protected $use_ssl = false;
	protected $baseUrl;
	protected $attempted = [];
	protected $configuration;

	public function __construct($config = [])
	{
		$this->configuration = new RestTestConfiguration($config);
		$this->hosts = $this->configuration->get('hosts');
		$this->host = reset($this->hosts);
		$this->port = $this->configuration->get('port');
		$this->username = $this->configuration->get('username');
		$this->password = $this->configuration->get('password');
		$this->use_ssl = $this->configuration->get('use_ssl');

		// Create  baseUrl
		$this->baseUrl = "http://";
		if($this->use_ssl)
		{
			$this->baseUrl = "https://";
		}

		$this->baseUrl . $this->host . ":" . $this->port;
	}

	public function setConfiguration($config = [])
    {
        $this->configuration = new RestTestConfiguration($config);

        return $this;
    }

    public function getConfiguration()
    {
        return $this->configuration;
    }

    public static function getInstance()
    {
    	return static::$instance ?? static::getNewInstance();
    }

    public static function getNewInstance()
    {
    	static::$instance = new \GuzzleHttp\Client([
    		'base_uri' => $this->baseUri,
    		'headers' => [
    			'Accept' => 'application/json'
    		],
    		'auth' => [$this->username, $this->password],
    	]);

    	return static::$instance;
    }

    public function get($uri)
    {
    	$response = static::$instance->request('GET', 'test');
    	dd($response);
    }
}