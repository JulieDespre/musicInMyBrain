<?php

namespace geoquizz\service\domain\DTO;

class PartieDTO extends DTO
{
    public int $id;
    public int $user_id;
    public int $score;
    public int $difficulte;
    public int $serie_id;

    /**
     * @param int $id
     * @param int $user_id
     * @param int $score
     * @param int $difficulte
     * @param int $serie_id
     */
    public function __construct(int $id, int $user_id, int $score, int $difficulte, int $serie_id)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->score = $score;
        $this->difficulte = $difficulte;
        $this->serie_id = $serie_id;
    }


}