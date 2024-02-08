<?php

namespace geoquizz\service\domain\DTO;

class Partie_SchemaDTO extends DTO
{
    public int $id;
    public int $partie_id;
    public int $tours;
    public int $localisation_id;

    /**
     * @param int $id
     * @param int $partie_id
     * @param int $tours
     * @param int $localisation_id
     */
    public function __construct(int $id, int $partie_id, int $tours, int $localisation_id)
    {
        $this->id = $id;
        $this->partie_id = $partie_id;
        $this->tours = $tours;
        $this->localisation_id = $localisation_id;
    }


}