<?php

interface ShowroomRepositoryInterface
{
    public function getTotalPage();
    public function getData($page = 1, $limit = 2);
}