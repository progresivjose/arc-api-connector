<?php

namespace Progresivjose\ArcApiConnector\Responses;

class JsonResponse implements Response
{
    private String $data;

    public function setData(string $data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return json_decode($this->data);
    }
}
