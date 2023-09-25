<?php

namespace Progresivjose\ArcApiConnector\Responses;

class StringResponse implements Response
{
    private String $data;

    public function setData(string $data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
}
