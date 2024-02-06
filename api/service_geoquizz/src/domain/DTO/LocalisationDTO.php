<?php

namespace geoquizz\service\domain\DTO;

class LocalisationDTO extends DTO
{
    public int $id;
    public string $url;
    public array $coordinate;

    /**
     * @param int $id
     * @param string $url
     * @param array $coordinate
     */
    public function __construct(int $id, string $url, array $coordinate)
    {
        $this->id = $id;
        $this->url = $url;
        $this->coordinate = $coordinate;
    }


}