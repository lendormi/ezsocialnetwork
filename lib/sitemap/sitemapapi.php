<?php
/**
 * 
 * @licence http://www.gnu.org/licenses/gpl-2.0.txt GNU GPLv2
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

class SitemapAPI extends SocialRequest
{
    const TIMEOUT = 2;

    private function __construct()
    {
        $this->configCurl = array();
    }

    /**
     * [getContent description]
     * @param  [type] $parameters [description]
     * @return [type]             [description]
     */
    public static function getContent($parameters)
    {
        $instanceSitemap = new SitemapAPI();
        /**
         * This instance return an object XML
         */
        $xmlString = $instanceSitemap->request($parameters['url']);
        return $instanceSitemap->load($xmlString);
    }

    /**
     * This function allow to valid and return a string
     * in format SimpleXMLElement
     * @param  string $xmlString
     * @return SimpleXMLElement
     */
    public function load($xmlString)
    {
        libxml_use_internal_errors(true);
        $xmlSitemap = simplexml_load_string($xmlString);
        if (!$xmlSitemap) {
            $xmlErrors = "";
            foreach (libxml_get_errors() as $error) {
                $xmlErrors = $error->message . "\n";
            }
            eZDebug::writeError("This document is invalid : ".$xmlErrors, 'Sitemap API');
            return false;
        }
        return $xmlSitemap;
    }

    /**
     * [getStatsOnAllSocialNetwork description]
     * @param  SimpleXMLElement $xmlItem [description]
     * @return [type]                    [description]
     */
    public static function getStatsOnAllSocialNetwork(SimpleXMLElement $xmlItem)
    {
        $itemUrl              = $xmlItem->loc;
        $itemPriority         = $xmlItem->priority;
        $itemFrequence        = $xmlItem->changefreq;
        $itemLastModification = $xmlItem->lastmod;
        return SocialRequest::requestAllSocialNetwork($itemUrl->__toString(), 'statsUrl');
    }

    /**
     * [incrementXml description]
     * @param  array  $xmlArray [description]
     * @return [type]           [description]
     */
    public static function incrementXml($xmlArray = array())
    {
        if (count($xmlArray)) {
            foreach ($xml->url as $xmlItem) {
                $result = SitemapAPI::getStatsOnAllSocialNetwork($xmlItem);
                //this pause avoid User Rate Limit Exceeded
                sleep(10);
            }
        }
    }
}
