<?php

namespace Progresivjose\ArcApiConnector\Responses;

interface Response
{
    public function setData(String $data);

    public function getData();
}
