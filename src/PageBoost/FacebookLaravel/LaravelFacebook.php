<?php namespace PageBoost\FacebookLaravel;

use Illuminate\Session\SessionManager;
use Illuminate\Log\Writer;
use \BaseFacebook;

/**
 * Class LaravelFacebook
 *
 * @package PageBoost\FacebookLaravel
 */
class LaravelFacebook extends BaseFacebook
{
   /**
   * Supported keys for persistent data
   *
   * @var array
   */
    protected static $kSupportedKeys = array('state', 'code', 'access_token', 'user_id');

    /**
     * Enable Api call logging
     *
     * @var bool
     */
    protected static $laravelDebug = false;

    /**
     * Laravel Session Instance
     *
     * @var \Illuminate\Session\SessionManager
     */
    protected $laravelSession;

    /**
     * Laravel Log Instance
     *
     * @var \Illuminate\Log\Writer
     */
    protected $laravelLog;

    /**
     *  @param array $config
     *  @param SessionManager $laravelSession
     *  @param Writer $laravelLog
     */
    public function __construct($config, SessionManager $laravelSession, Writer $laravelLog)
    {
        if (isset($config['laravelDebug'])) {
            self::$laravelDebug = $config['laravelDebug'];
            unset($config['laravelDebug']);
        }

        $this->laravelSession = $laravelSession;
        $this->laravelLog = $laravelLog;

        parent::__construct($config);
    }

    /**
     * @return mixed
     */
    public function api()
    {
        $args = func_get_args();
        if (self::$laravelDebug === true) {
            $this->laravelLog->info('Facebook Api Call: '.print_r($args, 1));
        }

        return call_user_func_array("parent::api", $args);
    }

    /**
     * {@inheritdoc}
     *
     * @see BaseFacebook::setPersistentData()
     */
    protected function setPersistentData($key, $value)
    {
        if (!in_array($key, self::$kSupportedKeys)) {
            self::errorLog('Unsupported key passed to setPersistentData.');

            return;
        }

        $session_var_name = $this->constructSessionVariableName($key);
        $this->laravelSession->put($session_var_name, $value);
    }

    /**
     * {@inheritdoc}
     *
     * @see BaseFacebook::getPersistentData()
     */
    protected function getPersistentData($key, $default = false)
    {
        if (!in_array($key, self::$kSupportedKeys)) {
            self::errorLog('Unsupported key passed to getPersistentData.');

            return $default;
        }
        $session_var_name = $this->constructSessionVariableName($key);

        return $this->laravelSession->get($session_var_name, $default);
    }

    /**
     * {@inheritdoc}
     *
     * @see BaseFacebook::clearPersistentData()
     */
    protected function clearPersistentData($key)
    {
        if (!in_array($key, self::$kSupportedKeys)) {
            self::errorLog('Unsupported key passed to clearPersistentData.');

            return;
        }

        $session_var_name = $this->constructSessionVariableName($key);
        if ($this->laravelSession->has($session_var_name)) {
            $this->laravelSession->forget($session_var_name);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @see BaseFacebook::clearAllPersistentData()
     */
    protected function clearAllPersistentData()
    {
        foreach (self::$kSupportedKeys as $key) {
            $this->clearPersistentData($key);
        }
    }

    /**
    * Constructs and returns the name of the session key.
    *
    * @see setPersistentData()
    * @param string $key The key for which the session variable name to construct.
    *
    * @return string The name of the session key.
    */
    protected function constructSessionVariableName($key)
    {
        $parts = array('fb', $this->getAppId(), $key);

        return implode('_', $parts);
    }

    /**
     * {@inheritdoc}
     *
     * @see BaseFacebook::errorLog()
     */
    protected static function errorLog($msg)
    {
       if (self::$laravelDebug === true) {
            \Log::info('Facebook ErrorLog: '.$msg);
        }
    }
}
