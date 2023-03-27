<?php
class SiteDatabase {

    private string $site;
    private mysqli $mysqli;
    private string $errorMessage;

    public function __construct(string $site, mysqli $mysqli) {
        $this->site = $site;
        $this->mysqli = $mysqli;
    }

    public function getSite() : string {
        return $this->site;
    }

    public function getErrorMessage() : string {
        return $this->errorMessage;
    }

    public function getComponentId(string $filename) : int {

        $componentId = 0;

        $sql = "SELECT c.componentid " . 
                 "FROM " . $this->site . "_content.component c LEFT JOIN " . $this->site . "_content.module m " .
                   "ON c.moduleid = m.moduleid " .
                "WHERE m.name = 'HTML' " . 
                  "AND c.filename = '" . $filename . "'";

        if ( $result = $this->mysqli->query($sql) ) {
            $componentId = $result->fetch_object()->componentid;
        } else {
            $this->errorMessage = "FATAL: Could not get component id for " . $this->site . " and " . $filename . ".";
        }
        
        return $componentId;
    }

    public function getPropertyId(string $name) : int {

        $propertyid = 0;

        $sql = "SELECT propertyid " . 
                 "FROM " . $this->site . "_content.property " . 
                "WHERE name = '" . $name . "'";

        if ( $result = $this->mysqli->query($sql) ) {
            $propertyid = $result->fetch_object()->propertyid;
        } else {
            $this->errorMessage = "FATAL: Could not get property id for " . $this->site . " and " . $name . ".";
        }
        
        return $propertyid;
    }

    public function updateComponentProperty(string $sourceSite, int $sourceComponentId, int $sourceProperyId, int $targetComponentId, int $targetProperyId) : int {

        $sql = 'UPDATE ' . $this->site . '_content.component_property ' .
                  'SET string = ( SELECT string ' .
                                   'FROM ' . $sourceSite . '_content.component_property ' .
                                  'WHERE componentid = ? '.
                                    'AND propertyid = ? ) ' .
                'WHERE componentid = ? ' .
                  'AND propertyid = ?';

        $statement = $this->mysqli->prepare($sql);
        $statement->bind_param('iiii', $sourceComponentId, $sourceProperyId, $targetComponentId, $targetProperyId);
        $statement->execute();

        return $this->mysqli->affected_rows;
    }

}