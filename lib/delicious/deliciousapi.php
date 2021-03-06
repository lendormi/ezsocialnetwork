<?php
/**
 * 
 * @licence http://www.gnu.org/licenses/gpl-2.0.txt GNU GPLv2
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

class DeliciousAPI extends SocialRequest
{
    const VERSION = 1;
    const HOST = 'http://feeds.delicious.com/';
    const TIMEOUT = 2;

    private function __construct()
    {
        $this->configCurl = array(
            CURLOPT_FAILONERROR => true,
            CURLOPT_TIMEOUT => self::TIMEOUT
        );
    }

    /**
     * build the url
     * @param  [type] $method [description]
     * @return [type]         [description]
     */
    public function url($method)
    {
        return DeliciousAPI::HOST.$method;
    }

    /**
     *  API will be deprecated
     *
     * Check back here for future changes.
     * @param  string $url [description]
     * @return [type]      [description]
     */
    public static function statsUrl($parameters)
    {
        $instanceDelicious = new DeliciousAPI();
        /**
         * This instance return an object JSON
         * @var count
         * @var fCnt
         * @var fCntPlusOne
         * @var url
         */
        $jsonString = $instanceDelicious->request($instanceDelicious->url("v2/json/urlinfo/data"), $parameters);
        $json = json_decode($jsonString, true);
        if (empty($json)) {
            eZDebug::writeError("No Data", 'Delicious API');
            return false;
        }
        return $json;
    }
}
