<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link    http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\Live;

use Piwik\Network\IPUtils;

class VisitorDetails extends VisitorDetailsAbstract
{
    public function extendVisitorDetails(&$visitor)
    {
        $visitor += array(
            'idSite'              => $this->getIdSite(),
            'idVisit'             => $this->getIdVisit(),
            'visitIp'             => $this->getIp(),
            'visitorId'           => $this->getVisitorId(),

            // => false are placeholders to be filled in API later
            'actionDetails'       => false,
            'goalConversions'     => false,
            'siteCurrency'        => false,
            'siteCurrencySymbol'  => false,

            // all time entries
            'serverDate'          => $this->getServerDate(),
            'visitServerHour'     => $this->getVisitServerHour(),
            'lastActionTimestamp' => $this->getTimestampLastAction(),
            'lastActionDateTime'  => $this->getDateTimeLastAction(),
        );
    }

    function getVisitorId()
    {
        if (isset($this->details['idvisitor'])) {
            return bin2hex($this->details['idvisitor']);
        }
        return false;
    }

    function getVisitServerHour()
    {
        return date('G', strtotime($this->details['visit_last_action_time']));
    }

    function getServerDate()
    {
        return date('Y-m-d', strtotime($this->details['visit_last_action_time']));
    }

    function getIp()
    {
        if (isset($this->details['location_ip'])) {
            return IPUtils::binaryToStringIP($this->details['location_ip']);
        }
        return null;
    }

    function getIdVisit()
    {
        return $this->details['idvisit'];
    }

    function getIdSite()
    {
        return $this->details['idsite'];
    }

    function getTimestampLastAction()
    {
        return strtotime($this->details['visit_last_action_time']);
    }

    function getDateTimeLastAction()
    {
        return date('Y-m-d H:i:s', strtotime($this->details['visit_last_action_time']));
    }
}