<?php

namespace geoquizz\service\domain\DTO;

class PartieDTO extends DTO
{
    public string $id;
    public string $user_email;
    public int $score;
    public int $difficulte;
    public int $serie_id;
    public string $serie_nom;
    public string $user_username;

    /**
     * @param string $id
     * @param string $user_email
     * @param int $score
     * @param int $difficulte
     * @param int $serie_id
     * @param string $serie_nom
     * @param string $user_username
     */
    public function __construct(string $id, string $user_email, int $score, int $difficulte, int $serie_id, string $serie_nom, string $user_username)
    {
        $this->id = $id;
        $this->user_email = $user_email;
        $this->score = $score;
        $this->difficulte = $difficulte;
        $this->serie_id = $serie_id;
        $this->serie_nom = $serie_nom;
        $this->user_username = $user_username;
    }


}