<?php

namespace App\Repositories\Contracts;

interface ResourcesCampaignsInterface
{
    public function findTypes(bool $isActive = true);
    public function findCompanies(bool $isActive = true);
    public function findDomains(bool $isActive = true);
    public function findClusters(bool $isActive = true);
    public function findCampaigns(bool $isActive = true);
    public function save(array $data, int $userId);
    public function update(array $data, int $id, int $userId);
}
