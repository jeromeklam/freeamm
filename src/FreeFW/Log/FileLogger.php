<?php
namespace FreeFW\Log;

/**
 * File logger
 */
class FileLogger extends \Psr\Log\AbstractLogger
{

    /**
     * Taille maxi des lmogs en octets
     * @var number
     */
    const MAXLOGSIZE = 10000000;

    /**
     * local pid
     * @var string
     */
    protected static $pid = null;

    /**
     * Par défaut juste les erreurs
     * @var mixed
     */
    protected $level = \Psr\Log\LogLevel::ERROR;

    /**
     * Nom du fichier
     * @var string
     */
    protected $file = null;

    /**
     * Enregistrement cache
     * @var boolean
     */
    protected $cache = true;

    /**
     * Tableau des logs
     * @var array
     */
    protected $tabCache = array();

    /**
     * Tableau des logs filebeat
     * @var array
     */
    protected $tabBeat = array();

    /**
     * Constructeur
     *
     * @var string $p_file
     * @var mixed  $p_level
     */
    public function __construct($p_file, $p_level = \Psr\Log\LogLevel::ERROR)
    {
        $this->level = $p_level;
        $this->file  = $p_file;
        if (self::$pid === null) {
            self::$pid = getmypid() . '.' . md5(uniqid());
        }
    }

    /**
     * Enregistrement si cache actif
     */
    public function __destruct()
    {
        if ($this->cache) {
            $this->commit();
        }
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        // On ne logge qu'en fonction du niveau souhaité
        if (self::getLevelAsInt($level) <= self::getLevelAsInt($this->level)) {
            $myMsg = \FreeFW\Tools\PBXString::parse($message, $context);
            $this->write($myMsg, $level);
        }
    }

    /**
     * ^Get client IP
     *
     * @return string
     */
    public static function getClientIp()
    {
        //Just get the headers if we can or else use the SERVER global
        if (function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
        } else {
            $headers = $_SERVER;
        }
        //Get the forwarded IP if it exists
        if (array_key_exists('X-Forwarded-For', $headers) &&
            filter_var($headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $the_ip = $headers['X-Forwarded-For'];
        } else {
            if (array_key_exists('HTTP_X_FORWARDED_FOR', $headers) &&
                filter_var($headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $the_ip = $headers['HTTP_X_FORWARDED_FOR'];
            } else {
                if (array_key_exists('X-ClientSide', $headers)) {
                    $parts  = explode(':', $headers['X-ClientSide']);
                    $the_ip = $parts[0];
                } else {
                    $the_ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
                }
            }
        }
        return $the_ip;
    }

    /**
     * Ecriture du message
     *
     * @var string $message
     *
     * @return \FreeFW\Log\FileLogger
     */
    protected function write($message, $level = false)
    {
        $now  = \DateTime::createFromFormat('U.u', number_format(microtime(true), 6, '.', ''));
        $line = array(
            'pid'  => self::$pid,
            'time' => $now->format("d/m/Y H:i:s.u")
        );
        if ($level !== false) {
            $line['$level'] = $level;
        } else {
            $line['$level'] = '........';
        }
        $line['mesg'] = $message;
        if (!$this->cache) {
            $this->flush();
        }
        $this->tabCache[] = $line;
        try {
            $params = [
                'appCode'    => APP_NAME,
                'appClient'  => '',
                'appSession' => session_id(),
                'appTs'      => microtime(),
                'appDate'    => date('c'),
                'appType'    => $level,
                'appErrNum'  => 0,
                'appErrMsg'  => (string)$message,
                'appErrFile' => '',
                'appErrLine' => 0,
                'appData'    => []
            ];
            if (isset($_SERVER) && array_key_exists('REQUEST_URI', $_SERVER)) {
                $params['requestUri'] = $_SERVER['REQUEST_URI'];
                $params['requestIp']  = self::getClientIp();
                $params['requestUA']  = $_SERVER['HTTP_USER_AGENT'];
                if (array_key_exists('HTTP_ACCEPT_LANGUAGE', $_SERVER)) {
                    $params['requestLg'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
                }
            }
            $this->tabBeat[] = $params;
        } catch (\Exception $ex) {
            // @nothing
        }
        if (!$this->cache) {
            $this->commit();
        }
        return $this;
    }

    /**
     * Purge du cache
     *
     * @return \FreeFW\Log\FileLogger
     */
    protected function flush()
    {
        $this->tabCache = array();
        $this->tabBeat  = array();
        return $this;
    }

    /**
     * Retourne le niveau de log
     *
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Enregistrement du cache
     *
     * @return \FreeFW\Log\FileLogger
     */
    protected function commit()
    {
        $rr = false;
        if (is_file($this->file)) {
            $size = filesize($this->file);
            if ($size > self::MAXLOGSIZE) {
                if (is_file($this->file . '.1')) {
                    unlink($this->file . '.1');
                }
                rename($this->file, $this->file . '.1');
            }
        } else {
            $rr = true;
        }
        if (is_file('/var/log/jvs/' . APP_NAME . '.log')) {
            $size = filesize('/var/log/jvs/' . APP_NAME . '.log');
            if ($size > self::MAXLOGSIZE) {
                if (is_file('/var/log/jvs/' . APP_NAME . '.log.1')) {
                    unlink('/var/log/jvs/' . APP_NAME . '.log.1');
                }
                rename('/var/log/jvs/' . APP_NAME . '.log', '/var/log/jvs/' . APP_NAME . '.log.1');
            }
        } else {
            $rr = true;
        }
        $h = fopen($this->file, 'a+');
        if ($rr) {
            @chmod($this->file, 0666);
        }
        if ($h) {
            while (null !== ($line = array_shift($this->tabCache))) {
                $content = implode('  ---  ', $line) . PHP_EOL;
                fwrite($h, $content);
            }
            fclose($h);
        }
        if (is_dir('/var/log/jvs')) {
            $h = fopen('/var/log/jvs/' . APP_NAME . '.log', 'a+');
            while (null !== ($line = array_shift($this->tabBeat))) {
                $content = json_encode($line) . PHP_EOL;
                fwrite($h, $content);
            }
            fclose($h);
        }
        return $this;
    }

    /**
     * Return logLevel as int
     *
     * @param string $p_level
     *
     * @return number
     */
    protected static function getLevelAsInt($p_level)
    {
        switch ($p_level) {
            case \Psr\Log\LogLevel::DEBUG:
                return 9;
            case \Psr\Log\LogLevel::INFO:
                return 8;
            case \Psr\Log\LogLevel::ALERT:
                return 7;
            case \Psr\Log\LogLevel::NOTICE:
                return 6;
            case \Psr\Log\LogLevel::WARNING:
                return 5;
            case \Psr\Log\LogLevel::ERROR:
                return 3;
            case \Psr\Log\LogLevel::CRITICAL:
                return 2;
            case \Psr\Log\LogLevel::EMERGENCY:
                return 1;
        }
        return 0;
    }
}
