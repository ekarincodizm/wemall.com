<?php

interface NewsRepositoryInterface {
	public function getInsight();
	public function getAllInsight(); 
	public function getNewsList(); 
	public function getByCategory();
}