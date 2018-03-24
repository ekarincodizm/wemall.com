<?php
/*
  |--------------------------------------------------------------------------
  | Repository binded.
  |--------------------------------------------------------------------------
  |
  | Application repositories.
  |
 */

// App::bind('ProductRepositoryInterface', 'OldProductRepository');
App::bind('ProductRepositoryInterface', 'ProductRepository');
App::bind('CollectionRepositoryInterface', 'CollectionRepository');
App::bind('BrandRepositoryInterface', 'BrandRepository');
App::bind('CampaignRepositoryInterface', 'CampaignRepository');

App::bind('MemberRepositoryInterface', 'MemberRepository');
App::bind('BannerRepositoryInterface', 'BannerRepository');
App::bind('NewsRepositoryInterface', 'NewsRepository');
App::bind('BestSellerRepositoryInterface', 'BestSellerRepository');
App::bind('CustomerAddressRepositoryInterface', 'CustomerAddressRepository');
App::bind('SuperDealRepositoryInterface', 'SuperDealRepository');
App::bind('EverydaywowRepositoryInterface', 'EverydaywowRepository');
App::bind('ShowroomRepositoryInterface', 'ShowroomRepository');
App::bind('AccordionBannerRepositoryInterface', 'AccordionBannerRepository');
App::bind('UserAgentRepositoryInterface', 'UserAgentRepository');
App::bind('SpecialCampaignRepositoryInterface', 'SpecialCampaignRepository');
App::bind('AngPaoRepositoryInterface', 'AngPaoRepository');
App::bind('SolrSearchRepositoryInterface', 'SolrSearchRepository');
App::bind('GearmanRepositoryInterface', 'GearmanRepository');
