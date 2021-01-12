<?php

namespace App;

trait PersonnelAction {

    public function updateBed($departure, $arrival)
    {
        $this->getRequest(
            "UPDATE `{$this->getInformation('location')}`
            SET `lits_occupes` = `lits_occupes` - :occupe
            WHERE `service` = \"{$this->getInformation('service')}\"",
            [
                'occupe' => $departure - $arrival
            ]
        );
    }

    public function showAllBedInOther(): ?array
    {
        $tables = $this->getRequest(
            'SHOW TABLES FROM `c.h.gestion`',
            [],
            'fetchAll'
        );
        $locations = [];
        foreach ($tables as $value) {
            if (
                $value['Tables_in_c.h.gestion'] === 'patients'
                || $value['Tables_in_c.h.gestion'] === 'users'
            ) {
                continue;
            }
            $data = $this->getRequest(
                "SELECT *
                FROM {$value['Tables_in_c.h.gestion']}
                WHERE `service` = :service",
                [
                    'service' => self::getInformation('service')
                ],
                'fetch'
            );
            $push = [
                'location' => $value['Tables_in_c.h.gestion']
            ];
            if (is_bool($data)) {
                continue;
            }
            array_push($push, $data);
            array_push($locations, $push);
        }
        return $locations;
    }

    public function showAllBedHere()
    {
        return $this->getRequest(
            "SELECT *
            FROM {$this->getInformation('location')}",
            [],
            'fetchAll'
        );
    }

    public function getPatientFolderByName($name, $firstName): ?array
    {
        $patient = $this->getRequest(
            'SELECT *
            FROM `patients`
            WHERE `name` = :name
            AND `firstName` = :firstName',
            [
                'name' => $name,
                'firstName' => $firstName
            ],
            'fetch'
        );
        return json_decode($patient['informations'], true);
    }

    public function getPatientFolderById($id): ?array
    {
        $patient = $this->getRequest(
            'SELECT *
            FROM `patients`
            WHERE `id` = :id',
            [
                'id' => $id
            ],
            'fetch'
        );
        return $patient = json_decode($patient['informations'], true);
    }

    public function addIncident($name, $firstName, $incidentCategory, $incidentDetails)
    {
        $patient = $this->getPatientFolderByName($name, $firstName);

        array_push(
            $patient['incidents'][$incidentCategory],
            $incidentDetails
        );
    
        $this->getRequest(
            'UPDATE `patients`
            SET `informations` = :fiche',
            [
                'fiche' => json_encode($patient)
            ]
        );
    }
}