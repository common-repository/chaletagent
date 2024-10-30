<?php

class ChaletAgentAPI
{
    const LOG_KEY = 'chaletops_log';

	/**
	 * @var string
	 */
	protected $api_url = CHALETOPS_API_BASE_URL;

	/**
	 * @var string
	 */
	protected $api_protocol = CHALETOPS_API_PROTOCOL;

	/**
	 * The ChaletAgent account id
	 *
	 * @var string
	 */
	protected $username;

	/**
	 * @param $username
	 */
	public function __construct ($username)
	{
		$this->username = $username;

		$this->api_url = $this->api_protocol . $username . '.' . $this->api_url;
	}

	/**
	 * Load the availability table from the API
	 *
	 * @param array $attr The array of attributes
	 *
	 * @return string
	 */
	public function get_availability ($attr)
	{
		if (!is_numeric($attr['season']))
		{
			return 'Season ID not specified.';
		}

		if (isset($attr['properties']) && preg_match("/[\d,]+/", $attr['properties']))
		{
			$data = $this->call_api(
				"{$this->api_url}/availabilities/{$attr['season']}/properties/{$attr['properties']}.html"
			);
		}
		else
		{
			$data = $this->call_api(
				"{$this->api_url}/availabilities/{$attr['season']}.html"
			);
		}

		return $data['body'];
	}

	/**
	 * Load the transfers table from the API
	 *
	 * @param array $attr The array of attributes
	 *
	 * @return string
	 */
	public function get_transfers ($attr)
	{
		$data = $this->call_api("{$this->api_url}/transfers/{$attr['season']}.html");

		return $data['body'];
	}

    /**
     * Load the testimonials list from the API
     *
     * @return string
     */
    public function get_testimonials ()
    {
        $data = $this->call_api("{$this->api_url}/testimonials.html");

        return $data['body'];
    }

    /**
     * Load the testimonials list from the API
     *
     * @return string
     */
    public function get_testimonials_catered ()
    {
        $data = $this->call_api("{$this->api_url}/catered/testimonials.html");

        return $data['body'];
    }

    /**
     * Load the testimonials list from the API
     *
     * @return string
     */
    public function get_testimonials_self_catered ()
    {
        $data = $this->call_api("{$this->api_url}/self/catered/testimonials.html");

        return $data['body'];
    }

	/**
	 * Load the seasons list from the API
	 *
	 * @param array $attr The array of attributes
	 *
	 * @return string
	 */
	public function get_seasons ($attr)
	{
		if (isset($attr['season']))
		{
			$data = $this->call_api("{$this->api_url}/seasons/{$attr['season']}.html");
		}
		else
		{
			$data = $this->call_api("{$this->api_url}/seasons.html");
		}

		return $data['body'];
	}

	/**
	 * Load the properties list from the API
	 *
	 * @param array $attr The array of attributes
	 *
	 * @return string
	 */
	public function get_properties ($attr)
	{
		if (isset($attr['property']))
		{
			$data = $this->call_api("{$this->api_url}/properties/{$attr['property']}.html");
		}
		else
		{
			$queryString = isset($attr['format']) ? '?format=' . $attr['format'] : '';

			$data = $this->call_api("{$this->api_url}/properties.html" . $queryString);
		}

		return $data['body'];
	}

	/**
	 * Centralised location to perform the actual API call.
	 *
	 * We also use Wordpress' Transient API to cache API calls for a short period.
	 * This improves performance by not actually hitting the API on each page request.
	 *
	 * Also, we have a fallback copy of the last good request that is stored for a
	 * long time, and this is used in the event of a connectivity failure etc to ensure
	 * the last know good output can be displayed.
	 *
	 * @param string $path
	 *
	 * @return mixed
	 */
	public function call_api ($path)
	{
		$key = 'ca_' . md5($path);
		$fbKey = 'ca_fb_' . md5($path);

		$transientData = get_transient($key);

		// If we have a cached copy, use it immediately
		if ($transientData !== false)
		{
			return $transientData;
		}
		// Otherwise, fetch a new version from ChaletAgent
		else
		{
			$apiData = $this->load_data($path);

			// If there is an error collecting a new version, provide the fallback copy instead
			if (isset($apiData['error']))
			{
				return get_transient($fbKey); // Don't error check here as last resort
			}

			// Otherwise, we have a good response so a) cache it, and b) save a long TTL fallback copy too
			set_transient($key, $apiData, CHALETOPS_API_CACHE_TTL);
			set_transient($fbKey, $apiData, CHALETOPS_API_CACHE_TTL * 24);

			// Now return the newly retrieved data
			return $apiData;
		}
	}

	/**
	 * Get the data from the API
	 *
	 * @param string $path
	 *
	 * @return mixed
	 */
	private function load_data ($path)
	{
		$response = wp_remote_get($path, [
			'timeout'   => CHALETOPS_API_TIMEOUT,
			'sslverify' => CHALETOPS_API_SSL_VERIFY
		]);

		if ($response instanceof WP_Error)
		{
		    $logData = $this->getLog();

            $logData[] = array(
				'timestamp' => time(),
				'message'   => 'Error connecting to ' . $path . ' : ' . print_r($response->get_error_messages(), true)
			);

            $this->setLog($logData);

			return [
				'error' => true,
				'body'  => 'An error has occurred with the ChaletAgent plugin.'
			];
		}

		// Remove line breaks in HTML so Wordpress doesn't try and replace them with <p> tags
		$response['body'] = str_replace(PHP_EOL, '', $response['body']);

		return $response;
	}

    private function getLog()
    {
        $transientData = get_transient(self::LOG_KEY);

        return false === $transientData ? [] : $transientData;
	}

    private function setLog($logData)
    {
        set_transient(self::LOG_KEY, $logData, 60 * 60);
	}

}
